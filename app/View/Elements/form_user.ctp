<?php
if (!isset($form_action)) $form_action = 'add';

if (empty($this->request->data))
    $saveButtonText = 'Crear';
else
    $saveButtonText = 'Salvar';

?>

<div>
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <?php
        echo $this->Form->input('username', array('type'=>'text'));
        if($form_action == 'add') echo $this->Form->input('password');
        else 
            echo $this->Form->input('password', array('label'=>'Contraseña', 'placeholder'=>'Contraseña vacía significa que no quieres cambiarla', 'required'=>false));
        echo $this->Form->input('role', array(
            'options' => array('regular' => 'Regular', 'admin' => 'Admin (acceso a todo)', 'tester'=>'Tester (como uno regular pero sus solicitudes se envían a choferes de prueba)', 'operator'=>'Operador (revisa las conversaciones, notifica choferes, sigue los viajes, etc.)')
        ));
        echo $this->Form->submit($saveButtonText);
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>