<?php
App::uses('AppModel', 'Model');
class EmailAttachment extends AppModel {
    
    public $belongsTo = 'EmailQueue';
    
    public function beforeSave($options = array()) {
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
            
            // Attempt to lock
            $outfile = fopen('./tmp/files/'.$name,'w');
            if(flock($outfile,LOCK_EX)){
                $unlocked_and_unique = TRUE;
            }else{
                flock($outfile,LOCK_UN);
                fclose($outfile);
            }
        }

        CakeLog::write('conversations', 'Saving file: '.$name);
        $OK = fwrite($outfile,$contents);
        fclose($outfile);
        
        if($OK) CakeLog::write('conversations', 'File saved successfully: '.$name);
        else CakeLog::write('conversations', 'Failed saving file: '.$name);
        
        $this->data[$this->alias]['filepath'] = './tmp/files/'.$name;
        
        return true;
    }
}

?>