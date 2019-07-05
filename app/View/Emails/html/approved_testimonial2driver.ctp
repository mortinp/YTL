<?php if(!isset($driver_name)) $driver_name = 'chofer'?>

<p>Hola <?php echo $driver_name?>,</p>

<p>Acabamos de aprobar una opinión de clientes suyos! Ahora se encuentra pública en su perfil como una recomendación que verán otros clientes potenciales.</p>

<p><b>Usted puede hacer 2 cosas con esta opinión:</b></p>

<p>1. Compartirla en su Facebook para que amigos y clientes interesados la puedan ver.</p>
<p style="margin-top: 10px;margin-bottom: 10px;">
    <span>
        <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_nick,'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" 
            target="_blank">
            <b>Comparte esta opinión sobre tí en tu Facebook »</b>
        </a>
    </span>
<p/>

<p>2. Responder al cliente con un mensaje de agradecimiento.</p>
<p style="margin-top: 10px;margin-bottom: 10px;">
    <?php $urlDef = array('controller' => 'testimonials', 'action' => 'reply/' . $testimonial['id'].'/'.$testimonial['driver_reply_token'], 'base'=>false) ?>
    <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
        href='<?php echo $this->Html->url($urlDef, true) ?>'
        target="_blank"><b>Responde al cliente »</b>
    </a>
<p/>

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

<p style="margin-top: 10px;margin-bottom: 10px;">
    <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_nick,'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" >
        <b>Comparte esta opinión sobre tí en tu Facebook »</b>
    </a>
<p/>

<p style="margin-top: 10px;margin-bottom: 10px;">
    <?php $urlDef = array('controller' => 'testimonials', 'action' => 'reply', $testimonial['id'], $testimonial['driver_reply_token'], 'base'=>false) ?>
    <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
        href='<?php echo $this->Html->url($urlDef, true) ?>'
        target="_blank"><b>Responde al cliente »</b>
    </a>
<p/>

<p>Saludos,</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>