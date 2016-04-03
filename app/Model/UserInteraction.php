<?php

App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class UserInteraction extends AppModel {
    
    public static $INTERACTION_TYPE_CONFIRM_EMAIL = 'confirm email';
    public static $INTERACTION_TYPE_CHANGE_PASSWORD = 'change password';
    public static $INTERACTION_TYPE_WRITE_REVIEW = 'write review';
    public static $INTERACTION_TYPE_NOTIFY_MORE_DRIVERS = 'notify more drivers';
    public static $INTERACTION_TYPE_FIND_CASAS = 'find casas';
    
    // Filters
    public static $SEARCH_ALL = 'all';
    public static $SEARCH_FIND_CASAS = 'find-casas';
    public static $SEARCH_CONFIRM_EMAIL = 'confirm-email';
    public static $SEARCH_CHANGE_PASSWORD = 'change-password';
    public static $SEARCH_NOTIFY_WRITE_REVIEW = 'write-review';
    public static $SEARCH_NOTIFY_MORE_DRIVERS = 'notify-more-drivers';
    public static $filtersForSearch = array('all', 'find-casas', 'confirm-email', 'change-password', 'write-review', 'notify-more-drivers');
    
    public $hasOne = array(
        'CasaFindRequest' => array(
            'conditions'=>array('UserInteraction.interaction_due'=>'find casas', 'UserInteraction.expired'=>true)
        )
    );
    
    
    /**
     * Busca en la BD si existe un código no expirado para el tipo de interacción, y si no existe, crea uno y lo salva en la BD.
     * 
     * @param userId: id del usuario
     * @param interactionType: tipo de la interaccion, por ejemplo UserInteraction::$INTERACTION_TYPE_CONFIRM_EMAIL
     * 
     * @return codigo de la interacción, o null en caso de que falle algo
     */
    
    public function getInteractionCode($userId, $interactionType) {
        
        // TODO: Verificar que el usuario existe
        
        $interaction = $this->find('first', array('conditions'=>array(
            'UserInteraction.user_id'=>$userId,
            'interaction_due'=>$interactionType,
            'expired'=>false)));        
        
        $OK = true;
        if($interaction != null) {
            $code = $interaction['UserInteraction']['interaction_code'];
        } else {
            $code = $this->getWeirdString();
            
            $interaction = array('UserInteraction');
            $interaction['UserInteraction']['user_id'] = $userId;
            $interaction['UserInteraction']['interaction_due'] = $interactionType;
            $interaction['UserInteraction']['expired'] = false;
            $interaction['UserInteraction']['interaction_code'] = $code;
            
            if(!$this->save($interaction)) $OK = false;
        }
        
        if($OK) return $code;
        else return null;
    }
    
    public function getInteraction($userId, $interactionType) {
        
        // TODO: Verificar que el usuario existe
        
        $interaction = $this->find('first', array('conditions'=>array(
            'UserInteraction.user_id'=>$userId,
            'interaction_due'=>$interactionType,
            'expired'=>false)));  
        
        if($interaction != null) {
            $interaction['UserInteraction']['was_created_now'] = false;
            $OK = true;
        } else {
            $code = $this->getWeirdString();
            
            $interaction = array('UserInteraction');
            $interaction['UserInteraction']['user_id'] = $userId;
            $interaction['UserInteraction']['interaction_due'] = $interactionType;
            $interaction['UserInteraction']['expired'] = false;
            $interaction['UserInteraction']['interaction_code'] = $code;
            $interaction['UserInteraction']['was_created_now'] = true;
            
            $OK = $this->save($interaction);
            if($OK) $interaction['UserInteraction']['id'] = $this->getLastInsertID();
        }
        
        if($OK) return $interaction;
        else return null;
    }
    
    
    public function expire($id = null) {
        if((!isset ($this->id) ||$this->id == null) && $id == null) throw new Exception ('Wrong programming: No id supplied for user interaction', 404, null);
        
        if(!$this->exists($id)) throw new Exception ('Wrong programming: Bad id for user interaction', 404, null);
        
        $this->id = $id;
        return $this->saveField('expired', true);
    }
    
    public function visit($id = null) {
        if((!isset ($this->id) ||$this->id == null) && $id == null) throw new Exception ('Wrong programming: No id supplied for user interaction', 404, null);
        
        if(!$this->exists($id)) throw new Exception ('Wrong programming: Bad id for user interaction', 404, null);
        
        $this->id = $id;
        return $this->saveField('visited', true);
    }
    
    public function tokenBelongsToUser($token, $userId) {
        return $this->field('interaction_code', array('interaction_code' => $token, 'user_id' => $userId)) == $token;
    }
    
    
    private function getWeirdString() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
    }
    
    public function getUnexpiredInteraction($token, $interactionType) {
        $interaction = $this->find('first', array('conditions'=>array(
            'interaction_due'=>$interactionType,
            'expired'=>false,
            'interaction_code'=>$token)));
        
        return $interaction;
    }
    
    
}

?>