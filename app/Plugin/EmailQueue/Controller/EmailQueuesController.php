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
        $this->set('emails', $this->EmailQueue->find('all'));
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
        
        $ids = split('-', $ids);
        
        $attachModel = ClassRegistry::init('EmailAttachment'); // No pincha bien diciendo $this->EmailAttachment , no se por que...

        // TODO: Haacer esto con un IN en la consulta para hacerlo de una sola vez
        $attachments = array();
        foreach ($ids as $id) {
            $attachments[] = $attachModel->findById($id);
        }
        
        $fullBaseUrl = Configure::read('App.fullBaseUrl');
        if(Configure::read('debug') > 0) $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        
        // Acomodar el resultado de tal forma que sea manejable en javascript
        $list = array();
        foreach ($attachments as $a) {
            $a['EmailAttachment']['url'] = $fullBaseUrl.'/'.str_replace('\\', '/', $a['EmailAttachment']['relfilepath']); // Adicionar este campo extra para poder renderear en la vista            
            $list[] = $a['EmailAttachment'];
        }
        
        echo json_encode(array('attachments'=>$list));
    }
}

?>