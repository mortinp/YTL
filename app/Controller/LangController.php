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
    
    public function setlang($lang) {
        /*$path = func_get_args();

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
        $this->set(compact('page', 'subpage', 'title_for_layout'));*/
        
        if($lang == null) return $this->redirect('/');
        
        $this->Cookie->write('app.lang', $lang, true, '+2 weeks');
        $this->Session->write('app.lang', $lang); // Escribir la Session por si no se puede escribir la Cookie
        $this->Session->write('Config.language', $lang);
        
        $user = AuthComponent::user();
        if($user != null && !empty ($user) /*&& $lang != $user['lang']*/) {
            $this->User->id = $user['id'];
            $this->User->saveField('lang', $lang);
            
            // TODO: actualizar lang en Auth
        }
        
        /**
         * Manejar el referer
         */
        $referer = $this->referer();
        
        if($referer == null || (is_string($referer) && $referer == '/')) return $this->redirect('/');
            
        if(is_array($referer)) return $this->redirect($referer); // Cuando es un array quiere decir que viene de dentro de la aplicacion (?)
        
        if(is_string($referer)) { // Es probable que venga de un dominio diferente

            $urlApp = Configure::read('App.fullBaseUrl');
            $urlBlog = Configure::read('App.fullBaseUrl');
            if(Configure::read('debug') > 0) {
                $urlApp .= '/yotellevo';
                $urlBlog .= '/yotellevo/app/webroot/blog';
            } else {
                $urlBlog .= '/blog';
            }

            // Comprobar si viene de nuestro propio dominio
            if(strpos($referer, $urlApp) === 0) { // Viene del dominio?
                if(strpos($referer, $urlBlog) === 0)//... y viene del blog?
                    return $this->redirect('/');
                else return $this->redirect($referer); // Si no viene del blog (pero viene del mismo dominio), entonces redirect a la misma pagina donde estaba
            }

            // Esto se ejecuta cuando viene de otro dominio
            return $this->redirect('/');

        }
        
        // Just in case nothing matches
        return $this->redirect('/');
    }

}
