<?php
App::uses('AppShell', 'Console/Command');
App::uses('Driver', 'Model');
App::uses('Travel', 'Model');
App::uses('DriverTravel', 'Model');
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
class ConfirmedReminderShell extends AppShell {
    //put your code here
    public $uses = array('User', 'DriverTravel', 'Driver','Travel', 'DriverTravelerConversation');
    
    /**
     * Set all drivers token
     *
     * @access public
     */
    public function main() {
        
        $now = date('Y-m-d');
        $query = "select drivers.id as driver_id, drivers_profiles.driver_name, drivers.username as driver_email, 
                travels.id as travel_id, travels.origin as travel_origin, travels.destination as travel_destination, travels.date as travel_date, 
                drivers_travels.travel_date as driver_travel_date, drivers_travels.notification_type, drivers_travels.identifier, drivers_travels.id as driver_travel_id

                from drivers_travels

                inner join travels_conversations_meta on travels_conversations_meta.conversation_id = drivers_travels.id

                inner join drivers on drivers.id = drivers_travels.driver_id

                left join travels on travels.id = drivers_travels.travel_id

                left join drivers_profiles on drivers_profiles.driver_id = drivers.id

                where travels_conversations_meta.confirmed_by_traveler='1' and travels_conversations_meta.date_confirmed >'".$now."' and (datediff('".$now."',travels_conversations_meta.date_confirmed) <= 3)

                order by drivers.id, travels.date asc

                ";
        //debug($query); die();
        $travelsNextDays = $this->Travel->query($query);
        
        
        
        $travels = array();
        for ($index = 0; $index < count($travelsNextDays);) {
            $current_driver = $travelsNextDays[$index]['drivers']['driver_id'];
            
            $travels[] = array(
                'Driver'=>array_merge($travelsNextDays[$index]['drivers'], $travelsNextDays[$index]['drivers_profiles']),
                'Travel'=>array()
            );
            
            while($index < count($travelsNextDays) && $travelsNextDays[$index]['drivers']['driver_id'] == $current_driver) {
                $travels[count($travels) - 1]['Travel'][] = array_merge($travelsNextDays[$index]['travels'], $travelsNextDays[$index]['drivers_travels']);
                $index++;
            }
        }
        
        
        foreach ($travels as $data) {
            EmailsUtil::email($data['Driver']['driver_email'], 'RECORDATORIO de próximos viajes confirmados', array('data'=>$data), 'super', 'reminder_driver_next_confirmed');
        }
        
    }
}
