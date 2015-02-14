<?php
App::uses('AppModel', 'Model');
class DriverProfileResource extends AppModel {
    
    public $useTable = 'drivers_profiles_resources';
    
    public $actsAs = array('HardDiskSave');
}

?>