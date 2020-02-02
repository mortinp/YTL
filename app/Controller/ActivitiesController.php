<?php

App::uses('AppController', 'Controller');
App::uses('Activity', 'Model');

class ActivitiesController extends AppController {
    
    public function display($activitySlug) {
        
        $activity = null;
        foreach (Activity::$activities as $a) {
            if($a['slug'] == $activitySlug) {
                $activity = $a;
                break;
            }
        }
        
        if($activity == null) throw new NotFoundException();
        
        $this->set(compact('activity'));
        
        $this->layout = 'activity';
        $this->render($activity['display_page']);
    }
}

?>