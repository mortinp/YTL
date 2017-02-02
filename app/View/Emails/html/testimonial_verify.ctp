<?php
   //some data, some explanation and most important link to validation token
    $urlValidar = array('controller' => 'testimonial', 'action' => 'verify', $Testimonial['validation_token']);
?>

<a href="<?php echo $this->Html->url($urlValidar, true); ?>">Haga Click Aquí Para Hacer Efectivo Su Comentario</a>