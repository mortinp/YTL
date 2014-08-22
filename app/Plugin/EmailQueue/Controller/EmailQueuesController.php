<?php

App::uses('AppController', 'Controller');

class EmailQueuesController extends AppController {
    
    public $uses = array('EmailQueue', 'EmailAttachment');
    
    public function index() {
        $this->set('emails', $this->EmailQueue->find('all'));
    }
}

?>