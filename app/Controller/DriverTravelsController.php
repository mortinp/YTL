<?php

App::uses('DriverTravel', 'Model');
App::uses('DriverTravelerConversation', 'Model');

class DriverTravelsController extends AppController {
    
    public $uses = array('DriverTravel', 'Travel', 'Driver');
    
    public function all() {
        $this->DriverTravel->recursive = 2;
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $this->paginate = array('order'=>array('Travel.date'=>'DESC'));
        $conditions = array(/*'User.role'=>'regular'*/);
        
        $driver_travels = $this->paginate($conditions);
        
        $this->set('filter_applied', DriverTravel::$SEARCH_ALL);
        $this->set('driver_travels', $driver_travels);
    }
    
    public function view_filtered($filter = 'all') {
        $this->DriverTravel->recursive = 2;        
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $this->paginate = array('order'=>array('Travel.date'=>'DESC'));
        $conditions = array(/*'User.role'=>'regular'*/);
        
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
                    'DriverTravel.driver_traveler_conversation_count >' => 0                    
                )),
                array('AND'=>array(
                    array('not' => array('TravelConversationMeta.read_entry_count' => null)),
                    'DriverTravel.driver_traveler_conversation_count > TravelConversationMeta.read_entry_count'
                ))
            );
            $this->paginate = array('order'=>array('Travel.date'=>'ASC'));
        } else if($filter == DriverTravel::$SEARCH_FOLLOWING) {
            $this->paginate = array('order'=>array('Travel.date'=>'ASC'));
            $conditions['TravelConversationMeta.following'] = true;
        } else if($filter == DriverTravel::$SEARCH_DONE) {
            $conditions['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_DONE;
        } else if($filter == DriverTravel::$SEARCH_PAID) {
            $conditions['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_PAID;
        }
        
        
        $driver_travels = $this->paginate($conditions);
        $this->set('filter_applied', $filter);
        $this->set('driver_travels', $driver_travels);
        $this->render('all');
    }
}

?>