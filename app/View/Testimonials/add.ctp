<?php 
   $webroot = $this->request->webroot;
   
   $imagen_path = 'files/driver_default_jpg';
   if( isset($driver_profile['avatar_filepath']) ) 
      $imagen_path = str_replace('\\', '/', $driver_profile['avatar_filepath']);
   
   $driver_nick = ( isset($driver_profile['driver_nick']) ) ? $driver_profile['driver_nick'] : null;
   $driver_name = ( isset($driver_profile['driver_name']) ) ? $driver_profile['driver_name'] : null;
?>	

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="col-md-2"><img src="<?php echo "{$webroot}{$imagen_path}"; ?>" class="info" title="<?php echo $driver_name?>"/></div>
            <div class="col-md-10">
                <div class="col-md-12 h4"><?php echo __d('testimonials', 'Genial').'! '.__d('testimonials', 'Estás escribiendo una opinión sobre %s', '<big><code>'.$driver_name.'</code></big>')?></div>
                <?php if($driver_profile['show_profile']):?>
                    <div class="col-md-12">
                        <span class="info" title="<?php echo __d('testimonials', 'Mira fotos de %s', $driver_name)?>">
                            <?php echo $this->Html->link(__d('testimonials', 'Ver el perfil de %s', $driver_name).' »', array('controller'=>'drivers', 'action'=>'profile/'.$driver_nick), array('target'=>'_blank', 'class'=>'text-warning'))?>
                        </span>
                    </div>
                <?php endif?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="col-md-6 col-md-offset-3">
        <span class="text-muted"><?php echo __d('testimonials', 'Cuéntanos sobre tu experiencia')?>:</span>
        <br/>
        <br/>
        <?php
           echo $this->Form->create('Testimonial', array('type'=>'file', 'id'=>'TestimonialForm'));
           echo $this->Form->input('lang', array('type' => 'hidden', 'value' => Configure::read('Config.language')));
           
           echo $this->Form->input('author', array( 'class' => 'form-control', 'label' => __d('testimonials', 'Tu nombre - incluye el de tus compañeros de viaje si quieres'), 'autofocus'=>true));
           
           //if( isset($external) && $external == true ) {
               $value = $userLoggedIn? AuthComponent::user('username'):null;
               echo $this->Form->input('email', array('label' => __d('testimonials', 'Tu correo electrónico'), 'value'=>$value));
           //}
               
           
           echo $this->Form->input('country', array('label' => __d('testimonials', '¿En qué sorprendente país vives?').' <span class="small text-muted">('.__d('testimonials', 'no obligatorio').')</span>'));
           
           echo $this->Form->input('text', array('class' => 'form-control', 'label' =>__d('testimonials', 'Cuéntanos de tu experiencia con %s y qué piensas de su servicio', Driver::shortenName($driver_name)).':', 'placeholder'=>__d('testimonials', 'Puedes incluir cualquier historia').'...' ));
           
           echo '<br/>';
           echo $this->Form->label('image', __d('testimonials', '¿Compartirías una foto de tu viaje con nosotros?'));
           echo '<br/>';
           echo $this->Form->file('image');
           
           echo '<br/><br/>';
           
           echo $this->Form->submit('<big>'.__d('testimonials', 'Enviar esta opinión sobre %s', $driver_name).'</big>', array('id'=>'TestimonialSubmit', 'class'=>'btn btn-block btn-warning', 'escape'=>false), true);
           
           echo $this->Form->end();
        ?>
    </div>   
</div>

<?php echo $this->element('addon_scripts_send_form', array('formId'=>'TestimonialForm', 'submitId'=>'TestimonialSubmit'))?>