<?php

App::uses('AppController', 'Controller');

class MetricsController extends AppController {
    
    public $uses = array('Travel', 'DriverTravelerConversation');
    
    public function dashboard() {
        $today = date('Y-m-d', strtotime('today'));
        $endDate = $today;
        $iniDate = date('Y-m-d', strtotime("$endDate - 6 months"));
        if(!empty ($this->request->query)) {
            //WARNING: A continuacion estoy asumiendo que las fechas vienen en formato dd-mm-yyyy
            
            $strIniDate = $this->request->query['date_ini'];
            $iniDate = substr($strIniDate,6,4).'-'.substr($strIniDate,3,2).'-'.substr($strIniDate,0,2);
            
            if(isset ($this->request->query['date_end'])) {
                $strEndDate = $this->request->query['date_end'];
                $endDate = substr($strEndDate,6,4).'-'.substr($strEndDate,3,2).'-'.substr($strEndDate,0,2);
            }            
        }        
        
        //$this->set('conversations', $this->conversationsRespondedByDrivers($iniDate, $endDate));
        $this->set('incomes', $this->incomes($iniDate, $endDate));  
        $this->set('travels_count', $this->travels_count2($iniDate, $endDate));
        $this->set('messages_count', $this->messages_count($iniDate, $endDate));
        
        $this->request->data['DateRange']['date_ini'] = date('d-m-Y', strtotime($iniDate));
        $this->request->data['DateRange']['date_end'] = date('d-m-Y', strtotime($endDate));        
    }
    
    /*private function conversationsRespondedByDrivers($iniDate, $endDate) {
        $query = "SELECT Travel.id, Travel.origin, Travel.destination, Travel.created, DriverTravel.id as conversation_id,

                sum( case when DriverTravelerConversation.response_by = 'driver' then 1 else 0 end) as driver_responses_count,

                sum( case when DriverTravelerConversation.response_by = 'traveler' then 1 else 0 end) as traveler_responses_count,

                TravelConversationMeta.state, TravelConversationMeta.income

                FROM travels as Travel

                INNER JOIN drivers_travels as DriverTravel ON Travel.id = DriverTravel.travel_id

                INNER JOIN driver_traveler_conversations AS DriverTravelerConversation ON DriverTravel.id = DriverTravelerConversation.conversation_id

                LEFT JOIN travels_conversations_meta as TravelConversationMeta ON DriverTravel.id = TravelConversationMeta.conversation_id
                
                WHERE Travel.created BETWEEN '$iniDate' AND '$endDate' AND Travel.date < '$endDate'

                GROUP BY DriverTravel.id

                ORDER BY Travel.id";
        
        return $this->Travel->query($query);
    }*/
    
