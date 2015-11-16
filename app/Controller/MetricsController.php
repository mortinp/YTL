<?php

App::uses('AppController', 'Controller');

class MetricsController extends AppController {
    
    public $uses = array('Travel');
    
    public function dashboard() {
        /*// VIAJES SIN RESPUESTAS DE LOS CHOFERES
        $query = "SELECT Travel.id, Travel.origin, Travel.destination, DriverTravel.id AS conversation

                FROM travels as Travel

                INNER JOIN drivers_travels as DriverTravel ON Travel.id = DriverTravel.travel_id

                WHERE DriverTravel.id NOT IN 
                (SELECT conversation_id FROM driver_traveler_conversations WHERE created > Travel.created)";
        
        $this->set('not_responded', $this->Travel->query($query));*/
        
        
        $endDate = date('Y-m-d', strtotime('today'));
        $iniDate = date('Y-m-d', strtotime("$endDate - 6 months"));
        if(!empty ($this->request->query)) {
            $strIniDate = $this->request->query['date_ini'];
            $strEndDate = $this->request->query['date_end'];
            
            //CAREFUL: Estoy asumiendo que las fechas vienen en formato dd-mm-yyyy
            $iniDate = substr($strIniDate,6,4).'-'.substr($strIniDate,3,2).'-'.substr($strIniDate,0,2);
            $endDate = substr($strEndDate,6,4).'-'.substr($strEndDate,3,2).'-'.substr($strEndDate,0,2);
        } 
        
        
        
        $query = "SELECT Travel.id, Travel.origin, Travel.destination, Travel.created, DriverTravel.id as conversation_id,

                sum( case when DriverTravelerConversation.response_by = 'driver' then 1 else 0 end) as driver_responses_count,

                sum( case when DriverTravelerConversation.response_by = 'traveler' then 1 else 0 end) as traveler_responses_count,

                TravelConversationMeta.state, TravelConversationMeta.income

                FROM travels as Travel

                INNER JOIN drivers_travels as DriverTravel ON Travel.id = DriverTravel.travel_id

                INNER JOIN driver_traveler_conversations AS DriverTravelerConversation ON DriverTravel.id = DriverTravelerConversation.conversation_id

                LEFT JOIN travels_conversations_meta as TravelConversationMeta ON DriverTravel.id = TravelConversationMeta.conversation_id
                
                WHERE Travel.created BETWEEN '$iniDate' AND '$endDate'

                GROUP BY DriverTravel.id

                ORDER BY Travel.id";
        
        $this->set('conversations', $this->Travel->query($query));
        
        $this->request->data['DateRange']['date_ini'] = date('d-m-Y', strtotime($iniDate));
        $this->request->data['DateRange']['date_end'] = date('d-m-Y', strtotime($endDate));
        
    }
}

?>