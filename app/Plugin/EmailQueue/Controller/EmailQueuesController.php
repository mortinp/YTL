<?php

App::uses('AppController', 'Controller');

class EmailQueuesController extends AppController {
    
    public $uses = array('EmailQueue.EmailQueue', 'EmailQueue.EmailAttachment');
    
    public function isAuthorized($user) {
        if (in_array($this->action, array('get_attachments'))) {
            if($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') return true;
        }
        
        return parent::isAuthorized($user);
    }
    
    public function index() {
        $this->paginate = array('limit'=>500);
        $this->set('emails', $this->paginate());
    }
    
    public function remove($id = null) {
        $this->EmailQueue->id = $id;
        if (!$this->EmailQueue->exists()) {
            throw new NotFoundException('Email inválido');
        }
        if ($this->EmailQueue->delete()) {
            $this->setInfoMessage('El email se eliminó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurió un error eliminando el email');
        }    
        return $this->redirect(array('action' => 'index'));
    }
    
    public function remove_sent() {
        $conditions = array('sent'=>true, 'send_at <' => date('Y-m-d', strtotime("today - 2 weeks")));
        if ($this->EmailQueue->deleteAll($conditions)) {
            $this->setInfoMessage('Se eliminaron los emails correctamente');
        } else {
            $this->setErrorMessage('Ocurió un error eliminando los emails');
        }    
        return $this->redirect(array('action' => 'index'));
    }
    
    public function unlock($id = null) {
        $this->EmailQueue->id = $id;
        if (!$this->EmailQueue->exists()) {
            throw new NotFoundException('Email inválido');
        }
        if ($this->EmailQueue->saveField('locked', false)) {
            $this->setInfoMessage('El email se desbloqueó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurió un error desbloqueando el email');
        }    
        return $this->redirect(array('action' => 'index'));
    }
    
    public function reset($id = null) {
        $this->EmailQueue->id = $id;
        if (!$this->EmailQueue->exists()) {
            throw new NotFoundException('Email inválido');
        }
        if ($this->EmailQueue->saveField('send_tries', 0)) {
            $this->setInfoMessage('El email se reseteó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurió un error reseteando el email');
        }    
        return $this->redirect(array('action' => 'index'));
    }
    
    
    
    public function get_attachments($ids) {
        
        // Esto solo se puede llamar por ajax
        if(!$this->request->is('ajax')) throw new MethodNotAllowedException();
        
        $this->autoRender = false;
        
        $attachModel = ClassRegistry::init('EmailQueue.EmailAttachment'); // No pincha bien diciendo $this->EmailAttachment , no se por que...
        
        $list = $attachModel->getAttachments($ids);
        
        echo json_encode(array('attachments'=>$list));
    }
}

?>