<?php

App::uses('DriverTravel', 'Model');
App::uses('DriverTravelerConversation', 'Model');

class DriverTravelsController extends AppController {
    
    public $uses = array('DriverTravel', 'Travel', 'Driver');
    
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
        $conditions = array('Travel.user_id' => $this->Auth->user('id'), 'DriverTravel.message_count >' =>0);
        
        
        $driver_travels = $this->DriverTravel->find('all', array('conditions'=>$conditions, 'order'=>$order));
        $this->set('driver_travels', $driver_travels);
    }
    
    public function view_filtered($filter = 'all') {
        $this->DriverTravel->recursive = 2;        
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $this->paginate = array('order'=>array('Travel.date'=>'DESC'));
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
            $this->paginate = array('order'=>array('Travel.date'=>'ASC'));
                    
        } else if($filter == DriverTravel::$SEARCH_FOLLOWING) {
            $this->paginate = array('order'=>array('Travel.date'=>'ASC'), 'limit'=>50);
            $conditions['TravelConversationMeta.following'] = true;
            $conditions['TravelConversationMeta.archived'] = 0; //Que no este archivado
        } else if($filter == DriverTravel::$SEARCH_DONE) {
            $this->paginate = array('order'=>array('Travel.date'=>'DESC'), 'limit'=>100);// Paginacion grande para ver todos los viajes realizados y hacer resumenes de cobros de comisiones facilmente sin tener que cambiar de paginas
            $conditions['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_DONE;
            $conditions['TravelConversationMeta.archived'] = 0; //Que no este archivado
        } else if($filter == DriverTravel::$SEARCH_PAID) {
            $this->paginate = array('order'=>array('Travel.date'=>'DESC'), 'limit'=>50);
            $conditions['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_PAID;
        } else if($filter == DriverTravel::$SEARCH_PINNED) {
            $this->paginate = array('order'=>array('Travel.date'=>'ASC'), 'limit'=>50);
            $conditions['TravelConversationMeta.flag_type !='] = null;
        } else if($filter == DriverTravel::$SEARCH_ARCHIVED) {
            $conditions['TravelConversationMeta.archived'] = 1;
        }
        
        if(AuthComponent::user('role') == 'operator')
            $this->DriverTravel->Behaviors->load('Operations.OperatorScope', array('match'=>'Driver.operator_id', 'action'=>'C')); // Restringir ver conversaciones
        
        $driver_travels = $this->paginate($conditions);
        $this->set('filter_applied', $filter);
        $this->set('driver_travels', $driver_travels);
        $this->render('all');
    }
}

?>