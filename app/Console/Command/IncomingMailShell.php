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
    
    private $TravelLogic;
    private $LocalityRouter;
    
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
        /*$stdin = fopen('php://stdin', 'r');
        $emailParser = new PlancakeEmailParser(stream_get_contents($stdin));
        fclose($stdin);
        
        $text = $emailParser->getHeader('From');
        preg_match('#\<(.*?)\>#', $text, $match);
        $sender = $match[1];
        if($sender == null || strlen($sender) == 0) $sender = $text;
        
        $target = $emailParser->getTo();        
        $to = $target[0];
        $to = str_replace('<', '', $to);
        $to = str_replace('>', '', $to);
        
        $subject = trim($emailParser->getSubject());
        
        $body = h($emailParser->getPlainBody()); // h() para escapar los caracteres html
        
        //print_r($emailParser->getRawFields());*/
        
        $parser = new mailReader();
        //$parser->debug = true;
        $parser->readEmail();
        
        $text = $parser->from;
        preg_match('#\<(.*?)\>#', $text, $match);
        $sender = $match[1];
        if($sender == null || strlen($sender) == 0) $sender = $text;
        
        $text = $parser->to;
        preg_match('#\<(.*?)\>#', $text, $match);
        $to = $match[1];
        if($to == null || strlen($to) == 0) $to = $text;
        /*$to = $parser->to;
        $to = str_replace('<', '', $to);
        $to = str_replace('>', '', $to);*/
        
        $subject = trim($parser->subject);
        
        $body = /*h(*/$parser->body/*)*/; // h() para escapar los caracteres html
        
        CakeLog::write('emails_received', 'Sender: '.$sender.' | To: '.$to.' | Subject: '.$subject.' | Body: '.$body);
        
        if($to === 'viajes@yotellevo.ahiteva.net') {
            CakeLog::write('travels_by_email', 'Travel Created - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
            
            $subject = str_replace("'", "", $subject);
            $subject = str_replace('"', "", $subject);

            $parseOK = preg_match('/(?<from>.+)-(?<to>.+)/', $subject, $matches);
            if($parseOK) {
                $origin = trim($matches['from']);
                $destination = trim($matches['to']);                
                
                preg_match_all('/(?<!\w)#\w+/', $body, $hashtags);

                $this->do_process($sender, $origin, $destination, $body, $hashtags[0]);
            } else {
                $this->out('Fail');
                CakeLog::write('travels_by_email', 'Error: Wrong Subject');
                if(Configure::read('enqueue_mail')) {
                    ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                            $sender,
                            array('subject' => $subject), 
                            array(
                                'template'=>'travel_by_email_wrong_subject',
                                'format'=>'html',
                                'subject'=>'Anuncio de Viaje Fallido (Origen-Destino incorrectos)',
                                'config'=>'no_responder')
                            );
                } else {
                    $Email = new CakeEmail('no_responder');
                    $Email->template('travel_by_email_wrong_subject')
                    ->viewVars(array('subject' => $subject))
                    ->emailFormat('html')
                    ->to($sender)
                    ->subject('Anuncio de Viaje Fallido (Origen-Destino incorrectos)');
                    try {
                        $Email->send();
                    } catch ( Exception $e ) {
                        // TODO: What to do here?
                    }
                } 
            }
            
            CakeLog::write('travels_by_email', '----------------------------------------------------------------------------');
            
        } else if($to === 'info@yotellevo.ahiteva.net') {
            CakeLog::write('info_requested', 'Info Requested - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
            
            if(Configure::read('enqueue_mail')) {
                ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $sender,
                        array(), 
                        array(
                            'template'=>'info',
                            'format'=>'html',
                            'subject'=>'Sobre YoTeLlevo',
                            'config'=>'no_responder')
                        );
            } else {
                $Email = new CakeEmail('no_responder');
                $Email->template('info')
                ->viewVars(array())
                ->emailFormat('html')
                ->to($sender)
                ->subject('Sobre YoTeLlevo');
                try {
                    $Email->send();
                } catch ( Exception $e ) {
                    // TODO: What to do here?
                }
            }
            
            CakeLog::write('info_requested', '----------------------------------------------------------------------------');
        } else if($to === 'chofer@yotellevo.ahiteva.net') {
            CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);            
            if($parser->attachments != null && is_array($parser->attachments) && !empty ($parser->attachments)) {
                CakeLog::write('conversations', 'Attachments:');
                //print_r($parser->attachments);
                foreach ($parser->attachments as $filename=>$value) {
                    //$this->out($filename);
                    CakeLog::write('conversations', $filename);
                }
            }
            
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $conversation = $matches[1];
                $this->out($conversation);
                
                CakeLog::write('conversations', 'Split Conversation:'.$conversation);
                
                $driverTravel = $this->DriverTravel->findById($conversation);
                
                if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
                    if(isset ($driverTravel['DriverTravel']['last_driver_email']) && 
                            $driverTravel['DriverTravel']['last_driver_email'] != null && strlen($driverTravel['DriverTravel']['last_driver_email']) != 0)
                        $deliverTo = $driverTravel['DriverTravel']['last_driver_email'];
                    else $deliverTo = $driverTravel['Driver']['username'];
                    
                    CakeLog::write('conversations', 'Deliver To:'.$deliverTo);

                    //print_r($driverTravel);
                    //$this->out($deliverTo);
                    //$this->out($body);

                    $datasource = $this->DriverTravelerConversation->getDataSource();
                    $datasource->begin();

                    $OK = $this->DriverTravelerConversation->save(array(
                        'conversation_id'=>$conversation,
                        'response_by'=>'traveler',
                        'response_text'=>$body
                    ));
                    if(!$OK) CakeLog::write('conversations', 'Error: No se pudo salvar la conversación en driver_traveler_conversations');

                    if($OK) ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $deliverTo,
                        array(/*'conversation'=>$conversation,*/ 'response'=>$body, 'travel_id'=>$driverTravel['DriverTravel']['travel_id'], 'travel'=>$driverTravel['Travel']),
                        array(
                            'template'=>'response_traveler2driver',
                            'format'=>'html',
                            'subject'=>$subject,
                            'config'=>'viajero',
                            'attachments'=>$parser->attachments) // TODO: habilitar una cuenta para respuestas de viajeros a choferes
                    );
                    if(!$OK) CakeLog::write('conversations', 'Error: No se pudo salvar en emails_queue');

                    if($OK) {
                        $datasource->commit();
                        CakeLog::write('conversations', 'Conversation Saved and Email Enqueued!');
                    } else {
                        $datasource->rollback();
                        CakeLog::write('conversations', 'Conversation Failed!');
                    }
                } else {
                    $this->out("No se encontró la conversacion");// TODO: 
                }
            }
            
            CakeLog::write('conversations', '----------------------------------------------------------------------------');
            
        }  else if($to === 'viajero@yotellevo.ahiteva.net') {
            CakeLog::write('conversations', 'Conversation - Sender: '.$sender.' | Subject: '.$subject.' | Body: '.$body);
            if($parser->attachments != null && is_array($parser->attachments) && !empty ($parser->attachments)) {
                CakeLog::write('conversations', 'Attachments:');
                //print_r($parser->attachments);
                foreach ($parser->attachments as $filename=>$value) {
                    //$this->out($filename);
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
                
                if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
                    $deliverTo = $driverTravel['Travel']['User']['username'];
                    
                    CakeLog::write('conversations', 'Deliver To:'.$deliverTo);
                
                    //print_r($driverTravel);
                    //$this->out($deliverTo);
                    //$this->out($body);

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
                        if(!$OK) CakeLog::write('conversations', 'Error: No se pudo actulizar el campo last_driver_email en la tabla drivers_travels');
                    }

                    if($OK) $OK = $this->DriverTravelerConversation->save(array(
                        'conversation_id'=>$conversation,
                        'response_by'=>'driver',
                        'response_text'=>$body
                    ));
                    if(!$OK) CakeLog::write('conversations', 'Error: No se pudo salvar la conversación en driver_traveler_conversations');

                    if($OK) ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $deliverTo,
                        array(/*'conversation'=>$conversation,*/ 'response'=>$body, 'driver_id'=>$driverTravel['DriverTravel']['driver_id'], 'travel'=>$driverTravel['Travel']),
                        array(
                            'template'=>'response_driver2traveler',
                            'format'=>'html',
                            'subject'=>$subject,
                            'config'=>'chofer',
                            'attachments'=>$parser->attachments) // TODO: habilitar una cuenta para respuestas de choferes a viajeros
                    );
                    if(!$OK) CakeLog::write('conversations', 'Error: No se pudo salvar en emails_queue');

                    if($OK) {
                        $datasource->commit();
                        CakeLog::write('conversations', 'Conversation Saved and Email Enqueued!');
                    }else {
                        $datasource->rollback();
                        CakeLog::write('conversations', 'Conversation Failed!');
                    }
                }else {
                    $this->out("No se encontro la conversacion");// TODO: 
                }
                
            }
            
            CakeLog::write('conversations', '----------------------------------------------------------------------------');
        }
        
        CakeLog::write('emails_received', '----------------------------------------------------------------------------');
    }
    
    private function do_process($sender, $origin, $destination, $description, $hashtags = array()) {
        
        $datasource = $this->TravelByEmail->getDataSource();
        $datasource->begin();
        $OK = true;
        
        $user = $this->User->findByUsername($sender);
            
        if($user == null || empty ($user)) {
            $user = array('User');
            $user['User']['username'] = $sender;
            $user['User']['password'] = 'email123';// TODO
            $user['User']['role'] = 'regular';
            $user['User']['active'] = true;
            $user['User']['email_confirmed'] = true;
            $user['User']['register_type'] = 'email';
            if($this->User->save($user)) {
                $userId = $this->User->getLastInsertID();
            } else {
                $OK = false;
            }

        } else {
            $userId = $user['User']['id'];
            
            if(!$user['User']['email_confirmed']) {
                
                $user['User']['email_confirmed'] = true;
                $this->User->id = $userId;
                $OK = $this->User->saveField('email_confirmed', '1');
            }
        }
        
        $this->LocalityRouter =& new LocalityRouterComponent(new ComponentCollection());
        $closest = $this->LocalityRouter->getMatch($origin, $destination);
        
        $result = array();        
        if($OK && $closest != null && !empty ($closest)) {
            $this->out(print_r($closest, true));
            
            $travel = array('TravelByEmail');
            $travel['TravelByEmail']['user_origin'] = $origin;
            $travel['TravelByEmail']['user_destination'] = $destination;
            $travel['TravelByEmail']['description'] = $description;
            $travel['TravelByEmail']['matched'] = $closest['name'];
            $travel['TravelByEmail']['locality_id'] = $closest['locality_id'];
            $travel['TravelByEmail']['where'] = $closest['direction'] == 0? $destination : $origin;
            $travel['TravelByEmail']['direction'] = $closest['direction'];
            $travel['TravelByEmail']['user_id'] = $userId;
            $travel['TravelByEmail']['state'] = Travel::$STATE_CONFIRMED;
            $travel['User'] = $user['User'];
            
            
            //print_r($hashtags);
            $travel['TravelByEmail']['need_modern_car'] = false;
            $travel['TravelByEmail']['need_air_conditioner'] = false;
            if($hashtags != null && !empty ($hashtags)) {
                foreach ($hashtags as $tag) {
                    echo strtolower($tag);
                    if(strtolower($tag) === '#moderno') $travel['TravelByEmail']['need_modern_car'] = true;
                    else if(strtolower($tag) === '#aire') $travel['TravelByEmail']['need_air_conditioner'] = true;
                }
            }
            
            
            $this->TravelLogic =& new TravelLogicComponent(new ComponentCollection());
            $result = $this->TravelLogic->confirmTravel('TravelByEmail', $travel);
            
            $OK = $result['success'];
            $this->out($result['message']);
            
        } else {
            $result['message'] = 'Origin and Destination not recognized';
            $OK = false;
        }
        
        $travelText = '('.$origin.' - '.$destination.' : '.$sender.')';
        
        if($OK) {
            $datasource->commit();
            CakeLog::write('travels_by_email', $travelText.' Mejor coincidencia: '.  $closest['name'].' -> '.(1.0 - $closest['distance']/strlen($closest['name'])).' [ACEPTADO]');
            
            if(Configure::read('enqueue_mail')) {
                ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $sender,
                        array('travel' => $travel), 
                        array(
                            'template'=>'travel_by_email_match',
                            'format'=>'html',
                            'subject'=>'Creado Anuncio de Viaje ('.$origin.'-'.$destination.')',
                            'config'=>'no_responder')
                        );
                
                //$this->out('email enqueued');
            } else {
                $Email = new CakeEmail('no_responder');
                $Email->template('travel_by_email_match')
                ->viewVars(array('travel' => $travel))
                ->emailFormat('html')
                ->to($sender)
                ->subject('Creado Anuncio de Viaje ('.$origin.'-'.$destination.')');
                try {
                    $Email->send();
                } catch ( Exception $e ) {
                    // TODO: What to do here?
                }
            }
        } else {
            $datasource->rollback();
            CakeLog::write('travels_by_email', $travelText.' [NO ACEPTADO: '.$result['message'].']');
            
            $this->out('Fail');
            
            $localities = $this->Locality->getAsList();
            $thesaurus = $this->LocalityThesaurus->find('all');
            if(Configure::read('enqueue_mail')) {
                ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $sender,
                        array(
                            'user_origin' => $origin, 
                            'user_destination' => $destination,
                            'localities' =>$localities,
                            'thesaurus' => $thesaurus
                            ), 
                        array(
                            'template'=>'travel_by_email_no_match',
                            'format'=>'html',
                            'subject'=>'Anuncio de Viaje Fallido ('.$origin.'-'.$destination.')',
                            'config'=>'no_responder')
                        );
                
                //$this->out('email enqueued');
            } else {
                $Email = new CakeEmail('no_responder');
                $Email->template('travel_by_email_no_match')
                ->viewVars(array(
                    'user_origin' => $origin, 
                    'user_destination' => $destination,
                    'localities' =>$localities,
                    'thesaurus' => $thesaurus
                ))
                ->emailFormat('html')
                ->to($sender)
                ->subject('Anuncio de Viaje Fallido');
                try {
                    $Email->send();
                } catch ( Exception $e ) {
                    // TODO: What to do here?
                }
            } 
        }
    }
}

?>
