<?php

App::uses('Component', 'Controller');
App::uses('User', 'Model');
App::uses('Travel', 'Model');

class TravelLogicComponent extends Component {
    
    public function confirmTravel($modelType /*Travel or TravelByEmail*/, &$travel) {
        $OK = true;
        $errorMessage = '';
        if($travel != null) {
            
            $this->DriverLocality = ClassRegistry::init('DriverLocality');
            $this->DriverTravel = ClassRegistry::init('Driver'.$modelType);
            $this->Travel = ClassRegistry::init($modelType);
            $this->Driver = ClassRegistry::init('Driver');
            
            $drivers_conditions = array(
                'DriverLocality.locality_id'=>$travel[$modelType]['locality_id'], 
                'Driver.active'=>true);
            if(isset ($travel[$modelType]['people_count'])) $drivers_conditions['Driver.max_people_count >='] = $travel[$modelType]['people_count'];
            if(isset ($travel[$modelType]['need_modern_car']) && $travel[$modelType]['need_modern_car']) $drivers_conditions['Driver.has_modern_car'] = true;
            if(isset ($travel[$modelType]['need_air_conditioner']) && $travel[$modelType]['need_air_conditioner']) $drivers_conditions['Driver.has_air_conditioner'] = true;
            
            if(User::isRegular($travel['User'])) $drivers_conditions['Driver.role'] = 'driver';
            else $drivers_conditions['Driver.role'] = 'driver_tester';
            
            // Verify English skills
            $english = false;
            $lang = Configure::read('Config.language');
            if($lang != null && $lang == 'en') {
                $drivers_conditions['Driver.speaks_english'] = true;
                $english = true;
            }

            $inflectedTravelType = Inflector::underscore($modelType);
            $drivers = $this->DriverLocality->find('all', array(
                'conditions'=>$drivers_conditions, 
                'order'=>'Driver.'.'last_notification_date ASC, Driver.'.$inflectedTravelType.'_count'.' ASC',
                'limit'=>3));
            
            
            // English
            if($english && count($drivers) < 3) {
                $drivers_conditions['Driver.speaks_english'] = false;
                
                $driversSp = $this->DriverLocality->find('all', array(
                    'conditions'=>$drivers_conditions, 
                    'order'=>'Driver.'.'last_notification_date ASC, Driver.'.$inflectedTravelType.'_count'.' ASC',
                    'limit'=>3 - count($drivers)));
                
                $drivers = array_merge($drivers, $driversSp);
            }
            
            if (count($drivers) > 0) {
                $travel[$modelType]['state'] = Travel::$STATE_CONFIRMED;
                $travel[$modelType]['drivers_sent_count'] = count($drivers);
                if($this->Travel->save($travel)) {
                    if(!isset ($travel[$modelType]['id'])) $travel[$modelType]['id'] = $this->Travel->getLastInsertID();
                } else {
                    $errorMessage = 'Ocurrió un error confirmando el viaje. Intenta de nuevo.';
                    $OK = false;
                }
            } else {
                $errorMessage = 'No hay choferes para atender este viaje. Intente confirmarlo más tarde.';
                if(isset ($travel[$modelType]['people_count']) && $travel[$modelType]['people_count'] > 4)
                    $errorMessage = 'La cantidad de personas ('.$travel[$modelType]['people_count'].') supera la máxima capacidad para taxis individuales para su origen y destino. Le recomendamos que <b>cree el viaje para 4 personas</b>, y cuando se comunique con el chofer, le haga saber sobre la cantidad real de personas que van a viajar. El chofer seguramente le gestionará su viaje sin contratiempos.';
                $OK = false;
            }
            
            $drivers_sent_count = 0;
            
            if($OK) {
                
                $emailConfig = 'no_responder';
                if(!User::isRegular($travel['User']) || Configure::read('conversations_via_app')) $emailConfig = 'viajero';
                    
                foreach ($drivers as $d) {
                    $this->DriverTravel->create();
                    $driverTravel = array('driver_id'=>$d['Driver']['id'], 'travel_id'=>$travel[$modelType]['id']);
                    $OK = $this->DriverTravel->save(array('Driver'.$modelType=>$driverTravel));
                                        
                    if($OK) {
                        $this->Driver->id = $d['Driver']['id'];
                        
                        $OK = $this->Driver->saveField(
                                'last_notification_date',
                                gmdate('Y-m-d H:i:s')
                                /*$this->Driver->getFormattedDate('last_notification_date', time())*/);
                    }
                    
                    if($OK) {

                        $conversation = $this->DriverTravel->getLastInsertID();
                        $subject = __d('user_email', 'Nuevo Anuncio de Viaje').' [['.$conversation/*$travel[$modelType]['id'].' '.$this->Travel->travelType*/.']]';
                        
                        if(Configure::read('enqueue_mail')) {
                            ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                                    $d['Driver']['username'], 
                                    array('travel' => $travel, 'showEmail'=>true, 'conversation_id'=>$conversation), 
                                    array(
                                        'template'=>'new_'.$inflectedTravelType,
                                        'format'=>'html',
                                        'subject'=>$subject,
                                        'config'=>$emailConfig));
                        } else {
                            $Email = new CakeEmail($emailConfig);
                            $Email->template('new_'.$inflectedTravelType)
                            ->viewVars(array('travel' => $travel, 'showEmail'=>true, 'conversation_id'=>$conversation))
                            ->emailFormat('html')
                            ->to($d['Driver']['username'])
                            ->subject($subject);
                            try {
                                $Email->send();
                            } catch ( Exception $e ) {
                                if($drivers_sent_count < 1) {
                                    //$this->setErrorMessage('Ocurrió un error enviando el viaje a los choferes. Intenta de nuevo.');
                                    $errorMessage = 'Ocurrió un error enviando el viaje a los choferes. Intenta de nuevo.';
                                    $OK = false;
                                    continue;
                                }
                            }
                        }
                    }

                    if($OK) {
                        $drivers_sent_count++;
                    }
                }

                // Always send an email to me ;) 
                $subject = 'Nuevo Anuncio de Viaje ('.$travel[$modelType]['id'].' '.$this->Travel->travelType.')';
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
    
    
    public function confirmPendingTravel($tId, $userId) {
        $OK = true;
        $errorMessage = '';
        if($tId != null) {
            
            $this->PendingTravel = ClassRegistry::init('PendingTravel');
            $this->Travel = ClassRegistry::init('Travel');
            
            $pending = $this->PendingTravel->findById($tId);
            
            if($pending != null && !empty ($pending)) {
                
                unset ($pending['PendingTravel']['email']);
                
                $travel['Travel'] = $pending['PendingTravel'];
                unset ($travel['Travel']['id']);
                
                $travel['Travel']['user_id'] = $userId;
                
                $OK = $this->Travel->save($travel); // 
                $travel['Travel']['id'] = $this->Travel->getLastInsertID();
                $travel = $this->Travel->findById($travel['Travel']['id']);
                
                if($OK) $OK = $this->PendingTravel->delete($tId);
                
                if($OK) $result = $this->confirmTravel('Travel', $travel);
                
                if(!$OK) $errorMessage = 'Ocurrió un error confirmando este viaje.';
                
                if(!$result['success']) {
                    $OK = false;
                    $errorMessage = $result['message'];
                }
                
            } else {
                $OK = false;
                $errorMessage = 'El viaje especificado no existe como pendiente.';
            }
            
        } else {
            $OK = false;
            $errorMessage = 'No has especificado el viaje que quieres confirmar.';
        }
        
        if($OK ) {
            return array('success'=>$OK, 'message'=>$errorMessage, 'travel'=>$travel);
        }
        return array('success'=>$OK, 'message'=>$errorMessage);
    }
    
}
?>
