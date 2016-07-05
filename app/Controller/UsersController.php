<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('DriverTravel', 'Model');

class UsersController extends AppController {
    
    public $uses = array('User', 'UserInteraction', 'Travel', 'DriverTravel', 'Locality', 'Driver');
    
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
                
                $redirect = null;
                if(isset ($this->request->query['redirect'])) $redirect = $this->request->query['redirect'];                
                
                if($redirect != null) {
                    $parts = split('/', $redirect, 2);
                    $redirect = array('action'=>'index');
                    $redirect['controller'] = $parts[0];
                    if(isset ($parts[1]) && $parts[1] != null) $redirect['action'] = $parts[1];
                    
                } else {
                    if(in_array(AuthComponent::user('role'), array('admin', 'operator'))) $redirect = array('controller'=>'driver_travels', 'action'=>'view_filtered/'.DriverTravel::$SEARCH_NEW_MESSAGES);
                    else $redirect = $this->Auth->redirect();
                }
                
                return $this->redirect($redirect);
                
            } else $this->setErrorMessage(__('El usuario o la contraseña son inválidos. Intenta de nuevo.'));
        }
        if ($this->Auth->loggedIn() || $this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    private function do_login() {
        if ($this->Auth->login()) {
            $this->_setCookie($this->Auth->user('id'));
            
            $lang = Configure::read('Config.language');
            if($lang != null) {
                $this->User->id = AuthComponent::user('id');
                $this->User->saveField('lang', $lang);
            }
            
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
                $this->setErrorMessage(__('Este correo electrónico ya está registrado en <em>YoTeLlevo</em>. Escribe una dirección diferente o <a href="%s">entra con tu cuenta</a>', Router::url(array('action'=>'login'))));// TODO: esta direccion estatica es un hack
                return $this->redirect($this->referer());
            }

            $this->request->data['User']['role'] = 'regular';
            $this->request->data['User']['active'] = true;
            $this->request->data['User']['registered_from_ip'] = $this->request->clientIp();
            $this->request->data['User']['register_type'] = 'register_form';
            
            $datasource = $this->User->getDataSource();
            $datasource->begin();
            
            $OK = $this->do_register($this->request->data['User'], /*'welcome'*/'welcome_new');
                
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
                $this->setErrorMessage(__('Este correo electrónico ya está registrado en <em>YoTeLlevo</em>. Escribe una dirección diferente o <a href="%s">entra con tu cuenta</a>', Router::url(array('action'=>'login'))));// TODO: esta direccion estatica es un hack
                return $this->redirect($this->referer());
            }

            $this->request->data['User']['role'] = 'regular';
            $this->request->data['User']['active'] = true;
            $this->request->data['User']['registered_from_ip'] = $this->request->clientIp();
            $this->request->data['User']['register_type'] = 'pending_travel_register_form';
            
            $datasource = $this->User->getDataSource();
            $datasource->begin();
            
            $result = array();
            
            $OK = $this->do_register($this->request->data['User'], /*'welcome_with_travel'*/'welcome_new');
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
        $this->set('users', $this->User->find('all'));
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
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
                $this->setInfoMessage('El usuario se guardó exitosamente.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->setInfoMessage('Ocurrió un error guardando el usuario.');
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) throw new NotFoundException(__('Invalid user.'));
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(strlen($this->request->data['User']['password']) == 0) unset ($this->request->data['User']['password']);
            
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('El usuario se guardó exitosamente');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Ocurrió un error guardando el usuario.');
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
            throw new NotFoundException('Invalid user');
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('User deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('User was not deleted');
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
        
        $code = $this->UserInteraction->getInteractionCode($user['id'], UserInteraction::$INTERACTION_TYPE_CONFIRM_EMAIL);
        $OK = $code != null;
        
        if($OK) {
            if(Configure::read('enqueue_mail')) {
                ClassRegistry::init('EmailQueue.EmailQueue')->enqueue(
                        $user['username'], 
                        array('confirmation_code' => $code), 
                        array(
                            'template'=>$emailTemplate,
                            'format'=>'html',
                            'subject'=>__d('user_email', 'Que encuentres un buen chofer en Cuba'/*'Bienvenido - Confirma tu cuenta'*/).'!',
                            'config'=>/*'no_responder'*/'super',
                            'lang'=>  Configure::read('Config.language')));
            } else {
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
        } 
        
        return $OK;
    }
    
    public function confirm_email($token) {
        
        $datasource = $this->User->getDataSource();
        $datasource->begin();
        
        $interaction = $this->UserInteraction->getUnexpiredInteraction($token, UserInteraction::$INTERACTION_TYPE_CONFIRM_EMAIL);
        
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
            
            $datasource = $this->User->getDataSource();
            $datasource->begin();
            
            $code = $this->UserInteraction->getInteractionCode($user['User']['id'], UserInteraction::$INTERACTION_TYPE_CHANGE_PASSWORD);
            $OK = $code != null;

            if($OK) {
                // Send email and redirect to a welcome page
                $Email = new CakeEmail('no_responder');
                $Email->template('change_password')
                ->viewVars(array('confirmation_code' => $code))
                ->emailFormat('html')
                ->to($user['User']['username'])
                ->subject(__('Cambio de contraseña'));
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
    
    public function change_password($token) {
        $interaction = $this->UserInteraction->getUnexpiredInteraction($token, UserInteraction::$INTERACTION_TYPE_CHANGE_PASSWORD);
        
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
            
            $this->set('code', $token);
        }
    } 
    
    
       
    
    
    
    /**
     * ADMINS
     */
    public function view_travels($userId) {
        $this->set('user', $this->User->findById($userId));
        
        Travel::prepareFullConversations($this);
        $this->set('travels', $this->Travel->find('all', array('conditions'=>array('user_id'=>$userId))));
        $this->set('drivers', $this->Driver->getAsSuggestions()); // Esto es para notificar a otros choferes
    }
    
    public function admin($userId) {
        $this->set('user', $this->User->findById($userId));
        $this->set('interactions', $this->UserInteraction->find('all', array('conditions'=>array('UserInteraction.user_id'=>$userId))));        
    }
}

?>