<?php

App::uses('Component', 'Controller');
App::uses('User', 'Model');
App::uses('Travel', 'Model');
App::uses('EmailsUtil', 'Util');

class TravelLogicComponent extends Component {
    
    public function prepareForSendingToDrivers() {
        $this->DriverTravel = ClassRegistry::init('DriverTravel');
        $this->Driver = ClassRegistry::init('Driver');
    }
    
    public function confirmTravel(&$travel) {
        $OK = true;
        $errorMessage = '';
        
        if($travel != null) {
            
            // Algunas inicializaciones
            $this->DriverLocality = ClassRegistry::init('DriverLocality');
            $this->Travel = ClassRegistry::init('Travel');
            $this->prepareForSendingToDrivers();
            
            // Encontrar todos los choferes que pudieran atender este viaje
            $drivers = $this->findAllDriversSuitableForTravel($travel);
            
            // Obtener los operadores en un orden de prioridad (TODO: Describir la prioridad)
            $operators = $this->findOperatorsOrderedByPriority($travel);
            
            // Encontrar el operador que va a atender el viaje, dependiendo de su tiene choferes que puedan atender el viaje o no
            $result = $this->matchOperatorAndDrivers($operators, $drivers);
            if($result) {
                $operator = $result['operator'];
                $drivers = $result['drivers'];
            }
            
            // Trabajar con el resultado y hacer todo lo que se debe hacer
            if (count($drivers) > 0) {
                
                // Actualizar fecha de ultima notificacion del operador
                $this->User = ClassRegistry::init('User');
                $this->User->id = $operator['User']['id'];
                if( !$this->User->saveField('last_notification_date', gmdate('Y-m-d H:i:s')) ) {
                    $OK = false;
                    $errorMessage = __("Here go an error message [can't save User.last_notification_date]");
                }
                 
                if($OK) {
                    // Correo del asistente de viajes
                    // Variante 1: Si el operador nunca ha atendido a este usuario, enviarle un correo de parte de este operador al usuario
                    /*$sendEmailFromAssistant = $operator[0]['user_ownership'] == 0;
                    if($sendEmailFromAssistant) {
                        if(!EmailsUtil::email(
                                $travel['User']['username'], 
                                __('user_email', 'Hola, soy su asistente de YoTeLlevo'), 
                                array(), //TODO: Definir variables para este correo
                                $operator['User']['email_config'], 
                                'welcome_operator2traveler')) {
                            $OK = false;
                            $errorMessage = __("Here go an error message [Could not send email from operator]");
                        }
                    }*/
                    // Variante 2: Si es el primer viaje del usuario, mandarle un correo del Asistente de Viajes General (Ana)
                    $sendEmailFromAssistant = $travel['User']['travel_count'] <= 1;
                    if($sendEmailFromAssistant) {
                        if(!EmailsUtil::email(
                                $travel['User']['username'], 
                                __d('user_email', 'Hola, soy su asistente de YoTeLlevo'), 
                                array(),
                                'customer_assistant', 
                                'welcome_operator_general',
                                array('lang'=>$travel['User']['lang']))) {
                            $OK = false;
                            $errorMessage = __("Here go an error message [Could not send email from operator]");
                        }
                    }


                    // Actualizar datos del viaje
                    $travel['Travel']['operator_id'] = $operator['User']['id'];
                    $travel['Travel']['state'] = Travel::$STATE_CONFIRMED;
                    $travel['Travel']['drivers_sent_count'] = count($drivers);
                    if($this->Travel->save($travel)) {
                        if(!isset ($travel['Travel']['id'])) $travel['Travel']['id'] = $this->Travel->getLastInsertID();
                    } else {
                        $errorMessage = __('Ocurrió un error confirmando el viaje. Intenta de nuevo.');
                        $OK = false;
                    }
                }
            } else {
                $errorMessage = __('No hay choferes para atender este viaje. Intente confirmarlo más tarde.');
                if(isset ($travel['Travel']['people_count']) && $travel['Travel']['people_count'] > 4)
                    $errorMessage = __('La cantidad de personas supera la máxima capacidad para este origen y destino. Ponga 4 personas y valore con el chofer qué hacer.');
                $OK = false;
            }
            
            // Todo OK? Enviar las notificaciones a los choferes
            if($OK) {
                // Esta es una variable que cuenta los choferes que realmente recibieron la notificacion (por si algunos fallan)... realmente no es importante.
                $drivers_sent_count = 0;
                
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
            }
        }
        
        
        return array('success'=>$OK, 'message'=>$errorMessage);
    }
    
