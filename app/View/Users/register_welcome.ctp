<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <h2><?php echo __('Bienvenido a')?> <em>YoTeLlevo</em> <div><small class="text-muted"><?php echo __('Ahora te será mucho más fácil viajar en Cuba')?></small></div></h2>
            
            <br/>            
            <?php if(isset ($travel)):?>
                <p>
                    <?php echo __('Tienes el siguiente viaje')?>
                    <span style="color:<?php echo Travel::$STATE[$travel['Travel']['state']]['color']?>">
                        <b><?php echo Travel::$STATE[$travel['Travel']['state']]['label']?></b>
                    </span>:
                </p>
                <?php echo $this->element('travel', array('travel'=>$travel))?>
            <?php else:?>
                <h3>
                    <?php echo __('Ya puedes crear tu primer anuncio de viaje')?>: <?php echo $this->Html->link('<i class="glyphicon glyphicon-flag"></i>'.__('Crear Viaje'), array('controller'=>'travels', 'action'=>'add'), array('escape'=>false))?>.                
                </h3>
            <?php endif?>
            
            <br/>
            <br/>
            
            <p>                
                <?php echo __('Enviamos un correo a tu cuenta')?> (<b><?php echo AuthComponent::user('username')?></b>) <?php echo __('para ser verificada').'<b>'.__('Revisa tu correo y sigue las instrucciones').'</b>'?>.
                <?php echo __('Ten en cuenta que sólo podrás crear <b>1 anuncio de viaje</b> hasta que verifiques tu cuenta')?>.
            </p>
            
            <?php echo $this->element('email_sent_tips', array('link'=>$this->Html->link('<i class="glyphicon glyphicon-ok"></i> '.__('Enviar correo de verificación'), array('controller'=>'users', 'action'=>'send_confirm_email'), array('escape'=>false))))?>
                        
        </div>
    </div>
    
</div>