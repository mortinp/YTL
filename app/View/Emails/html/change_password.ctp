<?php $urlDef = array('controller' => 'users', 'action' => 'change_password/' . $confirmation_code, 'base'=>false) ?>
<p><?php echo __d('user_email', 'Hola viajero')?>,</p>

<p>    
    <?php echo __d('user_email', 'Para cambiar la contraseña de <em>YoTeLlevo</em> da click en <a href="%s">este enlace</a>.', $this->Html->url($urlDef, true))?>
</p>

<p><small><?php echo __d('user_email', 'Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido')?>.</small></p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo __d('user_email',  'Da click aquí para cambiar tu contraseña')?></a>
