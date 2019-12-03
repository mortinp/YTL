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
class DriverTokenShell extends AppShell {
    //put your code here
    //public $uses = array('User', 'DriverTravel', 'Driver', 'DriverTravelerConversation');
    
    /**
     * Set all drivers token
     *
     * @access public
     */
    public function main() {
        $this->DriverModel = ClassRegistry::init('Driver'); 

        $drivers = $this->DriverModel->find('all',array('conditions'=>array('Driver.web_auth_token IS NULL')));

        foreach ($drivers as $driver) {
            $driver['Driver']['web_auth_token'] = StringsUtil::getWeirdString();
            $this->DriverModel->save($driver);
        }
    }
}
