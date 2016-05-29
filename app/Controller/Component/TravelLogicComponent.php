<?php

App::uses('Component', 'Controller');
App::uses('User', 'Model');
App::uses('Travel', 'Model');

class TravelLogicComponent extends Component {
    
    public function prepareForSendingToDrivers($travelType) {
        $this->DriverTravel = ClassRegistry::init('Driver'.$travelType);
        $this->Driver = ClassRegistry::init('Driver');
    }
    
    public function confirmTravel($travelType /*Travel or TravelByEmail*/, &$travel) {
        $OK = true;
        $errorMessage = '';
        $inflectedTravelType = Inflector::underscore('Travel');
        
        if($travel != null) {
            
            $this->DriverLocality = ClassRegistry::init('DriverLocality');
            $this->Travel = ClassRegistry::init($travelType);
            
            $this->prepareForSendingToDrivers($travelType);
            
            $drivers = $this->findDriversForTravel($travel);
            
            if (count($drivers) > 0) {
                $travel[$travelType]['state'] = Travel::$STATE_CONFIRMED;
                $travel[$travelType]['drivers_sent_count'] = count($drivers);
                if($this->Travel->save($travel)) {
                    if(!isset ($travel[$travelType]['id'])) $travel[$travelType]['id'] = $this->Travel->getLastInsertID();
                } else {
                    $errorMessage = __('Ocurrió un error confirmando el viaje. Intenta de nuevo.');
                    $OK = false;
                }
            } else {
                $errorMessage = __('No hay choferes para atender este viaje. Intente confirmarlo más tarde.');
                if(isset ($travel[$travelType]['people_count']) && $travel[$travelType]['people_count'] > 4)
                    $errorMessage = __('La cantidad de personas supera la máxima capacidad para este origen y destino. Ponga 4 personas y valore con el chofer qué hacer.');
                $OK = false;
            }
            
            $drivers_sent_count = 0;
            
            if($OK) {
                //$this->prepareForSendingToDrivers($travelType);
                
                $emailConfig = 'no_responder';
                if(!User::isRegular($travel['User']) || Configure::read('conversations_via_app')) $emailConfig = 'viaje';
                    
                foreach ($drivers as $d) {
                    $OK = $this->sendTravelToDriver($d, $travel, DriverTravel::$NOTIFICATION_TYPE_AUTO, $emailConfig);
                    if($OK) {
                        $drivers_sent_count++;
                    } else if($drivers_sent_count < 1) {
                        $errorMessage = __('Ocurrió un error enviando el viaje a los choferes. Intenta de nuevo.');
                        continue;
                    }
                }

                // Always send an email to me ;) 
                //$subject = 'Nuevo Anuncio de Viaje ('.$travel[$travelType]['id'].' '.$this->Travel->travelType.')';
                $subject = $this->getNotificationEmailSubject($travel, $travel[$travelType]['id']);
                
                if(Configure::read('enqueue_mail')) {
                    ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                            Configure::read('superadmin_email')/*'mproenza@grm.desoft.cu'*/,
                            array('travel'=>$travel, 'admin'=>array('drivers'=>$drivers, 'notified_count'=>$drivers_sent_count), 'creator_role'=>$travel['User']['role']), 
                            array(
                                'template'=>'new_'.$inflectedTravelType,
                                'format'=>'html',
                                'subject'=>$subject,
                                'config'=>'no_responder'));
                } else {
                    $Email = new CakeEmail('no_responder');
                    $Email->template('new_'.$inflectedTravelType)
                    ->viewVars(array('travel'=>$travel, 'admin'=>array('drivers'=>$drivers, 'notified_count'=>$drivers_sent_count), 'creator_role'=>$travel['User']['role']))
                    ->emailFormat('html')
                    ->to('mproenza@grm.desoft.cu')
                    ->subject($subject);
                    try {
                        $Email->send();
                    } catch ( Exception $e ) {
                        // TODO: Should I do something here???
                    }
                }
            }
        }
        
        
        return array('success'=>$OK, 'message'=>$errorMessage);
    }
    
    public function findDriversForTravel($travel, $count = 5) {
        $drivers_conditions = array(
            'DriverLocality.locality_id'=>$travel['Travel']['locality_id'],
            'Driver.active'=>true);
        if(isset ($travel['Travel']['people_count'])) {
            $drivers_conditions['Driver.min_people_count <='] = $travel['Travel']['people_count'];
            $drivers_conditions['Driver.max_people_count >='] = $travel['Travel']['people_count'];
        }
        if(isset ($travel['Travel']['need_modern_car']) && $travel['Travel']['need_modern_car']) $drivers_conditions['Driver.has_modern_car'] = true;
        if(isset ($travel['Travel']['need_air_conditioner']) && $travel['Travel']['need_air_conditioner']) $drivers_conditions['Driver.has_air_conditioner'] = true;

        if(User::isRegular($travel['User'])) $drivers_conditions['Driver.role'] = 'driver';
        else $drivers_conditions['Driver.role'] = 'driver_tester';

        // Verify English skills
        $english = false;
        $lang = Configure::read('Config.language');
        if($lang != null && $lang == 'en') {
            $drivers_conditions['Driver.speaks_english'] = true;
            $english = true;
        }

        $this->setupSelectDriverProfile(); // Esto es para que el chofer se cargue con su perfil

        if($this->DriverLocality == null) $this->DriverLocality = ClassRegistry::init('DriverLocality');
        $drivers = $this->DriverLocality->find('all', array(
            'conditions'=>$drivers_conditions, 
            'order'=>'Driver.'.'last_notification_date ASC, Driver.travel_count'.' ASC',
            'limit'=>$count));

        // English
        if($english && count($drivers) < $count) {
            $drivers_conditions['Driver.speaks_english'] = false;

            $this->setupSelectDriverProfile(); // Esto es para que el chofer se cargue con su perfil

            $driversSp = $this->DriverLocality->find('all', array(
                'conditions'=>$drivers_conditions, 
                'order'=>'Driver.'.'last_notification_date ASC, Driver.travel_count'.' ASC',
                'limit'=>$count - count($drivers)));

            $drivers = array_merge($drivers, $driversSp);
        }
        
        return $drivers;
    }
    
    /**
     * Sends a notification email to a driver
     * 
     * @param $driver: the driver
     * @param $travel: the travel
     * @param $notificationType: the type of the notification (ex. DriverTravel::$NOTIFICATION_TYPE_PREARRANGED)
     * @param $config: some configurations for the notification. This param can be a string, which will be
     * interpreted as the email_config, or can be an array containing the following keys:
     *      template: the email template (default: new_travel)
     *      email_config: the email_config (default: viaje)
     *      custom_variables: some custom variables you want to evaluate in the email template
     * 
     * @return array: in case of success: array('success'=>true, 'conversation_id'=><the id of the conversation just created>)
     */
    
    public function sendTravelToDriver(array $driver, array $travel, $notificationType, $config = null) {
        // Setup configurations
        $template = 'new_travel';
        $emailConfig = 'viaje';
        $customVariables = array();
        if($config != null && is_string($config)) $emailConfig = $config;
        if($config != null && is_array($config)) {
            if(isset ($config['template'])) $template = $config['template'];
            if(isset ($config['email_config'])) $emailConfig = $config['email_config'];
            if(isset ($config['custom_variables'])) $customVariables = $config['custom_variables'];
        }
        
        
        $OK = true;
        
        $this->DriverTravel->create();
        $driverTravel = array('driver_id'=>$driver['Driver']['id'], 'travel_id'=>$travel['Travel']['id'], 'notification_type'=>$notificationType);
        $OK = $this->DriverTravel->save(array('DriverTravel'=>$driverTravel));

        if($OK) {
            $this->Driver->id = $driver['Driver']['id'];

            $OK = $this->Driver->saveField(
                    'last_notification_date',
                    gmdate('Y-m-d H:i:s'));
        }

        if($OK) {

            $conversation = $this->DriverTravel->getLastInsertID();
            
            $subject = $this->getNotificationEmailSubject($travel, $conversation);
            
            $driverName = 'chofer';
            if(isset ($driver['Driver']['DriverProfile']) && $driver['Driver']['DriverProfile'] != null && !empty ($driver['Driver']['DriverProfile']))
                $driverName = Driver::shortenName($driver['Driver']['DriverProfile']['driver_name']);
                
            
            $variables = array('travel' => $travel, 'showEmail'=>true, 'conversation_id'=>$conversation, 'driver_name'=>$driverName);
            $variables = array_merge($variables, $customVariables);
            if(Configure::read('enqueue_mail')) {
                ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $driver['Driver']['username'], 
                        $variables, 
                        array(
                            'template'=>$template,
                            'format'=>'html',
                            'subject'=>$subject,
                            'config'=>$emailConfig));
            } else {
                $Email = new CakeEmail($emailConfig);
                $Email->template($template)
                ->viewVars($variables)
                ->emailFormat('html')
                ->to($driver['Driver']['username'])
                ->subject($subject);
                try {
                    $Email->send();
                } catch ( Exception $e ) {
                    $OK = false;
                }
            }
        }
        
        if($OK) $OK = array('success'=>true, 'conversation_id'=>$conversation);

        return $OK;
    }
    
    private function getNotificationEmailSubject($travel, $id) {
        $subject = date('y-m-d', strtotime($travel['Travel']['date'])).' ';
        /*$tag = $travel[$travelType]['origin'].' - '.$travel[$travelType]['destination'];
        if(strlen($tag) > 80) $subject .= substr ($tag, 0, 80).'...';
        else $subject .= $tag;*/
        $subject .= __d('user_email', 'Nuevo Anuncio de Viaje');
        $subject .= ' [['.$id.']]';
        
        return $subject;
    }
    
    
    public function confirmPendingTravel($travelId, $userId) {
        $OK = true;
        $errorMessage = '';
        if($travelId != null) {
            
            $this->PendingTravel = ClassRegistry::init('PendingTravel');
            $this->Travel = ClassRegistry::init('Travel');
            
            $pending = $this->PendingTravel->findById($travelId);
            
            if($pending != null && !empty ($pending)) {
                
                unset ($pending['PendingTravel']['email']);
                
                $travel['Travel'] = $pending['PendingTravel'];
                unset ($travel['Travel']['id']);
                
                $travel['Travel']['user_id'] = $userId;
                
                $OK = $this->Travel->save($travel); // 
                $travel['Travel']['id'] = $this->Travel->getLastInsertID();
                $travel = $this->Travel->findById($travel['Travel']['id']);
                
                if($OK) $OK = $this->PendingTravel->delete($travelId);
                
                if($OK) $result = $this->confirmTravel('Travel', $travel);
                
                if(!$OK) $errorMessage = __('Ocurrió un error confirmando este viaje.');
                
                if(!$result['success']) {
                    $OK = false;
                    $errorMessage = $result['message'];
                }
                
            } else {
                $OK = false;
                $errorMessage = __('El viaje especificado no existe como pendiente.');
            }
            
        } else {
            $OK = false;
            $errorMessage = __('No has especificado el viaje que quieres confirmar.');
        }
        
        if($OK ) {
            return array('success'=>$OK, 'message'=>$errorMessage, 'travel'=>$travel);
        }
        return array('success'=>$OK, 'message'=>$errorMessage);
    }
    
    private function setupSelectDriverProfile() {
        $this->DriverLocality->recursive = 2; // Esto es para que el chofer se cargue con su perfil
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));// Esto es para que no se carguen las localidades del chofer
    }
    
}
?>
