<?php

App::uses('AppController', 'Controller');
App::uses('ExpiredLinkException', 'Error');

class UrlInvitationsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('visit');
    }
    
    public function index() {
        $this->set('invitations', $this->UrlInvitation->find('all'));
    }
    
    public function add() {
        if ($this->request->is('post')) {
            
            $this->UrlInvitation->create();
            
            // Hay que ponerle siempre un slash (/) delante a la url que se va a compartir
            if(substr($this->request->data['UrlInvitation']['url'], 0, 1) != '/') $this->request->data['UrlInvitation']['url'] = '/'.$this->request->data['UrlInvitation']['url'];
            
            if ($this->UrlInvitation->save($this->request->data)) {
                $this->setInfoMessage('La invitación se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->setErrorMessage('Ocurrió un error guardando la invitación.');
        }
        
        // Show view
    }
    
    public function visit($id) {
        $this->UrlInvitation->id = $id;
        if(!$this->UrlInvitation->exists()) throw new NotFoundException ();
        
        $invitation = $this->UrlInvitation->findById($id);
        
        if($invitation['UrlInvitation']['visited_count'] >= $invitation['UrlInvitation']['allowed_visits_count']) throw new ExpiredLinkException ();
        
        // Contar la visita solo si el usuario no es un administrador
        if(!$this->Auth->loggedIn() || !in_array(AuthComponent::user('role'), array('admin', 'tester'))) {
            $this->UrlInvitation->saveField('visited_count', $invitation['UrlInvitation']['visited_count'] + 1);
        }
        
        $this->Session->id(); // Asegurandome de que la sesion se inicie si no se habia iniciado (ver docs de SessionComponent::id())
        
        // TODO: buscar una forma de no permitir una acción específica solamente, pues esto lleva a fallas de seguridad
        // O sea, seria bueno poder especificar por ejemplo, la url de una conversacion sin tener que permitir la action view globalmente
        $this->Session->write('allowed_action', $invitation['UrlInvitation']['action_to_allow']);
        $this->redirect($invitation['UrlInvitation']['url']);
    }
}

?>