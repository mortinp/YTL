<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    public $uses = array('Locality', 'Testimonial', 'Driver');
    
    public $components = array('Paginator');

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     * 	or MissingViewException in debug mode.
     */
    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        
        if($page === 'home' || $page === 'welcome') {
            $this->layout = 'home';
            $this->set('localities', $this->Locality->getAsSuggestions());
            
            // Esta es una variable que indica que el visitor ya fue introducido a nuestra plataforma, por lo cual se asume que ya conoce de que trata
            // Se usa por ejemplo en el perfil de los choferes
            $this->Session->write('introduced-in-website', true);
            
        } else if($page === 'catalog-drivers-cuba') {
            
            $this->Testimonial->recursive = 2;
        
            $this->Driver->unbindModel(array('belongsTo' => array('Province')));
            $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));

            $this->paginate = array('order'=>array('Testimonial.created'=>'DESC'), 'limit'=>20);
            $this->Paginator->settings = $this->paginate;
            
            $langs = array(Configure::read('Config.language'));
            if(isset($this->request->query['also']) && Configure::read('Config.language') != $this->request->query['also']) {
                $langs[] = $this->request->query['also'];
            }
            
            $conditions =  array('featured'=>true, 'lang'=>$langs);
            
            $this->set('testimonials', $this->Paginator->paginate('Testimonial', $conditions));
            
            // Esta es una variable que indica que el visitor ya fue introducido a nuestra plataforma, por lo cual se asume que ya conoce de que trata
            // Se usa por ejemplo en el perfil de los choferes
            $this->Session->write('introduced-in-website', true);
            
            $this->layout = 'catalog';
            
        } else if($page === 'testimonials') {
            return $this->redirect(array('controller'=>'testimonials', 'action'=>'featured'));
        }

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();
        
        if($this->Auth->loggedIn()) {
            if($this->request->params['pass'][0] === 'home') {
                $this->Auth->deny('display');
            }   
        } else {
            // Try to authenticate
            if ($this->Auth->login()) {
                $this->setInfoMessage('Has entrado a <em>YoTeLlevo</em> con el usuario <b>'.$this->Auth->user('username').'</b>');
                if(AuthComponent::user('role') === 'admin') return $this->redirect(array('action'=>'index'));
                return $this->redirect($this->Auth->redirect());
            }
        }
    }

}
