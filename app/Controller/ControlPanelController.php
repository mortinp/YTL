<?php

App::uses('AppController', 'Controller');
App::uses('TimeUtil', 'Util');

class ControlPanelController extends AppController {
    
    public $uses = array('DriverTravel', 'Driver');
    
    public function new_messages() {
        $this->DriverTravel->recursive = 2;        
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        
        $conditions = array();
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
        
        $this->paginate = array('order'=>array('Travel.date'=>'ASC'), 'limit'=>50);
        
        $conversations = $this->paginate($conditions);
        $this->set('conversations', $conversations);
        //$this->render('all');
    }
    
    public function following_expire_soon() {
        $this->DriverTravel->recursive = 2;        
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        
        $conditions = array();
        $conditions['TravelConversationMeta.following'] = true;
        $conditions['TravelConversationMeta.archived'] = 0; //Que no este archivado
        
        $limitDate = date('Y-m-d', strtotime("today + 2 weeks"));
        $conditions['Travel.date < '] = $limitDate;// Que expiren hasta dos semanas hacia adelante
        
        $this->paginate = array('order'=>array('Travel.date'=>'ASC'), 'limit'=>50);
        
        $conversations = $this->paginate($conditions);
        $this->set('conversations', $conversations);
        
        $this->set('message', 'Conversaciones <em>Siguiendo</em> que expiran hasta '.TimeUtil::prettyDate($limitDate));
    }
}

?>