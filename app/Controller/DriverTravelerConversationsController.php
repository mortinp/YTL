<?php

App::uses('AppController', 'Controller');
App::uses('LangController', 'Controller');
App::uses('DriverTravel', 'Model');
App::uses('DriverTravelerConversation', 'Model');


class DriverTravelerConversationsController extends AppController {
    
    public $uses = array('DriverTravelerConversation', 'DriverTravel',/*-*/ 'Driver', 'DriverProfile', 'TravelConversationMeta', 'UserInteraction');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('show_profile');
    }
    
    public function view($conversationId) {
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));        
        $this->Driver->attachProfile($this->DriverTravel);
        
        $data = $this->DriverTravel->findById($conversationId);
        $this->set('data', $data);
        
        $conversations = $this->DriverTravelerConversation->findAllByConversationId($conversationId);
        $this->set('conversations', $conversations);
    }
    
    public function resend($conversationId) {
        $this->DriverTravel->bindModel(array('belongsTo'=>array('Travel')));
        $data = $this->DriverTravel->findById($conversationId);
    }
    
    // Administracion    
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
    
    /**
     * 
     * @param conversationId: el id de la conversacion
     * @param state: el estado en que se va a poner la conversacion, por ejemplo DriverTravelerConversation::$STATE_TRAVEL_DONE
     * 
     * @param userId: [opcional] Se usa para algunas cosas, y es un parámetro que se pasa para hacer más eficiente esta funcion, 
     * por ejemplo cuando hay que buscar el usuario de la conversacion.
     */
    public function set_state($conversationId, $state, $userId = null) {
        $OK = $this->tag($conversationId, 'state', $state);
        
        // Realizar algunas acciones que dependen del estado en que se esta poniendo la conversacion
        if($OK) { 
            if($state == DriverTravelerConversation::$STATE_TRAVEL_DONE) {
                // Generar un código de interacción para que el usuario deje una review del viaje
                if($userId != null) {
                    $this->UserInteraction->getInteractionCode($userId, UserInteraction::$INTERACTION_TYPE_WRITE_REVIEW);
                }
            }
        }
        
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
    
    
    public function set_income($id = null) {
        $this->TravelConversationMeta->id = $id;
        if (!$this->TravelConversationMeta->exists()) {
            throw new NotFoundException('Conversación inválida.');
        }
        //TODO: Verificar que la conversación ya está pagada
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->request->data['TravelConversationMeta']['conversation_id'] = $id;
            
            if ($this->TravelConversationMeta->save($this->request->data)) {
                $this->setInfoMessage('Se guardó la ganancia del viaje <b>'.$id.'</b> exitosamente.');
                return $this->redirect($this->referer()/*array('controller'=>'driver_travels', 'action' => 'view_filtered/'.DriverTravel::$SEARCH_PAID)*/);
            }
            $this->setErrorMessage('Ocurrió un error salvando la ganacia del viaje '.$id);
        } else
            throw new UnauthorizedException();
    }
    
    
    
    
    // Otros
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