<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<!--<p>Hola <?php //echo $driver_name?>,</p>-->
<p>Hola <?php echo $data['Driver']['driver_name']?>,</p>
<p>¿Tienes que hacer algún traslado en tu taxi próximamente y no tienes pasajeros todavía?</p>

<p>Puede ser que te sucedan uno de estos 2 casos:</p>

<ol>
    <li>Tienes que dejar clientes en Viñales, Varadero, Trinidad, Cayo Santa María, etc. y no tienes pasajeros para el regreso a La Habana, por lo cual probablemente tengas que regresar vacío.</li>
    <li>Tienes que ir a recoger clientes lejos de La Habana y tienes que ir vacío porque no tienes pasajeros para la ida.</li>
</ol>

<p>En cualquiera de estos casos estás perdiendo dinero, pero <b>en YoTeLlevo podemos ayudarte a encontrar pasajeros para esos recorridos</b>.</p>

<p>Nuestra propuesta es que ofertes el viaje de regreso <b>a mitad de precio</b>, garantizando que al ser una oferta atractiva, puedas conseguir viajeros.</p>

<p>A continuación te listamos los viajes que tienes en los próximos 30 días para si en alguno tienes que virar con tu taxi vacío:</p>


<ul>
    <?php foreach ($data['Travel'] as $travel):?>
    <li>    
        <?php $urlDef = array('controller' => 'drivers', 'action' => 'add_offer/' . $travel['driver_travel_id'], 'base'=>false) ?>
        <?php if($travel['notification_type'] != DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE): ?>        
        #<?php echo $travel['travel_id']?> (<?php echo $travel['travel_origin']?> - <?php echo $travel['travel_destination']?>) con fecha de inicio <?php echo TimeUtil::prettyDate($travel['travel_date'])?> <a href="<?php echo $this->html->url($urlDef,true); ?>">[Ofertar]</a>
        <?php else: ?>
            Mensaje directo #D<?php echo $travel['identifier']?> con fecha de inicio <?php echo TimeUtil::prettyDate($travel['driver_travel_date'])?> <a href="<?php echo $this->html->url($urlDef,true); ?>">[Ofertar]</a>
        <?php endif; ?>
        <div>
            <a href="<?php  echo $this->Html->url(array('controller'=>'drivers','action'=>'messages', $travel['driver_travel_id'], 'base'=>false), true);?>">
                Mira esta conversación completa en nuestro sitio web
            </a>
        </div>
    </li>
    <?php endforeach?>
</ul>
<!--<p><b>Sólo tienes que llamarnos a este teléfono:</b></p>

<p><b>54530482 (Martín)</b></p>

<p>Te explicaremos enseguida y te ayudaremos a encontrar clientes.</p>

<p>Por favor, <b>revisa tu agenda y verifica cuándo tienes que viajar con tu taxi vacío y llámanos</b>.</p>-->

<p>Un saludo y gracias!</p>

<p>El equipo de <a href="https://yotellevocuba.com">YoTeLlevo</a></p>