<?php
App::uses('AppModel', 'Model');
class EmailAttachment extends AppModel {
    
    public $belongsTo = 'EmailQueue';
    
    public $actsAs = array('HardDiskSave');
    
    /*public function beforeSave($options = array()) {
        $filename = $this->data[$this->alias]['filename'];
        $contents = $this->data[$this->alias]['contents'];
        $mimeType = $this->data[$this->alias]['mimetype'];
        
        $unique_filename = preg_replace('/[^a-zA-Z0-9_-]/','_',$filename);
        
        $unlocked_and_unique = FALSE;
        while(!$unlocked_and_unique){
            // Find unique
            $name = time() . "_" . $unique_filename;
            while(file_exists('./tmp/files/'.$name)) {
                $name = time() . "_" . $unique_filename;
            }
            
            $path = ROOT.DS.APP_DIR.DS.'tmp'.DS.'files'.DS.$name;
            
            // Attempt to lock
            $outfile = fopen($path,'w');            
            if(!$outfile) {
                CakeLog::write('conversations', 'Could not open: '.$path);
                break;
            }
            
            if(flock($outfile,LOCK_EX)){
                $unlocked_and_unique = TRUE;
            }else{
                flock($outfile,LOCK_UN);
                fclose($outfile);
            }
        }
        
        CakeLog::write('conversations', 'Saving file: '.$path);
        $OK = fwrite($outfile,$contents);
        fclose($outfile);
        
        if($OK) CakeLog::write('conversations', 'File saved successfully: '.$name);
        else CakeLog::write('conversations', 'Failed saving file: '.$name);
        
        $this->data[$this->alias]['filepath'] = $path;
        
        return true;
    }*/
}

?>