<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<div style="text-align: center;width: 100%">**********</div>

<?php if(!isset ($driver_name)) $driver_name = 'chofer'?>
<p>Hola <?php echo $driver_name?>,</p>

<p>
    Este correo tiene la intención de tratar con usted asuntos asociados al viaje <b>#<?php echo $travel_id?></b>. 
</p>
<p>Solo como recordatorio, el viaje fue creado con los siguientes datos:</p>
<div style="border-left: #efefef solid 2px;padding-left: 15px"> 
    <?php if($notification_type != DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE): ?>
        <div><big><?php echo $travel_origin?> - <?php echo $travel_destination?></big></div>
    <?php else: ?>
        <div><big>Solicitud por mensaje directo</big></div>
    <?php endif; ?>
    <div>Fecha: <?php echo TimeUtil::prettyDate($travel_date)?></div>
</div>

<p> 
    Este correo usted <b>NO</b> debe responderlo, puede contactar a alguno de los operadores (<a href="mailto:ena@yotellevocuba.com">Ena</a> o <a href="mailto:ana@yotellevocuba.com">Ana</a>). Nos inquieta la siguiente situación:
</p>

<p> 
    <div><?php echo $message ?></div>
</p>

<p>
    <b>Nota:</b> Contactar a un operador es <b>OBLIGATORIO</b> para confirmación de que recibió nuestro 
    comunicado.
</p>
<p>
    Muchísimas gracias y saludos,
</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>
<p>
    <small>
    Este correo le fue enviado porque a este viaje se le está dando seguimiento y ha sido necesario comunicarle alguna situación.
    </small>
</p>