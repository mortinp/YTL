<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('User', 'Model');
App::uses('Travel', 'Model');
App::uses('Locality', 'Model');

class TravelsController extends AppController {
    
    public $uses = array('Travel', 'TravelByEmail', 'PendingTravel', 'Locality', 'Driver', 'User', 'DriverLocality', 'Province', 'LocalityThesaurus', 'DriverTravel', 'TravelConversationMeta');
    
    public $components = array('TravelLogic', 'LocalityRouter', 'Paginator');
    
    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Auth->loggedIn()) $this->Auth->allow('add_pending', 'view_pending', 'pending', 'edit_pending');
    }
    
    public function isAuthorized($user) {
        if ($this->action ==='index') {
            if($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') return true;
        }
        
        if ($this->action === 'add') {
            /*if(($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') && User::canCreateTravel()) */return true;
        }

        if (in_array($this->action, array('edit', 'view', 'confirm', 'delete'))) {
            // Verificar que venga el id del viaje
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
            array('user_id' => $this->Auth->user('id'))));
        
        $this->set('travels', $travels);
    }
    
    // Admins only
    public function all() {
        Travel::prepareFullConversations($this);
        
        $conditions = array('User.role'=>'regular');
        
        $this->Travel->Behaviors->load('GroupByUsers', array( 'users_order' => 'max(Travel.id)   desc'));
        
        $this->set('filter_applied', Travel::$SEARCH_ALL);
        //$this->set('travels', $this->paginate($conditions));
        $this->set('users', $this->paginate($conditions));
        $this->set('drivers', $this->Driver->getAsSuggestions());
    }
    
    public function view_filtered($filter = 'all') {
        Travel::prepareFullConversations($this);
        
        $users_order = array(
            Travel::$SEARCH_ALL              => 'max(Travel.id)   desc',
            Travel::$SEARCH_CLOSER_TO_EXPIRE => 'min(Travel.date) asc,  max(Travel.id) desc',
            Travel::$SEARCH_EXPIRED_NEWEST   => 'max(Travel.date) desc, max(Travel.id) desc',
            Travel::$SEARCH_ADMINS           => 'max(Travel.id)   desc',
            Travel::$SEARCH_TESTERS          => 'max(Travel.id)   desc',
            Travel::$SEARCH_OPERATORS        => 'max(Travel.id)   desc',
            Travel::$SEARCH_MAYBE_SHARE      => 'min(Travel.date) asc,  max(Travel.id) desc',
        );
        
        $conditions = array('User.role'=>'regular');
        
        if($filter == Travel::$SEARCH_ALL) {
            $this->paginate = array('limit'=>30);
        } else if($filter == Travel::$SEARCH_CLOSER_TO_EXPIRE) {
            //$this->paginate = array('order'=>array('Travel.date'=>'ASC'));
            $this->paginate = array('order'=>array('Travel.date'=>'ASC', 'Travel.id' => 'DESC'));
            $conditions['Travel.date >='] = date('Y-m-d', mktime());
        } else if($filter == Travel::$SEARCH_EXPIRED_NEWEST) {
            //$this->paginate = array('order'=>array('Travel.date'=>'DESC'));
            $this->paginate = array('order'=>array('Travel.date'=>'DESC', 'Travel.id' => 'DESC'));
            $conditions['Travel.date <'] = date('Y-m-d', mktime());
        } else if($filter == Travel::$SEARCH_ADMINS) {
            $conditions['User.role'] = 'admin';
        } else if($filter == Travel::$SEARCH_TESTERS) {
            $conditions['User.role'] = 'tester';
        } else if($filter == Travel::$SEARCH_OPERATORS) {
            $conditions['User.role'] = 'operator';
        } else if($filter == Travel::$SEARCH_MAYBE_SHARE) {
            
            $conditions['User.shared_ride_offered'] = false;
            $conditions['Travel.people_count >='] = 1;
            $conditions['Travel.people_count <='] = 3;
        
            $today = date('Y-m-d', strtotime('today'));
            $conditions['Travel.date >='] = $today;
            $conditions['Travel.date <='] = date('Y-m-d', strtotime("$today + 60 days"));
            $conditions['Travel.created <='] = date('Y-m-d', strtotime("$today - 2 days"));
            
            $this->paginate = array('order'=>array('Travel.date'=>'ASC', 'Travel.id' => 'ASC'));
        }
        
        if(AuthComponent::user('role') == 'operator')
            $this->Travel->Behaviors->load('Operations.OperatorScope', array('match'=>'Travel.operator_id', 'action'=>array('R'))); // Restringir ver solicitudes
        
        $this->Travel->Behaviors->load('GroupByUsers', array( 'users_order' => $users_order[$filter] ));
        
        $this->set('filter_applied', $filter);
        //$this->set('travels', $this->paginate($conditions));
        $this->set('users', $this->paginate($conditions));
        $this->set('drivers', $this->Driver->getAsSuggestions());
        $this->render('all');
    }
    
    public function view($id) {
        $travel = $this->Travel->findById($id);

        $this->set('travel', $travel);
        
        $this->request->data = $travel;
    }

    public function add() {
        if ($this->request->is('post')) {
            
            // Encontrar la localidad que mejor matchee
            $closest = $this->LocalityRouter->getMatch($this->request->data['Travel']['origin'], $this->request->data['Travel']['destination']);
            
            if($closest != null && !empty ($closest)) { // Si hubo un match...
                $this->Travel->create();

                /**
                 * Ponerle otros datos al viaje
                 * 
                 * - Se pone en estado default -no notificado a choferes aun. Hay que esperar el confirm para notificar a los choferes.
                 * - Se le asigna la localidad que matcheó para al confirmar escoger bien a los choferes
                 * - Se le ponen otros datos como el usuario, el ip del usuario, etc.
                 */ 
                $this->request->data['Travel']['state'] = Travel::$STATE_DEFAULT;
                if( isset($closest['origin']) )       $this->request->data['Travel']['origin_locality_id']      = $closest['origin']['locality_id'];			
		if( isset($closest['destination']) )  $this->request->data['Travel']['destination_locality_id'] = $closest['destination']['locality_id'];
		$this->request->data['Travel']['direction'] = 2; //$closest['direction'];     // meaningless from now on
                $this->request->data['Travel']['user_id'] = $this->Auth->user('id');
                $this->request->data['Travel']['created_from_ip'] = $this->request->clientIp();
                
                if ($this->Travel->save($this->request->data)) {
                    $id = $this->Travel->getLastInsertID();
                    return $this->redirect(array('action' => 'view/' . $id));
                }
                $this->setErrorMessage(__('Error al crear el viaje'));                
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (add) - Unknown origin and destination: '.$this->request->data['Travel']['origin'].' - '.$this->request->data['Travel']['destination']);
                CakeLog::write('travels_failed', 'Created by user: id = '.$this->Auth->user('id'));
                CakeLog::write('travels_failed', "<span style='color:blue'>---------------------------------------------------------------------------------------------------------</span>\n\n");
                $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.')); // TODO: Enviar una respuesta mejor!!!
                $this->redirect($this->referer());
            }
        }
    } 
    
    public function confirm($id) {
        $travel = $this->Travel->findById($id);
        
        // Sanity check (si no se encuentra o esta confirmado, dar un error)
        $OK = true;
        if($travel != null && Travel::isConfirmed($travel['Travel']['state'])) {
            $this->setErrorMessage(__('Este viaje ya ha sido confirmado.'));
            $OK = false;
        }
        
        // Todo OK? Confirmar...
        if($OK) {
            $datasource = $this->Travel->getDataSource();
            $datasource->begin();
            
            // Confirmar el viaje (todo se hace en el TravelLogicComponent)
            $result = $this->TravelLogic->confirmTravel($travel);

            if($result['success']) {
                $datasource->commit();
                $this->setSuccessMessage('<b>'.__('Felicidades, ya completaste la solicitud').'!!!</b>');
            } else {
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
                
                if( isset($closest['origin']) )       $travel['Travel']['origin_locality_id']      = $closest['origin']['locality_id'];			
		if( isset($closest['destination']) )  $travel['Travel']['destination_locality_id'] = $closest['destination']['locality_id'];
		$travel['Travel']['direction'] = 2; //$closest['direction'];     // meaningless from now on
                
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
    
    /**
     * This function updates any data of a travel coming in the request object. Accepts data via POST.
     * 
     * @param $id: the id of the travel.
     * @param $validate: whether you want to validate the data. Defaults to true.
     */
    public function edit_travel_data($id, $validate = true) {
        $this->Travel->create();
        $this->Travel->id = $id;
        if(!$this->Travel->exists()) throw new NotFoundException();
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if (!$this->Travel->save($this->request->data, $validate)) $this->setErrorMessage('Ocurrió un error actualizando este viaje');
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
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
    
    public function all_pending() {
        $this->paginate = array('limit'=>50);
        $this->Paginator->settings = $this->paginate;

        $this->set('travels', $this->Paginator->paginate('PendingTravel'));
    }
    
    public function pending($id) {
        $travel = $this->PendingTravel->findById($id);
        $travel['PendingTravel']['state'] = Travel::$STATE_UNCONFIRMED;
        
        $this->set('travel', $travel);
        
        $this->request->data = $travel;
        
        $this->layout = 'transition'; // Un layout transicional, pues el usuario se encuentra en medio de una transaccion
    }
    public function view_pending($id) {
        $travel = $this->PendingTravel->findById($id);
        $travel['PendingTravel']['state'] = Travel::$STATE_UNCONFIRMED;
        
        $this->set('travel', $travel);
        
        $this->request->data = $travel;
    }
    
    /*
    public function add_pending() {
        if ($this->request->is('post')) {
            
            $closest = $this->LocalityRouter->getMatch($this->request->data['PendingTravel']['origin'], $this->request->data['PendingTravel']['destination']);
            
            if($closest != null && !empty ($closest)) {
                $this->PendingTravel->create();

                if( isset($closest['origin']) )       $this->request->data['PendingTravel']['origin_locality_id']      = $closest['origin']['locality_id'];			
		if( isset($closest['destination']) )  $this->request->data['PendingTravel']['destination_locality_id'] = $closest['destination']['locality_id'];
		$this->request->data['PendingTravel']['direction'] = 2; //$closest['direction'];     // meaningless from now on
                $this->request->data['PendingTravel']['state'] = Travel::$STATE_UNCONFIRMED;
                $this->request->data['PendingTravel']['created_from_ip'] = $this->request->clientIp();
                
                if ($this->PendingTravel->save($this->request->data)) {
                    $id = $this->PendingTravel->getLastInsertID();
                    return $this->redirect(array('action' => 'pending/' . $id));
                }
                $this->setErrorMessage(__('Error al crear el viaje'));                
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (add_pending) - Unknown origin and destination: '.$this->request->data['PendingTravel']['origin'].' - '.$this->request->data['PendingTravel']['destination']);
                CakeLog::write('travels_failed', 'Created by: '.$this->request->data['PendingTravel']['email']);
                CakeLog::write('travels_failed', "<span style='color:blue'>---------------------------------------------------------------------------------------------------------</span>\n\n");
                $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.'));
                $this->redirect($this->referer().'#'.__d('mobirise/default', 'solicitar'));
            }
        }
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
                
                if( isset($closest['origin']) )       $travel['PendingTravel']['origin_locality_id']      = $closest['origin']['locality_id'];			
		if( isset($closest['destination']) )  $travel['PendingTravel']['destination_locality_id'] = $closest['destination']['locality_id'];
		$travel['PendingTravel']['direction'] = 2; //$closest['direction'];     // meaningless from now on
                
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
    */
    
    /**
     * ADMIN ACTIONS
     */
    
    public function notify_driver_travel($travelId, $notificationType = 'M') {
        if ($this->request->is('post') || $this->request->is('put') || $this->request->is('ajax')) {
            
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
                $data = $this->data;
            } else if ($this->request->is('post') || $this->request->is('put')) {
                $data = $this->request->data;
            }

            $driverId = $data['Driver']['driver_id'];
            
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
            
            $config = null;
            
            // Dump all the data that comes from TravelConversationMeta in custom variables
            if( isset ($data['TravelConversationMeta'])) {
                $config = array('custom_variables'=>$data['TravelConversationMeta']);
                $config['template'] = 'arranged_travel';
            }
            
            $datasource = $this->Driver->getDataSource();
            $datasource->begin();            
            
            $this->TravelLogic->prepareForSendingToDrivers('Travel');
            $OK = $this->TravelLogic->sendTravelToDriver($driver, $travel, $notificationType, $config);
            if(is_array($OK) && isset ($OK['success']) && $OK['success']) {
                $conversation_id = $OK['conversation_id'];
                $OK = true;
            }
            
            // Save TravelConversationMeta
            if( isset ($data['TravelConversationMeta'])) {
                $data['TravelConversationMeta']['conversation_id'] = $conversation_id;
                
                // Hay que ponerle following a los viajes que son arreglados
                if(isset ($data['TravelConversationMeta']['arrangement']) && !empty($this->request->data['TravelConversationMeta']['arrangement'])) 
                        $data['TravelConversationMeta']['following'] = true;
                
                $OK = $this->TravelConversationMeta->save($data);
            }

            if($OK) {
                $datasource->commit();
            } else {
                $datasource->rollback();
                $this->setErrorMessage('Error notificando el viaje.');
            }
        }
        
        if ($this->request->is('ajax')) {
            $driverName = $driver['Driver']['username'];
            if(isset ($driver['DriverProfile']) && !empty ($driver['DriverProfile']) && !empty($driver['DriverProfile']['driver_name'])) 
                $driverName = $driver['DriverProfile']['driver_name'];
            
            echo json_encode(array('object'=>array(
                'conversation_id'=>$conversation_id, 
                'driver_email'=>$driver['Driver']['username'],
                'notification_type'=>$notificationType,
                'driver_name'=>$driverName)));
            return;
        }
        
        return $this->redirect($this->referer().'#travel-'.$travelId);
    }
    
    
    public function admin($id) {
        Travel::prepareFullConversations($this);
        $travel = $this->Travel->findById($id);
        $this->set('travel', $travel);
        
        //Travel::prepareFullConversations($this);
        $this->set('travels_by_same_user', $this->Travel->find('all', array('conditions'=>array('user_id'=>$travel['User']['id'], 'Travel.id !='=>$id))));
        
        $this->set('drivers', $this->Driver->getAsSuggestions());
    }
    
    
    /**
     * COMPARTIDOS
     */
    public function maybe_share() {
        Travel::prepareFullConversations($this);
        
        $users_order = array(
            Travel::$SEARCH_ALL              => 'max(Travel.id)   desc',
            Travel::$SEARCH_CLOSER_TO_EXPIRE => 'min(Travel.date) asc,  max(Travel.id) desc',
            Travel::$SEARCH_EXPIRED_NEWEST   => 'max(Travel.date) desc, max(Travel.id) desc',
            Travel::$SEARCH_ADMINS           => 'max(Travel.id)   desc',
            Travel::$SEARCH_TESTERS          => 'max(Travel.id)   desc',
            Travel::$SEARCH_OPERATORS        => 'max(Travel.id)   desc'
        );
        
        if($filter == Travel::$SEARCH_ALL) {
            $this->paginate = array('limit'=>30);
        } else if($filter == Travel::$SEARCH_CLOSER_TO_EXPIRE) {
            //$this->paginate = array('order'=>array('Travel.date'=>'ASC'));
            $this->paginate = array('order'=>array('Travel.date'=>'ASC', 'Travel.id' => 'DESC'));
            $conditions['Travel.date >='] = date('Y-m-d', mktime());
        } else if($filter == Travel::$SEARCH_EXPIRED_NEWEST) {
            //$this->paginate = array('order'=>array('Travel.date'=>'DESC'));
            
        } else if($filter == Travel::$SEARCH_ADMINS) {
            $conditions['User.role'] = 'admin';
        } else if($filter == Travel::$SEARCH_TESTERS) {
            $conditions['User.role'] = 'tester';
        } else if($filter == Travel::$SEARCH_OPERATORS) {
            $conditions['User.role'] = 'operator';
        }
        
        /*if(AuthComponent::user('role') == 'operator')
            $this->Travel->Behaviors->load('Operations.OperatorScope', array('match'=>'Travel.operator_id', 'action'=>array('R'))); // Restringir ver solicitudes*/
        
        $this->Travel->Behaviors->load('GroupByUsers', array( 'users_order' => $users_order[$filter] ));
        
        $this->set('filter_applied', $filter);
        //$this->set('travels', $this->paginate($conditions));
        $this->set('users', $this->paginate($conditions));
        $this->set('drivers', $this->Driver->getAsSuggestions());
        $this->render('all');
    }
}

?>