<?php

App::uses('AppController', 'Controller');
App::uses('File', 'Utility');

class AdminsController extends AppController {
    
    public function view_travels_by_email_log() {
        $file = new File('../tmp/logs/viaje_por_correo.log');
        
        $lines = preg_split("/(\r\n|\n|\r)/", $file->read());
        $file_content = '';
        foreach ($lines as $l) {
            $file_content .= $l.'<br/>';
        }
        $this->set('content', $file_content);
    }
    
    public function view_log($log) {
        $file = new File('../tmp/logs/'.$log.'.log');
        
        $lines = preg_split("/(\r\n|\n|\r)/", $file->read());
        $file_content = '';
        foreach ($lines as $l) {
            $file_content .= $l.'<br/>';
        }
        $this->set('content', $file_content);
    }
}

?>