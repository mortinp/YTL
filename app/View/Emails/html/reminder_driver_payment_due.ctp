<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php $driver_name = 'chofer'?>
<?php if($data['Driver']['driver_name'] != null) $driver_name = $data['Driver']['driver_name']?>
<div style="padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6;">
    <div><b>INFO PARA EL PAGO</b></div>
    <div>Usted puede realizar el pago de las comisiones a cualquiera de las siguientes tarjetas:</div>
    <div>-----</div>
    <div>Tarjeta de BANDEC:</div>
    <div><b>9200 0699 9563 1805</b></div>
    <div>-----</div>
    <div>Tarjeta de BANCO METROPOLITANO:</div>
    <div><b>9200 9598 7527 5956</b></div>
    <div>-----</div>
    <div>Para nosotros verificar usted debe decirnos el monto de la transferencia, la fecha y el desglose por cada uno de los viajes pagados.</div>
</div>

<p>Hola <?php echo $driver_name?>,</p>

<p>
    Este es un correo automático que contiene información de los viajes que usted tiene confirmada su realización con nosotros, pero que aún no ha pagado la comisión.
</p>
<p>Los viajes que tenemos pendientes de pago (o realizándose) son los siguientes:</p>
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
    Si usted ya ha pagado alguno de estos viajes, debe enviarnos la fecha del pago o transferencia y el monto total de la misma. Además debe enviarnos un desglose por viajes y monto de la comisión de cada uno.
</p>

<p>
    Puede ser que usted haya realizado otros viajes también pero que aún no hemos verificado o que usted no nos ha confirmado aún. Si tiene viajes sin verificar por favor confírmenos su realización o no.
</p>

<p> 
    Si encuentra algún problema en esta información, por favor póngase en contacto con nosotros a través de este mismo correo. Puede ser que aún no hayamos actualizado toda la información en el sitio o que haya alguna confusión. Siéntase libre de comunicarnos cualquier inconveniente.
</p>

<p>
    Muchísimas gracias y saludos,
</p>
<p>El equipo de <a href="http://yotellevocuba.com">YoTeLlevo</a></p>
<p>
    <small>
    Este correo le fue enviado automáticamente porque tiene viajes realizados y sin pagar. Este recordatorio se le enviará cada 5 días mientras tenga viajes sin pagar.
    </small>
</p>