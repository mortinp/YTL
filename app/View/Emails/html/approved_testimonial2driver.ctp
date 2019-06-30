<?php if(!isset($driver_name)) $driver_name = 'chofer'?>

<p>Hola <?php echo $driver_name?>,</p>

<p>Acabamos de aprobar una opinión de clientes suyos!</p>

<p>La opinión se encuentra pública en su perfil como una recomendación que verán otros clientes potenciales.</p>

<p>Tener opiniones positivas siempre ayuda a convencer a los viajeros, además de que son una prueba de la calidad de sus servicios y de su experiencia.</p>

<p>A continuación los detalles de la opinión:</p>

<div>
    <?php
    $client = '<b>'.$testimonial['author'].'</b>';
    if($testimonial['country'] != null && !empty($testimonial['country'])) 
        $client .= ' de <b>'.$testimonial['country'].'</b>';
    ?>
    <p><?php echo $client?> dice:</p>
    <p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?></p>
    <?php if ($testimonial['image_filepath']): ?>
        <p><b>El testimonio tiene una foto!</b></p>
        <p>
            <?php $urlDef = array('controller' => 'testimonials', 'action' => 'view/' . $testimonial['id'], 'base'=>false) ?>
            <a href='<?php echo $this->Html->url($urlDef, true) ?>'>Click aquí para ver el testimonio en el sitio web</a>
        </p>
    <?php endif?>
         <p>
            <?php $urlDef = array('controller' => 'testimonials', 'action' => 'reply/' . $testimonial['id'].'/'.$testimonial['driver_reply_token'], 'base'=>false) ?>
            <a href='<?php echo $this->Html->url($urlDef, true) ?>'>Click aquí para responder este testimonio</a>
        </p>
        
        <br/>
        <span class="social-button">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_nick,'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" class="facebook" target="_blank"><b>Comparte esta opinión sobre tí en tu muro de Facebook »</b></a>
        </span>        
       
        
    
</div>

<p>Saludos,</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>