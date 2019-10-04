<?php
App::uses('Driver', 'Model');
?>

<?php
$driver_name = Driver::shortenName($profile_data['driver_name']);
$driver_code = $profile_data['driver_code'];
$conversationID = $profile_data['conversation']; 

if(!isset ($traveler_name) || $traveler_name == null) $traveler_name = '';
else $traveler_name = ' '.$traveler_name;
?>

<p><?php echo __d('user_email', 'Hola')?><?php echo $traveler_name?>,</p>

<p><?php echo __d('user_email', 'Queremos enviarle un INMENSO GRACIAS por haber decidido usar a %s como su chofer aquí en Cuba, y esperamos que la hayan pasado súper bien en la isla. Seguro recorrieron muchos lugares y la pasaron genial', $driver_name)?> :)</p>

<p><?php echo __d('user_email', 'Mil gracias por confiar en nosotros y en %s.', $driver_name)?></p>

<p><?php echo __d('user_email', 'Queríamos aprovechar este correo y pedirle que si les gustó genuinamente su viaje, por favor escriba una opinión sobre él en nuestro sitio. Eso sería de gran ayuda porque otros viajeros podrían inspirarse con su testimonio y sentirse más seguros al contratarlo.')?></p>

<p><?php echo __d('user_email', 'Si tiene unos minutos puede escribir rápidamente un testimonio sobre %s aquí', $driver_name)?>:</p>

<p style="margin-top:30px;margin-bottom:30px;">
    <span>
        <a  style="padding:10px;color: #333;background-color: #ebebeb;border-color: #adadad;text-decoration: none"
            href="https://yotellevocuba.com/opinion/<?php echo $driver_code?>/<?php echo $conversationID ?>"
            target="_blank">
            <b><?php echo __d('user_email', 'Enviarle una opinión a %s', $driver_name)?> »</b>
        </a>
    </span>
<p/>

<p><?php echo __d('user_email', 'Un testimonio se ve mucho mejor con una foto de su viaje; si tiene una a la mano sería genial que la pusiera junto con el comentario - aunque no es obligatorio, por supuesto')?> :)</p>

<p><?php echo __d('user_email', 'Le queremos enviar las gracias por adelantado de nuestra parte y de parte de %s también. Esperamos que se hayan sentido bien en Cuba.', $driver_name)?></p>

<p><?php echo __d('user_email', 'Saludos y ojalá podamos servirle en otra ocasión nuevamente.')?></p>

<p><?php echo __d('user_email', 'Hasta pronto')?>!</p>

<p><?php echo __d('user_email', '%s y el equipo de YoTeLlevo', 'Yuniel')?></p>

<p><?php echo __d('user_email', 'PD: De verdad, una opinión es algo que haría muy feliz a %s', $driver_name)?> :)</p>