<?php $urlDef = array('controller' => 'users', 'action' => 'change_password/' . $confirmation_code) ?>
<h4>Hola viajero</h4>

<p>
    ¿Perdiste tu contraseña de <em>YoTeLlevo</em>? No hay que alarmarse, puedes crear una nueva y comenzar a usarla. Para cambiar tu contraseña da click en
    <a href='<?php echo $this->Html->url($urlDef, true) ?>'>este enlace</a>. Enseguida podrás entrar a <em>YoTeLlevo</em> nuevamente.
</p>

<p><small>Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido.</small></p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'>Da click aquí para cambiar tu contraseña</a>
