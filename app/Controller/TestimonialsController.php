<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('EmailsUtil', 'Util');
App::uses('StringsUtil', 'Util');

class TestimonialsController extends AppController {

    public $components = array('Paginator');
    public $uses = array('Testimonial', 'DriverTravel', 'Driver', 'TravelConversationMeta', 'DriverProfile', 'User');
    
    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('enter_code', 'featured');
        if (isset($this->request->params['pass']['0'])) {
            if ($this->request->params['action'] == 'add') {
                if (!isset($this->request->params['pass']['1']))
                    $this->Auth->allow('add');
                else
                    $driver_travel_id = $this->request->params['pass']['1'];
            }
            else if (in_array($this->request->params['action'], array('edit', 'preview'))) {
                $testimonial_id = $this->request->params['pass']['0'];
                $testimonial_data = $this->Testimonial->findById($testimonial_id);
                if (!isset($testimonial_data['DriverTravel']['id']))                //externo
                    $this->Auth->allow('preview');
                else
                    $driver_travel_id = $testimonial_data['DriverTravel']['id'];
            }

            if (isset($driver_travel_id)) {
                $driver_travel_data = $this->DriverTravel->findById($driver_travel_id);

                $user_real = isset($driver_travel_data['Travel']['user_id']) ? $driver_travel_data['Travel']['user_id'] : null;
                if ($this->Auth->loggedIn() || $this->Auth->login())
                    $user_requesting = AuthComponent::user('id');

                if ($user_requesting == $user_real)
                    $this->Auth->allow('add', 'edit', 'preview');
            }
        }
    }
    
    public function isAuthorized($user){
        if($this->request->action == 'edit') return false;

        if($user['role'] =='operator' && in_array($this->action, array('view_filtered', 'index', 'preview', 'state_change', 'lang_change', 'admin', 'request_testimonial'))) 
            return true;

        //nadie puede annadir testimonios internos [a menos que se le haya permitido en el beforeFilter] -> [solo si es el usuario del viaje]
        if($this->request->action == 'add' && isset($this->request->params['pass']['1']))
            return false;

        return parent::isAuthorized($user);
    }

    public function index() {
        $this->redirect(array('action' => 'view_filtered/pending'));
    }
    
    public function featured() {
        $this->paginate = array('order'=>array('Testimonial.created'=>'DESC'), 'limit'=>20);
        $this->set('testimonials', $this->paginate(array('featured'=>true)));
    }

    public function view_filtered($filtro = 'pending') {
        $this->Testimonial->recursive = 3;
        $this->DriverTravel->unbindModel(array('hasOne' => array('TravelConversationMeta')));
        $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));

        $conditions = array();
        if ($filtro != 'all')
            $conditions = array('Testimonial.state =' => Testimonial::$statesValues[$filtro]);

        $this->Paginator->settings = array('limit' => 50);
        $testimonials = $this->Paginator->paginate('Testimonial', $conditions);

        $this->set('testimonials', $testimonials);
        $this->set('filter_applied', $filtro);

        $this->render('all');
    }

    public function add($driver_code, $conversation_id = null) {
        $driver_code = strtolower($driver_code); // El codigo siempre va a estar en lowercase en la BD. Ver DriversController::edit_profile
        
        // Buscar el perfil por el codigo del chofer
        $dp_data = $this->DriverProfile->findByDriverCode($driver_code);
        
        if (!$dp_data) // Si no se encuentra el perfil entonces el codigo esta mal
            throw new NotFoundException(__d('testimonials', 'No se encontró un chofer con este código. Revíselo e intente de nuevo.'));

        // Verificaciones si se pasa la conversacion
        if ($conversation_id != NULL) {
            $dt_data = $this->DriverTravel->findById($conversation_id);
            if (!$dt_data)
                throw new NotFoundException(__('No existe la Conversación solicitada.'));

            if ($dt_data['DriverTravel']['driver_id'] != $dp_data['DriverProfile']['driver_id'])
                throw new BadRequestException(__('La conversación no corresponde al chofer solicitado'));
            
            $user = $this->User->findById($dt_data['Travel']['user_id']);
        }

        if ($this->request->is('post')) {
            $datasource = $this->Testimonial->getDataSource();
            $datasource->begin();
            
            $this->Testimonial->create();

            $this->request->data['Testimonial']['driver_travel_id'] = $conversation_id;
            $this->request->data['Testimonial']['driver_id'] = $dp_data['DriverProfile']['driver_id'];
            $this->request->data['Testimonial']['validation_token'] = StringsUtil::getWeirdString();
            if( isset($user['User']['username']) )
                $this->request->data['Testimonial']['email'] = $user['User']['username'];
            
            $OK = $this->Testimonial->save($this->request->data);
            if($OK) {
                $tid = $this->Testimonial->id;
                $OK = $this->_sendAdminMail($tid);
                if(!$OK) CakeLog::write('testimonial_errors', "Error al enviar mensaje de nuevo testimonio $tid al admin");
                
                //if( $this->_sendVerificationMail($tid) )
                    $datasource->commit();
                /*else{    
                    $datasource->rollback();
                    $this->setErrorMessage( __d('testimonials', 'Error al enviar mensaje de verificación') );
                }  */
                
                return $this->redirect(array('action' => 'preview', $tid));
            } else {
                $datasource->rollback();
                $this->setErrorMessage( __d('testimonials', 'Ocurrió un error al intentar guardar el testimonio.') );
            }
            
        } else {
            if ($conversation_id != NULL) {
                $data = $this->Testimonial->findByConversationId($conversation_id);  //debe devolver solo 1 registro aunque no este modelado asi en la bd
                if (isset($data['Testimonial']['id']))
                    return $this->redirect(array('action' => 'edit', $data['Testimonial']['id']));
            }

            $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
            $data = $this->Driver->findById($dp_data['DriverProfile']['driver_id']);
            $this->set('driver', $data['Driver']);
            $this->set('driver_profile', $data['DriverProfile']);
            $this->set('external', ($conversation_id == NULL));
        }
    }

    public function edit($id) {
        $testimonial = $this->Testimonial->findById($id);
        if (!$testimonial)
            throw new NotFoundException( __d('testimonials', 'El Testimonio solicitado no existe') );

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Testimonial->id = $id;
            $this->request->state = Testimonial::$statesValues['pending'];


            if ($this->Testimonial->save($this->request->data)) {
                return $this->redirect(array('action' => 'preview', $id));
            }
            $this->setErrorMessage( __d('testimonials', 'Ocurrió un error al intentar guardar el testimonio.') );
        }

        if (!$this->request->data)
            $this->request->data = $testimonial;

        $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
        $data = $this->Driver->findById($testimonial['Testimonial']['driver_id']);
        $this->set('driver', $data['Driver']);
        $this->set('driver_profile', $data['DriverProfile']);
    }

    public function preview($id) {
        $this->Driver->attachProfile($this->Testimonial);
        $data = $this->Testimonial->findById($id);
        if (!$data)
            throw new NotFoundException(__d('testimonials', 'No existe el testimonio solicitado'));

        $this->set('data', $data);
    }
    
    public function set_featured($id) {
        $OK = $this->change_field($id, 'featured', true);
        
        //if(!$OK)
        
        $this->redirect($this->referer().'#testimonial'.$id);
    }
    
    public function unset_featured($id) {
        $OK = $this->change_field($id, 'featured', false);
        
        //if(!$OK)
        
        $this->redirect($this->referer().'#testimonial'.$id);
    }
    
    private function change_field($testimonialId, $field, $value) {
        $this->Testimonial->id = $testimonialId;
        if(!$this->Testimonial->exists()) throw new NotFoundException ();
        
        return $this->Testimonial->save(array('Testimonial'=>array($field=>$value, 'modified'=>false)));
    }

    public function state_change($id, $state, $action = 'admin') {
        $data = $this->Testimonial->findById($id);
        if (!$data)
            throw new NotFoundException('No existe el testimonio solicitado');

        if (!in_array($state, Testimonial::$statesValues))
            throw new NotFoundException('El estado no es válido');

        $save_data = array('id' => $id, 'state' => $state, 'modified' => false);
        if ($this->Testimonial->save($save_data)) {
            $state_str = Testimonial::$states[$state];
            if ($action == 'admin')
                return $this->redirect(array('action' => "admin/$id"));
            else
                return $this->redirect(array('action' => "view_filtered/$state_str#testimonial$id"));
        }
        $this->setErrorMessage('No se pudo cambiar el estado');
    }

    public function lang_change($id, $lang, $action = 'admin') {
        $data = $this->Testimonial->findById($id);
        if (!$data)
            throw new NotFoundException('No existe el testimonio solicitado');

        if (!in_array($lang, Testimonial::$langs))
            throw new NotFoundException('El idioma no es válido');

        $save_data = array('id' => $id, 'lang' => $lang, 'modified' => false);
        if ($this->Testimonial->save($save_data)) {
            $state_str = Testimonial::$states[$data['Testimonial']['state']];
            if ($action == 'admin')
                return $this->redirect(array('action' => "admin/$id"));
            else
                return $this->redirect(array('action' => "view_filtered/$state_str#testimonial$id"));
        }
        $this->setErrorMessage('No se pudo cambiar el idioma');
    }

    public function delete($id) {
        if (!$this->request->is('get'))
            throw new MethodNotAllowedException();

        if ($this->Testimonial->delete($id))
            return $this->redirect(array('action' => 'index'));
    }

    private function _sendAdminMail($id) {
        $this->Testimonial->recursive = 3;
        $this->DriverTravel->unbindModel(array('hasOne' => array('TravelConversationMeta')));
        $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
        $this->Driver->unbindModel(array('belongsTo' => array('Province')));
        $data = $this->Testimonial->findById($id);

        $vars = array('testimonial' => $data['Testimonial'], 'driver' => $data['Driver']);
        /*if (isset($data['Driver']['DriverProfile']['avatar_filepath'])) {
            $vars = array_merge($vars, array('driver_profile' => $data['Driver']['DriverProfile']));
        }*/ 

        if (isset($data['DriverTravel']['Travel']))
            $vars = array_merge($vars, array('travel' => $data['DriverTravel']['Travel'], 'user' => $data['DriverTravel']['Travel']['User']));
        
        $to = 'martin@yotellevocuba.com'/*Configure::read('superadmin_email')*/;//TODO: Poner el superadmin_email para martin@...
        $subject = 'Nuevo testimonio';
        if(isset ($data['Driver']['DriverProfile'])) $subject .= ' sobre '.$data['Driver']['DriverProfile']['driver_name'];

        return EmailsUtil::email($to, $subject, $vars, 'no_responder', 'testimonial_new');
    }
    
    private function _sendVerificationMail($id) {
        $data = $this->Testimonial->findById($id);
        $vars['Testimonial'] = $data['Testimonial'];
        
        return EmailsUtil::email($data['Testimonial']['email'], __d('testimonial', 'Sobre YoTeLlevo'), $vars, 'no_responder', 'testimonial_verify');
    }

    public function admin($id) {
        $data = $this->Testimonial->findById($id);
        if (!$data)
            throw new NotFoundException('No existe el testimonio solicitado');

        $this->set('testimonial', $data['Testimonial']);
    }

    public function request_testimonial($driver_travel_id) {
        $this->DriverTravel->recursive = 2;
        $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
        $data = $this->DriverTravel->findById($driver_travel_id);
        if (!$data)
            throw new NotFoundException('Conversación inválida.');

        $vars['data'] = $data;

        $datasource = $this->TravelConversationMeta->getDataSource();
        $datasource->begin();

        $to = $data['Travel']['User']['username'];
        $subject = __d('testimonials', 'Prueba de calidad del servicio #') . $data['Travel']['id'] . ' [[' . $driver_travel_id . ']]';
        $OK = EmailsUtil::email($to, $subject, $vars, 'verificacion_viaje', 'request_testimonial');
        if ($OK) {
            $this->TravelConversationMeta->id = $driver_travel_id;
            $OK = $this->TravelConversationMeta->saveField('testimonial_requested', true);
        }

        if ($OK) $datasource->commit(); 
        else $datasource->rollback();
        
        return $this->redirect($this->referer() . '#testimonial_addon');
    }

    public function enter_code() {
        if ($this->request->is('post')) {
            $driver_code = $this->request->data['Testimonial']['driver_code'];
            if (!$driver_code)
                return;

            $driver_code = strtolower($driver_code); // El codigo siempre va a estar en lowercase en la BD. Ver DriversController::edit_profile
            $driver = $this->DriverProfile->findByDriverCode($driver_code);
            if (!$driver) {
                // TODO: Mostrar una respuesta elegante donde se ayude al usuario
                $this->setErrorMessage(__d('testimonials', 'No se encontró un chofer con este código. Revíselo e intente de nuevo.'));
            } else{
                $this->DriverProfile->id = $driver['DriverProfile']['id'];
                $attempts = $driver['DriverProfile']['testimonial_attempts'] + 1;
                if( !$this->DriverProfile->saveField('testimonial_attempts', $attempts) )
                    CakeLog::write('testimonial_errors', "Error al actualizar 'testimonial_attempts', driver_code = $driver_code, attempt = $attempts"); 

                $this->redirect( array('action' => 'add', $driver_code) );
            }
        }
    }
    
    public function verify($token) {
        $data = $this->Testimonial->findByValidationToken($token);
        if(!$data)
           throw new NotFoundException( __d('testimonials', 'El token para la validación es incorrecto') );
        
        $this->Testimonial->id = $data['Testimonial']['id'];
        if( $this->Testimonial->saveField('validated', true) ){
            $this->setSuccessMessage( __d('testimonials', 'Su comentario ha sido validado') );
        }
        else $this->setErrorMessage( __d('testimonials', 'Ha ocurrido un error al salvar los datos') );
    }
}

?>
