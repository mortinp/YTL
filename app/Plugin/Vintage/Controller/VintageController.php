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
    
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('vintage_car_tour_havana');
    }
    
    public function vintage_car_tour_havana() {
        $this->layout = 'activity';
    }
}
