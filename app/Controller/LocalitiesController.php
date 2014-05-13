<?php

App::uses('AppController', 'Controller');

class LocalitiesController extends AppController {
    
    public $uses = array('Locality', 'Province');
    
    public function index() {
        $this->Locality->recursive = 0;
        $this->set('localities', $this->paginate());
    }

    public function add() {
        if ($this->request->is('post')) {            
            $this->Locality->create();
            if ($this->Locality->save($this->request->data)) {
                Cache::delete('localities');
                
                $this->setInfoMessage(__('La localidad se guardó exitosamente.'));
                return $this->redirect(array('action' => 'index'));                
            }
            $this->setErrorMessage(__('Ocurrió un error guardando la localidad.'));
        }
        $this->set('provinces', $this->Province->find('list'));
    }

    public function edit($id = null) {
        $this->Locality->id = $id;
        if (!$this->Locality->exists()) {
            throw new NotFoundException(__('Localidad inválida.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if ($this->Locality->save($this->request->data)) {
                Cache::delete('localities');
                
                $this->setInfoMessage('La localidad se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->setErrorMessage('Ocurrió un error salvando la localidad');
        } else {
            $this->request->data = $this->Locality->read(null, $id);
            $this->set('provinces', $this->Province->find('list'));
        }
    }

    public function remove($id = null) {
        $this->Locality->id = $id;
        if (!$this->Locality->exists()) {
            throw new NotFoundException(__('Localidad inválida'));
        }
        
        $datasource = $this->Locality->getDataSource();
        $datasource->begin();
        
        if ($this->Locality->delete()) {
            Cache::delete('localities');
            
            $datasource->commit();
            $this->setInfoMessage('La localidad se eliminó exitosamente.');
        } else {
            $datasource->rollback();
            $this->setErrorMessage(__('Ocurió un error eliminando la localidad'));
        }    
        return $this->redirect(array('action' => 'index'));
    }
}

?>