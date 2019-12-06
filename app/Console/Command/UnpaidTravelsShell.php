<?php
App::uses('AppShell', 'Console/Command');
App::uses('Driver', 'Model');
App::uses('EmailsUtil', 'Util');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnpaidTravelsShell
 *
 * @author Yuniel
 */
class UnpaidTravelsShell extends AppShell {
    //put your code here
    public $uses = array('User', 'DriverTravel', 'Driver', 'DriverTravelerConversation');
    
    /**
     * Set all drivers token
     *
     * @access public
     */
    public function main() {
        $this->DriverModel = ClassRegistry::init('Driver'); 

        $drivers = $this->DriverModel->find('all',array(/*'conditions'=>array(),*/
            'joins'=>array(
                array('table' => 'drivers_travels',
                'alias' => 'Rides',
                'type' => 'INNER',
                'conditions' => array(
                'Driver.id = Rides.driver_id',"Rides.travel_date > '2019-12-01'",'DATEDIFF(CURDATE(),Rides.travel_date) > 30'
                )
                ),
                array('table' => 'travels_conversations_meta',
                'alias' => 'Meta',
                'type' => 'INNER',
                'conditions' => array(
                'Rides.id = Meta.conversation_id','Meta.state="D"'
                )
                )
                ),/* 'limit'=>2 */           ));
           
        //die(print_r($drivers));
        foreach ($drivers as $data) {
            $data['Driver']['blocked'] = true;
            
            if($this->DriverModel->save($data))
            EmailsUtil::email($data['Driver']['username'], 'CUENTA BLOQUEADA por atraso en pago de comisiones', array('driver_name'=>$data['DriverProfile']['driver_name']), 'super', 'block_driver_payment_due');
        }
    }
}
