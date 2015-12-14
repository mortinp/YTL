<?php

App::uses('Component', 'Controller');

class QueriesComponent extends Component {
    
    /*public function __construct() {
        $this->DriverTrave = ClassRegistry::init('Locality');
    }*/
    
    
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
    public function getConversationsSummary($date/*yyyy-mm-dd*/) {
        $query = "SELECT Travel.id, Travel.origin, Travel.destination, DriverTravel.id AS conversation, User.username, Driver.username, DriverProfile.driver_name,

                SUM( CASE WHEN DriverTravelerConversation.response_by = 'driver' THEN 1 ELSE 0 END) as driver_responses_count,
                SUM( CASE WHEN DriverTravelerConversation.response_by = 'traveler' THEN 1 ELSE 0 END) as traveler_responses_count

                FROM travels as Travel

                INNER JOIN drivers_travels as DriverTravel 
                ON Travel.id = DriverTravel.travel_id AND Travel.created = '$date'

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
        
        return $this->query($query);
    }
    
}
?>
