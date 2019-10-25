<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('DriverTravel', 'Model');
App::uses('StringsUtil', 'Util');
App::uses('EmailsUtil', 'Util');
App::uses('MessagesUtil', 'Util');

class UsersController extends AppController {
    
    public $uses = array('User', 'UserInteraction', 'Travel', 'DriverTravel', 'Locality', 'Driver', 'Operations.OpActionRule', 'DriverTravelerConversation');
    
    public $components = array('TravelLogic', 'DirectMessages','LocalityRouter', 'Paginator');
    

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow( array('confirm_email', 'change_password', 'contact_driver', 'welcome') );
        
        if($this->Auth->loggedIn()) {
            $this->Auth->allow('logout', 'send_confirm_email', 'unsubscribe', 'register_welcome');
            
            if($this->justLoggedIn) $this->Auth->allow('login'); // la accion login se activa una sola vez por si el usuario se esta logueando (ver AppController)
            
        } else $this->Auth->allow('login', 'register', 'welcome', 'register_and_create', 'forgot_password', 'send_change_password');
    }

    public function isAuthorized($user) {
        if(in_array($this->action, array('add', 'edit', 'remove')) && $this->Auth->user('role') != 'admin') return false; // Solo los admin pueden hacer esto
        
        if(in_array($this->action, array('password_changed', 'profile'))) { // Allow these actions for the logged-in user
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
                    $parts = split('/', $redirect, 3);
                    $redirect = array('action'=>'index');
                    $redirect['controller'] = $parts[1];
                    if(isset ($parts[2]) && $parts[2] != null) $redirect['action'] = $parts[2];
                    
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
            // NEW: Recordar por defecto
            $this->request->data['User']['remember_me'] = true;
            
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
            
            if( $this->do_register($this->request->data['User'], 'welcome_new', 'register_form') ){
                if($this->do_login()) return $this->render('register_welcome');        
            }    
            else $this->setErrorMessage(__('Ocurrió un error registrando su usuario. Intente de nuevo.'));
        }
    } 
    
    public function register_and_create() {
           
        if ($this->request->is('post')) {
            
            $closest = $this->LocalityRouter->getMatch($this->request->data['Travel']['origin'], $this->request->data['Travel']['destination']);
            if($closest != null && !empty ($closest)) {
                if( isset($closest['origin']) )       $this->request->data['Travel']['origin_locality_id']      = $closest['origin']['locality_id'];			
		if( isset($closest['destination']) )  $this->request->data['Travel']['destination_locality_id'] = $closest['destination']['locality_id'];
		$this->request->data['Travel']['direction'] = 2; //$closest['direction'];     // meaningless from now on
                $this->request->data['Travel']['state'] = Travel::$STATE_UNCONFIRMED;
                                           
            } else {
                CakeLog::write('travels_failed', 'Travel Failed (OLD add_pending) - Unknown origin and destination: '.$this->request->data['Travel']['origin'].' - '.$this->request->data['Travel']['destination']);
                CakeLog::write('travels_failed', 'Created by: '.$this->request->data['Travel']['email']);
                CakeLog::write('travels_failed', "<span style='color:blue'>---------------------------------------------------------------------------------------------------------</span>\n\n");
                $this->setErrorMessage(__('El origen y el destino del viaje no son reconocidos.'));
                $this->redirect($this->referer().'#'.__d('mobirise/default', 'solicitar'));
            }
            
                        
            if($this->User->loginExists($this->request->data['Travel']['email'])) {
                $this->setErrorMessage(__('Este correo electrónico ya está registrado en <em>YoTeLlevo</em>. Escribe una dirección diferente o <a href="%s">entra con tu cuenta</a>', Router::url(array('action'=>'login'))));// TODO: esta direccion estatica es un hack
                return $this->redirect($this->referer());
            }
            
            $datasource = $this->User->getDataSource();
            $datasource->begin();
            
            $result = array('success' => true);
            $this->request->data['User']= array('username'=>$this->request->data['Travel']['email'],'password'=> StringsUtil::getWeirdString()); 
            if( $this->do_register($this->request->data['User'], 'welcome_new', 'pending_travel_register_form') ){
                $result = $this->TravelLogic->confirmPendingTravel($this->request->data['Travel'],$this->request->data['User']['id']);
            
                if($result['success']){
                    $datasource->commit();
                    if($this->do_login()) {
                        // BIENVENIDA: Aquí la bienvenida a un usuario nuevo
                        return $this->redirect(array('action'=>'welcome', $result['travel']['Travel']['id']));
                    }
                } else {
                    /**
                     * Hack: Al guardarse el viaje antes de confirmarlo, se ejecuta el afterSave() de Travel. Esto incrementa la variable travel_count de la sesion.
                     * Si la transaccion falla, hay que decrementar esa variable nuevamente.
                     * TODO: existira un metodo mas o menos como afterSaveFail() en los modelos???
                     */
                    CakeSession::delete('Auth.User');
                }
            } else{
                $result['success'] = false;
                $result['message'] = 'Ocurrió un error registrando tu usuario. Intenta nuevamente.';
            }
            
            if(!$result['success']) {
                $datasource->rollback();
                $this->setErrorMessage(__($result['message']));
                $this->redirect($this->referer()/*array('controller'=>'travels', 'action'=>'view_pending/'.$pendingTravelId)*/);
            }
            
        }      
       
    }
    
    public function welcome($travelId = null /*El id de la solicitud que se acaba de crear*/) {
        $travel = $this->Travel->findById($travelId);
        
        if($travel == null || empty($travel)) throw new NotFoundException();
        
        $this->layout = 'transition';
        $this->set(compact('travel'));
    }
    
    private function do_register(&$user, $emailTemplate, $register_type) {
        $datasource = $this->User->getDataSource();
        $datasource->begin();        
        
        $user['role'] = 'regular';
        $user['active'] = true;
        $user['lang'] = Configure::read('Config.language');
        $user['registered_from_ip'] = $this->request->clientIp();
        $user['register_type'] = $register_type;    
        
        if( $this->User->save($user) ){
            $user['id'] = $this->User->getLastInsertID();
            if( $this->do_send_confirm_email($user, $emailTemplate) ){
                $datasource->commit();
                return true;
            }
            $datasource->rollback();
            return false;
        }
        
        $datasource->rollback();
        return false;
    }
    
    public function profile() {
        if ($this->request->is('post')|| $this->request->is('put')) {
            $user = $this->request->data;
            
            if(strlen($user['User']['password']) == 0) unset ($user['User']['password']);
            if(strlen($user['User']['username']) == 0) {
                $u = $this->Auth->user();
                $this->request->data['User']['username'] = $user['User']['username'] = $u['username'];
            }else{
                $this->Session->write('Auth.User.username', $user['User']['username']);
            }
              
            $userEmailChanged = (strlen(trim($user['User']['username'])) > 0 && strcmp($this->request->data['User']['username'], $this->request->data['User']['old_username'])!=0) ?true:false;
            if($this->User->save($user)) {                
                //$this->Session->write('Auth.User', $user['User']);
                $this->Session->write('Auth.User.display_name', $user['User']['display_name']);
                //if(isset ($user['User']['password']))$this->Session->write('Auth.User.display_name', $user['User']['password']);
                //sending the email for user change and converstions summary
                if($userEmailChanged) {                    
                    $this->DriverTravel->recursive = 3;
                    $today = date('Y-m-d', strtotime('today')); 
                    $travels = $this->DriverTravel->find('all',array('conditions'=>array('DriverTravel.user_id'=>$user['User']['id'],'DriverTravel.travel_date >'=>$today,'DriverTravel.message_count >'=>0))); 
                    //die(print_r($travels[0]['Driver']));
                    if(sizeof($travels) > 0) {
                        EmailsUtil::email(
                            $user['User']['username'], 
                            __d($user['User']['display_name'], 'Cambio de correo de contacto con YoTeLlevoCuba').'!',array('data'=>$travels, 'user_name'=>$user['User']['username']),
                            'no_responder', 
                            'user_new_email_travel_list', 
                            array('lang'=>$this->Session->read('Auth.User.lang')));
                   } else {
                        EmailsUtil::email(
                            $user['User']['username'], 
                            __d($user['User']['display_name'], 'Cambio de correo de contacto con YoTeLlevoCuba').'!',array('user_email'=>$user['User']['username']),
                            'no_responder', 
                            'user_new_email_notification', 
                            array('lang'=>$this->Session->read('Auth.User.lang')));  
                   }
                }
                $this->setSuccessMessage('Tu nueva información ha sido guardada');
            } else {                
                $this->setErrorMessage('Ocurrió un problema guardando la información. Intenta de nuevo.');
            }        
        }else{
            $this->request->data['User'] = $this->Auth->user();
        }
    }
    
    public function operations() {
        // Buscar las reglas que otros operadores me permiten
        $this->set('op_rules_others_allow', $this->OpActionRule->find('all',
                array('conditions'=>
                    array('op_other'=>AuthComponent::user('id'),
                          'allowed_by_owner'=>true)
                )));
        
        // Buscar las reglas que yo le permito a otros operadores
        $this->set('op_rules_own', $this->OpActionRule->find('all',
                array('conditions'=>
                    array('op_owner'=>AuthComponent::user('id'))
                )));
    }
    
    public function index() {
        $this->paginate = array('order'=>array('User.created'=>'DESC'), 'limit'=>500); // Los ultimos 500 usuarios
        $users = $this->paginate();
        $this->set('users', $users);
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
                $this->setInfoMessage('El usuario se guardó exitosamente');
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
            $OK = EmailsUtil::email(
                    $user['username'], 
                    __d('user_email', 'Bienvenid@, que encuentre un buen chofer en Cuba').'!', 
                    array('confirmation_code' => $code),
                    'no_responder', 
                    $emailTemplate, 
                    array('lang'=>$user['lang'], 'enqueue'=>false));
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
                $this->setErrorMessage(__('Este correo no pertenece a ningún usuario.'));
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
                        
                        $this->setInfoMessage(__('Su contraseña fue cambiada exitosamente.'));
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
    
    
    public function contact_driver($new = false){
        
        // Si el usuario esta logueado, simplemente mandar el mensaje y continuar
        if($this->Auth->loggedIn()){
            $conversation = array('DriverTravel' => $this->request->data['DriverTravel']);
            
            /* Si es un descuento hay que pasar los datos en el mensaje */
            if($conversation['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST) {
                $this->loadModel('DiscountRide');
                $discount = $this->DiscountRide->findFullById($conversation['DriverTravel']['discount_id']);
                $conversation['DiscountRide'] = $discount['DiscountRide'];
            }
            
            $message = $this->request->data['DriverTravelerConversation']['response_text'];
            
            $conversationIsExpired = isset($this->request->data['closed']);
            if($conversationIsExpired) {
                $super = $this->request->data['closed'];
                $result = $this->DirectMessages->send_message($conversation, $message, $super);
            } else
               $result = $this->DirectMessages->send_message($conversation, $message);  
            
            if($result['success']){
                
                // BIENVENIDA: Aquí la bienvenida a un usuario nuevo
                if($new) return $this->redirect (array('action' => 'register_welcome', $result['conversation_id']));
                
                $this->setInfoMessage($result['message']);
                return $this->redirect( array('controller' => 'conversations', 'action'=>'messages', $result['conversation_id']) );
            }
            else $this->setErrorMessage ($result['message']);
        }
        
        // Si no está logueado, pero el usuario existe, intentar loguearse con la contraseña y mandar el mensaje
        else if( $this->User->loginExists( $this->request->data['User']['username'] ) ){
            if( $this->do_login() )  return $this->contact_driver ();
            else $this->setErrorMessage( __('Verifique su contraseña e intente nuevamente.') );
        }
        
        // Si es un nuevo usuario, registrarlo, loguearlo, mandar la bienvenida y enviar el mensaje
        else {
            //we create the password for the new user
            $this->request->data['User']['password'] = StringsUtil::getWeirdString();
            if( $this->do_register($this->request->data['User'], 'welcome_new', 'driver_profile_msg_form') && $this->do_login() ) {
                EmailsUtil::email(
                    $this->request->data['User']['username'], 
                    __d('user_email', 'Hola, soy su asistente de YoTeLlevo'), 
                    array(),
                    'customer_assistant', 
                    'welcome_operator_general',
                    array('lang'=>$this->request->data['User']['lang']));

                return $this->contact_driver (true);
            
            }else {
                $this->setErrorMessage( __('Ocurrió un error registrando su usuario. Intente de nuevo.') );
            }
        }   
        
        return $this->redirect( $this->referer().'#'.__d('mobirise/default', 'solicitar') );
        //El redirect hace que se pierdan los datos del formulario... podria usar un query para volverlos a setear y luego enfocar el formulario
    }
    
    // Este metodo se adiciono para evitar que se creara un nuevo mensaje directo al recargar la pagina luego de un contact_driver using $this->render('register_welcome'); 
    public function register_welcome($conversation_id){
        DriverTravel::prepare_direct_message($this);
        $data = $this->DriverTravel->find('first', array('conditions' => array('DriverTravel.id' => $conversation_id)));
        if(!$data)   throw new NotFoundException( __('ConversaciÃ³n no vÃ¡lida') );
        
        if($this->Auth->user('id') != $data['User']['id'])
            throw new ForbiddenException();

        $this->set('conversation', $data);
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
    
    public function search_travels_by_username() {
        if(!empty ($this->request->query)) {
            $user = $this->User->findByUsername($this->request->query['username']);
            
            if($user == null || (is_array($user) && empty ($user))) throw new NotFoundException ('Este correo no corresponde a ningún usuario');

            $this->setInfoMessage('Estos son los viajes del usuario que coincide con tu búsqueda');
            return $this->redirect(array('action'=>'view_travels/'.$user['User']['id'].'?ref=search'));
        } else throw new MethodNotAllowedException ();
        
        
    }
    
    
    
}

?>