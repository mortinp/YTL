<?php

App::uses('AppController', 'Controller');
App::uses('LangController', 'Controller');

class DriverTravelerConversationsController extends AppController {
    
    public $uses = array('DriverTravelerConversation', 'DriverTravel',/*-*/ 'Driver', 'DriverProfile', 'TravelConversationMeta');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('show_profile');
    }
    
    public function view($conversationId) {
        // Bindings and unbindings to avoid extra data
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $this->Driver->unbindModel(array('hasOne'=>array('DriverProfile')));
        $this->DriverTravel->recursive = 2;
        
        $data = $this->DriverTravel->findById($conversationId);
        $this->set('data', $data);
        
        $conversations = $this->DriverTravelerConversation->findAllByConversationId($conversationId);
        $this->set('conversations', $conversations);
    }
    
    public function resend($conversationId) {
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));
        $data = $this->DriverTravel->findById($conversationId);
    }
    
    private function tag($conversationId, $tagName, $value) {
        
        // TODO: Verificar que la conversacion existe
        $this->TravelConversationMeta->id = $conversationId;
        $meta = array();
        
        $meta['TravelConversationMeta']['conversation_id'] = $conversationId;
        $meta['TravelConversationMeta'][$tagName] = $value;
        
        $OK = true;
        if (!$this->TravelConversationMeta->save($meta)) {
            $OK = false;
            $this->setErrorMessage('Ocurrió un error.');
        }
        
        return $OK;
    }
    
    public function follow($conversationId, $following = true) {
        $this->tag($conversationId, 'following', true);        
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    public function unfollow($conversationId) {
        $this->tag($conversationId, 'following', false);
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    public function set_state($conversationId, $state) {
        $this->tag($conversationId, 'state', $state);
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    
    public function update_read_entries($conversationId, $entriesCount) {
        
        // TODO: Verificar que la cantidad de entradas es igual o menor que la real
        
        $this->TravelConversationMeta->id = $conversationId;
        $meta = array();
        
        $meta['TravelConversationMeta']['conversation_id'] = $conversationId;
        $meta['TravelConversationMeta']['read_entry_count'] = $entriesCount;
        
        if ($this->TravelConversationMeta->save($meta)) {
            $this->setSuccessMessage('Se marcaron todos los mensajes de este viaje como leídos');
        } else {
            $this->setErrorMessage('Ocurrió un error.');
        }
        
        $this->redirect(array('action' => 'view/'.$conversationId));
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