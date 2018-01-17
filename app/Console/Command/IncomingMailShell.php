<?php

App::uses('Travel', 'Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('EmailsUtil', 'Util');
App::uses('MessagesUtil', 'Util');
App::uses('SharedTravel', 'SharedTravels.Model');

require_once ("helper/mailReader.php");
//require_once ("Config/email.php");

class IncomingMailShell extends AppShell {
    
    public $uses = array('User', 'DriverTravel', 'Driver', 'DriverTravelerConversation', 'TravelConversationMeta', 'Testimonial', 'SharedTravels.SharedTravel');

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
                
                $mu = new MessagesUtil();
                $mu->sendMessage('traveler', $conversation, $sender, $body, $parser->attachments);
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
                
                $mu = new MessagesUtil();
                $mu->sendMessage('driver', $conversation, $sender, $body, $parser->attachments);
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
            
            
        }
        
        // MOBILE TEST
        else if($to === 'mviajero@'.Configure::read('domain_name')) {
            $conversation = $subject;
            $this->out($conversation);

            $mu = new MessagesUtil();
            $mu->sendMessage('driver', $conversation, $sender, $body, $parser->attachments);            
        }
        // ENDOF MOBILE TEST
        
        else if($to === 'verificacion-viaje@'.Configure::read('domain_name')) {
            
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
        } else if($to === 'compartido@'.Configure::read('domain_name')) {
            // TODO: Implementar la confirmacion de solicitud de viaje compartido
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $requestId = $matches[1];
                
                $this->out($requestId);
                
                $request = $this->SharedTravel->findByIdToken($requestId);
                
                print_r($request);
                
                // Sanity checks
                if($request == null || empty($request)) return;
                if($request['SharedTravel']['state'] != SharedTravel::$STATE_ACTIVATED) return; // Solo se puede confirmar cuando esta en estado ACTIVATED
                
                $datasource = $this->SharedTravel->getDataSource();
                $datasource->begin();
                
                $OK = $this->SharedTravel->confirmRequest($request);
                
                if($OK) $datasource->commit();
                else $datasource->rollback();
            }
        } else if($to === 'mauth@'.Configure::read('domain_name')) {
            
            $testEmail = Configure::read('mobile_test_email');            
            if($sender == $testEmail) {
                if($subject == 'bf361dc6bf0067bc818e1d4804027cabe754ce15') {
                    $Email = new CakeEmail('mauth');
                    $Email->to($testEmail)->subject('bf361dc6bf0067bc818e1d4804027cabe754ce15');
                    $Email->send('ok');
                } else {
                    $Email = new CakeEmail('mauth');
                    $Email->to($testEmail)->subject('bf361dc6bf0067bc818e1d4804027cabe754ce15');
                    $Email->send('fail');
                }
            }
        }     
    }  
}

?>