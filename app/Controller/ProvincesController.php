<?php

App::uses('AppController', 'Controller');

class ProvincesController extends AppController {
    
    public function index() {
        $this->Province->recursive = 0;
        $this->set('provinces', $this->paginate());
    }

    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {            
            $this->Province->create();
            if ($this->Province->save($this->request->data)) {
                Cache::delete('localities');
                Cache::delete('localities_suggestion');
                
                $this->setInfoMessage('La provincia se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));                
            }
            $this->setErrorMessage('Ocurrió un error guardando la provincia.');
        }
    }

    public function edit($id = null) {
        $this->Province->id = $id;
        if (!$this->Province->exists()) {
            throw new NotFoundException('Provincia inválida.');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if ($this->Province->save($this->request->data)) {
                Cache::delete('localities');
                Cache::delete('localities_suggestion');
                
                $this->setInfoMessage('La provincia se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->setErrorMessage('Ocurrió un error salvando la provincia');
        } else {
            $this->request->data = $this->Province->read(null, $id);
        }
    }

    public function remove($id = null) {
        $this->Province->id = $id;
        if (!$this->Province->exists()) {
            throw new NotFoundException('Provincia inválida');
        }
        if ($this->Province->delete()) {
            Cache::delete('localities');
            Cache::delete('localities_suggestion');
            
            $this->setInfoMessage('La provincia se eliminó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurió un error eliminando la provincia');
        }    
        return $this->redirect(array('action' => 'index'));
    }
}

?>