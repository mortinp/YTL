<?php App::uses('TimeUtil', 'Util')?>


<div style="text-align: center;width: 100%">**********</div>

<?php if(!isset ($driver_name)) $driver_name = 'chofer'?>
<p>Hola <?php echo $driver_name?>,</p>

<p>
    Este correo tiene la intención de verificar la realización del viaje <b>#<?php echo $travel_id?></b> que debe haberse realizado o estarse realizando hace unos días. Esperamos todo haya salido bien. 
</p>
<p>Solo como recordatorio, el viaje fue creado con los siguientes datos:</p>
<div style="border-left: #efefef solid 2px;padding-left: 15px"> 
    <div><big><?php echo $travel_origin?> - <?php echo $travel_destination?></big></div>
    <div>Fecha: <?php echo TimeUtil::prettyDate($travel_date)?></div>
</div>

<p> 
    Este correo usted debe responderlo <b>sin modificar el asunto</b> para confirmar la realización o no de dicho viaje y hacer lo siguiente según sea el caso:
</p>
<ul>
    <li>En caso de que <b>Sí se haya realizado el viaje</b>, incluya en el cuerpo de su correo el <b>total ingresado por el viaje</b> y una breve explicación si es necesario.</li>
    <li>En caso de que <b>No se haya realizado el viaje</b>, incluya en el cuerpo de su correo una breve explicación.</li>
</ul>
<p>
    Nosotros almacenaremos su correo para luego verificarlo. Muchísimas gracias y saludos.
</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>
<p>
    <small>
    Este correo le fue enviado automáticamente porque a este viaje se le está dando seguimiento y lo tenemos como posible a haberse realizado.
    </small>
</p>