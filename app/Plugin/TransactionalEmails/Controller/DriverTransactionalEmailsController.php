<?php

App::uses('AppController', 'Controller');

class DriverTransactionalEmailsController extends AppController {
    
    public $uses = array('TransactionalEmails.DriverTransactionalEmail');
    
    public function index() {
        $this->set('emails_sent', $this->DriverTransactionalEmail->find('all'));
    }
}

?>