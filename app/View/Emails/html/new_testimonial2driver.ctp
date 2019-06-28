<?php if(!isset($driver_name)) $driver_name = 'chofer'?>

<p>Hola <?php echo $driver_name?>,</p>

<p>Acabamos de recibir una opinión de clientes suyos!</p>

<p>La opinión se encuentra en moderación, y en cuanto sea aprobada estará pública en su perfil.</p>

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
    <p>
        <?php $urlDef = array('controller' => 'testimonials', 'action' => 'view/' . $testimonial['id'], 'base'=>false) ?>
        <a href='<?php echo $this->Html->url($urlDef, true) ?>'>Click aquí para ver el testimonio en el sitio web</a>
    </p>
</div>

<p>Saludos,</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>