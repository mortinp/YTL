<?php

App::uses('AppController', 'Controller');
App::uses('UserInteraction', 'Model');
App::uses('ExpiredLinkException', 'Error');
App::uses('EmailsUtil', 'Util');


class CasasController extends AppController {
    
    public $uses = array('CasaFindRequest', 'UserInteraction', 'User');
    
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function isAuthorized($user) {
        if (in_array($this->action, array('add_request'))) {
            if(isset ($this->request->params['pass'][0])) {
                $token = $this->request->params['pass'][0];
                if ($this->UserInteraction->tokenBelongsToUser($token, $user['id'])) {
                    return true;
                }
            }
        }   

        return parent::isAuthorized($user);
    }
    
    
    public function send_proposal_find_casas($userId) {
            
        $user = $this->User->findById($userId);

        // Verificar existencia de usuario
        if($user == null || empty ($user)) {
            $this->setErrorMessage('Usuario no encontrado.');
            return $this->redirect($this->referer());
        }

        $datasource = $this->User->getDataSource();
        $datasource->begin();

        $interaction = $this->UserInteraction->getInteraction($userId, UserInteraction::$INTERACTION_TYPE_FIND_CASAS);
        $code = null;
        if($interaction != null && !empty ($interaction)) {
            $OK = true;
            $code = $interaction['UserInteraction']['interaction_code'];
            
            if(!$interaction['UserInteraction']['was_created_now']) { // no permitir que se envie varias veces la propuesta
                $datasource->rollback();
                $this->setErrorMessage('Hay una propuesta activa actualmente y no se puede volver a enviar.');
                $this->redirect($this->referer());
            } 

            $this->UserInteraction->id = $interaction['UserInteraction']['id'];
            $OK = $this->UserInteraction->saveField('sent', true);
        }
        else $OK = false;
        
        if($OK) {
            
            $subject = 'Casas particulares en Cuba';
            if($user['User']['lang'] == 'en') $subject = 'Homestays in Cuba';
            
            EmailsUtil::email(
                    $user['User']['username'], 
                    $subject, 
                    array('find_casas_token' => $code), 
                    'super', 
                    'Casas.casas_find_proposal', 
                    array('lang'=>$user['User']['lang']));
        }        

        if($OK) {
            $datasource->commit();
            $this->setInfoMessage('Correo de propuesta de casas enviado al viajero exitosamente');
        }else {
            $datasource->rollback();
            $this->setErrorMessage('Ocurrió un error enviando el correo al usuario.');            
        }
        
        $this->redirect($this->referer());
    }
    
    
    
    
    public function add_request($token) {
        $interaction = $this->UserInteraction->find('first', array('conditions'=>array(
            'interaction_due'=>  UserInteraction::$INTERACTION_TYPE_FIND_CASAS,
            'expired'=>false,
            'interaction_code'=>$token)));
            
        if($interaction == null || empty ($interaction)) throw new ExpiredLinkException();
        
        if ($this->request->is('post')|| $this->request->is('put')) {
            
            $casasExpert = Configure::read('casas_expert');
            if(AuthComponent::user('role') == 'admin') $casasExpert = array('name'=>'Martin', 'email'=>array('mproenza@grm.desoft.cu', 'martin@yotellevocuba.com')); // Esto es para que las propuestas que se les envien a los admin, las solicitudes se me envien a mi. Esto es para poder hacer pruebas.
            
            $request = $this->request->data;
            $request['CasaFindRequest']['user_id'] = AuthComponent::user('id');
            $request['CasaFindRequest']['user_interaction_id'] = $interaction['UserInteraction']['id'];
            $request['CasaFindRequest']['send_to'] = $casasExpert['name']; // TODO: En algun momento tengo que poner algo diferente al nombre aqui
            
            $datasource = $this->CasaFindRequest->getDataSource();
            $datasource->begin();
            
            $OK = $this->CasaFindRequest->save($request);
            $request['CasaFindRequest']['id'] = $this->CasaFindRequest->getLastInsertID();
            
            if($OK) $OK = $this->UserInteraction->expire($interaction['UserInteraction']['id']);
            
            if($OK) {
                
                EmailsUtil::email(
                    $casasExpert['email'], 
                    'Solicitud de casas #'.$request['CasaFindRequest']['id'], 
                    array('request_id'=>$request['CasaFindRequest']['id'], 'guests_names'=>$request['CasaFindRequest']['guests_names'], 'details'=>$request['CasaFindRequest']['details'], 'contact_email'=>AuthComponent::user('username')), 
                    'super', 
                    'Casas.casas_new_request');
            }
            
            if($OK) {
                $datasource->commit();
                return $this->render('casas_request_thankyou');
            } else {
                $datasource->rollback();
                $this->setErrorMessage(__d('casas', 'Ocurrió un problema enviando la solicitud. Intenta de nuevo.'));
            }
        } else {
            // Marcar la interaccion como visitada
            $this->UserInteraction->visit($interaction['UserInteraction']['id']);
            
            // Mostrar vista para crear la solicitud (se muestra la vista de esta accion)
        }
    }
}

?>