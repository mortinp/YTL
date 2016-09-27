<?php

App::uses('Travel', 'Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('EmailsUtil', 'Util');

// TODO: Me parece que estas 4 inclusiones de abajo no se usan ya (BORRAR)
/*App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('TravelLogicComponent', 'Controller/Component');
App::uses('LocalityRouterComponent', 'Controller/Component');*/

//require_once("PlancakeEmailParser.php");
require_once ("helper/mailReader.php");
//require_once ("Config/email.php");

class IncomingMailShell extends AppShell {
    
    public $uses = array('User', 'DriverTravel', 'Driver', 'DriverTravelerConversation', 'TravelConversationMeta' /*,'Locality', 'DriverLocality',*/ /*'TravelByEmail',*/ /*'LocalityThesaurus'*/ );

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
        
        //CakeLog::write('emails_raw', utf8_encode($raw));
        //CakeLog::write('emails_raw', "<span style='color:blue'>--------------------------------------------------------------------------------------------------</span>\n\n");
        
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
            //CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);  
            CakeLog::write('conversations', 'Conversation Started by Traveler: '.$sender);
            if($parser->attachments != null && is_array($parser->attachments) && !empty ($parser->attachments)) {
                CakeLog::write('conversations', 'Attachments:');
                foreach ($parser->attachments as $filename=>$value) {
                    CakeLog::write('conversations', $filename);
                }
            }
            
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                CakeLog::write('conversations', 'Split Conversation:'.$conversation);
                
                $this->Driver->attachProfile($this->DriverTravel); // Esto es para poder coger el nombre de chofer
                
                $driverTravel = $this->DriverTravel->findById($conversation);
                
                //print_r($driverTravel);
                
                if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
                    if(isset ($driverTravel['DriverTravel']['last_driver_email']) && 
                            $driverTravel['DriverTravel']['last_driver_email'] != null && strlen($driverTravel['DriverTravel']['last_driver_email']) != 0)
                        $deliverTo = $driverTravel['DriverTravel']['last_driver_email'];
                    else $deliverTo = $driverTravel['Driver']['username'];
                    
                    CakeLog::write('conversations', 'Deliver To:'.$deliverTo);

                    $datasource = $this->DriverTravelerConversation->getDataSource();
                    $datasource->begin();
                    
                    
                    $fixedBody = $this->fixEmailBody($this->removeAllEmailAddresses($body));

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
                        
                        // El $returnData es para coger los ids de los attachments que hayan
                        $returnData = array(0); // Este 0 hay que ponerselo porque si no la referencia parece que es nula!!! esta raro esto pero bueno...
                        ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                            $deliverTo,
                            array('conversation_id'=>$conversation, 'response'=>$fixedBody, 'travel'=>$driverTravel['Travel'], 'driver_name'=>$driverName),
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
                        CakeLog::write('conversations', 'Conversation Saved and Email Enqueued!');
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
                // TODO
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
            
            CakeLog::write('conversations', "<span style='color:blue'>---------------------------------------------------------------------------------------------------------</span>\n\n");
            
        }  else if($to === 'viajero@'.Configure::read('domain_name') || $to === 'viaje@'.Configure::read('domain_name')) {
            //CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
            CakeLog::write('conversations', 'Conversation Started by Driver: '.$sender);
            if($parser->attachments != null && is_array($parser->attachments) && !empty ($parser->attachments)) {
                CakeLog::write('conversations', 'Attachments:');
                foreach ($parser->attachments as $filename=>$value) {
                    CakeLog::write('conversations', $filename);
                }
            }
            
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                CakeLog::write('conversations', 'Split Conversation:'.$conversation);
                
                $this->DriverTravel->recursive = 2;
                $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
                $driverTravel = $this->DriverTravel->findById($conversation);
                
                //print_r($driverTravel['Driver']) ;
                
                if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
                    $deliverTo = $driverTravel['Travel']['User']['username'];
                    
                    CakeLog::write('conversations', 'Deliver To:'.$deliverTo);

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
                    if(isset ($driverTravel['Travel']['User']['lang']) && $driverTravel['Travel']['User']['lang'] != null)
                        Configure::write('Config.language', $driverTravel['Travel']['User']['lang']);
                    
                    $fixedBody = $this->fixEmailBody($this->removeAllUrls($this->removeAllEmailAddresses($body)));
                    
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
                            array('conversation_id'=>$conversation, 'response'=>$fixedBody,'driver'=>$driverTravel['Driver'], 'travel'=>$driverTravel['Travel']),
                            array(
                                'layout'=>$layout,
                                'template'=>$template,
                                'format'=>'html',
                                'subject'=>$subject,
                                'config'=>'chofer',
                                'attachments'=>$parser->attachments,
                                'lang'=>$driverTravel['Travel']['User']['lang'],
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
                        CakeLog::write('conversations', 'Conversation Saved and Email Enqueued!');
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
                // TODO
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
            
            CakeLog::write('conversations', "<span style='color:blue'>---------------------------------------------------------------------------------------------------------</span>\n\n");
        } else if($to === 'verificacion-viaje@'.Configure::read('domain_name')) {
            CakeLog::write('travel_confirmations', "<span style='color:blue'>------------------------CONFIRMATION RECEIVED------------------------------</span>\n\n");
            
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                CakeLog::write('travel_confirmations', "Parsed Conversation: ".$conversation."\n\n");
                
                $meta = $this->TravelConversationMeta->findByConversationId($conversation);
                
                if($meta == null || empty ($meta)) {
                    CakeLog::write('travel_confirmations', "Conversation NOT FOUND\n\n");
                    return;
                }// no hacer nada si no existe la conversacion
                
                $newMessage = trim($body);
                CakeLog::write('travel_confirmations', "Message: ".$newMessage."\n\n");
                CakeLog::write('travel_confirmations', "Starting to cut message\n\n");
                if(strpos($newMessage, '**********')) $newMessage = substr($newMessage, 0, strpos($newMessage, '**********'));
                CakeLog::write('travel_confirmations', "Cut Message: ".$newMessage."\n\n");
                
                // Verificar si ya se habia recibido otra confirmacion anterior de esta misma conversacion; agregarle el nuevo texto en caso de que sí.
                if(isset ($meta['TravelConversationMeta']['received_confirmation_details']) && $meta['TravelConversationMeta']['received_confirmation_details'] != null)
                    $newMessage = 
                        $meta['TravelConversationMeta']['received_confirmation_details'].
                        "\r\n\r\n (...)\r\n\r\n".
                        $newMessage;
                CakeLog::write('travel_confirmations', "Fixed Message: ".$newMessage."\n\n");
                
                $meta = array('TravelConversationMeta'=>array(
                    'conversation_id'=>$conversation, 
                    'received_confirmation_details'=>$newMessage, 
                    'received_confirmation_type'=>'K'/*Unknown*/,
                    'asked_confirmation'=>true));
                
                CakeLog::write('travel_confirmations', "Dataset ready to be saved\n\n");
                
                if(!$this->TravelConversationMeta->save($meta)) {
                    CakeLog::write('travel_confirmations', "Error saving data on DB\n\n");
                } else {
                    CakeLog::write('travel_confirmations', "Data saved on DB\n\n");
                }
            } else {
                CakeLog::write('travel_confirmations', "Error parsing conversation id\n\n");
            }
            
            CakeLog::write('travel_confirmations', "<span style='color:blue'>------------------------CONFIRMATION ENDED------------------------------</span>\n\n");
        } else if($to === 'info-chofer@'.Configure::read('domain_name')) {
            // Hacer el info choferes
            EmailsUtil::email($sender, 'Sobre YoTeLlevo', array(), 'super', 'info_drivers');
        }      
    }
    
    
    public function fixEmailBody($body) {
        $fixedBody = $body;
        
        // Remove the avatars
        $replacement = '['.__d('conversation', 'imagen borrada').']';
        $fixedBody = $this->removeTag($fixedBody,'driver-avatar','<img','/>', $replacement);
        
        // Remove the footer
        $fixedBody = $this->removeTag($fixedBody,'email-salute','<div','/div>');
        
        // Remove the social links
        $fixedBody = $this->removeTag($fixedBody,'social-link','<a','/a>');
        
        return $fixedBody;
    }
    
    public function removeAllEmailAddresses($text) {
        $fixedText = $text;
        
        $emailpattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
        $replacement = '['.__d('conversation', 'correo borrado').']';
        $fixedText = preg_replace($emailpattern, $replacement, $fixedText);
        
        return $fixedText;
    }
    
    public function removeAllUrls($text) {
        $fixedText = $text;
        
        $urlpattern = "!\b(((ht|f)tp(s?))\://)?(www.|[a-z].)[a-z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk|cu)(\:[0-9]+)*(/($|[a-z0-9\.\,\;\?\\'\\\\\+&amp;%\$#\=~_\-]+))*\b!i";
        $replacement = '['.__d('conversation', 'url borrada').']';
        $fixedText = preg_replace($urlpattern, $replacement, $fixedText);
        
        return $fixedText;
    }
    
    
    //str - string to search 
    //id - text to search for
    //start_tag - start delimiter to remove
    //end_tag - end delimiter to remove
    function removeTag($str, $id, $start_tag, $end_tag, $replacement = '') { // Source: http://www.katcode.com/php-html-parsing-extracting-and-removing-html-tag-of-specific-class-from-string/
        //find position of tag identifier. loops until all instance of text removed
        while(($pos_srch = strpos($str,$id))!==false) {
            //get text before identifier
            $beg = substr($str,0,$pos_srch);
            //get position of start tag
            $pos_start_tag = strrpos($beg,$start_tag);
            //echo 'start: '.$pos_start_tag.'<br>';
            //extract text up to but not including start tag
            $beg = substr($beg,0,$pos_start_tag);
            //echo "beg: ".$beg."<br>";

            //get text from identifier and on
            $end = substr($str,$pos_srch);

            //get length of end tag
            $end_tag_len = strlen($end_tag);
            //find position of end tag
            $pos_end_tag = strpos($end,$end_tag);
            //extract after end tag and on
            $end = substr($end,$pos_end_tag+$end_tag_len);

            $str = $beg.$replacement.$end;
        }

        //return processed string
        return $str;
    } 
    
    function removeTag1($str, $id, $start_tag, $end_tag, $replacement = '') {
        //find position of tag identifier. loops until all instance of text removed
        while(($pos_srch = strpos($str,$id)) !== false) {
            //get text before identifier
            $beg = substr($str, 0, $pos_srch);
            //get position of start tag
            $pos_start_tag = strrpos($beg, $start_tag);
            //extract text up to but not including start tag
            $beg = substr($beg, 0, $pos_start_tag);
            //echo “beg: “.$beg.”";
            //get text from identifier and on
            $end = substr($str, $pos_srch);
            //get length of end tag
            $end_tag_len = strlen($end_tag);
            //find the first position of end tag
            $pos_end_tag = strpos($end, $end_tag);
            //compare the number of start tags and end tags within the current end tag pointed to
            //there should be equal number of start tags and end tags (considering children of same tag)
            while (substr_count(substr($end, 0, $pos_end_tag), $start_tag) < substr_count(substr($end, 0, $pos_end_tag), $end_tag)) {
                //find position of next end tag
                $pos_end_tag = strpos($end, $end_tag, $pos_end_tag);
            }
            //extract after end tag and on
            $end = substr($end, $pos_end_tag + $end_tag_len);
            $str = $beg.$replacement.$end;
        }
        //return processed string
        return $str;
    }

    
    //str - string to search
    //id - text to search for
    //start_tag - start delimiter
    //end_tag - end delimiter
    function extractTag($str, $id, $start_tag, $end_tag) { // Source: http://www.katcode.com/php-html-parsing-extracting-and-removing-html-tag-of-specific-class-from-string/
         if($id) {
             $pos_srch = strpos($str,$id);
             //extract string up to id value
             $beg = substr($str,0,$pos_srch);

             //get position of start delimiter
             $pos_start_tag = strrpos($beg,$start_tag);
         }
         else
            $pos_start_tag = strpos($str,$start_tag); //if no id value get first tag found

         //get position of end delimiter
         $pos_end_tag = strpos($str,$end_tag,$pos_start_tag);
         //length of end deilimter
         $end_tag_len = strlen($end_tag);
         //length of string to extract
         $len = ($pos_end_tag+$end_tag_len)-$pos_start_tag;
         //Extract the tag
         $tag = substr($str,$pos_start_tag,$len);

         return $tag;
    }
}

?>