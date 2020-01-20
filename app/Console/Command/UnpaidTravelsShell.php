<?php
App::uses('AppShell', 'Console/Command');
App::uses('Driver', 'Model');
App::uses('DiverTravel', 'Model');
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
        
        
        $this->DriverTravel = ClassRegistry::init('DriverTravel'); 
         
        /*Logica para avisar el bloqueo 5 dias antes*/
        $now = date('Y-m-d');
        $query = "select drivers.id as driver_id, drivers_profiles.driver_name, drivers.username as driver_email, 
                travels.id as travel_id, travels.origin as travel_origin, travels.destination as travel_destination, travels.date as travel_date, 
                drivers_travels.travel_date as driver_travel_date, drivers_travels.notification_type, drivers_travels.identifier, drivers_travels.id as driver_travel_id

                from drivers_travels

                inner join travels_conversations_meta on travels_conversations_meta.conversation_id = drivers_travels.id

                inner join drivers on drivers.id = drivers_travels.driver_id

                left join travels on travels.id = drivers_travels.travel_id 

                left join drivers_profiles on drivers_profiles.driver_id = drivers.id

                where  travels_conversations_meta.state='D' and drivers_travels.travel_date >'2016-12-01' and (datediff('".$now."',drivers_travels.travel_date) >= 25) and (datediff('".$now."',drivers_travels.travel_date) < 30)

                order by drivers.id, travels.date asc";
        
        
        //debug($query); die();
        $travelsDuePay = $this->DriverTravel->query($query);
        //die(print_r($travelsDuePay));
        
        
        $travels = array();
        for ($index = 0; $index < count($travelsDuePay);) {
            $current_driver = $travelsDuePay[$index]['drivers']['driver_id'];
            
            $travels[] = array(
                'Driver'=>array_merge($travelsDuePay[$index]['drivers'], $travelsDuePay[$index]['drivers_profiles']),
                'Travel'=>array()
            );
            
            while($index < count($travelsDuePay) && $travelsDuePay[$index]['drivers']['driver_id'] == $current_driver) {
                $travels[count($travels) - 1]['Travel'][] = array_merge($travelsDuePay[$index]['travels'], $travelsDuePay[$index]['drivers_travels']);
                $index++;
            }
        }
        
        
       foreach ($travels as $data) {
            EmailsUtil::email($data['Driver']['driver_email'], 'En 5 (CINCO) días será BLOQUEADO - Tiene viajes por pagar', array('data'=>$data), 'super', 'reminder_driver_payment_due');
        }
        
        /*Logica para bloquear*/
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
