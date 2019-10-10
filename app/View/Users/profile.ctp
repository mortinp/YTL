<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $this->Session->flash('auth'); ?>
        <legend><?php echo __('Edita tu perfil'); ?></legend>
        <?php echo $this->Form->create('User'); ?>
        <fieldset>
            <?php
            echo $this->Form->input('username', array('type' => 'text','placeholder'=>$this->request->data['User']['username'].__(' (no modificar si no desea cambiar)'),'value'=>'','required'=>false));
            echo $this->Form->input('display_name', array('label' => __('Nombre'), 'type' => 'text', 'placeholder'=>__('Nombre vacío significa que quieres usar tu correo como nombre')));
            echo $this->Form->input('password', array('label'=>__('Contraseña'), 'placeholder'=>__('Contraseña vacía significa que no quieres cambiarla'), 'required'=>false));
            echo $this->Form->input('id', array('type' => 'hidden'));
            
            echo $this->Form->input('role', array('type' => 'hidden'));
            echo $this->Form->input('created', array('type' => 'hidden'));
            echo $this->Form->submit(__('Salvar'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
</div>