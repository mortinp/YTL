<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class DriversController extends AppController {
    
    public $uses = array('Driver', 'Locality', 'DriverLocality', 'DriverTravel', 'DriverProfile', 'DriverTravelByEmail', 'Travel', 'TravelByEmail');
    
    public $components = array('TravelLogic');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('profile');
    }
    
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
        
        Travel::prepareFullConversations($this);
        $this->set('travels', $this->Travel->find('all', array('conditions'=>array('Travel.id'=>$ids))));
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
    
    public function edit_profile($id = null) {
        $this->Driver->id = $id;
        if (!$this->Driver->exists()) {
            throw new NotFoundException('Chofer inválido.');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['DriverProfile']['driver_id'] = $id;
            
            /*$avatar = new Model();
            $avatar->Behaviors->load('HardDiskSave');
            $avatar->create($this->request->data['DriverProfile']['avatar']);*/
            
            if(isset ($this->request->data['DriverProfile']['avatar'])) {
                $l = $this->request->data['DriverProfile']['avatar']['size'];
                if($this->request->data['DriverProfile']['avatar']['size'] == 0) {
                    unset ($this->request->data['DriverProfile']['avatar']);
                    $this->DriverProfile->Behaviors->unload('HardDiskSave');
                }  
            }       
            
            if($this->DriverProfile->save($this->request->data)) {
                $this->setInfoMessage('El perfil  se guardó exitosamente.');
                return $this->redirect(array('action'=>'profile/'.$this->request->data['DriverProfile']['driver_nick']));
            }
        }
        
        $this->Driver->recursive = 0;
        $driver = $this->Driver->findById($id);
        
        $this->request->data = $this->DriverProfile->findByDriverId($id);
        
        $this->set('driver', $driver);
    }
    
    public function profile($nick) {
        $profile = $this->DriverProfile->findByDriverNick($nick);
        
        $lang = $this->Session->read('app.lang');
        $lang2 = Configure::read('Config.language');
        
        if($profile != null && !empty ($profile)) {
            $this->layout = 'profile';
            $this->set('profile', $profile['DriverProfile']);
        } else {
            throw new NotFoundException(__('Este perfil no existe'));
        }
    }
    
    
    public function notify_travel($driverId, $travelId) {
        $this->Driver->id = $driverId;
        if (!$this->Driver->exists()) {
            throw new NotFoundException('Chofer inválido.');
        }
        $this->Travel->id = $travelId;
        if (!$this->Travel->exists()) {
            throw new NotFoundException('Viaje inválido.');
        }
        
        $driver = $this->Driver->findById($driverId);
        $travel = $this->Travel->findById($travelId);
        
        $this->TravelLogic->prepareForSendingToDrivers('Travel');
        $OK = $this->TravelLogic->sendTravelToDriver($driver, $travel, 'Travel', DriverTravel::$NOTIFICATION_TYPE_MANUAL);
        
        
        if($OK) $this->setInfoMessage('Viaje notificado.');
        else $this->setErrorMessage('Error notificando el viaje.');
        
        return $this->redirect(array('action'=>'view_travels/'.$driverId));
    }
}

?>