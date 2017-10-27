<?php

App::uses('DriverTravel', 'Model');
App::uses('DriverTravelerConversation', 'Model');
App::uses('TimeUtil', 'Util');
App::uses('EmailsUtil', 'Util');

class DriverTravelsController extends AppController {
    
    //public $uses = array('DriverTravel', 'Travel', 'Driver');
    public $uses = array('DriverTravel', 'Travel', 'Driver', 'DriverTravelerConversation', 'User');
    
    public function isAuthorized($user) {
        if ($this->action ==='index') {
            if($this->Auth->user('role') === 'regular' || $this->Auth->user('role') === 'tester') return true;
        }
        
        if(in_array(AuthComponent::user('role'), array('admin', 'operator')) && in_array($this->action, array('view_filtered'))) 
            return true;
        
        return parent::isAuthorized($user);
    }
    
    public function index() {
        $this->DriverTravel->recursive = 2;        
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $order = array('Travel.id'=>'DESC', 'Driver.id');
        
        // Las conversaciones del usuario logueado y que al menos tengan 1 mensaje
        $conditions = array('DriverTravel.user_id' => $this->Auth->user('id'), 'DriverTravel.message_count >' =>0);
        
        
        $driver_travels = $this->DriverTravel->find('all', array('conditions'=>$conditions, 'order'=>$order));
        $this->set('driver_travels', $driver_travels);
    }
    
