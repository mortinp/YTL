<?php
App::uses('AppModel', 'Model');
App::uses('PathUtil', 'Util');
class EmailAttachment extends AppModel {
    
    //public $belongsTo = 'EmailQueue';
    
    public $actsAs = array('HardDiskSave');
    
    
    public function getAttachments($ids) {
        $ids = split('-', $ids);

        // TODO: Haacer esto con un IN en la consulta para hacerlo de una sola vez
        $attachments = array();
        foreach ($ids as $id) {
            $attachments[] = $this->findById($id);
        }
        
        // Acomodar el resultado de tal forma que sea manejable en javascript
        $list = array();
        foreach ($attachments as $a) {
            $a['EmailAttachment']['url'] = PathUtil::getFullPath($a['EmailAttachment']['relfilepath']); // Adicionar este campo extra para poder referenciar url completa          
            $list[] = $a['EmailAttachment'];
        }
        
        return $list;
    }
}

?>