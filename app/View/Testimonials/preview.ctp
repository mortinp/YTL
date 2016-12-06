<?php App::uses('Driver', 'Model')?>

<?php
$testimonial = $data['Testimonial'];

$driver_name = $data['Driver']['DriverProfile']['driver_name'];
?>

<div class="container">
    <div class="row">
        
        <div class="col-md-8 col-md-offset-2">
            <p class="lead"><?php echo __d('testimonials', 'Muchísimas gracias').'! '.__d('testimonials', 'Ya tenemos tu opinión sobre %s.', '<code>'.$driver_name.'</code>')?></p> 
            <p><?php echo __d('testimonials', 'Tu opinión está ahora en moderación por nuestros administradores - nos gusta evitar comentarios spam.').' '.__d('testimonials', 'En breve lo revisamos y lo ponemos en la página de perfil de %s.', Driver::shortenName($driver_name))?></p>
            <p><?php echo __d('testimonials', 'Así se verá tu testimonio')?>:</p>
            <br/>
        </div>
        
        <div class="col-md-8 col-md-offset-2">
            <?php echo $this->element('testimonial_body', array('testimonial' => $testimonial));?>
            
            <!--<?php if ($testimonial['conversation_id']): ?>  
                <a href="<?php echo $this->Html->url(array('controller' => 'testimonials', 'action' => 'edit', $testimonial['id']), true) ?>"> 
                    <i class="glyphicon glyphicon-pencil"></i> 
                    <?php echo __("Haz click aquí para editarlo"); ?> 
                </a>  
            <?php endif; ?> --> 
        </div>
        
        <div class="col-md-8 col-md-offset-2">
            <br/>
            <p class="lead"><?php echo __d('testimonials', 'Es genial que te hayas tomado el tiempo para escribir esta opinión.').' '.__d('testimonials', 'Te deseamos un maravilloso próximo viaje a Cuba').'!'?></p>
        </div>
        
    </div>    
</div>