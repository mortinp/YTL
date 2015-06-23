<?php

App::uses('AppController', 'Controller');
App::uses('LangController', 'Controller');

class DriverTravelerConversationsController extends AppController {
    
    public $uses = array('DriverTravelerConversation', 'DriverTravel',/*-*/ 'Driver', 'DriverProfile');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('show_profile');
    }
    
    public function view($conversationId) {
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));
        $data = $this->DriverTravel->findById($conversationId);
        $this->set('data', $data);
        
        $conversations = $this->DriverTravelerConversation->findAllByConversationId($conversationId);
        $this->set('conversations', $conversations);
    }
    
    public function resend($conversationId) {
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));
        $data = $this->DriverTravel->findById($conversationId);
    }
    
    public function show_profile($conversation) {
        $this->DriverTravel->recursive = 2;
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $driverTravel = $this->DriverTravel->findById($conversation);                
        if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
            
            // Driver with profile
            $driver = $driverTravel['Driver'];
            $this->DriverProfile->recursive = -1;
            $driver = array_merge($driver, $this->DriverProfile->findByDriverId($driver['id']));
            
            // User
            $user = $driverTravel['Travel']['User'];
            
            // Profile language
            $lang = $user['lang'];
            if($lang == null) $lang = Configure::read('default_language');
            
            //$this->Session->write('next.page.lang', $lang);
            $this->Cookie->write('app.lang', $lang, true, '+2 weeks');
            $this->Session->write('app.lang', $lang); // Escribir la Session por si no se puede escribir la Cookie
            
            return $this->redirect(array('controller'=>'drivers', 'action'=>'profile/'.$driver['DriverProfile']['driver_nick']/*.'/'.$lang.'/1'*/));
        } else {
            throw new NotFoundException();
        }
    }
}

?>