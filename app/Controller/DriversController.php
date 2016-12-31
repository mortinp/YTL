<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class DriversController extends AppController {
    
    public $uses = array('Driver', 'Locality', 'DriverLocality', 'DriverTravel', 'DriverProfile', 'DriverTravelByEmail', 'Travel', 'TravelByEmail', 'User');
    
    public $components = array('TravelLogic');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('profile');
    }
    
    public function index() {
        $this->Driver->recursive = 1;
        $this->Driver->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'operator_id', 'fields'=>array('id', 'username', 'display_name', 'role')))));
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
        $this->set('drivers', $this->Driver->getAsSuggestions());
    }

    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->Driver->create();
            
            //$this->request->data['Driver']['role'] = 'driver';
            if ($this->Driver->saveAssociated($this->request->data)) {
                $this->setInfoMessage('El chofer se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));                
            }
            $this->setErrorMessage('Ocurrió un error guardando el chofer.');
        }
        $this->set('localities', $this->Driver->Locality->getAsList());
        $this->set('provinces', $this->Driver->Province->find('list'));
        $this->set('operators', $this->User->getOperatorsList(true));
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
            $this->set('provinces', $this->Driver->Province->find('list'));
            $this->set('operators', $this->User->getOperatorsList(true));
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
            $this->request->data['DriverProfile']['driver_code'] = strtolower($this->request->data['DriverProfile']['driver_code']); // Salvar el codigo siempre lowercase
            
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
        if(Configure::read('show_testimonials_in_profile')) $this->Driver->loadTestimonials($this->DriverProfile);
        
        $this->Driver->unloadProfile($this->DriverProfile);
        
        $profile = $this->DriverProfile->findByDriverNick($nick);
        
        if($profile != null && !empty ($profile)) {
            $this->layout = 'profile';
            $this->set('profile', $profile);
        } else {
            throw new NotFoundException(__('Este perfil no existe'));
        }
    }
    
    public function admin($id) {
        $this->set('driver', $this->Driver->findById($id));
        
        $this->set('timeline', $this->getDriverMessagesTimeline($id));
    }
    
    
    private function getDriverMessagesTimeline($driverId, $iniDate = null, $endDate = null) {
        $query = "SELECT driver_traveler_conversations.created, driver_traveler_conversations.conversation_id, drivers.id as driver_id, driver_traveler_conversations.response_by, driver_traveler_conversations.response_text

                FROM driver_traveler_conversations

                INNER JOIN drivers_travels ON drivers_travels.id = driver_traveler_conversations.conversation_id AND driver_traveler_conversations.created BETWEEN '2014-01-01' AND '2016-05-24'

                INNER JOIN drivers ON drivers.id = drivers_travels.driver_id AND drivers.id = $driverId

                ORDER BY  driver_traveler_conversations.created";
        
        $messages = $this->Driver->query($query);
        $fixedMessages = array();
        foreach ($messages as $index=> $value) {
            $fixedMessages[$index] = array();
            $fixedMessages[$index]['date'] = $value['driver_traveler_conversations']['created'];
            $fixedMessages[$index]['response_by'] = $value['driver_traveler_conversations']['response_by'];
            $fixedMessages[$index]['response_text'] = $value['driver_traveler_conversations']['response_text'];
            if(strlen($fixedMessages[$index]['response_text']) > 500) $fixedMessages[$index]['response_text'] = substr ($fixedMessages[$index]['response_text'], 0, 500).'...';
            
            $d = strtotime($value['driver_traveler_conversations']['created']);
            $hour = date('H', $d);
            $min = date('i', $d);
            
            $fixedMessages[$index]['driver'] = -100;
            $fixedMessages[$index]['traveler'] = -100;
            if($value['driver_traveler_conversations']['response_by'] == 'driver')  $fixedMessages[$index]['driver'] = $hour*60 + $min;
            else if($value['driver_traveler_conversations']['response_by'] == 'traveler') $fixedMessages[$index]['traveler'] = $hour*60 + $min;
            
            $fixedMessages[$index]['timestr'] = "$hour:$min";
        }
        
        return $fixedMessages;
    }
}

?>