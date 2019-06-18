<?php

App::uses('AppController', 'Controller');
App::uses('MessagesUtil', 'Util');

class ApiConversationsController extends AppController {
    public $components = array('RequestHandler');
    
    public $uses = array('DriverTravel', 'ApiSync.SyncObject');
    
    public function beforeFilter() {
        $this->Auth->allow('sync', 'newMessagesInConversation', 'newMessageToTraveler');
    }
    
    private function getConversationsToSync($conversationId = null) {
        // TODO: $this->Auth->identify()... esta identificacion debe ser con la tabla drivers!!
        $user = array('id' => 145 /*Lenier*/);
        
        
        // Buscar las conversaciones asociadas a los mensajes que vamos a sincronizar
        $idCondition = "";
        if($conversationId != null) $idCondition = "AND drivers_travels.id = '".$conversationId."'";
        $sql = "SELECT
                    api_sync_queue_2driver_conversations.msg_id,
                    driver_traveler_conversations.response_text,
                    driver_traveler_conversations.created as msg_created,
                    driver_traveler_conversations.attachments_ids,
                    drivers_travels.id as conversation_id,
                    drivers_travels.identifier,
                    drivers_travels.notification_type,
                    drivers_travels.travel_date,
                    drivers_travels.created, 
                    drivers_travels.travel_id, 
                    travels.origin, 
                    travels.destination, 
                    travels.people_count as pax, 
                    travels.details,
                    travels.created as travel_created
                    FROM api_sync_queue_2driver_conversations
                    INNER JOIN drivers_travels ON api_sync_queue_2driver_conversations.conversation_id = drivers_travels.id
                    LEFT JOIN driver_traveler_conversations ON api_sync_queue_2driver_conversations.msg_id = driver_traveler_conversations.id
                    LEFT JOIN travels ON drivers_travels.travel_id = travels.id
                    WHERE 
                        drivers_travels.driver_id = ".$user['id']."
                        AND api_sync_queue_2driver_conversations.sync_date IS NULL 
                        ".$idCondition."
                    ORDER BY conversation_id";
        
        $conversationsToSync = $this->DriverTravel->query($sql);
        
        // Armar las conversaciones
        $conversations = array();
        for ($index = 0; $index < count($conversationsToSync);) {
            
            // Coger la conversacion actual
            $current_convId = $conversationsToSync[$index]['drivers_travels']['conversation_id'];
            
            // Primero crear la travel_request si existe
            $travelRequest = null;
            if($conversationsToSync[$index]['drivers_travels']['travel_id'] != null) {
                $travelRequest = array(
                    'id'=>$conversationsToSync[$index]['drivers_travels']['travel_id'],
                    'origin'=>$conversationsToSync[$index]['travels']['origin'],
                    'destination'=>$conversationsToSync[$index]['travels']['destination'],
                    'pax'=>$conversationsToSync[$index]['travels']['pax'],
                    'details'=>$conversationsToSync[$index]['travels']['details'],
                    'date'=>1000*strtotime($conversationsToSync[$index]['drivers_travels']['travel_date']),
                    'created'=>1000*strtotime($conversationsToSync[$index]['travels']['travel_created']),
                );
            }
            
            // Crear la conversacion con los mensajes listos para adicionar
            $conversations[] = array(
                'id'=>$conversationsToSync[$index]['drivers_travels']['conversation_id'],
                'code'=> DriverTravel::getIdentifier($conversationsToSync[$index]['drivers_travels']),
                'travel_date'=>1000*strtotime($conversationsToSync[$index]['drivers_travels']['travel_date']),
                'created'=>1000*strtotime($conversationsToSync[$index]['drivers_travels']['created']),
                
                'travel_request' => $travelRequest,
                
                'messages'=>array()
            );
            
            // Adicionar los mensajes a la conversacion
            while($index < count($conversationsToSync) && $conversationsToSync[$index]['drivers_travels']['conversation_id'] == $current_convId) {
                
                $isMessagePresent = $conversationsToSync[$index]['api_sync_queue_2driver_conversations']['msg_id'] != null;                
                if($isMessagePresent) {
                    // Coger media
                    $media = array();
                    $hasMedia = $conversationsToSync[$index]['driver_traveler_conversations']['attachments_ids'] != null && $conversationsToSync[$index]['driver_traveler_conversations']['attachments_ids'] != '';
                    if($hasMedia) {
                        $attachModel = ClassRegistry::init('EmailQueue.EmailAttachment');
                        $atts = $attachModel->getAttachments($conversationsToSync[$index]['driver_traveler_conversations']['attachments_ids']);

                        $media = array('url'=>$atts[0]['url']);
                    }

                    // Adicionar mensaje
                    $conversations[count($conversations) - 1]['messages'][] = 
                            array(
                                'id'=>$conversationsToSync[$index]['api_sync_queue_2driver_conversations']['msg_id'], 
                                'message'=>$conversationsToSync[$index]['driver_traveler_conversations']['response_text'],
                                'created'=>1000*strtotime($conversationsToSync[$index]['driver_traveler_conversations']['msg_created']),
                                'media'=>$media,
                                //'hasMedia'=>$hasMedia
                                );
                }
                
                $index++;
            }
        }
        
        return $conversations;
    }
    
