<?php

App::uses('AppController', 'Controller');
App::uses('UserInteraction', 'Model');

class UserInteractionsController extends AppController {
    
    public function index() {
        $this->UserInteraction->bindModel(array('belongsTo'=>array('User')));
        $this->set('interactions', $this->paginate());
        $this->render('all');
    }
    
    public function view_filtered($filter = 'all') {
        $this->UserInteraction->bindModel(array('belongsTo'=>array('User')));
        
        $this->paginate = array('order'=>array('UserInteraction.id'=>'DESC'), 'limit'=>100);
        $conditions = array();
        
        if($filter == UserInteraction::$SEARCH_FIND_CASAS) {
            $conditions['UserInteraction.interaction_due'] = UserInteraction::$INTERACTION_TYPE_FIND_CASAS;
        } else if($filter == UserInteraction::$SEARCH_CONFIRM_EMAIL) {
            $conditions['UserInteraction.interaction_due'] = UserInteraction::$INTERACTION_TYPE_CONFIRM_EMAIL;
        } else if($filter == UserInteraction::$SEARCH_CHANGE_PASSWORD) {
            $conditions['UserInteraction.interaction_due'] = UserInteraction::$INTERACTION_TYPE_CHANGE_PASSWORD;
        } else if($filter == UserInteraction::$SEARCH_NOTIFY_WRITE_REVIEW) {
            $conditions['UserInteraction.interaction_due'] = UserInteraction::$INTERACTION_TYPE_WRITE_REVIEW;
        } else if($filter == UserInteraction::$SEARCH_NOTIFY_MORE_DRIVERS) {
            $conditions['UserInteraction.interaction_due'] = UserInteraction::$INTERACTION_TYPE_NOTIFY_MORE_DRIVERS;
        }
        
        $this->set('filter_applied', $filter);
        $this->set('interactions', $this->paginate($conditions));
        $this->render('all');
        
    }
}

?>