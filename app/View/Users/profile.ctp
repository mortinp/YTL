<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-1">
        <?php echo $this->Session->flash('auth'); ?>
        <legend><?php echo __('Edita tu perfil'); ?></legend>
        <?php echo $this->Form->create('User'); ?>
        <fieldset>
            <?php
            echo $this->Form->input('display_name', array('label' => __('Nombre'), 'type' => 'text', 'placeholder'=>__('Nombre vacío significa que quieres usar tu correo como nombre')));
            echo $this->Form->input('password', array('label'=>__('Contraseña'), 'placeholder'=>__('Contraseña vacía significa que no quieres cambiarla'), 'required'=>false));
            echo $this->Form->input('id', array('type' => 'hidden'));
            echo $this->Form->input('username', array('type' => 'hidden'));
            echo $this->Form->input('role', array('type' => 'hidden'));
            echo $this->Form->input('created', array('type' => 'hidden'));
            echo $this->Form->submit(__('Salvar'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
        
        <br/>
        
        
    </div>
    <div class="col-md-4 col-md-offset-1">
        <legend><?php echo __('Otras acciones')?></legend>
        <div>
            <big>
            <?php echo $this->Html->link('<i class="glyphicon glyphicon-user"><i class="glyphicon glyphicon-arrow-right"></i></i><i class="glyphicon glyphicon-trash"></i> '.__('Eliminar mi Cuenta de Usuario'), 
                    array('action'=>'unsubscribe'), 
                    array('class'=>'text-danger', 'escape'=>false))?>
            </big>
        </div>
        <div class="text-danger">(<b><?php echo __('No podrás crear más viajes ni ver tus datos')?></b>)</div>
    </div>
</div>
</div>