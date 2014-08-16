<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <?php echo $this->Session->flash('auth'); ?>
        <div class="text-muted">
            <b><?php echo __('¿No tienes una cuenta todavía?')?></b> 
            <?php echo $this->Html->link(__('Regístrate'), array('controller'=>'users', 'action'=>'register'), array('escape'=>false))?> 
            <?php echo __('para crear anuncios de viajes')?>.
        </div>
        <br/>
        <legend><?php echo __('Entra y gestiona tus viajes')?></legend>
        <?php echo $this->Form->create('User'); ?>
        <fieldset>
            <?php
            echo $this->Form->input('username', array('label' => __('Correo electrónico'), 'type' => 'email'));
            echo $this->Form->input('password', array('label' => __('Contraseña')));
            echo $this->Form->checkbox('remember_me').' '.__('Recordarme');
            echo $this->Form->submit(__('Entrar'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
        <br/>
        <?php echo $this->Html->link(__('¿Olvidaste tu contraseña?'), array('controller'=>'users', 'action'=>'forgot_password'))?>
    </div>
</div>
</div>