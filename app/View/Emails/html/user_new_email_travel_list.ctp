<p>Hola <?php echo $user_name?>,</p>

<p>
    Usted ha modificado su correo y ha puesto esta dirección como su nuevo contacto. A partir de este momento toda la comunicación con nuestra plataforma o choferes se realizará mediante esta dirección.
</p>
<p>Usted tiene activas en este momento las siguientes conversaciones con nuestros choferes:</p>
<ul>
    <?php foreach ($data as $travel):?>
    <li>     
        <div>
            <a href="<?php  echo $this->Html->url(array('controller'=>'conversations','action'=>'messages', $travel['DriverTravel']['id'], 'base'=>false), true);?>">
                Conversación con <?php echo $travel['Driver']['DriverProfile']['driver_name']; ?>
            </a>
        </div>
    </li>
    <?php endforeach?>
</ul>

<p>
    Se las enviamos aquí para que no tenga que buscarlas en su antiguo correo, dando click encima puede ver cada conversación COMPLETA de manera ONLINE.
</p>

<p>
    Si Usted no ha modificado su email y este correo es un error, simplemente ignórelo, o póngase en contacto con nosotros para detalles.
</p>

<p>
    Muchísimas gracias por utilizar nuestros servicios,
</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>
<p>
    <small>
    Este correo le fue enviado automáticamente por haber modificado su información de contacto.
    </small>
</p>