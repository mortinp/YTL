<?php
App::uses('ClassRegistry', 'Utility');
App::uses('EmailsUtil', 'Util');

class MessagesUtil {
    public $errorMessage;
    public $uses = array('Driver', 'DriverTravel', 'DriverTravelerConversation');

    public function __construct() {
        foreach ($this->uses as $className)
            $this->{$className} = ClassRegistry::init($className);
    }

/**
* Preprocesa el texto en $body y pone en la cola un mensaje para el chofer o el viajero según corresponda, 
* además salva en la bd toda la información asociada a la conversación y al mensaje, 
* todo ocurre dentro de una transacción, si algo falla se escribe un mensaje de error al 'conversations' log file
* 
* @param string $from            ==> indica de quien proviene el mensaje ('driver', 'traveler')
* @param UUID   $conversation    ==> id de la conversación a la que se añadirá el mensaje
* @param email  $sender          ==> dirección de correo del que envía el mensaje
* @param string $body            ==> texto del correo sin procesar
* @param array  $attachments     ==> un arreglo de ajuntos, formato de cada adjunto: array(<nombre_de_archivo> => array('contents' => <contenido_del_adjunto>, 'mimeType' => <tipo_de_fichero>))
 * @param string $messageSource            ==> De donde viene el mensaje (WEB, EML, APP): defaul UNK: Unknown
* @return void, si falla se guarda un mensaje de error en 'conversations' log file
*/
    public function sendMessage($from, $conversation, $sender, $body, array $attachments, $messageSource = 'UNK', $isClosed = false) {
        $this->errorMessage = "Conversation Failed!";
        
        $this->prepareToGetData($from);
        $driverTravel = $this->DriverTravel->findById($conversation);
        
        if ($isClosed) {
            
            $closedConversationId = $conversation; // Guardar el id de la conversacion cerrada para usarlo luego
            
            // Si ya esta conversacion tiene una child conversation, entonces solamente actualizar el conversationId que vamos a usar
            if($driverTravel['DriverTravel']['child_conversation_id'] != null) {
                // Actualizar el conversationId
                $conversation = $driverTravel['DriverTravel']['child_conversation_id'];
            }
            else {
            
                // Crear una nueva conversacion
                $new_travel_date =  date('Y-m-d', strtotime('today + 1 month'));
                $new_travel = array('DriverTravel'=>array('travel_date'=> TimeUtil::dateFormatBeforeSave($new_travel_date),
                    'notification_type'=>DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE,
                    'last_driver_email'=> $driverTravel['DriverTravel']['last_driver_email'],
                    'driver_id'=> $driverTravel['DriverTravel']['driver_id'],
                    'user_id'=> $driverTravel['DriverTravel']['user_id'],
                    'travel_id'=> null,)
                );                        

                $this->DriverTravel->create();
                $OK = $this->DriverTravel->save($new_travel);//Guardamos la nueva conversacion
                
                if(!$OK) $this->errorMessage = "Conversation Failed: No se pudo salvar la nueva conversación en driver_travel"; 
                
                // Actualizar el conversationId
                $conversation = $this->DriverTravel->getLastInsertID();

                // Actualizar la conversacion cerrada (le ponemos el child_id de la conversacion recien creada)
                $this->DriverTravel->create();
                $this->DriverTravel->id = $closedConversationId;
                $OK = $this->DriverTravel->saveField('child_conversation_id', $conversation, array('counterCache'=>false));//Le añadimos el child_conversation_id  
                
                if(!$OK) $this->errorMessage = "Conversation Failed: No se pudo actualizar el child_conversation_id de la conversación en driver_travel";
            }
            
            // Actualizar el driverTravel con la conversacion real
            $driverTravel = $this->DriverTravel->findById($conversation);
        }
        
        $conversationDataIsOK = $driverTravel != null && is_array($driverTravel) && !empty ($driverTravel);
        if($conversationDataIsOK) {
            $fixedBody = $this->getFixedBody($from, $body);
            if(Configure::read('cut_messages')) 
                $fixedBody = EmailsUtil::splitBySeparator($fixedBody);

            $datasource = $this->DriverTravelerConversation->getDataSource();
            $datasource->begin();

            $OK = $this->DriverTravelerConversation->save(array(
                'conversation_id'=> $conversation,
                'response_by'=> $from,
                'response_text'=> $fixedBody,
                'msg_source'=>$messageSource
            ));

            if(!$OK) $this->errorMessage = "Conversation Failed: No se pudo salvar la conversación en driver_traveler_conversations"; 

            if($OK) {
                $msgId = $this->DriverTravelerConversation->getLastInsertID();

                if($from == 'traveler') 
                    $OK = $this->messageTraveler2Driver($conversation, $attachments, $driverTravel);
                else 
                    $OK = $this->messageDriver2Traveler($conversation, $sender, $fixedBody, $attachments, $driverTravel, $msgId);
            }   

            if($OK) {
                $datasource->commit();
                return $msgId;
            }
            else{    
                $datasource->rollback();
                $this->errorLog($this->errorMessage, compact('sender', 'subject', 'body'));
            }
        } 
        else $this->errorLog("Conversation Failed: No se encontró la conversación", compact('sender', 'subject', 'body'));

        return null;
    }

