<?php
/**
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
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2><?php echo $name; ?></h2>
        <p class="error">
            <strong><?php echo __d('error', 'Error'); ?>: </strong>
            <?php printf(
                    __d('error', 'La dirección requerida %s no se encuentra en este servidor.'),
                    "<strong>'{$url}'</strong>"
            ); ?>
        </p>
    </div>
</div>

<?php
if (Configure::read('debug') > 0):
    echo $this->element('exception_stack_trace');
endif;
?>
