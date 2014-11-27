<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <h2><?php echo __('Verificación de cuenta de correo electrónico')?></h2>
            <h3>
                <?php echo __('Ya enviamos un correo a la cuenta <b>%s</b> para ser verificada. <b>Revisa tu correo y sigue las instrucciones</b>.', AuthComponent::user('username'))?>
            </h3>
            
            <?php echo $this->element('email_sent_tips', array('link'=>$this->Html->link('<i class="glyphicon glyphicon-ok"></i> '.__('Enviar correo de verificación'), array('controller'=>'users', 'action'=>'send_confirm_email'), array('escape'=>false))))?>
                        
        </div>
    </div>
    
</div>