    private function errorLog($error, array $message = array()){
        CakeLog::write('conversations', "<span style='color:red'>$error</span>");
        if( !empty($message) )
            CakeLog::write('conversations', 'Conversation - Sender: '.$message['sender'].' | Subject: '.$message['subject'].' | Body: '.$message['body']);
    }

    private function prepareToGetData($from){
        if($from == 'traveler')
            $this->Driver->attachProfile($this->DriverTravel); // Esto es para poder coger el nombre de chofer
        else{ 
            $this->DriverTravel->recursive = 2;
            $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        }    
    }

    private function getFixedBody($from, $body){
        if($from == 'traveler')
            return EmailsUtil::fixEmailBody(EmailsUtil::removeAllEmailAddresses($body));

        return EmailsUtil::fixEmailBody(EmailsUtil::removeAllUrls(EmailsUtil::removeAllEmailAddresses($body)));
    }

    private function saveAttachments($returnData){
        $OK = true;

        // Guardar los ids de los attachments en la forma id1-id2-id3
        if(isset ($returnData['attachments_ids']) && !empty($returnData['attachments_ids'])) {
            $strIds = implode('-', $returnData['attachments_ids']);
            $OK = $this->DriverTravelerConversation->saveField('attachments_ids', $strIds);
            if(!$OK) $this->errorMessage = "Conversation Failed: No se pudieron salvar los attachments_ids"; 
        }

        return $OK;
    }
    
    private function saveAllAttachments($attachmentsList) {
        
        $OK = true;
        
        $attachmentsExist = $attachmentsList != null && is_array($attachmentsList) && !empty ($attachmentsList);
        if($attachmentsExist) {
            
            // Crear los attachments
            $attachments = array();
            foreach ($attachmentsList as $key => $value) {
                $attachments[] = array('filename'=>$key, 'contents'=>$value['contents'], 'mimetype'=>$value['mimetype']);
            }
            
            // Guardar los attachments            
            $attachmentModel = ClassRegistry::init('EmailQueue.EmailAttachment');
            $attIds = array();
            foreach ($attachments as $a) {
                $a = array('EmailAttachment'=>$a);

                $attachmentModel->create();
                $OK = $attachmentModel->save($a);
                
                if(!$OK) break;

                $attIds[] = $attachmentModel->getLastInsertID();
            }
            
            if($OK) $OK = $this->saveAttachments(array('attachments_ids'=>$attIds));
        }
        
        return $OK;
    }

    private function getMessagesInConversation($conversation){
        $msg_list = $this->DriverTravelerConversation->find('all', array(
                'conditions' => array('DriverTravelerConversation.conversation_id'=>$conversation), 
                                      'recursive'  => -1,
                                      'order' => 'DriverTravelerConversation.id DESC',
                                      'limit' => 10
        ));

        return $msg_list;
    }   