    public function incomes($iniDate, $endDate) {
        $query = "Select year(travels.date) as year, month(travels.date) as month, travels.date as date, 
                sum(travels_conversations_meta.income) as income, 
                sum(travels_conversations_meta.income_saving) as income_saving

                FROM travels
        
                INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'
        
                INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id

                INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND travels_conversations_meta.income IS NOT NULL AND (travels_conversations_meta.state = 'D' OR travels_conversations_meta.state = 'P')

                WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

                GROUP BY year, month";
        
        $months = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
        $incomes = $this->Travel->query($query);
        $fixedIncomes = array();
        foreach ($incomes as $index=> $value) {
            $fixedIncomes[$index] = array();
            $fixedIncomes[$index]['date'] = $value['travels']['date'];
            $fixedIncomes[$index]['income'] = $value[0]['income'];
            $fixedIncomes[$index]['income_saving'] = $value[0]['income_saving'];
            $fixedIncomes[$index]['year'] = $value[0]['year'];
            $fixedIncomes[$index]['month'] = $months[$value[0]['month'] - 1];
        }
        
        return $fixedIncomes;
    }
    
    
    public function travels_count($iniDate, $endDate) {
        $query = "Select year(travels.date) as year, month(travels.date) as month, travels.date as date,
                count(distinct travels.id) as travels_expired_count,
                sum( case when travels_conversations_meta.state = 'D' OR travels_conversations_meta.state = 'P' then 1 else 0 end) as travels_done_count

                FROM travels

                INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'
        
                INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id

                LEFT JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND (travels_conversations_meta.state = 'D' OR travels_conversations_meta.state = 'P')
        
                WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

                GROUP BY year(travels.date), month(travels.date)";
        
        $months = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
        $travels = $this->Travel->query($query);
        $fixedTravels = array();
        foreach ($travels as $index=> $value) {
            $fixedTravels[$index] = array();
            $fixedTravels[$index]['date'] = $value['travels']['date'];
            $fixedTravels[$index]['travels_expired_count'] = $value[0]['travels_expired_count'];
            $fixedTravels[$index]['travels_done_count'] = $value[0]['travels_done_count'];
            $fixedTravels[$index]['year'] = $value[0]['year'];
            $fixedTravels[$index]['month'] = $months[$value[0]['month'] - 1];
        }
        
        
        
        
        
        $query = "Select year(travels.created) as year, month(travels.created) as month, travels.created as date,
                count(distinct travels.id) as travels_created_count

                FROM travels

                INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'
        
                WHERE travels.created BETWEEN '$iniDate' AND '$endDate'

                GROUP BY year(travels.date), month(travels.date)";
        
        $travels = $this->Travel->query($query);
        foreach ($travels as $index=> $value) {
            if(!in_array($index, array_keys($fixedTravels))) {
                $fixedTravels[$index] = array();
                $fixedTravels[$index]['date'] = $value['travels']['date'];
                $fixedTravels[$index]['travels_count'] = 0;
                $fixedTravels[$index]['travels_done_count'] = 0;
                $fixedTravels[$index]['year'] = $value[0]['year'];
                $fixedTravels[$index]['month'] = $months[$value[0]['month'] - 1];
            }
            $fixedTravels[$index]['travels_created_count'] = $value[0]['travels_created_count'];
        }
        
        
        
        return $fixedTravels;
    }
    
    
    public function travels_count2($iniDate, $endDate) {
        
        $queryCreated = "Select year(travels.created) as year, month(travels.created) as month, travels.created as date,
            count(distinct travels.id) as travels_created_count

            FROM travels

            INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'

            WHERE travels.created BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        $queryExpired = "Select year(travels.date) as year, month(travels.date) as month, travels.date as date,
            count(distinct travels.id) as travels_expired_count

            FROM travels

            INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'

            WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        $queryDone = "Select year(travels.date) as year, month(travels.date) as month, travels.date as date,
            count( distinct travels.id) as travels_done_count

            FROM travels

            INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'

            INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id

            INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND (travels_conversations_meta.state = 'D' OR travels_conversations_meta.state = 'P')

            WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        $queryDoneNotPaid = "Select year(travels.date) as year, month(travels.date) as month, travels.date as date,
            count( distinct travels.id) as travels_done_not_paid_count

            FROM travels

            INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'

            INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id

            INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND (travels_conversations_meta.state = 'D')

            WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        
        $fixedTravels = array();
        $months = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
        
        
        $travelsCreated = $this->Travel->query($queryCreated);
        foreach ($travelsCreated as $index=> $value) {
            $fixedTravels[$index] = array();
            $fixedTravels[$index]['date'] = $value['travels']['date'];
            $fixedTravels[$index]['travels_created_count'] = $value[0]['travels_created_count'];
            $fixedTravels[$index]['year'] = $value[0]['year'];
            $fixedTravels[$index]['month'] = $months[$value[0]['month'] - 1];
        }      
        
        
        $travelsExpired = $this->Travel->query($queryExpired);
        foreach ($travelsExpired as $value) {
            
            $appended = false;
            foreach ($fixedTravels as &$t) {
                if($value[0]['year'] == $t['year'] && $months[$value[0]['month'] - 1] == $t['month']) {
                    $t['travels_expired_count'] = $value[0]['travels_expired_count'];
                    $appended = true;
                    break;
                }
            }
            if(!$appended) {
                $fixedTravels[] = array();
                $entries = count($fixedTravels);
                $fixedTravels[$entries - 1]['date'] = $value['travels']['date'];
                $fixedTravels[$entries - 1]['travels_expired_count'] = $value[0]['travels_expired_count'];
                $fixedTravels[$entries - 1]['year'] = $value[0]['year'];
                $fixedTravels[$entries - 1]['month'] = $months[$value[0]['month'] - 1];
            }
        }
        
        
        $travelsDone = $this->Travel->query($queryDone);        
        foreach ($travelsDone as $value) {
            
            $appended = false;
            foreach ($fixedTravels as &$t) {
                if($value[0]['year'] == $t['year'] && $months[$value[0]['month'] - 1] == $t['month']) {
                    $t['travels_done_count'] = $value[0]['travels_done_count'];
                    $appended = true;
                    break;
                }
            }
            if(!$appended) {
                $fixedTravels[] = array();
                $entries = count($fixedTravels);
                $fixedTravels[$entries - 1]['date'] = $value['travels']['date'];
                $fixedTravels[$entries - 1]['travels_done_count'] = $value[0]['travels_done_count'];
                $fixedTravels[$entries - 1]['year'] = $value[0]['year'];
                $fixedTravels[$entries - 1]['month'] = $months[$value[0]['month'] - 1];
            }
        }
        
        $travelsDoneNotPaid = $this->Travel->query($queryDoneNotPaid);        
        foreach ($travelsDoneNotPaid as $value) {
            
            $appended = false;
            foreach ($fixedTravels as &$t) {
                if($value[0]['year'] == $t['year'] && $months[$value[0]['month'] - 1] == $t['month']) {
                    $t['travels_done_not_paid_count'] = $value[0]['travels_done_not_paid_count'];
                    $appended = true;
                    break;
                }
            }
            if(!$appended) {
                $fixedTravels[] = array();
                $entries = count($fixedTravels);
                $fixedTravels[$entries - 1]['date'] = $value['travels']['date'];
                $fixedTravels[$entries - 1]['travels_done_not_paid_count'] = $value[0]['travels_done_not_paid_count'];
                $fixedTravels[$entries - 1]['year'] = $value[0]['year'];
                $fixedTravels[$entries - 1]['month'] = $months[$value[0]['month'] - 1];
            }
        }
        
        
        return $fixedTravels;
    }
    
    
    public function messages_count($iniDate, $endDate) {
        $queryDrivers = "Select year(driver_traveler_conversations.created) as year, month(driver_traveler_conversations.created) as month, driver_traveler_conversations.created as date,
            count(distinct driver_traveler_conversations.id) as messages_count_drivers

            FROM driver_traveler_conversations

            WHERE driver_traveler_conversations.response_by = 'driver' AND driver_traveler_conversations.created BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        $queryTravelers = "Select year(driver_traveler_conversations.created) as year, month(driver_traveler_conversations.created) as month, driver_traveler_conversations.created as date,
            count(distinct driver_traveler_conversations.id) as messages_count_travelers

            FROM driver_traveler_conversations

            WHERE driver_traveler_conversations.response_by = 'traveler' AND driver_traveler_conversations.created BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        $fixedMessages = array();
        $months = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
        
        
        $messagesDrivers = $this->DriverTravelerConversation->query($queryDrivers);
        foreach ($messagesDrivers as $index=> $value) {
            $fixedMessages[$index] = array();
            $fixedMessages[$index]['date'] = $value['driver_traveler_conversations']['date'];
            $fixedMessages[$index]['messages_count_drivers'] = $value[0]['messages_count_drivers'];
            $fixedMessages[$index]['year'] = $value[0]['year'];
            $fixedMessages[$index]['month'] = $months[$value[0]['month'] - 1];
        }
        
        $messagesTravelers = $this->Travel->query($queryTravelers);
        foreach ($messagesTravelers as $value) {
            
            $appended = false;
            foreach ($fixedMessages as &$t) {
                if($value[0]['year'] == $t['year'] && $months[$value[0]['month'] - 1] == $t['month']) {
                    $t['messages_count_travelers'] = $value[0]['messages_count_travelers'];
                    $appended = true;
                    break;
                }
            }
            if(!$appended) {
                $fixedMessages[] = array();
                $entries = count($fixedMessages);
                $fixedMessages[$entries - 1]['date'] = $value['driver_traveler_conversations']['date'];
                $fixedMessages[$entries - 1]['messages_count_travelers'] = $value[0]['messages_count_travelers'];
                $fixedMessages[$entries - 1]['year'] = $value[0]['year'];
                $fixedMessages[$entries - 1]['month'] = $months[$value[0]['month'] - 1];
            }
        }
        
        return $fixedMessages;
    }
    
    
    
    
    
