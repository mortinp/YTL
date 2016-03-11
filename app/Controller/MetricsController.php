<?php

App::uses('AppController', 'Controller');

class MetricsController extends AppController {
    
    public $uses = array('Travel');
    
    public function dashboard() {
        $today = date('Y-m-d', strtotime('today'));
        $endDate = $today;
        $iniDate = date('Y-m-d', strtotime("$endDate - 6 months"));
        if(!empty ($this->request->query)) {
            $strIniDate = $this->request->query['date_ini'];
            $strEndDate = $this->request->query['date_end'];
            
            //WARNING: Estoy asumiendo que las fechas vienen en formato dd-mm-yyyy
            $iniDate = substr($strIniDate,6,4).'-'.substr($strIniDate,3,2).'-'.substr($strIniDate,0,2);
            $endDate = substr($strEndDate,6,4).'-'.substr($strEndDate,3,2).'-'.substr($strEndDate,0,2);
        }        
        
        $this->set('conversations', $this->conversationsRespondedByDrivers($iniDate, $endDate));
        $this->set('incomes', $this->incomes($iniDate, $endDate));        
        
        $this->request->data['DateRange']['date_ini'] = date('d-m-Y', strtotime($iniDate));
        $this->request->data['DateRange']['date_end'] = date('d-m-Y', strtotime($endDate));        
    }
    
    private function conversationsRespondedByDrivers($iniDate, $endDate) {
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
    }
    
    public function incomes($iniDate, $endDate) {
        $query = "Select year(travels.date) as year, month(travels.date) as month, travels.date as date, sum(travels_conversations_meta.income) as income, sum(travels_conversations_meta.income_saving) as income_saving

                FROM travels
        
                INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id

                INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id AND travels_conversations_meta.income IS NOT NULL

                WHERE travels.date < '$endDate'

                GROUP BY year(travels.date), month(travels.date)";
        
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
    
}

?>