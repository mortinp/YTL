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
<!--<header id="header">
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

<br/>-->

<section class="testimonials3 cid-r6TeBtPTdm" id="testimonials3-o" style="margin-top: 60px">
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-10" data-form-type="formoid">
                    <p>Hola <?php echo $data['DriverProfile']['driver_name']?>, recibiste una opinión de clientes sobre tu servicio y ahora puedes responderla.</p>
                    <p><b>Házlo desde el formulario al final de la opinión</b>. A continuación puedes ver la opinión:</p>
                    <br>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-10" data-form-type="formoid">
                    <?php echo $this->element('mobirise/testimonial-full', array('testimonial'=>$data['Testimonial'], 'driver'=>$data['Driver']))?>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-8 offset-md-1 mt-5" data-form-type="formoid">
                    <?php echo $this->Session->flash(); ?>
                    <p>Responder esta opinión:</p>
                    <span class="alert alert-warning alert-dismissable">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        IMPORTANTE: 
                        <p>
                            Tu respuesta estará pública en tu perfil y la verán otros clientes potenciales. 
                            Escribe correctamente de manera que los que quieran contratarte les guste tu respuesta.
                        </p>
                        <p>
                            <b>Esta respuesta se la enviaremos al cliente que escribió la opinión!</b>
                        </p>
                    </span>
                    
                    <img src="<?php echo PathUtil::getFullPath($data['DriverProfile']['avatar_filepath'])?>" style="max-width:60px"/>
                    <?php echo $this->Form->create('TestimonialsReply', array('url' => array('controller' => 'testimonials', 'action' =>'reply', $data['Testimonial']['id'], $data['Testimonial']['driver_reply_token']))); ?>
                    <fieldset>
                        <?php
                        echo $this->Form->input('testimonial_id', array('type'=>'hidden','value'=>$data['Testimonial']['id']));
                        echo $this->Form->input('driver_reply_token', array('type'=>'hidden','value'=>$data['Testimonial']['driver_reply_token']));
                        echo $this->Form->input('reply_text', array('type'=>'textarea', 'label'=>'Respondiendo como '.$data['DriverProfile']['driver_name'],'placeholder'=>'Escribe tu respuesta aquí', 'class'=>'input-sm', 'required'));
                        echo $this->Form->submit('Enviar respuesta');
                        ?>
                    </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>