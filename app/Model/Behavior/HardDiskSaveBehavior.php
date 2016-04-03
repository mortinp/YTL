<?php

App::uses('ModelBehavior', 'Model');

class HardDiskSaveBehavior extends ModelBehavior {

    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                'hard_disk_save' => null,
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);
    }
        
    public function beforeSave(Model $Model, $options = array()) {
        $settings = $this->settings[$Model->alias];
        $attachedFieldsPrepend = '';
        
        if(isset ($settings['hard_disk_save']) && $settings['hard_disk_save'] != null) { // Si esta definido un campo de donde coger los datos a salvar (nombre del archivo, contenido, etc)
            $attachedFieldsPrepend = $settings['hard_disk_save'].'_';
            $data = $Model->data[$Model->alias][$settings['hard_disk_save']];
        } else $data = $Model->data[$Model->alias];
        
        
        // Sanity check
        if( (!isset ($data['filename']) && !isset ($data['name'])) || $data['size'] == 0) { // Esto quiere decir que no se subio nada
            unset ($Model->data[$Model->alias][$settings['hard_disk_save']]); // Quitarle el campo que se usa como datos para que no se sobreescriba al guardar el modelo, y no se pierdan datos si se subio anteriormente algo
            return;
        }
        
        
        if(isset ($data['filename'])) $filename = $data['filename'];
        else $filename = $data['name'];
        
        if(isset ($data['contents'])) $contents = $data['contents'];
        else {
            // Load content from tmp directory
            $contents = file_get_contents($data['tmp_name']);
        }
        
        $unique_filename = preg_replace('/[^a-zA-Z0-9_-]/','_',$filename);
        
        $unlocked_and_unique = FALSE;
        while(!$unlocked_and_unique){
            // Find unique
            $name = time() . "_" . $unique_filename;
            while(file_exists('/files/'.$name)) { // TODO: Deberia configurar en las settings el path donde se deben guardar las imagenes??? ej. /files
                $name = time() . "_" . $unique_filename;
            }
            
            $relpath = 'files'.DS.$name;
            $path = ROOT.DS.APP_DIR.DS.'webroot'.DS.$relpath;
            
            // Attempt to lock
            $outfile = fopen($path,'w');            
            if(!$outfile) {
                CakeLog::write('files_saved', 'Could not open: '.$path);
                break;
            }
            
            if(flock($outfile,LOCK_EX)){
                $unlocked_and_unique = TRUE;
            }else{
                flock($outfile,LOCK_UN);
                fclose($outfile);
            }
        }
        
        //CakeLog::write('files_saved', 'Saving file: '.$path);
        $OK = fwrite($outfile,$contents);
        fclose($outfile);
        
        if($OK) CakeLog::write('files_saved', 'File saved successfully: '.$path);
        else CakeLog::write('files_saved', 'Failed saving file: '.$path);
        
        /* Attach fields */
        if(isset ($settings['path_type']) && $settings['path_type'] == 'relative') $Model->data[$Model->alias][$attachedFieldsPrepend.'filepath'] = $relpath;
        else $Model->data[$Model->alias][$attachedFieldsPrepend.'filepath'] = $path;
        
        $Model->data[$Model->alias][$attachedFieldsPrepend.'relfilepath'] = $relpath;
        
        return $OK;
    }
}
