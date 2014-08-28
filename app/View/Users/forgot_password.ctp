<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $this->Session->flash('auth'); ?>
        <legend>
            <div><big><?php echo __('Cambio de contraseña')?></big></div>
            <div>
                <small class="text-muted"><p><?php echo __('¿Olvidaste tu contraseña? Escribe tu correo electrónico y enviaremos las instrucciones para cambiarla')?></p></small>
            </div>
        </legend>
        <?php echo $this->Form->create('User', array('action'=>'send_change_password')); ?>
        <fieldset>
            <?php
            echo $this->Form->input('username', array('label' => __('Tu correo electrónico'), 'type' => 'email'));
            echo $this->Form->submit(__('Enviarme instrucciones'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>