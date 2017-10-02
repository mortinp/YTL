<?php
App::uses('AppModel', 'Model');
class DriverProfile extends AppModel {
    
    public $useTable = 'drivers_profiles';
    
    public $belongsTo = array(
        'Driver' => array(
            'fields'=>array('id', 'username', 'max_people_count', 'has_air_conditioner')
        )
    );
    
    public $actsAs = array(
        'HardDiskSave'=>array('hard_disk_save'=>'avatar', 'path_type'=>'relative')
    );
    
    public $validate = array('driver_code' => array('rule' => 'isUnique', 'message' => 'El código debe ser único') );
    
    public static function getAbsolutePath($filePath) {
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $filePath);
        
        return $src;
    }
    
    public function afterSave($created, array $options = array()) {
        parent::afterSave($created, $options);
        
        if($created) {
            // Enviar un correo de bienvenida al chofer
            $driverModel = new Driver();
            $driverModel->recursive = -1;
            $driver = $driverModel->findById($this->data['DriverProfile']['driver_id']);
            EmailsUtil::email(
                $driver['Driver']['username'], 
                'Bienvenido a YoTeLlevo', 
                array('profile'=>$this->data['DriverProfile']), 
                'super',
                'welcome_driver', 
                array('from_name'=>'Bienvenido, YoTeLlevo', 'from_email'=>'martin@yotellevocuba.com'));
        }
    }
    
    
}

?>