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
        $six_months_ago = date('Y-m-d', strtotime("today - 3 month"));
        $this->DriverTravel->recursive=4;
        
        
        $result = $this->DriverTravel->find('all',array('conditions'=>array('DriverTravel.travel_date '=>"2016-08-07",
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
       
       print_r($driver_travel);//for checking into console
       $this->ArchiveDriversTravels->bindModel(array('hasMany'=>array('ArchiveDriversTravelerConversations'=>array('className'=>'ArchiveDriversTravelerConversations','foreignKey'=>'conversation_id'))));
       $this->ArchiveDriversTravels->bindModel(array('hasMany'=>array('ArchiveTravelsConversationsMeta'=>array('className'=>'ArchiveTravelsConversationsMeta','foreignKey'=>'conversation_id'))));
       $datasource = $this->ArchiveDriversTravels->getDataSource();
       $datasource->begin();
       
//       foreach ($result as $value) {
//           
//           
//               $OK = $this->ArchiveDriversTravels->saveAll($driver_travel);
//               if (!$OK){
//                     $datasource->rollback();
//               break;}
//              
//           
//       }
//        $datasource->commit(); 
       /*Inserting and deleting (new datasourse for this last option)*/
       $datasourceDelete = $this->DriverTravel->getDataSource();
       $datasourceDelete->begin();
              
               $OK = $this->ArchiveDriversTravels->saveMany($driver_travel);
              if(!empty(array_filter($driver_travel))) $okDel=$this->DriverTravel->deleteAll($driver_travel, false);
               if (!$OK || !$okDel){
                     $datasource->rollback();
                     $datasourceDelete->rollback();
                     
               }
              
               
             
               $OK = $this->ArchiveDriverTravelerConversations->saveMany($conversation);
              if(!empty(array_filter($conversation))) $okDel=$this->DriverTravelerConversation->deleteAll($conversation, false);
               if (!$OK || !$okDel){
                     $datasource->rollback();
                     $datasourceDelete->rollback();
                     
               }
            
               
               $OK = $this->ArchiveTravelsConversationsMeta->saveMany($conversationMeta);    
               if(!empty(array_filter($conversationMeta))) $okDel=$this->TravelConversationMeta->deleteAll($conversationMeta, false);
               if (!$OK || !$okDel){
                     $datasource->rollback();
                     $datasourceDelete->rollback();
                     
               }
              
     
                 $datasource->commit(); 
                 $datasourceDelete->commit();
        
    }
    
    
}

?>