    public function analisis() {
        $today = date('Y-m-d', strtotime('today'));
        $endDate = $today;
        $iniDate = date('Y-m-d', strtotime("$endDate - 1 months"));
        if(!empty ($this->request->query)) {
            //WARNING: A continuacion estoy asumiendo que las fechas vienen en formato dd-mm-yyyy
            
            $strIniDate = $this->request->query['date_ini'];
            $iniDate = substr($strIniDate,6,4).'-'.substr($strIniDate,3,2).'-'.substr($strIniDate,0,2);
            
            if(isset ($this->request->query['date_end'])) {
                $strEndDate = $this->request->query['date_end'];
                $endDate = substr($strEndDate,6,4).'-'.substr($strEndDate,3,2).'-'.substr($strEndDate,0,2);
            }            
        }        
        
        $this->set('expired_vs_done', $this->created_expired_vs_done($iniDate, $endDate));
        
        $this->request->data['DateRange']['date_ini'] = date('d-m-Y', strtotime($iniDate));
        $this->request->data['DateRange']['date_end'] = date('d-m-Y', strtotime($endDate)); 
    }
    public function created_expired_vs_done($iniDate, $endDate) {
        
        $queryExpired = "Select year(travels.created) as year, month(travels.created) as month, travels.created as date,
            count(distinct travels.id) as travels_expired_count

            FROM travels

            INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'

            WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        $queryDone = "Select year(travels.created) as year, month(travels.created) as month, travels.created as date,
            count( distinct travels.id) as travels_done_count

            FROM travels

            INNER JOIN users ON travels.user_id = users.id AND users.role != 'admin' AND users.role != 'tester'

            INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id

            INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND (travels_conversations_meta.state = 'D' OR travels_conversations_meta.state = 'P')

            WHERE travels.date BETWEEN '$iniDate' AND '$endDate'

            GROUP BY year, month";
        
        
        $fixedTravels = array();
        $months = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
        
        
        $travelsExpired = $this->Travel->query($queryExpired);
        foreach ($travelsExpired as $value) {
            
            $appended = false;
            foreach ($fixedTravels as &$t) {
                if($value[0]['year'] == $t['year'] && $months[$value[0]['month'] - 1] == $t['month']) {
                    $t['travels_expired_count'] = $value[0]['travels_expired_count'];
                    $appended = true;
                    break;
                }
            }
            if(!$appended) {
                $fixedTravels[] = array();
                $entries = count($fixedTravels);
                $fixedTravels[$entries - 1]['date'] = $value['travels']['date'];
                $fixedTravels[$entries - 1]['travels_expired_count'] = $value[0]['travels_expired_count'];
                $fixedTravels[$entries - 1]['year'] = $value[0]['year'];
                $fixedTravels[$entries - 1]['month'] = $months[$value[0]['month'] - 1];
            }
        }
        
        
        $travelsDone = $this->Travel->query($queryDone);        
        foreach ($travelsDone as $value) {
            
            $appended = false;
            foreach ($fixedTravels as &$t) {
                if($value[0]['year'] == $t['year'] && $months[$value[0]['month'] - 1] == $t['month']) {
                    $t['travels_done_count'] = $value[0]['travels_done_count'];
                    $appended = true;
                    break;
                }
            }
            if(!$appended) {
                $fixedTravels[] = array();
                $entries = count($fixedTravels);
                $fixedTravels[$entries - 1]['date'] = $value['travels']['date'];
                $fixedTravels[$entries - 1]['travels_done_count'] = $value[0]['travels_done_count'];
                $fixedTravels[$entries - 1]['year'] = $value[0]['year'];
                $fixedTravels[$entries - 1]['month'] = $months[$value[0]['month'] - 1];
            }
        }
        
        return $fixedTravels;
    }
    
    
    
    
    
    
}

?>