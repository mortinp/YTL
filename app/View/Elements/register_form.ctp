<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register')); ?>
<fieldset>
    <?php
    echo $this->Form->input('username', array('label' => __('Correo electrónico'), 'type' => 'email', 'id'=>'UserRegisterForm'));
    echo $this->Form->input('password', array('label'=> __('Contraseña'), 'placeholder'=>__('Escribe la contraseña que usarás para YoTeLlevo')));
    echo $this->Form->checkbox('remember_me').' '.__('Recordarme');
    echo $this->Form->submit(__('Registrarme y Crear mi primer Anuncio de Viaje'));
    ?>
</fieldset>
<?php echo $this->Form->end(); ?>