    private function messageTraveler2Driver($conversation, array $attachments, &$driverTravel) {
        $OK = true;
        
        // Verificar si hay que enviar por correo
        $sendMessageByEmail = !isset($driverTravel['Driver']['email_active']) || $driverTravel['Driver']['email_active'];
        if($sendMessageByEmail) {
            
            // Setear el email al que hay que enviarle al chofer
            $driverSentFromDifferentEmail = isset($driverTravel['DriverTravel']['last_driver_email']) && $driverTravel['DriverTravel']['last_driver_email'] != null && strlen($driverTravel['DriverTravel']['last_driver_email']) != 0;
            if($driverSentFromDifferentEmail) $deliverTo = $driverTravel['DriverTravel']['last_driver_email'];
            else $deliverTo = $driverTravel['Driver']['username'];
            
            // Setear el nombre del chofer
            $driverName = 'chofer';
            if(isset ($driverTravel['Driver']['DriverProfile']) && $driverTravel['Driver']['DriverProfile'] != null && !empty ($driverTravel['Driver']['DriverProfile']))
                $driverName = Driver::shortenName($driverTravel['Driver']['DriverProfile']['driver_name']);
            
            // Obtener los mensajes de la conversacion
            $messages = $this->getMessagesInConversation($conversation);

            // El $returnData es para coger los ids de los attachments que hayan
            $returnData = array(0); // Este 0 hay que ponerselo porque si no la referencia parece que es nula!!! esta raro esto pero bueno...
            $OK = ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                $deliverTo,
                array('conversation_id'=>$conversation, 'messages'=>$messages, 'messages_count'=>count($messages), 'travel'=>$driverTravel['Travel'], 'driver_name'=>$driverName,
                      'driver_travel'=>$driverTravel['DriverTravel']),
                array(
                    'template'=>'response_traveler2driver',
                    'format'=>'html',
                    'subject'=>MessagesUtil::getEmailSubject('driver', $driverTravel),
                    'config'=>'viajero',
                    'attachments'=>$attachments),
                $returnData
            );
            if(!$OK) $this->errorMessage = "Conversation Failed: No se pudo salvar en emails_queue"; 

            if($OK) $OK = $this->saveAttachments($returnData);
        } 
        
        
        else {
            // Salvar los attachments
            $OK = $this->saveAllAttachments($attachments);
        }

