<?php $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code) ?>
<h4><?php echo __d('user_email', 'Hola viajero')?>,</h4>

<p>
    <?php echo __d('user_email', 'Para confirmar tu cuenta en <em>YoTeLlevo</em> da click en <a href="%s">este enlace</a>.', $this->Html->url($urlDef, true))?>
</p>

<p><small><?php echo __d('user_email', 'Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido')?>.</small></p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo __d('user_email',  'Da click aquí para confirmar tu cuenta')?></a>