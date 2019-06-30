<!-- VIAJES Y CONTROLES -->
<?php
$driverName = 'el chofer'.' <small class="text-muted">('.$data['Driver']['username'].')</small>'?>
<?php $hasProfile = isset ($data['DriverProfile']) && $data['DriverProfile'] != null && !empty ($data['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['DriverProfile']['driver_name'];
    ?>
<?php endif;?>
<?php $this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false)); ?>
<header id="header">
    <div id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <nav id="nav">
            
            <div class="nav-link center" style="padding: 20px">
                <?php if($hasProfile):?><img src="<?php echo $src?>" style="max-height:30px;max-width:30px"/><?php endif;?>
                <?php echo 'Hola '.$driverName.'! ' ?>
                <?php echo $this->html->link('Vea su perfil',array('controller'=>'drivers', 'action'=>'profile', $data['DriverProfile']['driver_nick'])); ?>                
            </div>    

        </nav>
    </div>
</header>

<br/>

<!-- MENSAJES -->
<?php if(empty ($data['Testimonial'])):?><div class="row"><div class="col-md-6 col-md-offset-3">No nuevos testimonios para responder</div></div>
<?php else:?>   
   
        <div class="row container-fluid">
            <div class="col-md-9">
                <div class="col-md-9 col-md-offset-2 well">
                 <p class="text-muted"><span class="fa fa-comments-o"></span> <?php echo __($data['Testimonial']['author']) ?>
                 <?php $hasCountry = $data['Testimonial']['country'] != null;?>
                 <?php if($hasCountry):?> <?php echo __d('mobirise/testimonials', 'de %s', $data['Testimonial']['country']) ?><?php endif; ?></p>
                <i>"<?php echo $this->Text->truncate($data['Testimonial']['text'],250) ?>"</i>
                </div>
                
                <div class="col-md-7 col-md-offset-5 well">
                <div>
                    <?php echo $this->Form->create('TestimonialsReply', array('url' => array('controller' => 'testimonials', 'action' =>'reply/'.$data['Testimonial']['id'].'/'.$data['Testimonial']['driver_reply_token']))); ?>
                    <fieldset>
                        <?php
                        echo $this->Form->input('testimonial_id', array('type'=>'hidden','value'=>$data['Testimonial']['id']));
                        echo $this->Form->input('driver_reply_token', array('type'=>'hidden','value'=>$data['Testimonial']['driver_reply_token']));
                        echo $this->Form->input('reply_text', array('type'=>'textarea', 'class'=>'input-sm', 'label'=>'Responde este testimonio','required'));
                        echo $this->Form->submit('Enviar respuesta');
                        ?>
                    </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
                </div>
            </div>
            <br/>
        </div>      
   

    

<?php endif;?>