        return $OK;
    }   

    private function messageDriver2Traveler($conversation, $sender, $fixedBody, array $attachments, &$driverTravel, $lastMsgId){
        $OK = true;

        if($this->blockDriver($driverTravel['Driver'])) return false;

        $mustUpdateLastDriverEmail = 
                $sender != null && 
                isset ($driverTravel['DriverTravel']['last_driver_email']) && 
                (
                    $driverTravel['DriverTravel']['last_driver_email'] == null ||
                    strlen($driverTravel['DriverTravel']['last_driver_email']) == 0 ||
                    $driverTravel['DriverTravel']['last_driver_email'] != $sender
                );
        if($mustUpdateLastDriverEmail) {

            $driverTravel['DriverTravel']['last_driver_email'] = $sender;
            $this->DriverTravel->id = $conversation;
            $this->DriverTravel->order = null;
            $OK = $this->DriverTravel->saveField('last_driver_email', $driverTravel['DriverTravel']['last_driver_email']);
            if(!$OK) $this->errorMessage = "Conversation Failed: No se pudo actulizar el campo last_driver_email en la tabla drivers_travels";
        }

        // Poner el lenguaje para que todo se traduzca bien de aquí para abajo
        if(isset ($driverTravel['User']['lang']) && $driverTravel['User']['lang'] != null)
            Configure::write('Config.language', $driverTravel['User']['lang']);

        if($OK) {
            $layout = 'default';
            $template = 'response_driver2traveler';
            if(Configure::read('Email.html')) {
                $layout = 'html_ink';
                $template = 'response_driver2traveler_html';
            }

            $driverName = __d('conversation', 'Chofer %s', '#'.$driverTravel['Driver']['id']); // ej. Chofer #23
            if(isset ($driverTravel['Driver']['DriverProfile']) && !empty($driverTravel['Driver']['DriverProfile'])) {
                $driverName = Driver::removeParenthesisFromName($driverTravel['Driver']['DriverProfile']['driver_name']); // No eliminar el apellido para que no haya confusiones
            }
            $fromName = __d('conversation', '%s de YoTeLlevo', $driverName);

            $fromEmail = null;
            if (class_exists('EmailConfig')) {
                $emailConfig = new EmailConfig();
                $keysFrom = array_keys($emailConfig->chofer['from']);
                if(!empty ($keysFrom)) $fromEmail = $keysFrom[0];
            } else {
                $fromEmail = 'chofer@yotellevocuba.com'; // TODO: Deberia dejar esto fijo???
            }

            $deliverTo = $driverTravel['User']['username'];
            
            // AVOID COMPETITION :)
            if(strtolower($deliverTo) == 'cuber@cubertaxi.com') {
                $conversation = 'BLOCKED';
                $fixedBody = 'Hola Equipo de Cuber. Nos gusta su aplicación, pero no nos gusta la competencia deshonesta. No queremos tampoco que se obtengan los datos de nuestros choferes pues pueden ser usados para cualquier fin desconocido. Lo sentimos. Un saludo, el Equipo de YoTeLlevo';
                //return false;
            }

            // El $returnData es para coger los ids de los attachments que hayan
            $returnData = array(0); // Este 0 hay que ponerselo porque si no la referencia parece que es nula!!! esta raro esto pero bueno...
            $OK = ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                $deliverTo,
                array('conversation_id'=>$conversation, 'response'=>$fixedBody,'driver'=>$driverTravel['Driver'], 'travel'=>$driverTravel['Travel'], 
                      'driver_travel'=>$driverTravel['DriverTravel'], 'last_msg_id'=>$lastMsgId),
                array(
                    'layout'=>$layout,
                    'template'=>$template,
                    'format'=>'html',
                    'subject'=>MessagesUtil::getEmailSubject('traveler', $driverTravel, $driverTravel['User']['lang']),
                    'config'=>'chofer',
                    'attachments'=>$attachments,
                    'lang'=>$driverTravel['User']['lang'],
                    'from_name'=>$fromName,
                    'from_email'=>$fromEmail),
                $returnData
            );
            if(!$OK) $this->errorMessage = "Conversation Failed: No se pudo salvar en emails_queue"; 

            if($OK) $OK = $this->saveAttachments($returnData); 
        }

        return $OK;
    }


    private static function getEmailSubject($target/* driver o traveler */, $driverTravel, $lang = 'es') {
        $conversationId = $driverTravel['DriverTravel']['id'];

        $subject = '';
        if($target == 'driver') $subject = date('y-m-d', strtotime($driverTravel['DriverTravel']['travel_date'])).' ';
        if($lang == 'es') $subject .= 'Nuevo mensaje [['.$conversationId.']]';
        else if($lang == 'en') $subject .= 'New message [['.$conversationId.']]';
        else $subject .= '[['.$conversationId.']]';

        return $subject;
    }

    private function blockDriver($driver) {
        $driverBlocked = false;

        /*// Bloquear a Juan
        if($driver['id'] == 71) {
            $Email = new CakeEmail('super');
            $Email->to('juandrc59@nauta.cu')
                  ->subject('Usted está bloqueado');
            $Email->send('Hola Juan, usted está bloqueado en YoTeLlevo. Lo sentimos, sus mensaje no le llegarán a sus clientes mientras permanezca bloqueado. Comuníquese con nosotros al 54530482 o respondiendo este correo.');

            $driverBlocked = true;
        }*/

        return $driverBlocked;
    }
}
?>
