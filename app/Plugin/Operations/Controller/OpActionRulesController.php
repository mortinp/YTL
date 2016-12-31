<?php

App::uses('AppController', 'Controller');

class OpActionRulesController extends AppController {
    
    public $uses = array('Operations.OpActionRule', 'User');
    
    public function index() {
        $this->set('rules', $this->OpActionRule->find('all'));
        $this->set('operators', $this->User->getOperatorsList());
    }
    
    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->OpActionRule->create();
            if ($this->OpActionRule->save($this->request->data)) return $this->redirect(array('action' => 'index')); 
            
            $this->setErrorMessage('Ocurrió un error guardando la regla.');
            
        } else throw new BadRequestException();
    }
    
    
    public function allow($id) {
        $this->checkExists($id);
        $this->OpActionRule->saveField('allowed_by_owner', true);
        $this->redirect($this->referer());
    }
    
    public function disallow($id) {
        $this->checkExists($id);
        $this->OpActionRule->saveField('allowed_by_owner', false);
        $this->redirect($this->referer());
    }
    
    public function activate($id) {
        $this->checkExists($id);
        $this->OpActionRule->saveField('accepted_by_other', true);
        $this->redirect($this->referer());
    }
    
    public function disactivate($id) {
        $this->checkExists($id);
        $this->OpActionRule->saveField('accepted_by_other', false);
        $this->redirect($this->referer());
    }
    
    private function checkExists($id) {
        $this->OpActionRule->id = $id;
        if(!$this->OpActionRule->exists()) throw new NotFoundException ();
    }
}

?>