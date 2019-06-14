<?php

App::uses('ModelBehavior', 'Model');

class SyncronizableBehavior extends ModelBehavior {

    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                
                'sync_queue_table' => null, // La tabla donde se debe salvar el objeto a sincronizar (i.e. messages o travels)
                'key_field' => null,
                'fields'=>array(),
                'conditions' => array(),
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);
    }
        
    public function afterSave(Model $Model, $created) {
        
        if($created) {
            $settings = $this->settings[$Model->alias];
        
            // Sanity checks
            if(!isset ($settings['sync_queue_table']) || $settings['sync_queue_table'] == null) return;
            
            // Verificar las condiciones para guardar en la BD
            $conditionsOK = true;
            foreach ($settings['conditions'] as $key => $value) {
                if($Model->data[$Model->alias][$key] != $value) {
                    $conditionsOK = false;
                    break;
                }
            }

            if($conditionsOK) {

                // Ponerle la llave al objeto que voy a guardar
                $syncObject = array($settings['key_field'] => $Model->getLastInsertID());
                
                // Ponerle otros campos
                foreach ($settings['fields'] as $key => $value) {
                    //throw new Exception($key.' - '.$value.' = '.$Model->data[$Model->alias][$value]);
                    $syncObject[$key] = $Model->data[$Model->alias][$value];
                }

                $SyncTable = ClassRegistry::init('ApiSync.SyncObject');
                $SyncTable->useTable = $settings['sync_queue_table'];
                
                $SyncTable->create();

                if(!$SyncTable->save($syncObject) ) throw new Exception();
            }
        }
        
        return true;
    } 
}
