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
        </div>
        
        <div class="col-md-8 col-md-offset-2">
            <br/>
            <p><big><?php echo __d('testimonials', 'Es genial que te hayas tomado el tiempo para escribir esta opinión.').' '.__d('testimonials', 'Te deseamos un maravilloso próximo viaje a Cuba').'!'?></big></p>
            <p><?php echo __d('testimonials', 'Ah, y si te interesa compartir la <b>página personal de %s</b> para que otros lo contraten, aquí está:', Driver::shortenName($driver_name))?></p>
            
            <?php $profile_url = $this->Html->url(array('controller' => 'drivers', 'action' => 'profile/' . $data['Driver']['DriverProfile']['driver_nick'], 'base'=>false), true)?>
            <p class="lead"><code><?php echo $profile_url?></code></p>
            <br/>
            <span class="social-button"><a rel="nofollow" class="facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $profile_url?>"><?php echo __d('testimonials', 'Compártelo en Facebook').' »'?></a></span>
        </div>
        
    </div>
</div>