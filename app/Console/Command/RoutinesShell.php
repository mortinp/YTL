<?php
App::uses('EmailsUtil', 'Util');
App::uses('Driver', 'Model');

class RoutinesShell extends AppShell {
    
    public $uses = array('Travel', 'TravelConversationMeta');
    
    public function email2drivers_travels_payment_due() {
        $query = "select drivers.id as driver_id, drivers_profiles.driver_name, drivers.username as driver_email, travels.id as travel_id, travels.origin as travel_origin, travels.destination as travel_destination, travels.date as travel_date

                from drivers_travels

                inner join travels_conversations_meta on travels_conversations_meta.conversation_id = drivers_travels.id

                inner join drivers on drivers.id = drivers_travels.driver_id

                inner join travels on travels.id = drivers_travels.travel_id

                left join drivers_profiles on drivers_profiles.driver_id = drivers.id

                where travels_conversations_meta.state = 'D' and travels_conversations_meta.archived = false

                order by drivers.id, travels.date asc

                ";
        
        $travelsDueToPay = $this->Travel->query($query);
        
        $travels = array();
        for ($index = 0; $index < count($travelsDueToPay);) {
            $current_driver = $travelsDueToPay[$index]['drivers']['driver_id'];
            
            $travels[] = array(
                'Driver'=>array_merge($travelsDueToPay[$index]['drivers'], $travelsDueToPay[$index]['drivers_profiles']),
                'Travel'=>array()
            );
            
            while($index < count($travelsDueToPay) && $travelsDueToPay[$index]['drivers']['driver_id'] == $current_driver) {
                $travels[count($travels) - 1]['Travel'][] = $travelsDueToPay[$index]['travels'];
                $index++;
            }
        }
        
        foreach ($travels as $data) {
            EmailsUtil::email($data['Driver']['driver_email'], 'Recordatorio de viajes por pagar', array('data'=>$data), 'super', 'reminder_driver_payment_due');
        }
        
        // Loguear el reminder para debuguear
        $logEntry = '<b>Reminder Payment Due</b><br/><br/>';
        foreach ($travels as $data) {
            $logEntry .= 'Chofer: '.$data['Driver']['driver_id'];
            $logEntry .= '<br/>Viajes:<br/>';
            
            foreach ($data['Travel'] as $t) {
                $logEntry .= $t['travel_id'].' '.$t['travel_origin'].' - '.$t['travel_destination'].'<br/>';
            }
            
            $logEntry .= '<br/>';
        }
        CakeLog::write('cron', $logEntry);
    }

    
    public function ask_travels_confirmations() {
        $daysToWait = 3; // Wait this number of days after the travel expires to ask for confirmation
        
        $someDaysBack = date('Y-m-d', strtotime('today - '.$daysToWait.' days'));
        
        $query = "SELECT travels.id as travel_id, travels.origin as travel_origin, travels.destination as travel_destination, travels.date as travel_date, drivers_travels.id as conversation_id, travels_conversations_meta.asked_confirmation as asked_confirmation, drivers.username as driver_email, drivers_profiles.driver_name as driver_name

                FROM travels

                INNER JOIN  drivers_travels ON drivers_travels.travel_id = travels.id AND travels.date >= '2016-09-15' AND travels.date <= '$someDaysBack'

                INNER JOIN  travels_conversations_meta ON travels_conversations_meta.conversation_id = drivers_travels.id AND travels_conversations_meta.following = 1 AND travels_conversations_meta.asked_confirmation = 0

                INNER JOIN drivers ON drivers.id = drivers_travels.driver_id
        
                LEFT JOIN drivers_profiles ON drivers_profiles.driver_id =drivers.id";
        
        $travels = $this->Travel->query($query);
        foreach ($travels as $index=> $value) {
            $vars = array();
            $vars['travel_id'] = $value['travels']['travel_id'];
            $vars['travel_origin'] = $value['travels']['travel_origin'];
            $vars['travel_destination'] = $value['travels']['travel_destination'];
            $vars['travel_date'] = $value['travels']['travel_date'];
            $vars['conversation_id'] = $value['drivers_travels']['conversation_id'];
            $vars['asked_confirmation'] = $value['travels_conversations_meta']['asked_confirmation'];
            $vars['driver_name'] = Driver::shortenName($value['drivers_profiles']['driver_name']);
            
            //print_r($vars) ;
            
            $datasource = $this->Travel->getDataSource();
            $datasource->begin();
            
            $to = $value['drivers']['driver_email'];
            $subject = 'Verificación del viaje #'.$vars['travel_id'].' [['.$vars['conversation_id'].']]';
            $OK = EmailsUtil::email($to, $subject, $vars, 'verificacion_viaje', 'ask_confirmation_to_driver');
            if($OK) {
                $this->TravelConversationMeta->id = $vars['conversation_id'];
                $OK = $this->TravelConversationMeta->saveField('asked_confirmation', true);
            }
            
            if($OK) $datasource->commit(); else $datasource->rollback();
            
        }
    }
}

?>