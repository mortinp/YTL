<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <legend><?php echo __('Cambio de contraseña')?></legend>

            <p><?php echo __('Ya enviamos un correo a la cuenta <b>%s</b> con las instrucciones para cambiar la contraseña. Revisa tu correo y sigue las instrucciones.', $user['User']['username'])?></p>            
            
            <?php echo $this->element('email_sent_tips', array('link'=>$this->Html->link('<i class="glyphicon glyphicon-ok"></i> '.__('Cambiar contraseña'), array('controller'=>'users', 'action'=>'forgot_password'), array('escape'=>false))))?>
        </div>
    </div>
    
</div>