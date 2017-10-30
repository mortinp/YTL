<?php

App::uses('AppController', 'Controller');
App::uses('LangController', 'Controller');
App::uses('DriverTravel', 'Model');
App::uses('DriverTravelerConversation', 'Model');
App::uses('User', 'Model');
App::uses('EmailsUtil', 'Util');
App::uses('MessagesUtil', 'Util');


class DriverTravelerConversationsController extends AppController {
    
    public $uses = array('DriverTravelerConversation', 'DriverTravel',/*-*/ 'Driver', 'DriverProfile', 'TravelConversationMeta', 'UserInteraction');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('show_profile');
    }
    
    public function isAuthorized($user) {
        if ($this->action ==='messages' || $this->action ==='msg_to_driver') {
            if($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') return true;
        }
        
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
    
    public function messages($conversationId) {
        return $this->view($conversationId);
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
            if($this->request->is('ajax'))
                throw new BadRequestException('Ocurrió un error.');
            
            $OK = false;
            $this->setErrorMessage('Ocurrió un error.');
        }
        
        return $OK;
    }
    
    public function follow($conversationId, $following = true) {
        $this->tag($conversationId, 'following', true);
        
        if($this->request->is('ajax')){
            $this->autoRender = false;
            echo json_encode(array('follow'));
            return;
        }
        
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    public function unfollow($conversationId) {
        $this->tag($conversationId, 'following', false);
        
        if($this->request->is('ajax')){
            $this->autoRender = false;
            echo json_encode(array('unfollow'));
            return;
        }
        
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    public function pin($conversationId) {
        // Ponerle el usuario que hizo el comentario al final del comentario
        $user = AuthComponent::user();
        $this->request->data['TravelConversationMeta']['flag_comment'] = 
            trim($this->request->data['TravelConversationMeta']['flag_comment']).'<br/><b>- Comentario por '.User::prettyName($user).' -</b>';
        
        
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
        
        if($this->request->is('ajax')){
            $this->autoRender = false;
            $data = $this->DriverTravel->findById($conversationId);
            $conversations = $this->DriverTravelerConversation->findAllByConversationId($conversationId);
            
            $view = new View();
            $elements = array(
                'conversation_toolbox_states' => $view->element('conversation_toolbox_states', compact('data')),
                'addon_travel_verification'   => $view->element('addon_travel_verification', compact('data', 'conversations')),
                'addon_testimonial_request'   => $view->element('addon_testimonial_request', compact('data')),
                'state'                       => $state
            );
            
            echo json_encode($elements);
            return;
        }
        
        
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
        // Verificar que la cantidad de entradas es igual o menor que la real
        $Total = $this->DriverTravelerConversation->find( 'count', array('conditions' => array('conversation_id' => "$conversationId") ) );
        if($entriesCount > $Total){
            if($this->request->is('ajax'))
                throw new BadRequestException("Se está intentando marcar como leídos $entriesCount mensajes de un total de $Total");
            
           $this->setErrorMessage("Se está intentando marcar como leídos $entriesCount mensajes de un total de $Total"); 
           return;
        }        
        
        // Sanity check passed       
        
        // Preparar consulta para marcar los mensajes con el operador que los leyo
        $username = User::prettyName( $this->Auth->user() );
        $query = "update driver_traveler_conversations\n".
                 "set read_by = '$username', date_read = now()\n".
                 "where conversation_id = '$conversationId' and read_by is null";
        // TODO: Esto se puede hacer con un saveField()
        
        $OK = true;
        $datasource = $this->TravelConversationMeta->getDataSource();
        $datasource->begin();
        
        // Marcar los mensajes con el operador que los leyo
        try{ $this->TravelConversationMeta->query($query); }
        catch(Exception $error){ $OK = false; }
      
        if($OK){
            $this->TravelConversationMeta->id = $conversationId;
            $meta = array();

            $meta['TravelConversationMeta']['conversation_id'] = $conversationId;
            $meta['TravelConversationMeta']['read_entry_count'] = $entriesCount;
            
            $OK = $this->TravelConversationMeta->save($meta);
        }
        
        if($this->request->is('ajax')){
            $this->autoRender = false;
          
            if($OK){
                echo json_encode (array('Se marcaron todos los mensajes de este viaje como leídos'));
                $datasource->commit();
            } else throw new BadRequestException('Ocurrió un error salvando los datos.');
            
            return;
        }
        
        if ($OK) {
            $this->setSuccessMessage('Se marcaron todos los mensajes de este viaje como leídos');
            $datasource->commit();
        } else {
           $datasource->rollback();
           $this->setErrorMessage('Ocurrió un error salvando los datos.');
        }
        
        $this->redirect(array('action' => 'view/'.$conversationId));
    }
    
    
    public function set_income($id = null) {
        $this->TravelConversationMeta->id = $id;
        if (!$this->TravelConversationMeta->exists()) {
            throw new NotFoundException('Conversación inválida.');
        }
        $beforeSave = $this->TravelConversationMeta->findByConversationId($id);
        //TODO: Verificar que la conversación ya está pagada
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->request->data['TravelConversationMeta']['conversation_id'] = $id;
            
            if ($this->TravelConversationMeta->save($this->request->data)) {
                $this->setInfoMessage('Se guardó la ganancia del viaje <b>'.$id.'</b> exitosamente.');
                
                if($this->request->is('ajax')){
                    $this->autoRender = false;
                    echo json_encode( array('object' => array(
                        'id'                => $id,
                        'income'            => $this->request->data['TravelConversationMeta']['income'],
                        'income_saving'     => $this->request->data['TravelConversationMeta']['income_saving'],
                        'income_dif'        => $this->request->data['TravelConversationMeta']['income'] - $beforeSave['TravelConversationMeta']['income'],
                        'income_saving_dif' => $this->request->data['TravelConversationMeta']['income_saving'] - $beforeSave['TravelConversationMeta']['income_saving']
                    )));
                    return;
                }
                
                return $this->redirect($this->referer());
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
        $vars['travel_id']          = DriverTravel::getIdentifier($data);
        $vars['travel_date']        = $data['DriverTravel']['travel_date'];
        $vars['conversation_id']    = $id;
        $vars['driver_name']        = (isset ($data['Driver']['DriverProfile']) && !empty($data['Driver']['DriverProfile']))? Driver::shortenName($data['Driver']['DriverProfile']['driver_name']):'chofer';
        $vars['notification_type']  = $data['DriverTravel']['notification_type'];
        if($data['DriverTravel']['notification_type'] != DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE){
            $vars['travel_origin']      = $data['Travel']['origin'];
            $vars['travel_destination'] = $data['Travel']['destination'];
        }
        
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
        
        return $this->redirect($this->referer());
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
    
    
    
    public function show_profile($conversation) {
        $this->DriverTravel->recursive = 2;
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $driverTravel = $this->DriverTravel->findById($conversation);                
        if($driverTravel != null && is_array($driverTravel) && !empty ($driverTravel)) {
            
            /*// Driver with profile
            $driver = $driverTravel['Driver'];
            $this->DriverProfile->recursive = -1;
            $driver = array_merge($driver, $this->DriverProfile->findByDriverId($driver['id']));*/
            
            // Poner en la session que este usuario ya esta contactando con este chofer.
            // Esto se usa por ejemplo, para en el perfil no mostrar la opcion de contactar directamente a este chofer
            $this->Session->write('visited-driver-'.$driverTravel['Driver']['id'], $conversation);
            
            return $this->redirect(array('controller'=>'drivers', 'action'=>'profile/'.$driverTravel['Driver']['DriverProfile']['driver_nick']));
        } else {
            throw new NotFoundException();
        }
    }
    
    public function archive_state() {
        $tabla = array('drivers_travels', 'driver_traveler_conversations', 'travels_conversations_meta');
        $query = "select count(*) as total from archive_%s;";
        
        for($i = 0; $i < 3; $i++){
           $result = $this->DriverTravel->query( sprintf($query, $tabla[$i]) );
           $data[$tabla[$i]] = $result[0][0]['total']; 
        }   
        $this->set('data', $data);
    }
    
    public function msg_to_driver(){  
        $data = $this->request->data['DriverTravelerConversation'];
        $adjunto = $data['adjunto'];
        
        $attachment = array();
        if($adjunto['name'] != '')
            $attachment = array($adjunto['name'] => array('contents' => file_get_contents($adjunto['tmp_name']), 'mimetype' => $adjunto['type']));
        
        $sender = $this->Auth->user('username');
        $mu = new MessagesUtil();
        $msgId = $mu->sendMessage('traveler', $data['conversation_id'], $sender, $data['body'], $attachment);
        
        // 
        $parts = preg_split('/highlight=message-[0-9]+/', $this->referer());
        $redirect = (substr($parts[0], -1) != '?')? $parts[0]:substr($parts[0], 0, -1);
        if(count($parts) == 1)  $redirect .= '?highlight=message-'.$msgId;
        else                    $redirect .= '?highlight=message-'.$msgId . $parts[1];
        return $this->redirect($redirect);
        
        //return $this->redirect(array('action' => 'messages', $data['conversation_id']), '?highlight=message-'.$msgId);
    }
    
}

?>