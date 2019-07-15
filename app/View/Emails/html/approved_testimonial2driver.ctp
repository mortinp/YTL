<?php if(!isset($driver_name)) $driver_name = 'chofer'?>

<p>Hola <?php echo $driver_name?>,</p>

<p>Acabamos de aprobar una opinión de clientes tuyos! Ahora se encuentra pública en tu perfil como una recomendación que verán otros clientes potenciales.</p>

<p><b>Te recomendamos hacer 2 cosas con esta opinión:</b></p>

<p>1. Responder al cliente con un mensaje de agradecimiento. Sólo necesitas 2 minutos.</p>
<p style="margin-top: 10px;margin-bottom: 10px;">
    <?php $urlDef = array('language'=>'es' ,'controller' => 'testimonials', 'action' => 'reply/' . $testimonial['id'].'/'.$testimonial['driver_reply_token'], 'base'=>false) ?>
    <a  style="padding:10px;color: #333;background-color: #ebebeb;border-color: #adadad;text-decoration: none"
        href='<?php echo $this->Html->url($urlDef, true) ?>'
        target="_blank"><b>Responder el comentario al cliente »</b>
    </a>
<p/>
<br>

<p>2. Compartirla en tu Facebook para que amigos y clientes interesados la puedan ver.</p>
<p style="margin-top: 10px;margin-bottom: 10px;">
    <span>
        <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_nick,'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" 
            target="_blank">
            <b>Comparte esta opinión sobre tí en tu Facebook »</b>
        </a>
    </span>
<p/>
<br>

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
    <?php endif?>
</div>

<br>
<p>Saludos,</p>
<p>El equipo de <a href="https://yotellevocuba.com">YoTeLlevo</a></p>