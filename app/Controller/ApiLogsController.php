<?php
App::uses('ApiAppController', 'Controller');
App::uses('EmailsUtil', 'Util');

class ApiLogsController extends ApiAppController {
    
    //public $uses = array('Driver');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('uploadAppErrorLog');
    }
    
    public function uploadAppErrorLog() {
        if(!$this->request->is('post')) throw new MethodNotAllowedException();
        
        $user = $this->getUser();
        
        $attachments = array();
        if(isset($_FILES['file']['name'])) {
            $adjunto = $_FILES['file'];
        
            if($adjunto['name'] != '')
                $attachments = array($adjunto['name'] => array('contents' => file_get_contents($adjunto['tmp_name']), 'mimetype' => $adjunto['type']));
        }
        
        $OK = ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
            'martin@yotellevocuba.com',
            array(),
            array(
                'template'=>'default',
                'format'=>'text',
                'subject'=>'Error en app choferes: '.$user['username'],
                'config'=>'no_responder',
                'attachments'=>$attachments
            )
        );
        
        $this->set(array(
            'success' => true,
            'data' => true,
            '_serialize' => array('success', 'data')
        ));
    }
    
}

?>