<?php
    App::uses('EmailsUtil', 'Util');

    class DirectMessagesComponent extends Component {
        public $components = array('Auth');
        
        /*
         * Sería bueno mandar además un mensaje al usuario, para que tenga una forma de escribirle otro mensaje al chofer sin esperar su respuesta
         * o indicarle en la vista que debe esperar la respuesta del chofer
         */
        public function send_message($conversation, $message,$expired=null){
            if(!$this->Auth->loggedIn())
                return array('success' => false, 'message' => __d('drivers_travels', 'Debe entrar a YoTeLlevo antes de enviar su mensaje'));
            
            $DriverTravelModel = ClassRegistry::init('DriverTravel');
            $DriverTravelerConversationModel = ClassRegistry::init('DriverTravelerConversation');
            $datasource = $DriverTravelModel->getDataSource();
            $datasource->begin();

            $DriverTravelModel->order = null;  //$conversation['DriverTravel']['travel_id'] = null;
            $conversation['DriverTravel']['user_id'] = $this->Auth->user('id');
            
            if( $DriverTravelModel->save($conversation) ){
                $conversation['DriverTravel']['id'] = $DriverTravelModel->getLastInsertID();
                
                //Taking the child conversation id if messaging from expired
                if ($expired) {                   
                   $conv= $DriverTravelModel->findById($expired);
                   $conv['DriverTravel']['child_conversation_id'] = $DriverTravelModel->getLastInsertID();
                   $DriverTravelModel->save($conv);//modificamos la conversacion con el child_conversation_id
                }
                
                $message = EmailsUtil::fixEmailBody(EmailsUtil::removeAllEmailAddresses($message));
                
                $message_to_driver = array('DriverTravelerConversation' => array(
                    'conversation_id' => $conversation['DriverTravel']['id'],
                    'response_by'     => 'traveler',
                    'response_text'   => $message,             
                ));
                
                if( $DriverTravelerConversationModel->save($message_to_driver) ){
                    $vars = array('message' => $message, 'travel_date' => $conversation['DriverTravel']['travel_date']);
                    $DriverModel = ClassRegistry::init('Driver');
                    $driver = $DriverModel->find('first', array('conditions' => array('Driver.id' => $conversation['DriverTravel']['driver_id'])));
                    if( isset($driver['DriverProfile']['driver_name']) )
                        $vars['driver_name'] = Driver::shortenName($driver['DriverProfile']['driver_name']);
                                        
                    if($conversation['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT){
                    $vars['is_discount']=true;
                    $vars['discount']=$conversation['DiscountRide'];
                    
                   }
                    $OK = EmailsUtil::email(
                            $conversation['DriverTravel']['last_driver_email'], 
                            'Mensaje directo'.' [['.$DriverTravelModel->id.']]',
                            $vars, 
                            'viajero', 
                            'new_direct_message');
                    
                    if($OK) {   
                        $datasource->commit();
                        return array('success' => true, 'message' => __('Su mensaje fue enviado satisfactoriamente'), 'conversation_id' => $conversation['DriverTravel']['id']);
                    }    
                    else{
                        $datasource->rollback();
                        return array('success' => false, 'message' => __d('drivers_travels', 'Ocurrió un error intentando enviar su mensaje al chofer. Intente de nuevo.'));
                    }
                }
                else{
                    $datasource->rollback();
                    return array('success' => false, 'message' => __d('drivers_travels', 'Ocurrió un error intentando salvar los datos del mensaje al chofer. Intente de nuevo.'));
                }
            }
            else{
                $datasource->rollback();
                return array('success' => false, 'message' => __d('drivers_travels', 'Ocurrió un error intentando salvar los datos de la conversación. Intente de nuevo.'));
            }
        }
    }
?>
