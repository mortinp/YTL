<?php
App::uses('AppController', 'Controller');
App::uses('StringsUtil', 'Util');
App::uses('EmailsUtil', 'Util');
App::uses('Travel', 'Model');

class DataCleanerController extends AppController {
    
    public $uses = array('DataCleaner.ArchiveDriversTravels', 'DataCleaner.ArchiveDriverTravelerConversations','DataCleaner.ArchiveTravelsConversationsMeta','DriverTravel','Driver','DriverTravelerConversation','TravelConversationMeta');
    
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('backup');
    }
    
//    public function index() {
//       
//    }
    
    public function backup(){
        
        /*STEPS FOR BACKUP DATA

         * 1 - Select all REQUIRED info from original database (Info related to travels)
         * 2- Save it into the backup database
         * 3- Delete it from original database
        */
        $this->Driver->unbindModel(array('hasAndBelongsToMany'=>array('Locality')));
        $this->DriverTravel->unbindModel(array('belongsTo'=>array('Travel'))); 
        $this->DriverTravel->bindModel(array('hasMany'=>array('DriverTravelerConversation'=>array('className'=>'DriverTravelerConversation','foreignKey'=>'conversation_id'))));
        $six_months_ago = date('Y-m-d', strtotime("today - 6 month"));
        $this->DriverTravel->recursive=4;
        
        
        $result = $this->DriverTravel->find('all',array('conditions'=>array('DriverTravel.travel_date <='=>$six_months_ago,
            'DriverTravel.message_count <='=> 1 ),
            'joins' =>array(
                array('table' => 'travels_conversations_meta',
                'alias' => 'ITravelConversationMeta',
                'type' => 'LEFT',
                'conditions' => array(
                'ITravelConversationMeta.conversation_id = DriverTravel.id','ITravelConversationMeta.following = 0', array(
                    "NOT" => array(
                    "ITravelConversationMeta.state" => array('D','P')
                     )
                    )
                )
                ),
                array('table' => 'driver_traveler_conversations',
                'alias' => 'IDriverTravelerConversation',
                'type' => 'LEFT',
                'conditions' => array(
                'IDriverTravelerConversation.conversation_id = DriverTravel.id'
                )
                )            
            ),
            'limit'=>7
            ));
        
        
//        $query = "SELECT drivers_travels.id, drivers_travels.travel_date as date
//
//                FROM drivers_travels
//
//                LEFT JOIN  travels_conversations_meta ON travels_conversations_meta.conversation_id = drivers_travels.id AND travels_conversations_meta.following = 0
//                
//                LEFT JOIN  driver_traveler_conversations ON driver_traveler_conversations.conversation_id = drivers_travels.id
//                 
//                WHERE drivers_travels.travel_date <= '$six_months_ago' AND drivers_travels.message_count <= 1 LIMIT 30";
//                
//        
//        $travels = $this->Travel->query($query);
         $driver_travel = array();
         $conversation=array();
         $conversationMeta=array(); 
        /*Assign to actual variables*/
        foreach ($result as $key=>$value) {
           if(!empty(array_filter($value['DriverTravel']))) $driver_travel[$key]=array_filter($value['DriverTravel']);
           if(!empty(array_filter($value['DriverTravelerConversation']))) $conversation[$key]=array_filter($value['DriverTravelerConversation']);
           if(!empty(array_filter($value['TravelConversationMeta']))) $conversationMeta[$key]=array_filter($value['TravelConversationMeta']);
        }
        
        
        /*Saving Data*/
       
//       print_r($driver_travel);//for checking into console
       $this->ArchiveDriversTravels->bindModel(array('hasMany'=>array('ArchiveDriversTravelerConversations'=>array('className'=>'ArchiveDriversTravelerConversations','foreignKey'=>'conversation_id'))));
       $this->ArchiveDriversTravels->bindModel(array('hasMany'=>array('ArchiveTravelsConversationsMeta'=>array('className'=>'ArchiveTravelsConversationsMeta','foreignKey'=>'conversation_id'))));
       $datasource = $this->ArchiveDriversTravels->getDataSource();
       $datasource->begin();
       
       /*Inserting and deleting (new datasourse for this last option)*/
       
              $keyprefix='DriverTravel.';
              if(!empty(array_filter($driver_travel)))  $OkSaveTravels = $this->ArchiveDriversTravels->saveMany($driver_travel);
              else
                  $OkSaveTravels=true;
               /*Russian fuck for get it working*/
               foreach ($driver_travel as $key => $value) {
                   foreach ($value as $key2 => $value2) {
                       if($key2=='id'){
                       $value[$keyprefix.$key2]=$value[$key2];
                       unset($value[$key2]);
                       $driver_travel[$key]=$value[$keyprefix.$key2];
                       }
                       unset($value[$key2]);
                   }
                                  
               }
               /*END - Russian fuck for get it working*/
               
                 
               
             
              if(!empty(array_filter($conversation))) $OkSaveConversation = $this->ArchiveDriverTravelerConversations->saveMany($conversation);
              else $OkSaveConversation=true;
               /*Russian fuck for get it working*/
               $keyprefix='DriverTravelerConversation.';
               foreach ($conversation as $key => $value) {
                   foreach ($value as $key2 => $value2) {
                       if($key2=='id'){
                       $value[$keyprefix.$key2]=$value[$key2];
                       unset($value[$key2]);
                       $conversation[$key]=$value[$keyprefix.$key2];
                       }
                      unset($value[$key2]); 
                   }
                                  
               }
               /*END - Russian fuck for get it working*/
              
           
               if(!empty(array_filter($conversationMeta))) $OkSaveMeta = $this->ArchiveTravelsConversationsMeta->saveMany($conversationMeta); 
               else
                   $OkSaveMeta=true;
               /*Russian fuck for get it working*/
               $keyprefix='TravelConversationMeta.';
               foreach ($conversationMeta as $key => $value) {
                   foreach ($value as $key2 => $value2) {
                       if($key2=='conversation_id'){
                       $value[$keyprefix.$key2]=$value[$key2];
                       unset($value[$key2]);
                       $conversationMeta[$key]=$value[$keyprefix.$key2];
                       }
                       unset($value[$key2]);
                   }
                               
               }
               /*END - Russian fuck for get it working*/
              
               
               
               if (!$OkSaveTravels || !$OkSaveConversation ||!$OkSaveMeta){
                   echo "ERROR INSERTING";
                     $datasource->rollback();   
               }
               
               $datasourceDelete = $this->DriverTravel->getDataSource();
               $datasourceDelete->begin();
               

              print_r($driver_travel);//for checking into console
                if(!empty(array_filter($driver_travel))) $okDelTravels=$this->DriverTravel->deleteAll(['DriverTravel.id'=>$driver_travel],true);
                else $okDelTravels=true;
               
               if(!empty(array_filter($conversation))) $okDelConversation=$this->DriverTravelerConversation->deleteAll(['DriverTravelerConversation.id'=>$conversation], true);
               else $okDelConversation=true;
               
               if(!empty(array_filter($conversationMeta))) $okDelMeta=$this->TravelConversationMeta->deleteAll(['TravelConversationMeta.conversation_id'=>$conversationMeta], true);
               else $okDelMeta=true;
              
               $log=$datasourceDelete->getLog(false,false);
               debug($log);
               
                if (!$okDelTravels || !$okDelConversation || !$okDelMeta){
                    echo "ERROR DEL";
                     $datasource->rollback();
                     $datasourceDelete->rollback();
                     
               }
     
                 $datasource->commit(); 
                 $datasourceDelete->commit();
        
    }
    
    
}

?>