<?php $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code) ?>
<h4><?php echo __d('user_email', 'Hola y bienvenido a <em>YoTeLlevo</em>')?>.</h4>

<p>
    <?php echo __d('user_email', 'Tu viaje ya fue asignado y notificado y <b>pronto recibirás respuestas de nuestros choferes en tu correo</b>.')?>    
</p>

<?php echo $this->element('welcome_tips')?>

<p>
    <?php echo __d('user_email', 'Esta es tu oportunidad para conocer Cuba a tu propio modo. Recuéstate en el asiento trasero de tu taxi y disfruta esta isla maravillosa mientras recorres tus destinos favoritos.')?>
</p>
<p>
    <?php echo __d('user_email', 'Algo más: ahora que has sido registrado exitosamente, puedes %s en cualquier momento y crear otros viajes. Es muy fácil! Pero antes de crear un nuevo viaje en <em>YoTeLlevo</em> debes <b>confirmar tu cuenta</b> dando click en %s.', $this->Html->link(__d('user_email', 'entrar con tu cuenta'), array('controller' => 'users', 'action' => 'login')), '<a href="'.$this->Html->url($urlDef, true).'">'.__d('user_email', 'este enlace').'</a>')?>
</p>

<p><?php echo __d('user_email', 'Desata tu creatividad mientras conoces la isla en la seguridad y confort de tu taxi!!!')?></p>


<p><small><?php echo __d('user_email', 'Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido')?>.</small></p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo __d('user_email',  'Da click aquí para confirmar tu cuenta')?></a>