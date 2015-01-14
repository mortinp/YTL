<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('User', 'Model');
App::uses('Travel', 'Model');

class TravelsController extends AppController {
    
    public $uses = array('Travel', 'TravelByEmail', 'PendingTravel', 'Locality', 'User', 'DriverLocality', 'Province', 'LocalityThesaurus');
    
    public $components = array('TravelLogic', 'LocalityRouter');
    
    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Auth->loggedIn()) $this->Auth->allow('add_pending', 'view_pending', 'edit_pending');
    }
    
    public function isAuthorized($user) {
        if ($this->action ==='index') {
            if($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') return true;
        }
        
        if ($this->action === 'add') {
            if(($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') && User::canCreateTravel()) return true;
        }

        if (in_array($this->action, array('edit', 'view', 'confirm', 'delete'))) {
            if(isset ($this->request->params['pass'][0])) {
                $id = $this->request->params['pass'][0];
                if ($this->Travel->isOwnedBy($id, $user['id'])) {
                    return true;
                }
            }
        }   

        return parent::isAuthorized($user);
    }

    public function index() {
        $travels = $this->Travel->find('all', array('conditions' => 
            array('user_id' => $this->Auth->user('id')/*, 'state'=>Travel::$STATE_UNCONFIRMED*/)));
        
        $travels_by_email = $this->TravelByEmail->find('all', array('conditions' => 
            array('user_id' => $this->Auth->user('id')/*, 'state'=>Travel::$STATE_UNCONFIRMED*/)));
        
        $this->set('travels', $travels); 
        $this->set('travels_by_email', $travels_by_email); 
        
        $this->set('localities', $this->getLocalitiesList());
    }
    
    // Admins only
    public function all() {
        $this->Travel->bindModel(array('hasMany'=>array('DriverTravel')));
        //$this->set('travels', $this->Travel->find('all', array('conditions'=>array('User.role'=>'regular'))));
        $this->set('travels', $this->paginate(array('User.role'=>'regular')));
        //$this->set('travels_by_email', $this->TravelByEmail->find('all', array('conditions'=>array('User.role'=>'regular'))));
    }
    
    // Admins only
    public function all_admins() {
        $this->Travel->bindModel(array('hasMany'=>array('DriverTravel')));
        //$this->set('travels', $this->Travel->find('all', array('conditions'=>array('User.role'=>'admin'))));
        $this->set('travels', $this->paginate(array('User.role'=>'admin')));
        //$this->set('travels_by_email', $this->TravelByEmail->find('all', array('conditions'=>array('User.role'=>'admin'))));
        $this->render('all');
    }
    
    // Admins only
    public function all_pending() {
        $this->set('travels', $this->PendingTravel->find('all'));
    }

    public function view($id) {
        $travel = $this->Travel->findById($id);
        
        $this->set('localities', $this->getLocalitiesList());
        $this->set('travel', $travel);
        
        $this->request->data = $travel;
    }

    public function add() {
        if ($this->request->is('post')) {            
            $closest = $this->LocalityRouter->getMatch($this->request->data['Travel']['origin'], $this->request->data['Travel']['destination']);
            
            if($closest != null && !empty ($closest)) {
                $this->Travel->create();

                $this->request->data['Travel']['locality_id'] = $closest['locality_id'];
                $this->request->data['Travel']['direction'] = $closest['direction'];
                $this->request->data['Travel']['user_id'] = $this->Auth->user('id');
                $this->request->data['Travel']['state'] = Travel::$STATE_DEFAULT;
                $this->request->data['Travel']['created_from_ip'] = $this->request->clientIp();
                
                if ($this->Travel->save($this->request->data)) {
                    $id = $this->Travel->getLastInsertID();
                    return $this->redirect(array('action' => 'view/' . $id));
                }
                $this->setErrorMessage(__('Error al crear el viaje'));                
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (add) - Unknown origin and destination: '.$this->request->data['Travel']['origin'].' - '.$this->request->data['Travel']['destination']);
                $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.'));
                $this->redirect($this->referer());
            }
        }
        
        $this->set('localities', $this->getLocalitiesList());
    } 
    
    public function confirm($id) {
        $travel = $this->Travel->findById($id);
        
        $OK = true;
        
        if($travel != null && Travel::isConfirmed($travel['Travel']['state'])) {
            $this->setErrorMessage(__('Este viaje ya ha sido confirmado.'));
            $OK = false;
        }
        
        if($OK) {
            $datasource = $this->Travel->getDataSource();
            $datasource->begin();
            
            $result = $this->TravelLogic->confirmTravel('Travel', $travel);

            if($result['success']) $datasource->commit();
            else {
                $datasource->rollback();
                $this->setErrorMessage($result['message']);
            }
        }   
        
        return $this->redirect(array('action'=>'view/'.$travel['Travel']['id']));
    }

    public function edit($tId) {        
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $travel = $this->data;
        } else if ($this->request->is('post') || $this->request->is('put')) {
            $travel = $this->request->data;
        }

        $editing = $this->request->is('ajax') || $this->request->is('post') || $this->request->is('put');
        if($editing) {
            
            $closest = $this->LocalityRouter->getMatch($this->request->data['Travel']['origin'], $this->request->data['Travel']['destination']);
            if($closest != null && !empty ($closest)) {
                
                $travel['Travel']['locality_id'] = $closest['locality_id'];
                $travel['Travel']['direction'] = $closest['direction'];
                
                if ($this->Travel->save($travel)) {
                    if($this->request->is('ajax')) {
                        echo json_encode(array('object'=>$travel['Travel']));
                        return;
                    }
                    return $this->redirect(array('action' => 'index'));
                }
                $this->setErrorMessage(__('Ocurrió un error guardando los datos de este viaje. Intenta de nuevo.'));
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (edit) - Unknown origin and destination: '.$this->request->data['Travel']['origin'].' - '.$this->request->data['Travel']['destination']);
                if($this->autoRender == false) {
                    throw new NotFoundException(__('El origen y el destino del viaje no son reconocidos.'));
                } else {
                    $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.'));
                    $this->redirect($this->referer());
                }
            }
        }
        
        $travel = $this->Travel->findById($tId);
        if (!$this->request->data) {
            $this->request->data['Travel'] = $travel['Travel'];
        }
    }    

    public function delete($tId) {
        $travel = $this->Travel->findById($tId);
        if($travel != null) {
            if($travel['Travel']['state'] == Travel::$STATE_UNCONFIRMED || AuthComponent::user('role') === 'admin') {
                if ($this->Travel->delete($tId)) {
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->setErrorMessage(__('Ocurrió un error eliminando el viaje. Intenta de nuevo.'));
                }
            } else {
                $this->setErrorMessage(__('Este viaje no se puede eliminar porque ya está confirmado. Dile a tu chofer que deseas cancelar.'));
            }            
        } else {
            $this->setErrorMessage(__('Este viaje no existe.'));
        }
        
        $this->redirect($this->referer());
    }
    
    
    
    /**
     * PENDING
     */
    
    public function view_pending($id) {
        $travel = $this->PendingTravel->findById($id);
        $travel['PendingTravel']['state'] = Travel::$STATE_UNCONFIRMED;
        
        $this->set('localities', $this->getLocalitiesList());
        $this->set('travel', $travel);
        
        $this->request->data = $travel;
    }
    
    public function add_pending() {
        if ($this->request->is('post')) {
            
            $closest = $this->LocalityRouter->getMatch($this->request->data['PendingTravel']['origin'], $this->request->data['PendingTravel']['destination']);
            
            if($closest != null && !empty ($closest)) {
                $this->PendingTravel->create();

                $this->request->data['PendingTravel']['locality_id'] = $closest['locality_id'];
                $this->request->data['PendingTravel']['direction'] = $closest['direction'];
                $this->request->data['PendingTravel']['state'] = Travel::$STATE_UNCONFIRMED;
                $this->request->data['PendingTravel']['created_from_ip'] = $this->request->clientIp();
                
                if ($this->PendingTravel->save($this->request->data)) {
                    $id = $this->PendingTravel->getLastInsertID();
                    return $this->redirect(array('action' => 'view_pending/' . $id));
                }
                $this->setErrorMessage(__('Error al crear el viaje'));                
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (add_pending) - Unknown origin and destination: '.$this->request->data['PendingTravel']['origin'].' - '.$this->request->data['PendingTravel']['destination']);
                $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.'));
                $this->redirect($this->referer().'#FormContainer');
            }
        }
        
        $this->set('localities', $this->getLocalitiesList());
    }
    
    public function edit_pending($tId) {        
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $travel = $this->data;
        } else if ($this->request->is('post') || $this->request->is('put')) {
            $travel = $this->request->data;
        }

        $editing = $this->request->is('ajax') || $this->request->is('post') || $this->request->is('put');
        if($editing) {
            $closest = $this->LocalityRouter->getMatch($this->request->data['PendingTravel']['origin'], $this->request->data['PendingTravel']['destination']);
            if($closest != null && !empty ($closest)) {
                
                $travel['PendingTravel']['locality_id'] = $closest['locality_id'];
                $travel['PendingTravel']['direction'] = $closest['direction'];
                
                if ($this->PendingTravel->save($travel)) {
                    if($this->request->is('ajax')) {
                        echo json_encode(array('object'=>$travel['PendingTravel']));
                        return;
                    }
                    return $this->redirect(array('action' => 'index'));
                }
                $this->setErrorMessage(__('Ocurrió un error guardando los datos de este viaje. Intenta de nuevo.'));
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (edit_pending) - Unknown origin and destination: '.$this->request->data['PendingTravel']['origin'].' - '.$this->request->data['PendingTravel']['destination']);
                if($this->autoRender == false) {
                    throw new NotFoundException(__('El origen y el destino del viaje no son reconocidos.'));
                } else {
                    $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.'));
                    $this->redirect($this->referer());
                }
            }
        }
        
        $travel = $this->PendingTravel->findById($tId);
        if (!$this->request->data) {
            $this->request->data['PendingTravel'] = $travel['PendingTravel'];
        }
    }
    
    
    
    
    /**
     * AUX
     */
    
    private function getLocalitiesList() {
        
        return $this->Locality->getAsSuggestions();
        /*$list = Cache::read('localities_suggestion');
        if (!$list) {
            $localities = $this->Locality->find('all');
            $list = array();
            foreach ($localities as $l) {
                $list[] = $l['Locality'];
            }
            $thes = $this->LocalityThesaurus->find('all', array('conditions'=>array('use_as_hint'=>true)));
            foreach ($thes as $t) {
                $list[] = array('id'=>$t['LocalityThesaurus']['id'], 'name'=>$t['LocalityThesaurus']['fake_name']);
            }
            Cache::write('localities_suggestion', $list);
        }        
        return $list;*/
    }
}

?>