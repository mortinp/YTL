<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php $driver_name = 'chofer'?>
<?php if($data['Driver']['driver_name'] != null) $driver_name = $data['Driver']['driver_name']?>
<div style="padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;color: #8a6d3b;background-color: #fcf8e3;border-color: #faebcc;">
    <div><b>AVISO IMPORTANTE</b></div>
    <div>Perdimos las tarjetas de pagos de las comisiones y tuvimos que cancelarlas.</div>
    <div>Vamos a usar la siguiente tarjeta de BPA hasta nuevo aviso. Por favor transferir aquí:</div>
    <div><b>9202 1299 7044 8837</b></div>
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
        <p>
            <a href="<?php  echo $this->Html->url(array('controller'=>'drivers','action'=>'messages', $travel['driver_travel_id'], 'base'=>false), true);
         ?>">Mira esta conversación completa en nuestro sitio Web</a>
        </p>
        
        
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