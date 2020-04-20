<?php

App::uses('AppController', 'Controller');
App::uses('File', 'Utility');

class AdminsController extends AppController {
     public $uses = array('DriverTravel', 'Travel', 'Driver', 'DriverTravelerConversation', 'User', 'Testimonial');
    
    public function view_log($log) {
        $file = new File('../tmp/logs/'.$log.'.log');
        
        $lines = preg_split("/(\r\n|\n|\r)/", $file->read());
        $file_content = '';
        foreach ($lines as $l) {
            $file_content .= $l.'<br/>';
        }
        $this->set('content', $file_content);
    }
    /*Nueva landing para administrar*/
    public function index() {
        $this->DriverTravel->recursive = 2;
        /*Count new messages*/
      $conditions['OR'] = array(
                array('AND'=>array(
                    'TravelConversationMeta.read_entry_count' => null,
                    'DriverTravel.message_count >' => 0                    
                )),
                array('AND'=>array(
                    array('not' => array('TravelConversationMeta.read_entry_count' => null)),
                    'DriverTravel.message_count > TravelConversationMeta.read_entry_count'
                ))
            );
      $total_unread_messages = $this->DriverTravel->find('all',array('conditions'=>$conditions));
      $this->set('total_unread_messages', count($total_unread_messages));
      /*Count travels done*/
      $this->loadModel('DriverTravelerConversation');
      $conditions1['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_DONE;
      $conditions1['TravelConversationMeta.archived'] = 0; //Que no este archivado
      $total_done = $this->DriverTravel->find('all',array('conditions'=>$conditions1));
      $this->set('total_done', count($total_done));
        /*Count new Testimonials*/
       $conditions2 = array('Testimonial.state =' => Testimonial::$statesValues['pending']);
       $total_new_testimonials = $this->Testimonial->find('all',array('conditions'=>$conditions2));
      $this->set('total_new_testimonials', count($total_new_testimonials));
       /*Count delated payments*/
      $conditions3['TravelConversationMeta.state'] = DriverTravelerConversation::$STATE_TRAVEL_DONE;
      $conditions3['TravelConversationMeta.archived'] = 0; //Que no este archivado      
      $conditions3['DriverTravel.travel_date <'] = Date('Y-m-d',strtotime('- 30 days')); //menor que hace 30 dias
      $total_delayed = $this->DriverTravel->find('all',array('conditions'=>$conditions3));
      $this->set('total_delayed', count($total_delayed));
    }
}

?>