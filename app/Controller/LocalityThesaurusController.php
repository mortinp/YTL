<?php

App::uses('AppController', 'Controller');

class LocalityThesaurusController extends AppController {
    
    public $uses = array('LocalityThesaurus', 'Locality');
    
    public function index() {
        $this->LocalityThesaurus->recursive = 0;
        //$this->set('thesaurus', $this->paginate());
        $this->set('thesaurus', $this->LocalityThesaurus->find('all'));
    }

    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {            
            $this->LocalityThesaurus->create();
            if ($this->LocalityThesaurus->save($this->request->data)) {
                //Cache::delete('localities');
                Cache::delete('localities_suggestion');
                
                $this->setInfoMessage('El término se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));                
            }
            $this->setErrorMessage('Ocurrió un error guardando el término.');
        }
        $this->set('localities', $this->Locality->getAsList());
    }

    public function edit($id = null) {
        $this->LocalityThesaurus->id = $id;
        if (!$this->LocalityThesaurus->exists()) {
            throw new NotFoundException('Término inválido.');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if ($this->LocalityThesaurus->save($this->request->data)) {
                //Cache::delete('localities');
                Cache::delete('localities_suggestion');
                
                $this->setInfoMessage('El término se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->setErrorMessage('Ocurrió un error salvando el térnmino');
        } else {
            $this->set('localities', $this->Locality->getAsList());
            $this->request->data = $this->LocalityThesaurus->read(null, $id);
        }
    }

    public function remove($id = null) {
        $this->LocalityThesaurus->id = $id;
        if (!$this->LocalityThesaurus->exists()) {
            throw new NotFoundException('Térnmino inválido');
        }
        if ($this->LocalityThesaurus->delete()) {
            //Cache::delete('localities');
            Cache::delete('localities_suggestion');
            
            $this->setInfoMessage('El térnmino se eliminó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurió un error eliminando el térnmino');
        }    
        return $this->redirect(array('action' => 'index'));
    }
}

?>