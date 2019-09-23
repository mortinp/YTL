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

App::uses('Locality', 'Model');

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
    
    public $components = array('Paginator', 'LocalityRouter');

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
        
        $isLandingPage = in_array($page, array('home', 'taxi-prices-cuba', 'taxi-cuba') /*|| $page === 'la-habana' || $page === 'welcome' || $page === 'price-drivers-cuba'*/);
        if($isLandingPage) {
            
            $this->set('localities', Locality::getAsSuggestions());
            
            if($page === 'home') $this->layout = 'home';
            else if($page === 'taxi-prices-cuba') $this->layout = 'home_taxi_prices';
            else $this->layout = 'home';
            
            $this->set('stats', $this->_getVanityStats());
            $this->set('testimonials_sample', $this->Testimonial->getSample());
            
        } else if($page === 'catalog-drivers-cuba') {
            
            $this->Testimonial->recursive = 2;
        
            $this->Driver->unbindModel(array('belongsTo' => array('Province')));
            $this->Driver->unbindModel(array('hasAndBelongsToMany' => array('Locality')));
            
            $this->paginate = array('order'=>array('Testimonial.created'=>'DESC'), 'limit'=>20);
            $this->Paginator->settings = $this->paginate;
            
            $conditions = array();
            
            if(isset($this->request->query['in'])) {
                $match = $this->LocalityRouter->matchLocality($this->request->query['in']);
                
                $this->request->data['Search']['in'] =  $this->request->query['in'];
                
                if($match != null && !empty($match))
                    $conditions[] = "Driver.id IN (SELECT driver_id FROM drivers_localities WHERE locality_id=".$match['locality_id'].")";
            }
            
            $langs = array(Configure::read('Config.language'));
            if(isset($this->request->query['also']) && Configure::read('Config.language') != $this->request->query['also']) {
                $langs[] = $this->request->query['also'];
            }
            
            $conditions = array_merge($conditions, array('Testimonial.featured'=>true, 'Testimonial.lang'=>$langs));
            
            $this->set('testimonials', $this->Paginator->paginate('Testimonial', $conditions));
            
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
    
    private function _getVanityStats() {
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

            $done = $this->Testimonial->query($doneSQL);
            $reviews = $this->Testimonial->query($reviewsSQL);

            $stats = array('hires'=>$done[0][0]['hires'], 'people'=>$done[0][0]['people'], 'reviews'=>$reviews[0][0]['reviews']);
        }
        
        return $stats;
    }
}
