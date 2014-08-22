<?php $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code) ?>
<h4>Hola viajero</h4>

<p>
    La verificación de tu cuenta es un paso importante para poder crear más de 1 Anuncio de Viaje en <em>YoTeLlevo</em>. Para verificarla, da click en  
    <a href='<?php echo $this->Html->url($urlDef, true) ?>'>este enlace</a>. Este paso debes realizarlo sólo una vez y podrás anunciar todos los viajes
    que desees a partir de entonces.
</p>

<p>
    ¿Disfrutaste tu viaje en taxi por la isla? <?php echo $this->Html->link('Crea un nuevo Anuncio de Viaje', array('controller' => 'users', 'action' => 'login')) ?>
    si deseas repetir la experiencia ;). Va a ser genial.
</p>

<p><small>Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido.</small></p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'>Da click aquí para verificar tu cuenta</a>