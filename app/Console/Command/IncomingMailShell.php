<?php

App::uses('Travel', 'Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('EmailsUtil', 'Util');

require_once ("helper/mailReader.php");
//require_once ("Config/email.php");

class IncomingMailShell extends AppShell {
    
    public $uses = array('User', 'DriverTravel', 'Driver', 'DriverTravelerConversation', 'TravelConversationMeta', 'Testimonial');

    public function main() {
        $this->out('IncomingMail shell reporting.');
    }

    public function process() {
        $sender = $this->args[0];
        $origin = $this->args[1];
        $destination = $this->args[2];
        $description = $this->args[3];
        
        $this->do_process($sender, $origin, $destination, $description);
    }
    
    public function process2() {
        
        $raw = '';
        $fd = fopen('php://stdin','r');
        while(!feof($fd)){ $raw .= fread($fd,1024); }
        
        
        $parser = new mailReader();
        //$parser->debug = true;
        $parser->readEmail($raw);
        
        $text = $parser->from;
        preg_match('#\<(.*?)\>#', $text, $match);
        $sender = $match[1];
        if($sender == null || strlen($sender) == 0) $sender = $text;
        
        $text = $parser->to;
        preg_match('#\<(.*?)\>#', $text, $match);
        $to = $match[1];
        if($to == null || strlen($to) == 0) $to = $text;
        $to = strtolower($to);
        
        $subject = trim($parser->subject);
        
        $body = /*h(*/$parser->body/*)*/; // h() para escapar los caracteres html
        
        if($to === 'chofer@'.Configure::read('domain_name')) { 
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                $this->Driver->attachProfile($this->DriverTravel); // Esto es para poder coger el nombre de chofer
                
                $driverTravel = $this->DriverTravel->findById($conversation);
                
                if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
                    if(isset ($driverTravel['DriverTravel']['last_driver_email']) && 
                            $driverTravel['DriverTravel']['last_driver_email'] != null && strlen($driverTravel['DriverTravel']['last_driver_email']) != 0)
                        $deliverTo = $driverTravel['DriverTravel']['last_driver_email'];
                    else $deliverTo = $driverTravel['Driver']['username'];

                    $datasource = $this->DriverTravelerConversation->getDataSource();
                    $datasource->begin();
                    
                    
                    $fixedBody = EmailsUtil::fixEmailBody(EmailsUtil::removeAllEmailAddresses($body));

                    $OK = $this->DriverTravelerConversation->save(array(
                        'conversation_id'=>$conversation,
                        'response_by'=>'traveler',
                        'response_text'=>$fixedBody
                    ));
                    if(!$OK) {
                        CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo salvar la conversación en driver_traveler_conversations</span>");
                        CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                    }

                    if($OK) {
                        $driverName = 'chofer';
                        if(isset ($driverTravel['Driver']['DriverProfile']) && $driverTravel['Driver']['DriverProfile'] != null && !empty ($driverTravel['Driver']['DriverProfile']))
                            $driverName = Driver::shortenName($driverTravel['Driver']['DriverProfile']['driver_name']);
                        
                        $email_text = $this->getPrettyMsgList($conversation, __('Tú'), __('Viajero'));
                        
                        // El $returnData es para coger los ids de los attachments que hayan
                        $returnData = array(0); // Este 0 hay que ponerselo porque si no la referencia parece que es nula!!! esta raro esto pero bueno...
                        ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                            $deliverTo,
                            //array('conversation_id'=>$conversation, 'response'=>$fixedBody, 'travel'=>$driverTravel['Travel'], 'driver_name'=>$driverName),
                            //array('conversation_id'=>$conversation, 'response'=>$fixedBody, 'travel'=>$driverTravel['Travel'], 'driver_name'=>$driverName,
                            array('conversation_id'=>$conversation, 'response'=>$email_text, 'travel'=>$driverTravel['Travel'], 'driver_name'=>$driverName,
                                  'driver_travel'=>$driverTravel['DriverTravel']),
                            array(
                                'template'=>'response_traveler2driver',
                                'format'=>'html',
                                'subject'=>$subject,
                                'config'=>'viajero',
                                'attachments'=>$parser->attachments),
                            $returnData
                        );
                        // Guardar los ids de los attachments en la forma id1-id2-id3
                        if(isset ($returnData['attachments_ids']) && !empty($returnData['attachments_ids'])) {
                            $strIds = '';
                            $sep = '';
                            foreach ($returnData['attachments_ids'] as $id) {
                                $strIds .= $sep.$id;
                                $sep = '-';
                            }
                            
                            $this->out($strIds);
                            $this->DriverTravelerConversation->saveField('attachments_ids', $strIds);
                        }
                    }
                    if(!$OK) {
                        CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo salvar en emails_queue</span>");
                        CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                    }

                    if($OK) {
                        $datasource->commit();
                        //CakeLog::write('conversations', 'Conversation Saved and Email Enqueued!');
                    } else {
                        $datasource->rollback();
                        CakeLog::write('conversations', "<span style='color:red'>Conversation Failed!</span>");
                        CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                    }
                } else {
                    CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se encontró la conversación</span>");
                    CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                }
            } else {
                CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo parsear el asunto</span>");
                CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                
                $user = $this->User->findByUsername($sender);
                
                if($user != null && (is_array($user) && !empty ($user))) {
                    //$this->out($user['User']['id'].'-'.$user['User']['username'].'-'.$user['User']['lang']);
                    $lang = $user['User']['lang'];
                    
                    $cause = 'Problem in your response email';
                    $target_part = 'driver';
                    if($lang != 'en') {
                        $cause = 'Problema en su correo de respuesta';
                        $target_part = 'chofer';
                    }
                
                    ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $sender,
                        array('target_part'=>$target_part, 'subject'=>$subject, 'body'=>$body),
                        array(
                            'template'=>'wrong_conversation_email_subject',
                            'format'=>'html',
                            'subject'=>$cause,
                            'config'=>'soporte',
                            'lang'=>$lang)
                    );
                } else {
                    CakeLog::write('conversations', "<span style='color:red'>Oops, that user was not found in our database.</span>");
                }
            }
            
        }  else if($to === 'viajero@'.Configure::read('domain_name') || $to === 'viaje@'.Configure::read('domain_name')) {
            
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                $this->DriverTravel->recursive = 2;
                $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
                $driverTravel = $this->DriverTravel->findById($conversation);
                
                if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
                    
                    // Bloquear a Juan
                    if($driverTravel['Driver']['id'] == 71) {
                        $Email = new CakeEmail('super');
                        $Email->to('juandrc59@nauta.cu')
                              ->subject('Usted está bloqueado');
                        $Email->send('Hola Juan, usted está bloqueado en YoTeLlevo. Lo sentimos, sus mensaje no le llegarán a sus clientes mientras permanezca bloqueado. Comuníquese con nosotros al 54530482 o a este correo.');
                        
                        CakeLog::write('juan', "Mensaje de Juan bloqueado: $conversation - $body");
                        return;
                    }
                    
                    
                    $deliverTo = $driverTravel['User']['username'];

                    $datasource = $this->DriverTravelerConversation->getDataSource();
                    $datasource->begin();
                    $OK = true;

                    if(isset ($driverTravel['DriverTravel']['last_driver_email']) && 
                        ($driverTravel['DriverTravel']['last_driver_email'] == null ||
                        strlen($driverTravel['DriverTravel']['last_driver_email']) == 0 ||
                        $driverTravel['DriverTravel']['last_driver_email'] != $sender)) {

                        $driverTravel['DriverTravel']['last_driver_email'] = $sender;
                        $this->DriverTravel->id = $conversation;
                        $this->DriverTravel->order = null;
                        $OK = $this->DriverTravel->saveField('last_driver_email', $driverTravel['DriverTravel']['last_driver_email']);
                        if(!$OK) {
                            CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo actulizar el campo last_driver_email en la tabla drivers_travels</span>");
                            CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                        }
                    }
                    
                    // Poner el lenguaje para que todo se traduzca bien de aquí para abajo
                    if(isset ($driverTravel['User']['lang']) && $driverTravel['User']['lang'] != null)
                        Configure::write('Config.language', $driverTravel['User']['lang']);
                    
                    $fixedBody = EmailsUtil::fixEmailBody(EmailsUtil::removeAllUrls(EmailsUtil::removeAllEmailAddresses($body)));
                    
                    if($OK) $OK = $this->DriverTravelerConversation->save(array(
                        'conversation_id'=>$conversation,
                        'response_by'=>'driver',
                        'response_text'=>$fixedBody
                    ));
                    if(!$OK) {
                        CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo salvar la conversación en driver_traveler_conversations</span>");
                        CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);                       
                    }

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
                        
                        
                        // El $returnData es para coger los ids de los attachments que hayan
                        $returnData = array(0); // Este 0 hay que ponerselo porque si no la referencia parece que es nula!!! esta raro esto pero bueno...
                        ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                            $deliverTo,
                            array('conversation_id'=>$conversation, 'response'=>$fixedBody,'driver'=>$driverTravel['Driver'], 'travel'=>$driverTravel['Travel'], 
                                  'driver_travel'=>$driverTravel['DriverTravel']),
                            array(
                                'layout'=>$layout,
                                'template'=>$template,
                                'format'=>'html',
                                'subject'=>$subject,
                                'config'=>'chofer',
                                'attachments'=>$parser->attachments,
                                //'lang'=>$driverTravel['Travel']['User']['lang'],
                                'lang'=>$driverTravel['User']['lang'],
                                'from_name'=>$fromName,
                                'from_email'=>$fromEmail),
                            $returnData
                        );
                        // Guardar los ids de los attachments en la forma id1-id2-id3
                        if(isset ($returnData['attachments_ids']) && !empty($returnData['attachments_ids'])) {
                            $strIds = '';
                            $sep = '';
                            foreach ($returnData['attachments_ids'] as $id) {
                                $strIds .= $sep.$id;
                                $sep = '-';
                            }
                            
                            $this->out($strIds);
                            $this->DriverTravelerConversation->saveField('attachments_ids', $strIds);
                        }
                    }
                    if(!$OK) {
                        CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo salvar en emails_queue</span>");
                        CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                    }

                    if($OK) {
                        $datasource->commit();
                        //CakeLog::write('conversations', 'Conversation Saved and Email Enqueued!');
                    } else {
                        $datasource->rollback();
                        CakeLog::write('conversations', "<span style='color:red'>Conversation Failed!</span>");
                        CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                    }
                } else {
                    CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se encontró la conversación</span>");
                    CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                }
            } else {
                CakeLog::write('conversations', "<span style='color:red'>Conversation Failed: No se pudo parsear el asunto</span>");
                CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
                
                ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                    $sender,
                    array('target_part'=>'viajero', 'subject'=>$subject, 'body'=>$body),
                    array(
                        'template'=>'wrong_conversation_email_subject',
                        'format'=>'html',
                        'subject'=>'Problema en un correo de respuesta',
                        'config'=>'soporte')
                );
            }
            
            
        } else if($to === 'verificacion-viaje@'.Configure::read('domain_name')) {
            
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                $meta = $this->TravelConversationMeta->findByConversationId($conversation);
                
                if($meta == null || empty ($meta)) {
                    CakeLog::write('travel_confirmations', "Conversation NOT FOUND\n\n");
                    return;
                }// no hacer nada si no existe la conversacion
                
                $newMessage = trim($body);
                if(strpos($newMessage, '**********')) $newMessage = substr($newMessage, 0, strpos($newMessage, '**********'));
                
                // Verificar si ya se habia recibido otra confirmacion anterior de esta misma conversacion; agregarle el nuevo texto en caso de que sí.
                if(isset ($meta['TravelConversationMeta']['received_confirmation_details']) && $meta['TravelConversationMeta']['received_confirmation_details'] != null)
                    $newMessage = 
                        $meta['TravelConversationMeta']['received_confirmation_details'].
                        "\r\n\r\n (...)\r\n\r\n".
                        $newMessage;
                
                $meta = array('TravelConversationMeta'=>array(
                    'conversation_id'=>$conversation, 
                    'received_confirmation_details'=>$newMessage, 
                    'received_confirmation_type'=>'K'/*Unknown*/,
                    'asked_confirmation'=>true));
                
                if(!$this->TravelConversationMeta->save($meta)) {
                    CakeLog::write('travel_confirmations', "Error saving data on DB\n\n");
                } else {
                    //CakeLog::write('travel_confirmations', "Data saved on DB\n\n");
                }
            } else {
                CakeLog::write('travel_confirmations', "Error parsing conversation in subject $subject\n\n");
            }
            
        } else if($to === 'info-chofer@'.Configure::read('domain_name')) {
            $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
            $driver = $this->Driver->findByUsername($sender);
            CakeLog::write('info_choferes', "Solicitud de informacion recibida: $sender - $subject");
            if( !isset($driver['Driver']['id']) )
                EmailsUtil::email($sender, 'Sobre YoTeLlevo', array(), 'super', 'info_drivers');
            else{
                $vars['DriverProfile'] = $driver['DriverProfile'];
                $vars['DriverStats']['testimonials_approved'] = $this->Testimonial->find('count', array('conditions' => array('driver_id = ' => $driver['Driver']['id'], 'state = ' => 'A') ) );
                $vars['testimonials_total'] = $this->Testimonial->find('count', array('conditions' => array('state = ' => 'A') )) + 12 /* Un fake number para que los choferes sientan presion de solicitar testimonios */;
                
                $done = DriverTravelerConversation::$STATE_TRAVEL_DONE;$paid = DriverTravelerConversation::$STATE_TRAVEL_PAID;
                $vars['DriverStats']['travels_done'] =
                $this->DriverTravel->find( 
                    'count' , array('conditions' => 
                        array('driver_id = ' => $driver['Driver']['id'], "TravelConversationMeta.state in ('$done', '$paid')"
                        )
                    ) 
                );
                
                EmailsUtil::email($sender, 'Tus datos en YoTeLlevo', $vars, 'super', 'info_our_drivers');
            }
        }      
    }
    
    private function getPrettyMsgList($conversation, $driver_name, $traveler_name){
        $msg_list = $this->DriverTravelerConversation->find('all', array(
                'conditions' => array('DriverTravelerConversation.conversation_id'=>$conversation), 
                                      'recursive'  => -1,
                                      'order' => 'DriverTravelerConversation.id DESC',
                                      'limit' => 10
        ));

        $view = new View();
        $email_text = "";
        foreach($msg_list as $msg)
            $email_text .= trim ($view->element('pretty_message', array('message' => $msg['DriverTravelerConversation']) + compact('driver_name', 'traveler_name'))).'<br/><br/>';
            
        return $email_text;
    }
    
}

?>