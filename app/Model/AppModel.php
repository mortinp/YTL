<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    public $useDbConfig = 'mysql';
    
    protected function getFormattedField($formatter, $fieldName, $time) {
        $default = array('formatter' => $formatter);
        $colType = array_merge(
                $default, 
                $this->getDataSource()->columns[$this->getColumnType($fieldName)]);
        if (!array_key_exists('format', $colType)) {
            $formatted = $time;
        } else {
            $formatted = call_user_func($colType['formatter'], $colType['format']);
        }
        
        return $formatted;
    }
}
