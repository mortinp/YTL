<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class DriversController extends AppController {
    
    public $uses = array('Driver', 'Locality', 'DriverLocality', 'DriverTravel', 'DriverTravelByEmail', 'Travel', 'TravelByEmail');
    
    public function index() {
        $this->Driver->recursive = 1;
        //$this->set('drivers', $this->paginate());
        $this->set('drivers', $this->Driver->find('all'));
        
    }
    
    public function view_travels($driverId) {
        $this->set('driver', $this->Driver->findById($driverId));
        
        $driverTavels = $this->DriverTravel->find('all', array('conditions'=>array('Driver.id'=>$driverId)));
        $ids = array();
        foreach ($driverTavels as $dt) {
            $ids[] = $dt['Travel']['id'];
        }
        $this->set('travels', $this->Travel->find('all', array('conditions'=>array('Travel.id'=>$ids))));
        
        $driverTavelsByEmail = $this->DriverTravelByEmail->find('all', array('conditions'=>array('Driver.id'=>$driverId)));
        $ids = array();
        foreach ($driverTavelsByEmail as $dt) {
            $ids[] = $dt['TravelByEmail']['id'];
        }
        $this->set('travels_by_email', $this->TravelByEmail->find('all', array('conditions'=>array('TravelByEmail.id'=>$ids))));
    }

    public function add() {
        if ($this->request->is('post')) {
            
            $this->Driver->create();
            
            $this->request->data['Driver']['role'] = 'driver';
            if ($this->Driver->saveAssociated($this->request->data)) {
                $this->setInfoMessage('El chofer se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));                
            }
            $this->setErrorMessage('Ocurrió un error guardando el chofer.');
        }
        $this->set('localities', $this->Driver->Locality->getAsList());
    }

    public function edit($id = null) {
        $this->Driver->id = $id;
        if (!$this->Driver->exists()) {
            throw new NotFoundException('Chofer inválido.');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(strlen($this->request->data['Driver']['password']) == 0) unset ($this->request->data['Driver']['password']);
            
            if ($this->Driver->saveAll($this->request->data)) {
                $this->setInfoMessage('El chofer se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->setErrorMessage('Ocurrió un error salvando el chofer');
        } else {
            $this->request->data = $this->Driver->read(null, $id);
            unset($this->request->data['Driver']['password']);
            
            $this->set('localities', $this->Locality->getAsList());
        }
    }

    public function remove($id = null) {
        $this->Driver->id = $id;
        if (!$this->Driver->exists()) {
            throw new NotFoundException('Invalid driver');
        }
        if ($this->Driver->delete()) {
            $this->setInfoMessage('El chofer se eliminó exitosamente.');
        } else {
            $this->setErrorMessage('Ocurrió un error eliminando el chofer');
        }
        
        return $this->redirect(array('action' => 'index'));
    }
}

?>