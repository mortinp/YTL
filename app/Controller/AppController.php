<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

App::uses('User', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $uses = array('Dummy');
    
    public $helpers = array(
        'Html' => array(
            'className' => 'EnhancedHtml'
        ), 
        'Form' => array(
            'className' => 'BootstrapForm'
        ),
        'Session', 
        'Js');
    
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'conversations'),
            'logoutRedirect' => '/',
            'authorize' => array('Controller'),
            
            // Este mensaje de error hay que tenerlo traducido en default.po, porque la traducción la usa el AuthComponent -le hice una modificacion al AuthComponent de CakePHP para esto
            'authError' => '<div class="alert alert-danger alert-dismissable" style="text-align: center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No tienes permisos para visitar esa página.</div>'
        ),
        'Cookie'
    );

    public function beforeFilter() {
        // Cookie login
        $this->Auth->authenticate = array(
            'Cookie' => array(
                'fields' => array(
                    'username' => 'username',
                    'password' => 'password'
                ),
                'userModel' => 'User',
            ),
            'Form'
        );
        
        // Allow all static pages
        $this->Auth->allow('display', 'setlang');
        
        // Permitir una acción cuando se haya decidido que se permita (ej. las invitaciones deben permitir acceder a una url prohibida por defecto)
        if($this->Session->read('allowed_action') != null)
            $this->Auth->allow($this->Session->read('allowed_action'));
        
        //$this->_setupLanguage();
        $this->_setLanguage();
        //si el idioma no está en la url => redirecciono a la url equivalente con el idioma
        if( empty($this->params['language']) ){
            $lang = $this->Session->read('Config.language');
            $url             = $this->request['pass'];
            $url             = array_merge($url, $this->request['named']);
            $url['?']        = $this->request->query;
            $url['language'] = $lang;
            
            return $this->redirect($url, 301);
        }
        
        $this->_setPageTitle();
        $this->_setUserCredentials();
    }
    
    public function beforeRender() {
        parent::beforeRender();
        
        // Si no hay tema configurado, no hacer nada
        if(Configure::read('App.theme') == null) return;
        
        //
        $applyThemeIn = array(
            array('controller'=>'users', 'action'=>'welcome'),
            array('controller'=>'pages', 'action'=>'display', 'pass'=>'home', 'render'=>'home'),
            array('controller'=>'pages', 'action'=>'display', 'pass'=>'taxi-cuba', 'render'=>'taxi-cuba'),
            array('controller'=>'pages', 'action'=>'display', 'pass'=>'taxi-prices-cuba', 'render'=>'taxi-prices-cuba'),
            array('controller'=>'testimonials', 'action'=>'featured'),
            array('controller'=>'testimonials', 'action'=>'reviews'),
            array('controller'=>'testimonials', 'action'=>'reply'),
            array('controller'=>'drivers', 'action'=>'profile'),
            array('controller'=>'travels', 'action'=>'pending'),
            array('controller'=>'drivers', 'action'=>'drivers_by_province'),
            array('controller'=>'discount_rides', 'action'=>'home'),
        );
        
        $current = array('controller'=>$this->request->controller, 'action'=>$this->request->action);
        
        $matched = null;
        foreach ($applyThemeIn as $url) {
            $diff = array_diff_assoc($url, $current);
            
            $leftKeys = array_keys($diff);
            
            // Comprobar si quedaron las keys 'controller' y 'action'
            if(in_array('controller', $leftKeys) || in_array('action', $leftKeys)) continue;
            
            // Comprobar si el parametro pasado es correcto
            if(isset($url['pass']) &&  $url['pass'] != $this->request->params['pass'][0]) continue;
            
            // OK
            $matched = $url;
            break;
        }
        
        if($matched) {
            $page = $matched['action'];
            if(isset($matched['render'])) $page = $matched['render'];
            
            if(!$this->layout) $this->layout = 'default';
            $this->layout = Configure::read('App.theme').'/'.$this->layout;
            $this->viewPath = $this->viewPath.'/'.Configure::read('App.theme');
            
            Configure::write('App.cssBaseUrl', 'assets/');
            Configure::write('App.jsBaseUrl', 'assets/');
            Configure::write('App.imageBaseUrl', 'assets/images/');
        }
    }
    
    // esto no es completamente necesario solo evita el overhead que causarÃ­a redireccionarse a una url sin idioma
    // (tendrÃ­a que llegar al beforeFilter para solicitar nuevamente la url, ahora con el idioma)
    public function redirect( $url, $status = NULL, $exit = true ) {
        if( is_array($url) && $this->Session->check('Config.language') )
            $url['language'] = $this->Session->read('Config.language');
        
        parent::redirect($url,$status,$exit);
    }
    
    private function _update_language_anywhere($lang){
        $user = AuthComponent::user();
        $userLoggedIn = $user != null && !empty ($user);
        $isOtherLang = !$this->Session->check('Config.language') || $lang != $this->Session->read('Config.language'); // Si no esta iniciada la session o el lenguaje es diferente
        if( $userLoggedIn && $isOtherLang) {
            $userModel = new User();
            $userModel->id = $user['id'];
            $userModel->saveField('lang', $lang);
            // TODO: actualizar lang en Auth
        }
        
        $this->Session->write('Config.language', $lang);            //most important
        $this->Session->write('app.lang', $lang);
        $this->Cookie->write('app.lang', $lang, true, '+2 weeks');
        Configure::write('Config.language', $lang);
        
        
    }
    
    private function _setLanguage() {
        //if Config.language has not been set, initialize it using the value from the Cookie if there exists or default lang detected from browser
        if( !$this->Session->check('Config.language') ){
            $lang = ( $this->Cookie->read('app.lang') ) ? $this->Cookie->read('app.lang') : Configure::read('Config.language');
            $this->_update_language_anywhere($lang);
        } else {
            $this->_update_language_anywhere($this->Session->read('Config.language'));
        }
        
        //if language come in URL and is different from Config.language, take it from URL
        if ( isset($this->params['language']) && ($this->params['language'] != $this->Session->read('Config.language')))
            $this->_update_language_anywhere($this->params['language']);
    }
    
    public function afterFilter() {
        $this->Session->write('next.page.lang', null);
        
        /**
         * Lo siguiente hace que cuando el usuario visita algunas paginas, se ponga una variable en la session que indica que
         * el usuario ya fue introducido a lo que hace YoTeLlevo.
         * Esto se usa para en algunas paginas no mostrar algunas informaciones, etc.
         */
        $is_intro_page = 
            ($this->request->controller === 'pages' && $this->request->action ==='display' && $this->request->params['pass'][0] === 'home') ||
            ($this->request->controller === 'pages' && $this->request->action ==='display' && $this->request->params['pass'][0] === 'catalog-drivers-cuba') ||
            ($this->request->controller === 'testimonials' && $this->request->action ==='featured') ||
            ($this->request->controller === 'testimonials' && $this->request->action ==='view');
        if ($is_intro_page) {
            $this->Session->write('introduced-in-website', true);
        }
    }
    
    private function _setPageTitle() {
        $defaultTitle = $this->_getPageTitle('default');        
        $page_title = $defaultTitle['title'];
        $page_description = $defaultTitle['description'];
        
        $key = $this->request->params['controller'].'.'.$this->request->params['action']; 
        $partialTitle = $this->_getPageTitle($key);
        
        if($partialTitle != null) {
            if($this->request->params['controller'] === 'pages') {
                if(isset($partialTitle[$this->request->params['pass'][0]])) {
                    $page_title = $partialTitle[$this->request->params['pass'][0]]['title'];
                    if(isset ($partialTitle[$this->request->params['pass'][0]]['description'])) $page_description = $partialTitle[$this->request->params['pass'][0]]['description'];
                }
                    
            } else {
                $page_title = $partialTitle['title'];
                if(isset ($partialTitle['description'])) $page_description = $partialTitle['description'];
            }
        }
        $this->set('page_title', $page_title);
        $this->set('page_description', $page_description);
    }
    
    public function _setUserCredentials() {
        // Try to authenticate
        $this->justLoggedIn = false; // Ver mas abajo para ver que es esta variable
        if(!$this->Auth->loggedIn()) {
            
            if($this->Auth->login()) {
                // Esto es un hack para evitar redireccionamientos infinitos en el caso de los controladores que en su beforeFilter()
                // permiten acciones que dependen de si el usuario esta logueado o no.
                // Me pasaba con el /users/login, que al loguearse aquí en el AppController, ya no se permitía la accion /login y entonces se
                // redireccionaba infinitamente... esto lo evita
                $this->justLoggedIn = true; // Esta variable coge true solo una vez mientras el navegador este abierto...
                
                // El UsersController usa esta variable en su beforeFilter()
                // TODO: verificar si es necesario que otros controladores la usen
            }
        }
        
        // INITIALIZE
        $userLoggedIn = AuthComponent::user('id') ? true : false;
        $this->set('userLoggedIn', $userLoggedIn);
        
        if($userLoggedIn) {
            $user = AuthComponent::user();
            $userRole = $user['role'];
            $this->set('userRole', $userRole);
        }        
    }

    public function isAuthorized($user) {
        // admin can access every action
        if (isset($user['role']) && ($user['role'] === 'admin' || $user['role'] === 'operator')) return true;
        
        return false;
    }

    public function index() {
        
    }    
    
    private function _getPageTitle($key) {
        $pageTitles = array(
            'default' =>array('title'=>__d('meta', 'Taxi con chofer en Cuba: La Habana, Varadero, Viñales, Trinidad, Santiago de Cuba y más'), 'description'=>__d('meta', 'Descubre choferes que operan en Cuba, recibe ofertas de precio directamente de ellos y contrata al mejor para tu viaje.')),
            
            // Access to all
            'pages.display' =>array(
                'taxi-prices-cuba'=>array('title'=>__d('meta', 'Precios de taxi en Cuba. Taxi para turismo'), 'description'=>__d('meta', 'Conoce los precios para tus traslados directamente de conductores de taxi para turismo en Cuba')), 
                'taxi-cuba'=>array('title'=>__d('meta', 'Taxi con conductor en Cuba. A cualquier parte de la isla.'), 'description'=>__d('meta', 'YoTeLlevo es la mayor comunidad online de taxistas independientes en Cuba, listos para darte precios para tus traslados en la isla.')), 
                'contact'=>array('title'=>__d('meta', 'Contactar'), 'description'=>__d('meta', 'Contáctanos para cualquier pregunta o duda sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')), 
                'faq'=>array('title'=>__d('meta', 'Preguntas Frecuentes'), 'description'=>__d('meta', 'Preguntas y respuestas sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')),
                'testimonials'=>array('title'=>__d('meta', 'Testimonios de viajeros sorprendentes en Cuba'), 'description'=>__d('meta', 'Testimonios de viajeros que contrataron choferes con YoTeLlevo, Cuba')),
                'catalog-drivers-cuba'=>array('title'=>__d('meta', 'Choferes en Cuba: fotos y testimonios de viajeros'))),

            'users.login' =>array('title'=>__d('meta', 'Entrar'), 'description'=>__d('meta', 'Entra y consigue un taxi enseguida. Acuerda los detalles del viaje con tu chofer directamente')),
            'users.register' =>array('title'=>__d('meta', 'Registrarse'), 'description'=>__d('meta', 'Regístrate y consigue un taxi enseguida. Acuerda los detalles del viaje con tu chofer directamente')),
            'users.register_and_create' =>array('title'=>__d('meta', 'Bienvenida')),
            'users.register_welcome' =>array('title'=>__d('meta', 'Bienvenido')),
            
            'travels.add_pending' =>array('title'=>__d('meta', 'Crear Anuncio de Viaje')),
            'travels.view_pending' =>array('title'=>__d('meta', 'Solicitud pendiente')),
            'travels.pending' =>array('title'=>__d('meta', 'Solicitud pendiente')),
            
            'testimonials.enter_code' =>array('title'=>__d('meta', 'Deja una opinión sobre tu chofer en Cuba'), 'description'=>__d('meta', 'Opinar y reseñar sobre tu viaje en auto con chofer en Cuba')),
            'testimonials.add' =>array('title'=>__d('meta', 'Opina sobre este chofer')),
            'testimonials.preview' =>array('title'=>__d('meta', 'Gracias por tu opinión')),
            'testimonials.featured' =>array('title'=>__d('meta', 'Opiniones y reseñas sobre choferes en Cuba'), 'description'=>__d('meta', 'Mira opiniones y fotos de choferes en Cuba y solicita un viaje al que creas mejor')),
            'testimonials.reviews' =>array('title'=>__d('meta', 'Opiniones y reseñas sobre choferes de taxi en Cuba'), 'description'=>__d('meta', 'Mira opiniones y fotos de choferes en Cuba y solicita un viaje al que creas mejor')),
            'testimonials.view' =>array('title'=>__d('meta', 'Opinión sobre %driver, chofer en Cuba'), 'description'=>__d('meta', 'Comentario de %author sobre su viaje con %driver en Cuba')),
            
            'drivers.profile' =>array('title'=>__d('meta', 'Chofer en %province, Cuba: Fotos y testimonios sobre %driver')),    
            
            // Viajes compartidos
            'shared_travels.home' =>array('title'=>__d('shared_travels', 'Comparte un taxi en Cuba')),
            'shared_travels.create' =>array('title'=>__d('shared_travels', 'Comparte un taxi en Cuba')),
            'shared_travels.thanks' =>array('title'=>__d('shared_travels', 'Gracias por la solicitud')),
            'shared_travels.activate' =>array('title'=>__d('shared_travels', 'Solicitud confirmada')),
            'shared_travels.view' =>array('title'=>__d('shared_travels', 'Datos de la solicitud')),
            'shared_travels.index' =>array('title'=>__d('shared_travels', 'Compartidos')),
            'shared_travels.admin' =>array('title'=>__d('shared_travels', 'Admin Compartido')),
            
            // Users access
            'users.profile' =>array('title'=>__d('meta', 'Preferencias')),
            
            'users.change_password' =>array('title'=>__d('meta', 'Cambiar Contraseña')),
            'users.confirm_email' =>array('title'=>__d('meta', 'Confirmación de Correo')),
            'users.forgot_password' =>array('title'=>__d('meta', 'Contraseña Olvidada')),
            'users.send_change_password' =>array('title'=>__d('meta', 'Instrucciones para Cambio de Contraseña')),
            'users.send_confirm_email' =>array('title'=>__d('meta', 'Instrucciones para Verificación de Correo')),
            
            'travels.index' =>array('title'=>__d('meta', 'Solicitudes de viajes')),
            'travels.add' =>array('title'=>__d('meta', 'Crear solicitud de viaje')),
            'travels.view' =>array('title'=>__d('meta', 'Ver solicitud de viaje')),
            
            'casas.add_request' =>array('title'=>__d('meta', 'Consigue casas particulares en Cuba con la ayuda de un experto')),
            
            'driver_travels.index' =>array('title'=>__d('meta', 'Conversaciones')),
            
            'driver_traveler_conversations.messages' =>array('title'=>__d('meta', 'Mensajes con chofer')),
            
            // Admin access
            'users.index' =>array('title'=>'Usuarios'),
            'users.add' =>array('title'=>'Nuevo usuario'),           
            'users.edit' =>array('title'=>'Editar usuario'),  
            'users.view_travels' =>array('title'=>'Viajes de usuario'),
            'users.operations' =>array('title'=>'Panel de Operadores'),

            'drivers.index' =>array('title'=>'Choferes'),
            'drivers.add' =>array('title'=>'Nuevo chofer'),
            'drivers.edit' =>array('title'=>'Editar chofer'),
            'drivers.edit_profile' =>array('title'=>'Editar perfil de chofer'),
            
            'driver_travels.view_filtered' => array('title'=>'Conversaciones'),
            'travels.view_filtered' =>array('title'=>'Solicitudes'),
            'driver_traveler_conversations.view' =>array('title'=>'Mensajes en conversación'),
            
            'metrics.dashboard' =>array('title'=>'Dashboard'),
            
            'url_invitations.index' =>array('title'=>'URLs compartidas'),
            'url_invitations.add' =>array('title'=>'Compartir URL'),
            
            'email_queues.index' =>array('title'=>'Email Queue'),
            
            'travels.admin' =>array('title'=>'Administrar Viaje'),
            
            'testimonials.view_filtered' =>array('title'=>'Testimonios'),
            'testimonials.admin' =>array('title'=>'Administrar Testimonio'),
            
            'op_action_rules.index' =>array('title'=>'Reglas Operadores'),
            
            'search.index' =>array('title'=>'Búsqueda'),
            
        );
        
        if(isset ($pageTitles[$key])) return $pageTitles[$key];
        
        return null;
    }
    
    
    protected function setErrorMessage($message) {
        $this->Session->setFlash($message, 'error_message');
    }
    
    protected function setInfoMessage($message) {
        $this->Session->setFlash($message, 'info_message');
    }
    
    protected function setWarningMessage($message) {
        $this->Session->setFlash($message, 'warning_message');
    }
    
    protected function setSuccessMessage($message) {
        $this->Session->setFlash($message, 'success_message');
    }
    
    protected function _getVanityStats() {
        // STATS
        $stats = $this->Session->read('App.stats');
        if(!$stats) {
            $doneSQL = "SELECT COUNT( DISTINCT travels.id ) AS hires, SUM( travels.people_count ) AS people
                        FROM travels
                        INNER JOIN users ON travels.user_id = users.id
                        AND users.role !=  'admin'
                        AND users.role !=  'tester'
                        INNER JOIN drivers_travels ON travels.id = drivers_travels.travel_id
                        INNER JOIN travels_conversations_meta ON drivers_travels.id = travels_conversations_meta.conversation_id
                        AND (
                        travels_conversations_meta.state = 'D'
                        OR travels_conversations_meta.state = 'P'
                        )";

            $reviewsSQL = "SELECT COUNT( testimonials.id ) AS reviews
                        FROM testimonials
                        WHERE testimonials.state = 'A'";

            $done = $this->Dummy->query($doneSQL);
            $reviews = $this->Dummy->query($reviewsSQL);

            $stats = array('hires'=>$done[0][0]['hires'], 'people'=>$done[0][0]['people'], 'reviews'=>$reviews[0][0]['reviews']);
        }
        
        return $stats;
    }
}