    public function view_filtered($filter = 'all') {
        $this->DriverTravel->recursive = 2;        
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $conditions = array();
        
        if($filter == DriverTravel::$SEARCH_NEW_MESSAGES) {
            /**
             * Las conversaciones que no se ha marcado ninguno como leido y al menos tiene un mensaje
             * 
             * OR
             * 
             * Las conversaciones que tienen leídos, pero hay más mensajes que leídos
             */
            $conditions['OR'] = array(
                array('AND'=>array(
                    'TravelConversationMeta.read_entry_count' => null,
                    'DriverTravel.message_count >' => 0                    
                )),
                array('AND'=>array(
                    array('not' => array('TravelConversationMeta.read_entry_count' => null)),
                    'DriverTravel.message_count > TravelConversationMeta.read_entry_count'
                ))
            );
            //$this->paginate = array('order'=>array('Travel.date'=>'ASC'));
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'ASC'));
                    
        } else if($filter == DriverTravel::$SEARCH_FOLLOWING) {
            //$this->paginate = array('order'=>array('Travel.date'=>'ASC'), 'limit'=>50);
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'ASC', 'DriverTravel.user_id'=>'ASC'), 'limit'=>50);
            $conditions['TravelConversationMeta.following'] = true;
            $conditions['TravelConversationMeta.archived'] = 0; //Que no este archivado
        } else if($filter == DriverTravel::$SEARCH_DONE) {
            //$this->paginate = array('order'=>array('Travel.date'=>'DESC'), 'limit'=>100);// Paginacion grande para ver todos los viajes realizados y hacer resumenes de cobros de comisiones facilmente sin tener que cambiar de paginas
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'DESC'), 'limit'=>100);// Paginacion grande para ver todos los viajes realizados y hacer resumenes de cobros de comisiones facilmente sin tener que cambiar de paginas
            $conditions['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_DONE;
            $conditions['TravelConversationMeta.archived'] = 0; //Que no este archivado
        } else if($filter == DriverTravel::$SEARCH_PAID) {
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'DESC'), 'limit'=>50);
            $conditions['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_PAID;
        } else if($filter == DriverTravel::$SEARCH_DIRECT_MESSAGES) {
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'DESC'), 'limit'=>50);
            $conditions['DriverTravel.notification_type'] = DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE;
        } else if($filter == DriverTravel::$SEARCH_PINNED) {
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'ASC'), 'limit'=>50);
            $conditions['TravelConversationMeta.flag_type !='] = null;
        } else if($filter == DriverTravel::$SEARCH_ARCHIVED) {
            $this->paginate = array('order'=>array('DriverTravel.travel_date'=>'ASC'));
            $conditions['TravelConversationMeta.archived'] = 1;
        }
        
        if(AuthComponent::user('role') == 'operator')
            $this->DriverTravel->Behaviors->load('Operations.OperatorScope', array('match'=>'Driver.operator_id', 'action'=>'C')); // Restringir ver conversaciones
        
        $driver_travels = $this->paginate($conditions);
        
        $this->set('filter_applied', $filter);
        $this->set('driver_travels', $driver_travels);
        $this->render('all');
    }
    
    public function change_date($id) {
        $this->DriverTravel->create(false); // se pasa false para evitar que se carguen los valores por defecto, esto evita que se sobreescriba el notification_type = D 
        $this->DriverTravel->id = $id;
        if(!$this->DriverTravel->exists()) throw new NotFoundException();
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->DriverTravel->order = null;
            $conversation = $this->DriverTravel->find('first', array('conditions' => array('DriverTravel.id' => $id), 'recursive' => -1));
            
            if($conversation['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                $OK = $this->DriverTravel->save($this->request->data, false);
            else{        
                $travel = array('Travel' => array('id' => $conversation['DriverTravel']['travel_id']));
                $driver_travel = array();
                if( isset($this->request->data['DriverTravel']['travel_date']) ){
                    $travel['Travel']['date']     = $this->request->data['DriverTravel']['travel_date'];
                    $driver_travel['travel_date'] = "'".TimeUtil::dmY_to_Ymd($this->request->data['DriverTravel']['travel_date'])."'";
                }    
                
                if( isset($this->request->data['DriverTravel']['original_date']) ){
                    $travel['Travel']['original_date'] = $this->request->data['DriverTravel']['original_date'];
                    $driver_travel['original_date']    = "'".$this->request->data['DriverTravel']['original_date']."'";
                }    
                
                $datasource = $this->DriverTravel->getDataSource();
                $datasource->begin();
                
                $OK = $this->Travel->save($travel, false);
                
                if($OK){
                    $this->DriverTravel->unbindModel(array('belongsTo' => array('Driver', 'Travel', 'User'),
                                                           'hasOne'    => array('TravelConversationMeta')));
                    $OK = $OK && $this->DriverTravel->updateAll($driver_travel, array('DriverTravel.travel_id' => $travel['Travel']['id']));
                }
                
                if($OK)  $datasource->commit();
                else{
                    $datasource->rollback();
                    $this->setErrorMessage('OcurriÃ³ un error actualizando esta conversaciÃ³n');
                }
            }
            
            return $this->redirect($this->referer());
        } else throw new MethodNotAllowedException();
    }
    
    
    
    public function offer_shared_ride($conversationId) {
        
        $this->DriverTravel->recursive = 2;
        $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
        $data = $this->DriverTravel->findById($conversationId);
        if (!$data)
            throw new NotFoundException('Conversación inválida.');

        $vars['people_count'] = $data['Travel']['people_count'];

        $datasource = $this->DriverTravel->getDataSource();
        $datasource->begin();
        
        $subject = 'Ir de un destino a otro en Cuba por un precio muy conveniente';
        if($data['User']['lang'] == 'en') $subject = 'Go from one place to another in Cuba for a very good price';
        
        $to = $data['User']['username'];
        $OK = EmailsUtil::email($to, $subject, $vars, 'super', 'offer_shared_ride', array('lang'=>$data['User']['lang']));
        if ($OK) {
            $this->User->id = $data['User']['id'];
            $OK = $this->User->saveField('shared_ride_offered', true);
        }

        if ($OK) {
            $this->setSuccessMessage('Ofrecido el viaje compartido');
            $datasource->commit();
        } else {
            $this->setErrorMessage('Falló la oferta de viaje compartido');
            $datasource->rollback();
        }
        
        return $this->redirect($this->referer());
    }
    
}

?>