<?php
App::uses('ApiAppController', 'Controller');
App::uses('MessagesUtil', 'Util');

class ApiConversationsController extends ApiAppController {
    
    public $uses = array('DriverTravel', 'ApiSync.SyncObject');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('iniFetch', 'sync', 'newMessagesInConversation', 'newMessageToTraveler');
    }
    
    public function iniFetch() {
        $conversations = $this->getConversationsIniFetch();
        
        $synced = $this->markConversationsAsSynced($conversations, -1);
        
        // RESPUESTA
        $this->set(array(
            'success' => true,
            'data' => $conversations,
            'synced' =>$synced,
            '_serialize' => array('success', 'data', 'synced')
        ));
    }
    private function getConversationsIniFetch() {
        
        $user = $this->getUser();
        
        // Buscar las conversaciones asociadas a los mensajes que vamos a sincronizar
        $today = date('Y-m-d', strtotime('today'));
        $sql = $this->getSqlSelectFieldsForConversation()
            . " FROM drivers_travels
                
                INNER JOIN travels_conversations_meta
                ON travels_conversations_meta.conversation_id = drivers_travels.id
                AND travels_conversations_meta.following = true
                AND drivers_travels.travel_date > '".$today."'"

            . " LEFT JOIN driver_traveler_conversations ON driver_traveler_conversations.conversation_id = drivers_travels.id
                
                LEFT JOIN travels ON drivers_travels.travel_id = travels.id
                
                WHERE
                    drivers_travels.driver_id = ".$user['id']."
                        
                ORDER BY conversation_id";
        
        $conversationsToSync = $this->DriverTravel->query($sql);
        
        return $this->buildConversations($conversationsToSync);
    }
    
    /*public function conversationsDaysAgo($numberOfDaysAgo) {
        $conversations = $this->getConversationsDaysAgo($numberOfDaysAgo);
        
        $synced = $this->markConversationsAsSynced($conversations);
        
        // RESPUESTA
        $this->set(array(
            'success' => true,
            'data' => $conversations,
            'synced' =>$synced,
            '_serialize' => array('success', 'data', 'synced')
        ));
    }
    private function getConversationsDaysAgo($numberOfDaysAgo) {
        
        $user = $this->getUser();
        
        // Buscar las conversaciones asociadas a los mensajes que vamos a sincronizar
        if($numberOfDaysAgo == 0) $date = date('Y-m-d', strtotime('today'));
        else $date = date('Y-m-d', strtotime($numberOfDaysAgo.' days ago'));
        
        $sql = $this->getSqlSelectFieldsForConversation()
            . " FROM drivers_travels
                
                INNER JOIN travels_conversations_meta
                ON travels_conversations_meta.conversation_id = drivers_travels.id
                AND travels_conversations_meta.following = true
                AND drivers_travels.travel_date >= '".$date."'"

            . " LEFT JOIN driver_traveler_conversations ON driver_traveler_conversations.conversation_id = drivers_travels.id
                
                LEFT JOIN travels ON drivers_travels.travel_id = travels.id
                
                WHERE
                    drivers_travels.driver_id = ".$user['id']."
                        
                ORDER BY conversation_id";
        
        $conversationsToSync = $this->DriverTravel->query($sql);
        
        return $this->buildConversations($conversationsToSync);
    }*/
    
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
    public function sync($batchId) {
        $conversations = $this->getConversationsToSync($batchId);
        
        // Hack: Quitar campo estado (aqui en el sync no hace falta)
        foreach ($conversations as &$value) {
            unset($value['state']);
        }
        
        $synced = $this->markConversationsAsSynced($conversations, $batchId);
        
        // RESPUESTA
        $this->set(array(
            'success' => true,
            'synced_count' =>count($synced),
            'data' => $conversations,
            'synced' =>$synced,
            '_serialize' => array('success','synced_count', 'data', 'synced')
        ));
    }
    private function getConversationsToSync($batchId, $conversationId = null) {
        $user = $this->getUser();
        
        // Buscar las conversaciones asociadas a los mensajes que vamos a sincronizar
        $idCondition = "";
        if($conversationId != null) $idCondition = "AND drivers_travels.id = '".$conversationId."'";
        $sql = $this->getSqlSelectFieldsForConversation()
            . " FROM api_sync_queue_2driver_conversations
                INNER JOIN drivers_travels ON api_sync_queue_2driver_conversations.conversation_id = drivers_travels.id
                LEFT JOIN driver_traveler_conversations ON api_sync_queue_2driver_conversations.msg_id = driver_traveler_conversations.id
                LEFT JOIN travels ON drivers_travels.travel_id = travels.id
                LEFT JOIN travels_conversations_meta ON travels_conversations_meta.conversation_id = drivers_travels.id
                WHERE 
                    drivers_travels.driver_id = ".$user['id']."
                    
                    AND (
                        api_sync_queue_2driver_conversations.batch_id = ".$batchId."
                        OR
                        (
                            api_sync_queue_2driver_conversations.batch_id IS NULL 
                            AND 
                            api_sync_queue_2driver_conversations.sync_date IS NULL 
                        )                        
                    )
                    
                    ".$idCondition."
                ORDER BY conversation_id";
        
        $conversationsToSync = $this->DriverTravel->query($sql);
        
        return $this->buildConversations($conversationsToSync);
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
    public function newMessagesInConversation($conversationId, $batchId) {
        
        $conversations = $this->getConversationsToSync($batchId, $conversationId);
        
        $synced = $this->markConversationsAsSynced($conversations, $batchId);
        
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
        
        if(!$this->request->is('post')) throw new MethodNotAllowedException();
        
        $user = $this->getUser();
        // TODO: Verificar que la conversacion sea del chofer
        
        $attachments = array();
        if(isset($_FILES['file']['name'])) {
            $adjunto = $_FILES['file'];
        
            if($adjunto['name'] != '')
                $attachments = array($adjunto['name'] => array('contents' => file_get_contents($adjunto['tmp_name']), 'mimetype' => $adjunto['type']));
        }
        
        $mu = new MessagesUtil();
        $mu->sendMessage('driver', $conversationId, null, $this->request->data['message'], $attachments, 'APP');
        
        //CakeLog::write('api', print_r($this->request->data, true));
        
        $this->set(array(
            'success' => true,
            'data' => true,
            '_serialize' => array('success', 'data')
        ));
    }    
    
    /*
     * Retorna la sentencia SQL que selecciona los campos indispensables para construir las conversaciones con buildConversations()
     */
    private function getSqlSelectFieldsForConversation() {
        return "SELECT
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
                    travels.created as travel_created,
                    driver_traveler_conversations.id as msg_id,
                    driver_traveler_conversations.response_text,
                    driver_traveler_conversations.created as msg_created,
                    driver_traveler_conversations.response_by,
                    driver_traveler_conversations.attachments_ids,
                    travels_conversations_meta.state,
                    travels_conversations_meta.following";
    }
    
    /*
     * @param $conversationsToBuild: Un arreglo con datos que se ajustan a lo que devuelve getSqlSelectFieldsForConversation()
     */
    private function buildConversations($conversationsToBuild) {
        // Armar las conversaciones
        $conversations = array();
        for ($index = 0; $index < count($conversationsToBuild);) {
            
            $c = $conversationsToBuild[$index];
            
            // Primero crear la travel_request si existe
            $travelRequest = null;
            if($c['drivers_travels']['travel_id'] != null) {
                $travelRequest = array(
                    'id'=>$c['drivers_travels']['travel_id'],
                    'origin'=>$c['travels']['origin'],
                    'destination'=>$c['travels']['destination'],
                    'pax'=>$c['travels']['pax'],
                    'details'=>$c['travels']['details'],
                    'date'=>1000*strtotime($c['drivers_travels']['travel_date']),
                    'created'=>1000*strtotime($c['travels']['travel_created']),
                );
            }
            
            // Crear la conversacion con los mensajes listos para adicionar
            $conversations[] = array(
                'id'=>$c['drivers_travels']['conversation_id'],
                'code'=> DriverTravel::getIdentifier($c['drivers_travels']),
                'travel_date'=>1000*strtotime($c['drivers_travels']['travel_date']),
                'created'=>1000*strtotime($c['drivers_travels']['created']),
                'state'=>self::calculateState($c['travels_conversations_meta']),
                
                'travel_request' => $travelRequest,
                
                'messages'=>array()
            );
            
            // Adicionar los mensajes a la conversacion
            $current_convId = $c['drivers_travels']['conversation_id'];
            $i = $index;
            while($i < count($conversationsToBuild) && $conversationsToBuild[$i]['drivers_travels']['conversation_id'] == $current_convId) {
                
                $isMessagePresent = $conversationsToBuild[$i]['driver_traveler_conversations']['msg_id'] != null;                
                if($isMessagePresent) {
                    // Coger media
                    $media = array();
                    $hasMedia = $conversationsToBuild[$i]['driver_traveler_conversations']['attachments_ids'] != null && $conversationsToBuild[$i]['driver_traveler_conversations']['attachments_ids'] != '';
                    if($hasMedia) {
                        $attachModel = ClassRegistry::init('EmailQueue.EmailAttachment');
                        $atts = $attachModel->getAttachments($conversationsToBuild[$i]['driver_traveler_conversations']['attachments_ids']);

                        $media = array('url'=>$atts[0]['url']);
                    }

                    // Adicionar mensaje
                    $conversations[count($conversations) - 1]['messages'][] = 
                            array(
                                'id'=>$conversationsToBuild[$i]['driver_traveler_conversations']['msg_id'], 
                                'message'=>$conversationsToBuild[$i]['driver_traveler_conversations']['response_text'],
                                'created'=>1000*strtotime($conversationsToBuild[$i]['driver_traveler_conversations']['msg_created']),
                                'sent_by_driver'=>$conversationsToBuild[$i]['driver_traveler_conversations']['response_by'] == 'driver'?true:false,
                                'media'=>$media
                                );
                }
                
                $i++;
            }
            
            $index = $i;
        }
        
        return $conversations;
    }
    
    /*
     * Convierte el estado de la conversacion a un número compatible con la app móvil, según el siguiente enum:
     * UNCLASSIFIED: 0
     * FOLLOWING: 1
     * SCHEDULED: 2
     * REJECTED: 3
     * CANCELLED: 4
     * COMPLETED: 5
     * 
     */
    private static function calculateState($meta) {
        if($meta['following']) return 2;
        
        // TODO: Otros estados
        
        return 0;
    }
    
    private function markConversationsAsSynced($conversations, $batchId = null) {
        $SyncTable = ClassRegistry::init('ApiSync.SyncObject');
        $SyncTable->useTable = 'api_sync_queue_2driver_conversations';
        
        // Marcar como sincronizados
        $synced = array();
        foreach ($conversations as $c) {
            
            // Buscar todas las entradas en la cola de sincronizacion con el id de esta conversacion
            $syncedEntries = $SyncTable->find('all', 
                    array('conditions'=>array(
                            'conversation_id'=>$c['id'],
                            '(batch_id = '.$batchId.'
                                OR
                                (
                                    batch_id IS NULL 
                                    AND 
                                    sync_date IS NULL
                                )
                            )',
                    )));
            
            // Actualizar todas las entradas
            foreach($syncedEntries as $entry) {
                $entry['SyncObject']['sync_date'] = gmdate('Y-m-d H:i:s');
                $entry['SyncObject']['batch_id'] = $batchId;
                $entry['SyncObject']['batch_id_retry_count'] = $entry['SyncObject']['batch_id_retry_count'] + 1;
                $SyncTable->save($entry);
                $synced[] = $entry;
            }
        }
        
        return $synced;
    }
    
}

?>