<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <?php echo $this->Session->flash('auth'); ?>
        <legend><?php echo __('Cambia tu contraseña'); ?></legend>
        <?php echo $this->Form->create('User'); ?>
        <fieldset>
            <?php
            echo $this->Form->input('display_name', array('label' => __('Nombre'), 'type' => 'hidden'));
            echo $this->Form->input('password', array('label'=>__('Contraseña')));
            echo $this->Form->input('id', array('type' => 'hidden'));
            echo $this->Form->input('username', array('type' => 'hidden'));
            echo $this->Form->input('role', array('type' => 'hidden'));
            echo $this->Form->input('created', array('type' => 'hidden'));
            echo $this->Form->submit(__('Cambiar Contraseña'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
</div>