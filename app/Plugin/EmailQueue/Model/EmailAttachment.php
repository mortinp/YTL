<?php
App::uses('AppModel', 'Model');
class EmailAttachment extends AppModel {
    
    public $belongsTo = 'EmailQueue';
    
    public $actsAs = array('HardDiskSave');
}

?>