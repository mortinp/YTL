<?php if(!isset($traveler_name)) $traveler_name = 'viajero'?>

<p>Hola <?php echo $traveler_name ?>,</p>

<p><?php echo $driver_name ?> acaba de responder tu opinión. A continuación tienes la respuesta:</p>

<div>
    <?php
    $client = '<b>'.$driver_name.'</b>'; ?>
    
    <p><?php echo $client ?> dice:</p>
    <p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $reply['TestimonialsReply']['reply_text']);?></p>
    

    <p style="margin-top: 10px;margin-bottom: 10px;">
        <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
            href="<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_nick,'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" >
            <b>Mira la respuesta en el sitio aquí »</b>
        </a>
    <p/>    
    
    
</div>

<p>Saludos cordiales,</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>