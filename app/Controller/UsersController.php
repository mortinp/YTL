<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
    
    public $uses = array('User', /*'PendingUser',*/ 'UserInteraction');
    
    public $components = array('TravelLogic');

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('confirm_email');
        $this->Auth->allow('change_password');
        
        if($this->Auth->loggedIn()) {
            $this->Auth->allow('logout', 'send_confirm_email', 'unsubscribe');
        }
        else $this->Auth->allow('login', 'register', 'register_welcome', 'register_and_create', 'forgot_password', 'send_change_password');
    }

    public function isAuthorized($user) {
        if (in_array($this->action, array('register_welcome', 'password_changed', 'profile'))) { // Allow these actions for the logged-in user
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function login() {
        if ($this->request->is('post')) {
            if($this->do_login()) {
                if(AuthComponent::user('role') === 'admin') return $this->redirect(array('action'=>'index'));
                return $this->redirect($this->Auth->redirect());
            } else $this->setErrorMessage(__('El usuario o la contraseña son inválidos. Intenta de nuevo.'));
        }
        if ($this->Auth->loggedIn() || $this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    private function do_login() {
        if ($this->Auth->login()) {
            $this->_setCookie($this->Auth->user('id'));
            return true;
        }
        return false;
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function register() {
        if ($this->request->is('post')) {
            if($this->User->loginExists($this->request->data['User']['username'])) {
                $this->setErrorMessage(__('Este correo electrónico ya está registrado en <em>YoTeLlevo</em>. Escribe una dirección diferente o').' '. 
                    '<a href="'.Router::url(array('action'=>'login')).'">'.__('entra con tu cuenta').'</a>.');// TODO: esta direccion estatica es un hack
                return $this->redirect($this->referer());
            }

            $this->request->data['User']['role'] = 'regular';
            $this->request->data['User']['active'] = true;
            $this->request->data['User']['registered_from_ip'] = $this->request->clientIp();
            $this->request->data['User']['register_type'] = 'register_form';
            
            $datasource = $this->User->getDataSource();
            $datasource->begin();
            
            $OK = $this->do_register($this->request->data['User'], 'welcome');
                
            if($OK) {
                $datasource->commit();
                if($this->do_login()) return $this->render('register_welcome');
            } else {
                $datasource->rollback();
                $this->setErrorMessage(__('Ocurrió un error registrando su usuario. Intente de nuevo'));
            }
        }
    } 
    
    public function register_and_create($pendingTravelId) {
        if ($this->request->is('post')) {
            if($this->User->loginExists($this->request->data['User']['username'])) {
                $this->setErrorMessage(__('Este correo electrónico ya está registrado en <em>YoTeLlevo</em>. Escribe una dirección diferente o'). 
                    '<a href="'.Router::url(array('action'=>'login')).'">'.__('entra con tu cuenta').'</a>.');// TODO: esta direccion estatica es un hack
                return $this->redirect($this->referer());
            }

            $this->request->data['User']['role'] = 'regular';
            $this->request->data['User']['active'] = true;
            $this->request->data['User']['registered_from_ip'] = $this->request->clientIp();
            $this->request->data['User']['register_type'] = 'pending_travel_register_form';
            
            $datasource = $this->User->getDataSource();
            $datasource->begin();
            
            $result = array();
            
            $OK = $this->do_register($this->request->data['User'], 'welcome_with_travel');
            if(!$OK) $result['message'] = 'Ocurrió un error registrando tu usuario. Intenta nuevamente.';
            
            if($OK) $result = $this->TravelLogic->confirmPendingTravel($pendingTravelId, $this->request->data['User']['id']);
            
            
            if(!$result['success']) {
                $OK = false;
                
                /**
                 * Hack: Al guardarse el viaje antes de confirmarlo, se ejecuta el afterSave() de Travel. Esto incrementa la variable travel_count de la sesión.
                 * Si la transacción falla, hay que decrementar esa variable nuevamente.
                 * TODO: existirá un metodo más o menos como afterSaveFail() en los modelos???
                 */
                CakeSession::delete('Auth.User');
            }
                
            if($OK) {
                $datasource->commit();
                if($this->do_login()) {
                    $this->set('travel', $result['travel']);
                    return $this->render('register_welcome');
                }
            } else {
                $datasource->rollback();
                $this->setErrorMessage(__($result['message']));
                $this->redirect($this->referer()/*array('controller'=>'travels', 'action'=>'view_pending/'.$pendingTravelId)*/);
            }
        }
    } 
    
    private function do_register(&$user, $emailTemplate) {
        $OK = true;            
        $OK = $this->User->save($user);
        if($OK) $user['id'] = $this->User->getLastInsertID();
        if($OK) $OK = $this->do_send_confirm_email($user, $emailTemplate);
        
        return $OK;
    }
    
    public function profile() {
        if ($this->request->is('post')|| $this->request->is('put')) {
            $user = $this->request->data;
            
            if(strlen($user['User']['password']) == 0) unset ($user['User']['password']);
            if($this->User->save($user)) {                
                //$this->Session->write('Auth.User', $user['User']);
                $this->Session->write('Auth.User.display_name', $user['User']['display_name']);
                if(isset ($user['User']['password']))$this->Session->write('Auth.User.display_name', $user['User']['password']);
                
                $this->setSuccessMessage('Tu nueva información ha sido guardada');
            } else {
                $this->setErrorMessage('Ocurrió un problema guardando la información. Intenta de nuevo.');
            }
        } else {
            $this->request->data['User'] = $this->Auth->user();
        }
    }    
    
    public function index() {
        //$this->User->recursive = 0;
        $this->set('users', $this->User->find('all'));
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['active'] = true;
            $this->request->data['User']['registered_from_ip'] = $this->request->clientIp();
            $this->request->data['User']['register_type'] = 'add_user_form';
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('controller'=>'travels','action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function remove($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
    
    
    
    public function unsubscribe() {
        if(!$this->Auth->loggedIn()) {
            $this->setErrorMessage('Ocurrió un error eliminando tu cuenta. Intenta de nuevo');
            return $this->redirect(array('action'=>'login'));
        }  
        
        if($this->request->is('post')) {
            $this->setErrorMessage('Cuenta de usuario eliminada: '.$this->request->data['Unsubscribe']['text']);
            return $this->redirect(array('action'=>'profile'));
        }
    }
    
    public function resubscribe() {
        
    }
    
    
    
    /**
     * AUX
     */
    
    private function getWeirdString() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
    }
    
    protected function _setCookie($id) {
        if (!$this->request->data('User.remember_me')) {
            return false;
        }
        $data = array(
            'username' => $this->request->data('User.username'),
            'password' => $this->request->data('User.password')
        );
        $this->Cookie->write('User', $data, true, '+2 week');
        return true;
    }    
    
    
    
    
    /**
     * INTERACTIONS
     */
    
    public function send_confirm_email() {
        $datasource = $this->User->getDataSource();
        $datasource->begin();
        
        if($this->do_send_confirm_email(AuthComponent::user(), 'email_confirmation')) {
            $datasource->commit();
        } else {
            $datasource->rollback();
            $this->setErrorMessage('Ocurrió un error enviando las instrucciones a tu correo. Intenta de nuevo.');
            return $this->redirect($this->referer());
        }
    }
    
    private function do_send_confirm_email($user, $emailTemplate) {
        $interaction = $this->UserInteraction->find('first', array('conditions'=>array(
            'user_id'=>$user['id'],
            'interaction_due'=>'confirm email',
            'expired'=>false)));        
        
        $OK = true;
        if($interaction != null) {
            $code = $interaction['UserInteraction']['interaction_code'];
        } else {
            $code = $this->getWeirdString();
            
            $interaction = array('UserInteraction');
            $interaction['UserInteraction']['user_id'] = $user['id'];
            $interaction['UserInteraction']['interaction_due'] = 'confirm email';
            $interaction['UserInteraction']['expired'] = false;
            $interaction['UserInteraction']['interaction_code'] = $code;
            
            if(!$this->UserInteraction->save($interaction)) $OK = false;
        }
        
        if($OK) {
            /*if($welcome) $template = 'welcome';
            else $template = 'email_confirmation';*/
            
            $Email = new CakeEmail('no_responder');
            $Email->template($emailTemplate)
            ->viewVars(array('confirmation_code' => $code))
            ->emailFormat('html')
            ->to($user['username'])
            ->subject('Verificación de cuenta');
            try {
                $Email->send();
            } catch ( Exception $e ) {
                $OK = false;
            }
        } 
        
        return $OK;
    }
    
    public function confirm_email($code) {
        $interaction = $this->UserInteraction->find('first', array('conditions'=>array(
            'interaction_due'=>'confirm email',
            'expired'=>false,
            'interaction_code'=>$code)));       
        
        $datasource = $this->User->getDataSource();
        $datasource->begin();
        
        $OK = true;
        if($interaction != null) {
            
            $interaction['UserInteraction']['expired'] = true;
            if(!$this->UserInteraction->save($interaction)) $OK = false;
            
            if($OK) {
                if($this->Auth->loggedIn()) {
                    if(AuthComponent::user('id') != $interaction['UserInteraction']['user_id']) $OK = false;
                }
            }            
            
            if($OK) {
                $user = $this->User->findById($interaction['UserInteraction']['user_id']);
                if($user != null) {
                    $user['User']['email_confirmed'] = true;
                    $this->User->id = $interaction['UserInteraction']['user_id'];
                    if($this->User->saveField('email_confirmed', '1')) {
                        if($this->Auth->loggedIn()) {
                            $this->Auth->logout();
                            if ($this->Auth->login($user['User'])) {
                                $this->_setCookie($this->Auth->user('id'));
                            } else {
                                $OK = false;
                            }
                        } else {
                            //
                        }   
                        
                    } else {
                        $OK = false;
                    }
                }
            }
        } else {            
            $OK = false;
        }
        
        if($OK) {
            $datasource->commit();
            $this->set('user', $user);
            $this->set('isLoggedIn', $this->Auth->loggedIn());
        } else {
            $datasource->rollback();
            $this->setErrorMessage('Ocurrió un error verificando tu cuenta de correo electrónico. Puede ser que el enlace esté caducado o usado, o que la dirección que estás usando es incorrecta.');
            
            if($this->Auth->loggedIn()) {
                return $this->redirect(array('controller'=>'travels', 'action'=>'index'));
            } else {
                return $this->redirect(array('controller'=>'pages', 'action'=>'home'));
            }
        }
    }
    
    
    public function forgot_password() {
        
    }
    
    public function send_change_password() {
        if ($this->request->is('post')) {
            
            $user = $this->User->find('first', array('conditions'=>array('username'=>$this->request->data['User']['username'])));
            
            // Verificar existencia de usuario
            if($user == null || empty ($user)) {
                $this->setErrorMessage('Este correo no pertenece a ningún usuario.');
                return $this->redirect(array('action'=>'forgot_password'));
            }
            
            $interaction = $this->UserInteraction->find('first', array('conditions'=>array(
                'user_id'=>$user['User']['id'],
                'interaction_due'=>'change password',
                'expired'=>false)));

            $datasource = $this->User->getDataSource();
            $datasource->begin();

            $OK = true;
            if($interaction != null) {
                $code = $interaction['UserInteraction']['interaction_code'];
            } else {
                $code = $this->getWeirdString();

                $interaction = array('UserInteraction');
                $interaction['UserInteraction']['user_id'] = $user['User']['id'];
                $interaction['UserInteraction']['interaction_due'] = 'change password';
                $interaction['UserInteraction']['expired'] = false;
                $interaction['UserInteraction']['interaction_code'] = $code;

                if(!$this->UserInteraction->save($interaction)) $OK = false;
            }

            if($OK) {
                // Send email and redirect to a welcome page
                $Email = new CakeEmail('no_responder');
                $Email->template('change_password')
                ->viewVars(array('confirmation_code' => $code))
                ->emailFormat('html')
                ->to($user['User']['username'])
                ->subject('Cambio de contraseña');
                try {
                    $Email->send();
                } catch ( Exception $e ) {
                    $OK = false;
                }
            }        

            if($OK) {
                $datasource->commit();
                $this->set('user', $user);
            }else {
                $datasource->rollback();
                $this->setErrorMessage('Ocurrió un error enviando las instrucciones a tu correo. Intenta de nuevo.');
                $this->redirect($this->referer());
            }
        }
        
        
    }
    
    public function change_password($confirmation_code) {
        $interaction = $this->UserInteraction->find('first', array('conditions'=>array(
            'interaction_due'=>'change password',
            'expired'=>false,
            'interaction_code'=>$confirmation_code)));
        
        if ($this->request->is('post')|| $this->request->is('put')) {
            $user = $this->request->data;
            
            if($this->User->save($user)) {
                if($this->Auth->loggedIn()) {
                    $this->Auth->logout();
                    if ($this->Auth->login($user['User'])) {
                        $this->_setCookie($this->Auth->user('id'));
                        return $this->redirect($this->Auth->redirect());
                    }
                    
                } 
                $this->setInfoMessage('Tu contrseña ha sido cambiada. Entra a <em>YoTeLlevo</em> usando la nueva contraseña.');
                return $this->redirect(array('action'=>'login'));
            } else {
                $this->setErrorMessage('Ocurrió un problema guardando la información. Intenta de nuevo.');
            }
        } else {
            $user = $this->User->findById($interaction['UserInteraction']['user_id']);            
            unset ($user['User']['password']);
            $this->request->data['User'] = $user['User'];
            
            $this->set('code', $confirmation_code);
        }
    }
}

?>