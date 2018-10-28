<?php
App::uses('Auth', 'Component');
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p class="lead"><?php echo __d('pending_travel', 'Muchísimas gracias').'! '.__d('pending_travel', 'Ya tenemos los datos de tu solicitud.')?></p> 
            <p><?php echo __d('pending_travel', 'Enseguida enviaremos tu solicitud a varios choferes acá en %s. Debes crear una contraseña para poder gestionar tus conversaciones en el sitio y acceder a los perfiles de los choferes.', 'Cuba')?></p>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <br/>
            <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register_and_create/'.$travel['PendingTravel']['id'])); ?>
            <fieldset>
                <?php
                echo $this->Form->input('username', array('label' => __d('pending_travel', 'Tu correo electrónico'), 'value'=>$travel['PendingTravel']['email'], 'type' => 'hidden'));
                echo '<div style="max-width:400px">'.$this->Form->input('password', array('label'=> __d('pending_travel', 'Crea una contraseña para tu cuenta'), 'placeholder'=>__d('pending_travel', 'Escribe la contraseña que usarás para YoTeLlevo'), 'autofocus')).'</div>';
                //echo $this->Form->checkbox('remember_me').' '.__d('pending_travel', 'Recordarme');
                
                echo $this->Form->input('lang', array('type' => 'hidden', 'value'=>  Configure::read('Config.language')));
                ?>
                <br/>
                <?php echo $this->element('pending_travel', array('actions'=>false))?>
                <div style="text-align: center">
                    <?php echo $this->Form->submit(__d('pending_travel', "Enviar esta solicitud ahora y recibir ofertas de choferes"), array('class'=>'btn btn-block btn-primary', 'style'=>'font-size:14pt;white-space: normal;', 'escape'=>false));?>
                </div>
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>