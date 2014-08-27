<?php

App::uses('AppController', 'Controller');

class EmailQueuesController extends AppController {
    
    public $uses = array('EmailQueue.EmailQueue', 'EmailQueue.EmailAttachment');
    
    public function index() {
        $this->set('emails', $this->EmailQueue->find('all'));
    }
    
    public function remove($id = null) {
        $this->EmailQueue->id = $id;
        if (!$this->EmailQueue->exists()) {
            throw new NotFoundException(__('Email inválido'));
        }
        if ($this->EmailQueue->delete()) {
            $this->setInfoMessage('El email se eliminó exitosamente.');
        } else {
            $this->setErrorMessage(__('Ocurió un error eliminando el email'));
        }    
        return $this->redirect(array('action' => 'index'));
    }
    
    public function unlock($id = null) {
        $this->EmailQueue->id = $id;
        if (!$this->EmailQueue->exists()) {
            throw new NotFoundException(__('Email inválido'));
        }
        if ($this->EmailQueue->saveField('locked', false)) {
            $this->setInfoMessage('El email se desbloqueó exitosamente.');
        } else {
            $this->setErrorMessage(__('Ocurió un error desbloqueando el email'));
        }    
        return $this->redirect(array('action' => 'index'));
    }
}

?>