    private function markConversationsAsSynced($conversations) {
        // Marcar como sincronizados
        $SyncTable = ClassRegistry::init('ApiSync.SyncObject');
        $SyncTable->useTable = 'api_sync_queue_2driver_conversations';
        
        $synced = array();
        foreach ($conversations as $c) {
            
            // Buscar todas las entradas en la cola de sincronizacion con el id de esta conversacion
            $syncedEntries = $SyncTable->find('all', 
                    array('conditions'=>array(
                            'conversation_id'=>$c['id'])));
            
            // Actualizar todas las entradas
            foreach($syncedEntries as $entry) {
                $entry['SyncObject']['sync_date'] = gmdate('Y-m-d H:i:s');
                $SyncTable->save($entry);
                $synced[] = $entry;
            }
        }
        
        return $synced;
    }
    
    /*
     * EJEMPLO DE RESPUESTA
     * 
     * $sync = array(
            
            // NEW REQUEST
            array(
                'id'=>'5ce80e4b-6780-4916-b6b2-1a94c0a80165', 
                'code'=>"7545",
                'travel_date'=>6545645645435,
                'created'=>9756757,
                
                'travel_request' => array(
                    'id'=>19345,
                    'origin'=>'La Habana',
                    'destination'=>'Santiago de Cuba',
                    'pax'=>3,
                    'details'=>'Holaaaaaa!!!!',
                    'date'=>654564564,
                    'created'=>9756757,                    
                ),
                
                'messages'=> array(
                    
                )
            ),
            
            // OLD REQUEST, 2 NEW MESSAGES
            array(
                'id'=>'5cecb99f-1234-4db6-8a01-142410d2655b',
                'code'=>"19345",
                'travel_date'=>6545645646574,
                'created'=>867586797898,
                
                'travel_request' => array(
                    'id'=>19345,
                    'origin'=>'La Habana',
                    'destination'=>'Managua',
                    'pax'=>3,
                    'details'=>'Otra!!!!',
                    'date'=>65465465,
                    'created'=>9756757,
                ),
                
                'messages'=> array(
                    array('id' => 1, 'order' => 2, 'message' => 'Msg1', 'created' => 34656656, 'media'=>array()),
                    array('id' => 2, 'order' => 3, 'message' => 'Msg2', 'created' => 656765765, 'media'=>array('url'=>'http://192.168.1.102/yotellevo/files/20190204_150453_jpg')),
                    array('id' => 3, 'order' => 4, 'message' => 'Msg3', 'created' => 656765767, 'media'=>array('url'=>'http://192.168.1.102/yotellevo/files/cookbook_pdf')),
                    array('id' => 4, 'order' => 5, 'message' => 'Msg2', 'created' => 656765765, 'media'=>array('url'=>'http://192.168.1.102/yotellevo/files/lua_jpg')),
                )
            ),
            
            // NEW DIRECT MESSAGE + 1 MORE MESSAGE
            array(
                'id'=>'5cecb99f-2ce0-4db6-8a01-142410d2655b',
                'code'=>"D172",
                'travel_date'=>654564564722256,
                'created'=>867586797898,
                
                'travel_request' => null,
                
                'messages'=> array(
                    array('id' => 3, 'order' => 1, 'message' => 'Msg1', 'created' => 34656656),
                    array('id' => 4, 'order' => 2, 'message' => 'Msg2', 'created' => 656765),
                    array('id' => 5, 'order' => 3, 'message' => 'Msg2', 'created' => 656765765, 'media'=>array('url'=>'http://192.168.1.102/yotellevo/files/lua_jpg')),
                )
            ),
        );
     */
    public function sync() {
        $conversations = $this->getConversationsToSync();
        
        $synced = $this->markConversationsAsSynced($conversations);
        
        // RESPUESTA
        $this->set(array(
            'success' => true,
            'data' => $conversations,
            'synced' =>$synced,
            '_serialize' => array('success', 'data', 'synced')
        ));
    }
    
    /*
     * EJEMPLO DE RESPUESTA
     * 
     * $new = array(
            array(
                'id'=>$conversationId,
                'code'=>"D172",
                'travel_date'=>654564564722256,
                'created'=>867586797898,
                
                'travel_request' => null,
                
                'messages'=> array(
                    array('id' => 5, 'order' => 3, 'message' => 'XXX', 'created' => 134656656, 'media'=>array('url'=>'https://www.portal.nauta.cu/data/files/BOLETIN_H-B_Final.pdf')),
                    array('id' => 6, 'order' => 4, 'message' => 'YYY', 'created' => 134656656, 'media'=>array('url'=>'http://192.168.1.102/yotellevo/files/20190204_150453_jpg')),
                )
            ),
        );
     */    
    public function newMessagesInConversation($conversationId) {
        $conversations = $this->getConversationsToSync($conversationId);
        
        $synced = $this->markConversationsAsSynced($conversations);
        
        $conv = null;
        if(!empty($conversations)) $conv = $conversations[0]; // Aqui siempre va a venir una sola conversacion
        
        $this->set(array(
            'success' => true,
            'data' => $conv,
            'synced'=>$synced,
            '_serialize' => array('success', 'data', 'synced')
        ));
    }
    
    public function newMessageToTraveler($conversationId) {
        //$mu = new MessagesUtil();
        //$mu->sendMessage('driver', $conversationId, null, $this->request->data['message'], $this->request->data['media']);
        
        CakeLog::write('api', print_r($this->request->data, true));
        
        $this->set(array(
            'success' => true,
            'data' => true,
            '_serialize' => array('success', 'data')
        ));
    }
    
}

?>