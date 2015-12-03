<?php $urlDef = array('controller' => 'users', 'action' => 'confirm_email/' . $confirmation_code, 'base'=>false) ?>

<p>
    <?php echo __d('user_email', 'Hola, bienvenido a YoTeLlevo... y bienvenido a Cuba! Gracias por usar nuestro servicio. Soy %s.', 'Martín')?>
</p>

<p>
    <?php echo __d('user_email', 'Solamente quería decir hola y asegurarme de que nuestro servicio le sea de ayuda, y que usted sepa qué esperar y que le saque el mayor provecho posible. Para eso le dejo aquí algunos datos y tips que pueden ser muy útiles mientras usa YoTeLlevo y habla con los choferes')?>:
</p>

<ul>
    <li>
        <?php echo __d('user_email', 'Primeramente, nuestros choferes son personas propietarias de un auto que se dedican a transportar viajeros como usted. Lo interesante es que puedes estar hablando con un economista, un pescador o un piloto retirado. ¿No es eso genial?')?>
    </li>
    <li>
        <?php echo __d('user_email', 'Las ofertas de precios que usted recibirá pueden ser diferentes (a veces muy diferentes). Nuestros choferes trabajan de manera independiente y pueden tener distintas tarifas según sus costos personales u otros factores. Lo bueno es que usted puede escoger.')?>
    </li>
    <li>
        <?php echo __d('user_email', 'Asegúrese de dejar claro cada detalle antes de la fecha de recogida. Acuerde la hora, lugar y cualquier otra información necesaria para el primer encuentro. Guarde el número telefónico del chofer para contactos de último minuto.')?>
    </li>        
    <li>
        <?php echo __d('user_email', 'No espere que los choferes se puedan comunicar por mensajes de texto (sms) o llamadas telefónicas si usted no está dentro de Cuba. Estas opciones son muy caras para ellos. De todas formas, pregúnteles por su número móvil si quiere escribirles más cómodamente; ellos seguramente responderán por correo.')?>
    </li>
    <li>
        <?php echo __d('user_email', 'No dude en dejarles saber amablemente a los choferes si usted encuentra el precio un poco caro. Incluso cuando los precios no son negociables todo el tiempo, puede ser que el chofer pueda hacer una mejor oferta si usted se lo pide. Por favor, haga esto sólo si no puede costear el precio inicial.')?>
    </li>
    <li>
        <?php echo __d('user_email', 'Por último, usted va a mantener una conversación con una persona en Cuba. Aproveche y congenie con esa persona que va a ser su chofer.')?>
    </li>
</ul>

<p>
    <?php echo __d('user_email', '¿Le ayuda esto un poco? Bueno, si necesita algo más siéntase libre de responder este correo y hacerme una pregunta. Estaré muy contento de podérsela contestar y ponerme en contacto con usted. O puede preguntarle a los choferes, ellos probablemente tienen más experiencia que yo.')?>
</p>

<p>
    <?php echo __d('user_email', 'Espero que tenga un maravilloso viaje a Cuba')?>!
</p>

<p>
    <?php echo __d('user_email', 'Ah, y asegúrese de confirmar su cuenta de correo dando click en %s.', '<a href="'.$this->Html->url($urlDef, true).'">'.__d('user_email', 'este enlace').'</a>')?>
</p>

<p>
    <?php echo __d('user_email', 'Afectos')?>, Martín
</p>