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
    
    public $uses = array('DiscountRide');
    
    public function add_discount_offer($driver, $offer) {
        // Reacomodar datos para trabajar mas facil debajo
        if(isset($offer['DiscountRide'])) $offer = $offer['DiscountRide'];
        if(isset($driver['Driver'])) $driver = $driver['Driver'];
        
        // Asignar chofer a la oferta
        $offer['driver_id'] = $driver['id'];
        
        $discountsModel = ClassRegistry::init('DiscountRide');
        if(!$discountsModel->save($offer)) return false;
        
        return true;
        
    }
}
