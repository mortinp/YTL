<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register')); ?>
<fieldset>
    <?php
    echo $this->Form->input('username', array('label' => __('Tu correo electrónico'), 'type' => 'email'/*, 'id'=>'UserRegisterForm'*/));
    echo $this->Form->input('password', array('label'=> __('Contraseña'), 'placeholder'=>__('Escribe la contraseña que usarás para YoTeLlevo')));
    echo $this->Form->checkbox('remember_me').' '.__('Recordarme');
    echo $this->Form->input('lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));
    ?>
    <br/>
    <br/>
    <?php echo $this->Form->submit(__('Registrarme y contactar choferes ahora'));
    ?>
</fieldset>
<?php echo $this->Form->end(); ?>