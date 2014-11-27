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
class LangController extends AppController {
    
    public $uses = array('User');
    
    public function setlang() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $lang = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $lang = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        
        $this->Cookie->write('app.lang', $lang, true, '+2 weeks');
        $this->Session->write('app.lang', $lang); // Escribir la Session por si no se puede escribir la Cookie
        
        $user = AuthComponent::user();
        if($user != null && !empty ($user) /*&& $lang != $user['lang']*/) {
            $this->User->id = $user['id'];
            $this->User->saveField('lang', $lang);
            
            // TODO: actualizar lang en Auth
        }
        
        $referer = $this->referer();
        if($referer != null) return $this->redirect($referer);
        else return $this->redirect('/');
    }

    /*public function beforeFilter() {
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
    }*/

}
