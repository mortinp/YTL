<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php $driver_name = 'chofer'?>
<?php if($data['Driver']['driver_name'] != null) $driver_name = $data['Driver']['driver_name']?>

<p>Hola <?php echo $driver_name?>,</p>

<p>Le escribimos para recordarle que tiene viajes confirmados mediante YoTeLlevo en los próximos 3 (tres) <b>días</b>.</p>

<p>Le recomendamos tener en cuenta esto y coordinar todo con los viajeros para que no haya ningún problema o contratiempo.</p>

<p>Los viajeros agradecen siempre que el chofer esté atento de todo, y mejor aún, de todos los detalles del viaje.<b> Puede escribir también solo para saludarles!!!</b></p>

<p>Los viajes que se efectuarán en los siguientes días son los siguientes:</p>
<ul>
    <?php foreach ($data['Travel'] as $travel):?>
    <li>
        <?php if($travel['notification_type'] != DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE): ?>
            #<?php echo $travel['travel_id']?> (<?php echo $travel['travel_origin']?> - <?php echo $travel['travel_destination']?>) con fecha de inicio <?php echo TimeUtil::prettyDate($travel['travel_date'])?>
        <?php else: ?>
            Mensaje directo #D<?php echo $travel['identifier']?> con fecha de inicio <?php echo TimeUtil::prettyDate($travel['driver_travel_date'])?>
        <?php endif; ?>
        <div>
            <a href="<?php  echo $this->Html->url(array('controller'=>'drivers','action'=>'messages', $travel['driver_travel_id'], 'base'=>false), true);?>">
                Mira esta conversación completa en nuestro sitio web
            </a>
        </div>
    </li>
    <?php endforeach?>
</ul>

<p> 
    Si encuentra algún problema en esta información, por favor póngase en contacto con nosotros a través de este mismo correo. Puede ser que aún no hayamos actualizado toda la información en el sitio o que haya alguna confusión. Siéntase libre de comunicarnos cualquier inconveniente.
</p>

<p>
    Muchísimas gracias y saludos,
</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>
<p>
    <small>
    Este correo le fue enviado automáticamente porque tiene viajes confirmados para realizar en los próximos 3 (tres) días. Este recordatorio se le enviará siempre que tenga viajes confirmados para los siguientes tres días.
    </small>
</p>