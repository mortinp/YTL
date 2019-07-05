<p>Hola,</p>

<p><?php echo $driver_name ?> te envió este mensaje respondiendo tu comentario sobre su servicio:</p>

<div>
    <p><b><?php echo $driver_name ?></b> dice:</p>
    <p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $reply['TestimonialsReply']['reply_text']);?></p>
    
    <p style="margin-top: 10px;margin-bottom: 10px;">
        <a  style="padding:10px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none"
            href="<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver_nick,'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" >
            <b>Mira la respuesta en el sitio web »</b>
        </a>
    <p/>
</div>

<p>Saludos cordiales,</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>