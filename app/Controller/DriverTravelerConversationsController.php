<?php

App::uses('AppController', 'Controller');
App::uses('LangController', 'Controller');
App::uses('DriverTravel', 'Model');
App::uses('DriverTravelerConversation', 'Model');
App::uses('EmailsUtil', 'Util');


class DriverTravelerConversationsController extends AppController {
    
    public $uses = array('DriverTravelerConversation', 'DriverTravel',/*-*/ 'Driver', 'DriverProfile', 'TravelConversationMeta', 'UserInteraction');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('show_profile');
    }
    
    public function isAuthorized($user) {
        if(in_array(AuthComponent::user('role'), array('admin', 'operator')) && in_array($this->action, array('view'))) 
            return true;
        
        return parent::isAuthorized($user);
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
    
    public function pin($conversationId) {
        $datasource = $this->TravelConversationMeta->getDataSource();
        $datasource->begin();
        
        $OK = $this->tag($conversationId, 'flag_type', 'F');
        if($OK) $OK = $this->update_meta_field($conversationId, false /*No autoredirect*/); // Esta funcion va a coger directamente del $this->request-data
        
        if($OK) $datasource->commit();
        else {
            $datasource->rollback();
            $this->setErrorMessage('Ocurrió un error pineando este viaje');
        }
        
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    public function unpin($conversationId) {
        $this->tag($conversationId, 'flag_type', null);
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    /**
     * @param conversationId: el id de la conversacion
     * @param state: el estado en que se va a poner la conversacion, por ejemplo DriverTravelerConversation::$STATE_TRAVEL_DONE
     */
    public function set_state($conversationId, $state) {
        $OK = $this->tag($conversationId, 'state', $state);
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    public function archive($conversationId) {
        $OK = $this->tag($conversationId, 'archived', 1);
        $this->redirect($this->referer());
    }
    public function unarchive($conversationId) {
        $OK = $this->tag($conversationId, 'archived', 0);
        $this->redirect($this->referer());
    }
    
        
    public function update_meta_field($id = null, $autoRedirect = true) {
        $this->DriverTravel->id = $id;
        if (!$this->DriverTravel->exists()) {
            throw new NotFoundException('Conversación inválida.');
        }
        //TODO: Verificar que la conversación ya está pagada
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->request->data['TravelConversationMeta']['conversation_id'] = $id;
            
            if ($this->TravelConversationMeta->save($this->request->data)) {
                $this->setInfoMessage('Se guardó el campo del viaje <b>'.$id.'</b> exitosamente.');
                
                if(!$autoRedirect) return true;
                return $this->redirect($this->referer());
            }
            
            if(!$autoRedirect) return false;
            $this->setErrorMessage('Ocurrió un error salvando el campo del viaje '.$id);
        } else throw new UnauthorizedException();
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
        } else throw new UnauthorizedException();
    }
    
    
    
    public function ask_confirmation_to_driver($id) {
        
        $this->DriverTravel->id = $id;
        if (!$this->DriverTravel->exists()) {
            throw new NotFoundException('Conversación inválida.');
        }
        
        $this->Driver->attachProfile($this->DriverTravel);
        
        $data = $this->DriverTravel->findById($id);
        
        $vars = array();
        $vars['travel_id'] = $data['Travel']['id'];
        $vars['travel_origin'] = $data['Travel']['origin'];
        $vars['travel_destination'] = $data['Travel']['destination'];
        $vars['travel_date'] = $data['Travel']['date'];
        $vars['conversation_id'] = $id;
        $vars['driver_name'] = (isset ($data['Driver']['DriverProfile']) && !empty($data['Driver']['DriverProfile']))? Driver::shortenName($data['Driver']['DriverProfile']['driver_name']):'chofer';
        
        $datasource = $this->TravelConversationMeta->getDataSource();
        $datasource->begin();

        $to = $data['Driver']['username'];
        $subject = 'Verificacion del viaje #'.$vars['travel_id'].' [['.$vars['conversation_id'].']]';
        $OK = EmailsUtil::email($to, $subject, $vars, 'verificacion_viaje', 'ask_confirmation_to_driver');
        if($OK) {
            $this->TravelConversationMeta->id = $vars['conversation_id'];
            $OK = $this->TravelConversationMeta->saveField('asked_confirmation', true);
        }

        if($OK) $datasource->commit(); else $datasource->rollback();
        
        return $this->redirect($this->referer().'#travel-verification');
    }
    
    
    
    
    /**
     * This function can only be accesed via ajax, and it returns all the metadata of a given conversation
     */
    public function view_meta($id) {
        if($this->request->is('ajax')) {
            // TODO: verificar si existen los metadatos para esta conversacion
            
            $conversation = $this->TravelConversationMeta->find('list', array('conditions'=>array('conversatin_id'=>$id)));
            return json_encode($conversation);
        } else throw new MethodNotAllowedException ();
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