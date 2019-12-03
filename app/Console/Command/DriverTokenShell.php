<?php
App::uses('AppShell', 'Console/Command');
App::uses('Driver', 'Model');
App::uses('StringsUtil', 'Util');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DriverTokenShell
 *
 * @author Yuniel
 */
class DriverTokenShell extends AppShell{
    //put your code here
     public $uses = array('User', 'DriverTravel', 'Driver', 'DriverTravelerConversation');
    
    /**
     * Set all drivers token
     *
     * @access public
     */
    public function main() {
       $this->DriverModel = ClassRegistry::init('Driver'); 
       
       $drivers = $this->DriverModel->find('all',array('conditions'=>array('Driver.driver_discount_token'=>"")/*,'limit'=>1*/));
       
       
       foreach ($drivers as $driver) {
           $driver['Driver']['driver_discount_token'] = StringsUtil::getWeirdString();
           $this->DriverModel->save($driver);
           print_r($driver);
       }
        
        
    }
}
