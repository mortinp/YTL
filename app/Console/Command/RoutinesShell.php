<?php
App::uses('EmailsUtil', 'Util');
App::uses('Driver', 'Model');
App::uses('DriverTransactionalEmail', 'TransactionalEmails.Model');

class RoutinesShell extends AppShell {
    
    public $uses = array('Travel','Driver', 'TravelConversationMeta', 'TransactionalEmails.DriverTransactionalEmail');
    
    public function email2drivers_travels_payment_due() {
        $query = "select drivers.id as driver_id, drivers_profiles.driver_name, drivers.username as driver_email, 
                travels.id as travel_id, travels.origin as travel_origin, travels.destination as travel_destination, travels.date as travel_date, 
                drivers_travels.travel_date as driver_travel_date, drivers_travels.notification_type, drivers_travels.identifier, drivers_travels.id as driver_travel_id

                from drivers_travels

                inner join travels_conversations_meta on travels_conversations_meta.conversation_id = drivers_travels.id

                inner join drivers on drivers.id = drivers_travels.driver_id

                left join travels on travels.id = drivers_travels.travel_id

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
                $travels[count($travels) - 1]['Travel'][] = array_merge($travelsDueToPay[$index]['travels'], $travelsDueToPay[$index]['drivers_travels']);
                $index++;
            }
        }
        
        foreach ($travels as $data) {
            EmailsUtil::email($data['Driver']['driver_email'], 'Recordatorio de viajes por pagar', array('data'=>$data), 'super', 'reminder_driver_payment_due');
        }
    }
    
    
    
    public function email2drivers_reminder_old_testimonials() {
        $today = date('Y-m-d', strtotime('today'));
        $checkDate = date('Y-m-d', strtotime("$today - 1 month"));
        
        $query = "select drivers.id as driver_id, drivers_profiles.driver_name, drivers_profiles.driver_code, drivers.username as driver_email,
                max(testimonials.created) as last_testimonial_date, 
                dte.id as transaction_id, dte.last_sent

                from drivers

                inner join testimonials 
                on testimonials.driver_id = drivers.id 
                and testimonials.state = 'A'
                and drivers.active = 1

                left join drivers_transactional_emails dte 
                on dte.driver_id = drivers.id 
                and dte.transaction_type = ".DriverTransactionalEmail::$TYPE_REMINDER_OLD_TESTIMONIALS."

                inner join drivers_profiles 
                on drivers_profiles.driver_id = drivers.id
                and drivers_profiles.show_profile = 1

                group by driver_id, driver_name, driver_email

                order by last_testimonial_date asc
                ";
        
        $results = $this->DriverTransactionalEmail->query($query);
        
        //print_r($results);
        
        foreach ($results as $data) {
            //echo strtotime($data['dte']['last_sent']).' > '.strtotime($checkDate).'<br/>';
            
            // No enviar reminder cuando...
            if( 
                strtotime($data[0]['last_testimonial_date']) > strtotime($checkDate) // ...la fecha del ultimo testimonio es reciente
                || ($data['dte']['transaction_id'] != null && strtotime($data['dte']['last_sent']) > strtotime($checkDate)) // ...ya se le envio el reminder recientemente
            ) 
                continue;
            
            //print_r($data);
            
            if($data['dte']['transaction_id'] == null) {
                $this->DriverTransactionalEmail->create();
                $this->DriverTransactionalEmail->save(array(
                    'last_sent'=>$today,
                    'driver_id'=>$data['drivers']['driver_id'],
                    'transaction_type'=> DriverTransactionalEmail::$TYPE_REMINDER_OLD_TESTIMONIALS));
            } else {
                $this->DriverTransactionalEmail->id = $data['dte']['transaction_id'];
                $this->DriverTransactionalEmail->saveField('last_sent', $today);
            }
            
            EmailsUtil::email($data['drivers']['driver_email'], 'Sugerencia sobre su perfil', array('data'=>$data), 'coo', 'reminder_driver_old_testimonials');
        }
    }
    
    
    public function email2drivers_reminder_still_no_testimonials() {
        $today = date('Y-m-d', strtotime('today'));
        $checkDate = date('Y-m-d', strtotime("$today - 1 month"));
        
        $query = "select drivers.id as driver_id, drivers.created as driver_registered_date, drivers_profiles.driver_name, drivers_profiles.driver_code, drivers.username as driver_email,
                dte.id as transaction_id, dte.last_sent

                from drivers

                left join drivers_transactional_emails dte 
                on dte.driver_id = drivers.id 
                and dte.transaction_type = ".DriverTransactionalEmail::$TYPE_REMINDER_STILL_NO_TESTIMONIALS."

                inner join drivers_profiles 
                on drivers_profiles.driver_id = drivers.id
                and drivers_profiles.show_profile = 1
                
                where 
                drivers.active = 1 
                and drivers.created < '$checkDate'
                and drivers.id not in (select testimonials.driver_id from testimonials where testimonials.state = 'A')
                ";
        
        $results = $this->DriverTransactionalEmail->query($query);
        
        //print_r($results);
        
        foreach ($results as $data) {
            //echo strtotime($data['dte']['last_sent']).' > '.strtotime($checkDate).'<br/>';
            
            // Si tiene una transaccion de este tipo y ademas es mas reciente que $checkDate, no enviar...
            if($data['dte']['transaction_id'] != null && strtotime($data['dte']['last_sent']) > strtotime($checkDate)) continue;
            
            //print_r($data);
            
            if($data['dte']['transaction_id'] == null) {
                $this->DriverTransactionalEmail->create();
                $this->DriverTransactionalEmail->save(array(
                    'last_sent'=>$today,
                    'driver_id'=>$data['drivers']['driver_id'],
                    'transaction_type'=> DriverTransactionalEmail::$TYPE_REMINDER_STILL_NO_TESTIMONIALS));
            } else {
                $this->DriverTransactionalEmail->id = $data['dte']['transaction_id'];
                $this->DriverTransactionalEmail->saveField('last_sent', $today);
            }
            
            EmailsUtil::email($data['drivers']['driver_email'], 'Sugerencia sobre su perfil', array('data'=>$data), 'coo', 'reminder_driver_still_no_testimonials');
        }
    }
    
    
    public function email2drivers_reminder_discount_offer() {
        
        $query = "select drivers.id as driver_id, drivers_profiles.driver_name, drivers_profiles.driver_code, drivers.username as driver_email

                from drivers
                
                inner join drivers_profiles 
                on drivers_profiles.driver_id = drivers.id
                and drivers_profiles.show_profile = 1
                
                where 
                drivers.active = 1
                and drivers.province_id = 5
                ";
        
        $results = $this->Driver->query($query);
        
        foreach ($results as $data) {
            EmailsUtil::email($data['drivers']['driver_email'], 'No vuelvas a viajar con tu taxi vacío', array('driver_name'=>$data['drivers_profiles']['driver_name']), 'super', 'reminder_driver_discount_offer');
        }
    }

    
    /*public function ask_travels_confirmations() {
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
    }*/
}

?>