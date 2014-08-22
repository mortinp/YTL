<?php $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code) ?>
<h4>Hola y bienvenido a <em>YoTeLlevo</em>. <small>Gracias por preferir viajar con nosotros.</small></h4>

<p>
    Tu viaje ya fue asignado y notificado y <b>pronto recibirás respuestas de nuestros choferes en tu correo</b>. Esta comunicación directa con los posibles
    choferes de tu taxi es una buena oportunidad para aprovechar y detallar algunas cuestiones que quizás te interesen:    
</p>
<ul>
    <li>
        <b>Acuerda el precio de tus recorridos</b>. Nuestros choferes son taxistas independientes y seguramente recibes ofertas con precios diferentes.
        Selecciona el chofer que mejor se ajuste a tus necesidades.
    </li>
    <li>
        <b>Detalla los horarios y lugares de recogida</b>. Tu taxi estará ahí a la hora indicada.
    </li>        
    <li>
        <b>Aprovecha y entabla amistad con tu chofer</b>. Es mucho mejor viajar con alguien que sientes que es cercano, y nuestros choferes son
        <em>cubanos de pura sepa</em>: es muy fácil hacer amistad con ellos.
    </li>
    <li>
        Con los precios que acuerdes puedes armar tu presupuesto de transportación para mientras permaneces en la isla, y puedes
        hacerlo incluso antes de llegar; algo menos de qué preocuparse ;).
    </li>
</ul>

<p>
    Esta es tu oportunidad para conocer Cuba a tu propio modo. Recuéstate en el asiento trasero de tu taxi y disfruta esta isla maravillosa mientras recorres
    tus destinos favoritos.
</p>
<p>
    Algo más: ahora que has sido registrado exitosamente, puedes <?php echo $this->Html->link('entrar con tu cuenta', array('controller' => 'users', 'action' => 'login')) ?>
    en cualquier momento y crear otros viajes. Es muy fácil! Pero antes de crear un nuevo viaje en <em>YoTeLlevo</em> debes 
    <b>confirmar tu cuenta</b> dando click en <a href='<?php echo $this->Html->url($urlDef, true) ?>'>este enlace</a>.
</p>

<p>Desata tu creatividad mientras conoces la isla en la seguridad y confort de tu taxi!!!</p>


<p><small>Si este correo te llegó por error, simplemente bórralo y olvida lo ocurrido.</small></p>
<a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo __('Da click aquí para confirmar')?></a>