    private function findAllDriversSuitableForTravel($travel, $count = 5) {
        // Definir las condiciones primarias para encontrar choferes que pueden atender este viaje
        $primary_conditions = array(
            'DriverLocality.locality_id'=> $travel['Travel']['locality_id'],
            'Driver.active'             => true
        );
        
        if(isset ($travel['Travel']['people_count'])) {
            $primary_conditions['Driver.min_people_count <='] = $travel['Travel']['people_count'];
            $primary_conditions['Driver.max_people_count >='] = $travel['Travel']['people_count'];
        }
        
        if(User::isRegular($travel['User'])) $primary_conditions['Driver.role'] = 'driver';
        else                                 $primary_conditions['Driver.role'] = 'driver_tester';
        
        // Definir las condiciones secundarias para encontrar choferes que pueden atender este viaje
        $secondary_conditions = array();
        $order = array();

        // Adicionar la condicion del ingles si el idioma del sitio es ingles
        $lang = Configure::read('Config.language');
        if($lang != null && $lang == 'en') {
            $secondary_conditions['Driver.speaks_english'] = true;
            $order[] = 'Driver.speaks_english DESC';
        }
        
        if(isset ($travel['Travel']['need_air_conditioner']) && $travel['Travel']['need_air_conditioner']){ 
            $secondary_conditions['Driver.has_air_conditioner'] = true;
            $order[] = 'Driver.has_air_conditioner DESC';
        }
        
        if(isset ($travel['Travel']['need_modern_car']) && $travel['Travel']['need_modern_car']){
            $secondary_conditions['Driver.has_modern_car'] = true;
            $order[] = 'Driver.has_modern_car DESC';
        }
        
        // Primero buscar los que cumplen con todas las condiciones, y si no se encuentran, probar a buscar solo con las condiciones primarias
        $drivers = $this->findDrivers(array_merge($primary_conditions, $secondary_conditions), array('Driver.last_notification_date', 'Driver.travel_count'));
        if( count($drivers) < $count ) $drivers = $this->findDrivers($primary_conditions, array_merge($order, array('Driver.last_notification_date', 'Driver.travel_count')));
                
        return $drivers;
    }
    
    private function findDrivers($drivers_conditions, $order){
        $this->DriverLocality = ClassRegistry::init('DriverLocality');
        $this->Driver = ClassRegistry::init('Driver');
        $this->Driver->attachProfile($this->DriverLocality); // Esto es para que el chofer se cargue con su perfil
        
        // Se buscan primero los choferes que cumplen con las condiciones
        $drivers = $this->DriverLocality->find('all', array(
            'conditions' => $drivers_conditions,
            'order'      => $order
        ));
        
        return $drivers;
    }
    
    private function findOperatorsOrderedByPriority($travel){
        $join = array('table' => 'travels', 'alias' => 'Travel', 'type' => 'left',
                      'conditions' => array('User.id = Travel.operator_id', 'Travel.user_id' => $travel['Travel']['user_id']));

        $this->User = ClassRegistry::init('User');
        $operators = $this->User->find('all', array(
            'fields'     => array('User.id', 'User.email_config', 'count(Travel.operator_id) as user_ownership'),
            'joins'      => array($join),
            'recursive'  => -1,
            'conditions' => array('User.role' => 'operator'),
            'group'      => 'User.id',
            'order'      => array('user_ownership desc', 'User.last_notification_date') // TODO: Verificar si estas condiciones estan bien, porque me parece que ordenar por la cantidad de viajes que tiene un operador no es una buena idea...
        ));
        
        return $operators;
    }
    
    private function matchOperatorAndDrivers($operators, $drivers, $count = 5) {
        $driversOK = array();
        foreach($operators as $op){
            foreach($drivers as $d)
                if($d['Driver']['operator_id'] == $op['User']['id'] || $d['Driver']['operator_id'] == null){ // Se escogen los choferes que sean de este operador o los que no son de ningun operador
                    $driversOK[] = $d;
                    if(count($driversOK) == $count)
                        return array('operator'=>$op, 'drivers'=>$driversOK);
                }    
            
            if($driversOK) return array('operator'=>$op, 'drivers'=>$driversOK); // retornar el operador si tiene al menos un chofer que cumple las condiciones
        }
        
        return false;
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
        if($notificationType != DriverTravel::$NOTIFICATION_TYPE_AUTO) 
            $driverTravel['notified_by'] = User::prettyName(AuthComponent::user());
        
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
            if($driver['Driver']['username'] == 'yasmany.nolazco@nauta.cu') $subject = '[['.$conversation.']]'; // HACK: Esto es un hack para el correo de un chofer que esta cortando el asunto de los correos... es una prueba!!!
            
            $driverName = 'chofer';
            if(isset ($driver['Driver']['DriverProfile']) && $driver['Driver']['DriverProfile'] != null && !empty ($driver['Driver']['DriverProfile']))
                $driverName = Driver::shortenName($driver['Driver']['DriverProfile']['driver_name']);
                
            
            $variables = array('travel' => $travel, 'showEmail'=>true, 'conversation_id'=>$conversation, 'driver_name'=>$driverName);
            $variables = array_merge($variables, $customVariables);
            
            EmailsUtil::email($driver['Driver']['username'], $subject, $variables, $emailConfig, $template);
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
                
                $OK = $this->Travel->save($travel);
                $travel['Travel']['id'] = $this->Travel->getLastInsertID();
                $travel = $this->Travel->findById($travel['Travel']['id']);
                
                if($OK) $OK = $this->PendingTravel->delete($travelId);
                
                if($OK) $result = $this->confirmTravel($travel);
                
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
}
?>
