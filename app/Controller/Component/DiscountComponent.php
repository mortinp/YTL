<?php

App::uses('Component', 'Controller');
App::uses('DiscountRidesController', 'Controller');
App::uses('Driver', 'Model');
App::uses('DiscountRides', 'Model');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiscountComponent
 *
 * @author Yuniel
 */
class DiscountComponent extends Component{
    //put your code here
    
    public function add_discount_offer($driver_token,$offer) {
        $this->Driver = ClassRegistry::init('Driver');
        $this->DiscountRide = ClassRegistry::init('DiscountRide');
        
        /*If driver token is invalid return false*/
        $real = $this->Driver->find('all',array('conditions'=>array('Driver.driver_discount_token'=>$driver_token)) );
        if($real==null)
            return false;
        
        if($this->DiscountRide->save($offer))
            return true;
        else
            return false;   
        
    }
}
