<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <h2><?php echo __('Bienvenido a <em>YoTeLlevo</em>')?> <div><small class="text-muted"><?php echo __('¡Qué bueno tenerte a bordo!')?></small></div></h2>
            
            <br/>            
            <?php if(isset ($travel) || isset ($conversation)):?>
                <?php echo __('Creaste una solicitud de viaje con los siguientes datos')?>:
                <br/>
                <br/>
                <?php if( isset($travel) ):?> 
                    <?php echo $this->element('travel', array('travel'=>$travel));?>
                <?php else:?>
                    <?php echo $this->element('direct_message', array('data'=>$conversation, 'show_message' => true, 'show_perfil' => false));?>
                    <div>
                        <br/>
                        <?php echo $this->Form->button(__('Ver mis mensajes'), array('controller'=>'conversations', 'class'=>'btn-success'), true)?>
                    </div>
                <?php endif?>
            <?php else:?>
                <h3>
                    <?php echo __('Ya puedes crear tu primer anuncio de viaje')?>: 
                    <?php echo $this->Html->link(__('Crear un anuncio de viaje'), array('controller'=>'travels', 'action'=>'add'), array('escape'=>false))?>.                
                </h3>
            <?php endif?>
            
            <!--<br/> 
            <hr/>
            
            <p>                
                <?php echo __('Enviamos un correo a tu cuenta (<b>%s</b>) para ser verificada. <b>Revisa tu correo y sigue las instrucciones</b>.', AuthComponent::user('username'))?>
            </p>
            
            <?php echo $this->element('email_sent_tips', array('link'=>$this->Html->link('<i class="glyphicon glyphicon-ok"></i> '.__('Enviar correo de verificación'), array('controller'=>'users', 'action'=>'send_confirm_email'), array('escape'=>false))))?>
            -->          
        </div>
    </div>
    
</div>