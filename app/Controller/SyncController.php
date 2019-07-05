<?php

App::uses('AppController', 'Controller');

class SyncController extends AppController {
    
    public $components = array('Paginator');
    
    public function queue() {
        
        $SyncTable = ClassRegistry::init('ApiSync.SyncObject');
        $SyncTable->useTable = 'api_sync_queue_2driver_conversations';
        
        // Coger datos que hacen falta en la vista
        $SyncTable->bindModel(
            array('belongsTo' => array(
                    'DriverTravel'=>array('foreignKey'=>'conversation_id')
                )
            )
        );
        
        $this->paginate = array('order'=>array('SyncObject.id'=>'DESC'), 'limit'=>100);
        $this->Paginator->settings = $this->paginate;
        
        $this->set('queue', $this->Paginator->paginate($SyncTable));
    }
}

?>