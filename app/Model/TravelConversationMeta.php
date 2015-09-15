<?php
App::uses('AppModel', 'Model');
class TravelConversationMeta extends AppModel {
    
    public $useTable = 'travels_conversations_meta';
    
    public $primaryKey = 'conversation_id';
}

?>