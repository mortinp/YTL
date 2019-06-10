<?php

App::uses('AppController', 'Controller');

class ApiConversationsController extends AppController {
    public $components = array('RequestHandler');
    
    public function beforeFilter() {
        $this->Auth->allow('sync'); 
    }
    
    public function sync() {
        
        $user = array('id' => 139 /*Lenier*/);
        
        $sync = array(
            
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
                    array('id' => 2, 'order' => 3, 'message' => 'Msg2', 'created' => 656765765, 'media'=>array('url'=>'http://192.168.1.104/yotellevo/files/20190204_150453_jpg')),
                    array('id' => 3, 'order' => 4, 'message' => 'Msg3', 'created' => 656765767, 'media'=>array('url'=>'http://192.168.1.104/yotellevo/files/cookbook_pdf')),
                    array('id' => 4, 'order' => 5, 'message' => 'Msg2', 'created' => 656765765, 'media'=>array('url'=>'http://192.168.1.104/yotellevo/files/lua_jpg')),
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
                    array('id' => 5, 'order' => 3, 'message' => 'Msg2', 'created' => 656765765, 'media'=>array('url'=>'http://192.168.1.104/yotellevo/files/lua_jpg')),
                )
            ),
        );
        
        $this->set(array(
            'success' => true,
            'data' => $sync,
            '_serialize' => array('success', 'data')
        ));
    }
    
    public function newMessagesInConversation($conversationId) {
        $new = array(
            array(
                'id'=>$conversationId,
                'code'=>"D172",
                'travel_date'=>654564564722256,
                'created'=>867586797898,
                
                'travel_request' => null,
                
                'messages'=> array(
                    array('id' => 5, 'order' => 3, 'message' => 'Msg3', 'created' => 134656656, 'media'=>array()),
                    array('id' => 6, 'order' => 4, 'message' => 'Msg4', 'created' => 1656765, 'media'=>array('url'=>'http://192.168.1.104/yotellevo/files/20190204_150453_jpg')),
                )
            ),
        );
        
        $this->set(array(
            'success' => true,
            'data' => $new,
            '_serialize' => array('success', 'data')
        ));
    }
    
}

?>