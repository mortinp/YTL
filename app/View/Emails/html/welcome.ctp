<?php $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code) ?>
<h4>Hola y bienvenido a <em>YoTeLlevo</em>. <small>Ahora conseguir un taxi para moverte por Cuba será mucho más fácil.</small></h4>

<p>
    Ya puedes comenzar a crear viajes en <em>YoTeLlevo</em>. Podrás crear <b>1 anuncio de viaje</b>
    sin verificar tu cuenta de correo electrónico, pero tendrás que verificarla para crear más anuncios.
</p>
<p> 
    Para verificar tu cuenta, da click en <a href='<?php echo $this->Html->url($urlDef, true) ?>'>este enlace</a>.
</p>

<p><?php echo __('Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido')?>.</p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo __('Da click aquí para confirmar')?></a>