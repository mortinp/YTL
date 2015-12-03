<?php

App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class UserInteraction extends AppModel {
    
    public static $INTERACTION_TYPE_CONFIRM_EMAIL = 'confirm email';
    public static $INTERACTION_TYPE_CHANGE_PASSWORD = 'change password';
    public static $INTERACTION_TYPE_WRITE_REVIEW = 'write review';
    
    
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
            'user_id'=>$userId,
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
    
    
    private function getWeirdString() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
    }
    
    
}

?>