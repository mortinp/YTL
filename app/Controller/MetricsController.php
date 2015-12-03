<?php

App::uses('AppController', 'Controller');

class MetricsController extends AppController {
    
    public $uses = array('Travel');
    
    public function dashboard() {
        $today = date('Y-m-d', strtotime('today')); 
                
        /**
         * RESUMEN DE CONVERSACIONES DE CHOFERES Y VIAJEROS
         * ESTO DA VIAJE POR VIAJE, CUANTOS MENSAJES DEL CHOFER Y DEL VIAJERO HAY POR CADA CONVERSACION DEL VIAJE
         * EJ:
         * 
         * VIAJE 130 | HABANA | TRINDAD | CONVERSACION A | CHOFER LOIS   | VIAJERO X | RESPUESTAS CHOFER: 2 | RESPUESTAS VIAJERO: 1
         * VIAJE 130 | HABANA | TRINDAD | CONVERSACION B | CHOFER OVIDIO | VIAJERO X | RESPUESTAS CHOFER: 1 | RESPUESTAS VIAJERO: 0
         * 
         * VIAJE 135 | HABANA | TRINDAD | CONVERSACION A | CHOFER JOSUE  | VIAJERO X | RESPUESTAS CHOFER: 2 | RESPUESTAS VIAJERO: 0
         * VIAJE 135 | HABANA | TRINDAD | CONVERSACION B | CHOFER FELIPE | VIAJERO X | RESPUESTAS CHOFER: 1 | RESPUESTAS VIAJERO: 0
         * VIAJE 135 | HABANA | TRINDAD | CONVERSACION C | CHOFER LUIS   | VIAJERO X | RESPUESTAS CHOFER: 0 | RESPUESTAS VIAJERO: 0
         * 
         * CONCLUSIONES QUE SE PUEDEN SACAR CON EL RESULTADO DE ESTA CONSULTA
         * 
         * - EL VIAJE 130 FUE RESPONDIDO POR SOLO 1 CHOFER
         * - EL VIAJE 13O FUE RESPONDIDO POR EL VIAJERO
         * 
         * - EL VIAJE 135 FUE RESPONDIDO POR 2 CHOFERES
         * - EL VIAJE 135 NO HA SIDO RESPONDIDO POR EL VIAJERO!!!
         * 
         */
        /*$daysBack3 = date('Y-m-d', strtotime("$endDate - 3 days")); // ver viajes de hace 3 dias    
        $query = "SELECT Travel.id, Travel.origin, Travel.destination, DriverTravel.id AS conversation, User.username, Driver.username, DriverProfile.driver_name,

                SUM( CASE WHEN DriverTravelerConversation.response_by = 'driver' THEN 1 ELSE 0 END) as driver_responses_count,
                SUM( CASE WHEN DriverTravelerConversation.response_by = 'traveler' THEN 1 ELSE 0 END) as traveler_responses_count

                FROM travels as Travel

                INNER JOIN drivers_travels as DriverTravel 
                ON Travel.id = DriverTravel.travel_id AND Travel.created = '$daysBack3'

                LEFT JOIN driver_traveler_conversations as DriverTravelerConversation
                ON DriverTravelerConversation.conversation_id = DriverTravel.id

                INNER JOIN users User 
                ON User.id = Travel.user_id

                INNER JOIN drivers Driver
                ON Driver.id = DriverTravel.driver_id

                LEFT JOIN drivers_profiles DriverProfile
                ON Driver.id = DriverProfile.driver_id

                GROUP BY DriverTravel.id
                ORDER BY Travel.id";
        $this->set('summary', $this->Travel->query($query));*/
        
        
        $endDate = $today;
        $iniDate = date('Y-m-d', strtotime("$endDate - 6 months"));
        if(!empty ($this->request->query)) {
            $strIniDate = $this->request->query['date_ini'];
            $strEndDate = $this->request->query['date_end'];
            
            //WARNING: Estoy asumiendo que las fechas vienen en formato dd-mm-yyyy
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
                
                WHERE Travel.created BETWEEN '$iniDate' AND '$endDate' AND Travel.date < '$endDate'

                GROUP BY DriverTravel.id

                ORDER BY Travel.id";
        
        $this->set('conversations', $this->Travel->query($query));
        
        
        $this->request->data['DateRange']['date_ini'] = date('d-m-Y', strtotime($iniDate));
        $this->request->data['DateRange']['date_end'] = date('d-m-Y', strtotime($endDate));        
    }
}

?>