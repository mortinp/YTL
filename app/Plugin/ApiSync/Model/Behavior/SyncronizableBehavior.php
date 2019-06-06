<?php

App::uses('ModelBehavior', 'Model');

class SyncronizableBehavior extends ModelBehavior {

    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                
                'sync_queue_table' => null, // La tabla donde se debe salvar el objeto a sincronizar (i.e. messages o travels)
                'key_field' => null,
                'conditions' => array(),
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);
    }
        
    public function afterSave(Model $Model, $created) {
        
        if($created) {
            $settings = $this->settings[$Model->alias];
        
            // Sanity checks
            if(!isset ($settings['sync_queue_table']) || $settings['sync_queue_table'] == null)  return;

            $conditionsOK = true;
            foreach ($settings['conditions'] as $key => $value) {
                if($Model->data[$Model->alias][$key] != $value) {
                    $conditionsOK = false;
                    break;
                }
            }

            if($conditionsOK) {

                // El objeto que voy a guardar en la BD
                $syncObject = array($settings['key_field'] => $Model->getLastInsertID());

                $SyncTable = ClassRegistry::init('ApiSync.SyncObject');
                $SyncTable->useTable = $settings['sync_queue_table'];

                if(!$SyncTable->save($syncObject) ) throw new Exception();
            }
        }
        
        return true;
    } 
}
