<p>Hola <?php echo $traveler_name ?>,</p>

<p><?php echo __d('mobirise/testimonials', '%s envió este mensaje respondiendo su comentario sobre su servicio', $driver_name)?>:</p>


<p><b><?php echo $driver_name ?></b>:</p>
<p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $reply['TestimonialsReply']['reply_text']);?></p>
    
<br>
<p style="margin-top: 10px;margin-bottom: 10px;">
    <a  style="padding:10px;color: #333;background-color: #ebebeb;border-color: #adadad;text-decoration: none"
        href="<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile', $driver_nick, '?' => array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" >
        <b><?php echo __d('mobirise/testimonials', 'Mira la respuesta de %s el sitio web', $driver_name)?> »</b>
    </a>
<p/>


<br>
<p><?php echo __d('user_email', 'El equipo de <a href="https://yotellevocuba.com">YoTeLlevo</a>.')?></p>