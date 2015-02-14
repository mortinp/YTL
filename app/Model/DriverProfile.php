<?php
App::uses('AppModel', 'Model');
class DriverProfile extends AppModel {
    
    public $useTable = 'drivers_profiles';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username', 'max_people_count')
        )
    );
    
    public $actsAs = array(
        'HardDiskSave'=>array('hard_disk_save'=>'avatar', 'path_type'=>'relative')
    );
}

?>