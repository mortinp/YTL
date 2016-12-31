<?php
App::uses('AppModel', 'Model');

class OpActionRule extends AppModel {
    
    public $useTable = 'op_actions_rules';
    
    public $belongsTo = array(
        'Owner'=>array(
            'className'=>'User',
            'foreignKey'=>'op_owner',
            'fields'=>array('id', 'username', 'display_name', 'role')
        ),
        'Other'=>array(
            'className'=>'User',
            'foreignKey'=>'op_other',
            'fields'=>array('id', 'username', 'display_name', 'role')
        ),
    );
    
    public static $rules = array('M' => 'leer nuevos mensajes', 'N' => 'notificar choferes');
}

?>