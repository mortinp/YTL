<?php

App::uses('Travel', 'Model');
App::uses('CakeEmail', 'Network/Email');

App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('TravelLogicComponent', 'Controller/Component');
App::uses('LocalityRouterComponent', 'Controller/Component');

//require_once("PlancakeEmailParser.php");
require_once ("helper/mailReader.php");

class IncomingMailShell extends AppShell {
    
    public $uses = array('Locality', 'DriverLocality', 'TravelByEmail', 'User', 'LocalityThesaurus', 'DriverTravel', 'Driver', 'DriverTravelerConversation');

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
                    
                    
                    $fixedBody = $this->fixEmailBody($body);

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
                        
                        ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                            $deliverTo,
                            array('conversation_id'=>$conversation, 'response'=>$fixedBody, 'travel'=>$driverTravel['Travel'], 'driver_name'=>$driverName),
                            array(
                                'template'=>'response_traveler2driver',
                                'format'=>'html',
                                'subject'=>$subject,
                                'config'=>'viajero',
                                'attachments'=>$parser->attachments)
                        );
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
                $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));// TODO: como hacer que solo se haga recursive el Travel, de una mejor forma
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
                    
                    
                    $fixedBody = $this->fixEmailBody($body);
                    
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
                                'lang'=>$driverTravel['Travel']['User']['lang'])
                        );
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
        }        
    }
    
    
    public function fixEmailBody($body) {
        $fixedBody = $body;
        
        // Remove text after mark (asterisks)
        //$marker = '***************';
        /*$marker = '<div id="conversation-header">';
        list($fixedBody) = explode($marker, $body);*/
        
        // Remove all email addresses
        $emailpattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
        $replacement = '['.__d('conversation', 'correo borrado').']';
        $fixedBody = preg_replace($emailpattern, $replacement, $fixedBody);
        
        // Remove all urls
        //1- /\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i
        $urlpattern = "!\b(((ht|f)tp(s?))\://)?(www.|[a-z].)[a-z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk|cu)(\:[0-9]+)*(/($|[a-z0-9\.\,\;\?\\'\\\\\+&amp;%\$#\=~_\-]+))*\b!i";
        $replacement = '['.__d('conversation', 'url borrada').']';
        $fixedBody = preg_replace($urlpattern, $replacement, $fixedBody);
        
        // Remove the avatars
        //1.
        /*$avatarpattern = "/<img class=\"driver-avatar\"[^>]+\>/i";
        $replacement = '['.__d('conversation', 'imagen borrada').']';
        $fixedBody = preg_replace($avatarpattern, $replacement, $fixedBody);*/
        
        //2.
        $replacement = '['.__d('conversation', 'imagen borrada').']';
        $fixedBody = $this->removeTag($fixedBody,'driver-avatar','<img','/>', $replacement);
        
        // Remove the footer
        $fixedBody = $this->removeTag($fixedBody,'email-salute','<div','/div>');
        
        // Remove the social links
        $fixedBody = $this->removeTag($fixedBody,'social-link','<a','/a>');
        
        // Remove all appended text in previous conversations
        //$fixedBody = $this->removeTag1($fixedBody, 'appended-conversation-text', '<section', '/section>', '---/---');
        
        return $fixedBody;
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