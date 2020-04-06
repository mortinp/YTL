<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VintageController
 *
 * @author Yuniel
 */
class VintageController extends AppController{
    //put your code here
    
    public $uses = array('Driver', 'User' );
    
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('vintage_car_tour_havana');
    }
    
    public function vintage_car_tour_havana() {
        $this->layout = 'activity';
        $this->Driver->recursive=2;
        $options = $this->Driver->find('all',array('conditions'=>array('Driver.for_tours'=>true)));
        $this->set('options', $options);
    }
}
