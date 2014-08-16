<?php

App::uses('AppController', 'Controller');

class DriverTravelerConversationsController extends AppController {
    
    public $uses = array('DriverTravelerConversation', 'DriverTravel');
    
    public function view($conversationId) {
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));
        $data = $this->DriverTravel->findById($conversationId);
        $this->set('data', $data);
        
        $conversations = $this->DriverTravelerConversation->findAllByConversationId($conversationId);
        $this->set('conversations', $conversations);
    }
}

?>