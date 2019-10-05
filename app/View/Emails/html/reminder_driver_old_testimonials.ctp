<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('DriverTravel', 'Model')?>

<?php
$now = new DateTime(date('Y-m-d', time()));
$daysLastReview = $now->diff(new DateTime($data[0]['last_testimonial_date']), true)->format('%a');
?>

<?php $driver_name = 'chofer'?>
<?php if($data['drivers_profiles']['driver_name'] != null) $driver_name = $data['drivers_profiles']['driver_name']?>
<p>Hola <?php echo $driver_name?>,</p>

<p>Le queremos comentar que la última opinión de clientes que publicamos sobre usted en su perfil de YoTeLlevo es del <?php echo TimeUtil::prettyDate($data[0]['last_testimonial_date'], false)?>, <b>hace <?php echo $daysLastReview?> días</b>.</p>

<p>Le recomendamos tener opiniones frecuentemente porque eso aumenta la efectividad de su perfil. Para los clientes potenciales, esas opiniones son la prueba de la calidad de sus servicios y de su experiencia.</p>

<p><b>¿Cómo hacer que sus clientes pongan una opinión sobre usted en su perfil? Es muy simple!</b></p>

<p>Sólo debe darles esta dirección a sus clientes:</p>

<p><b>yotellevocuba.com/opinion/<?php echo strtoupper($data['drivers_profiles']['driver_code'])?></b></p>

<p>Desde ahí sus clientes van a poder escribir una opinión sobre usted enseguida. Si ahora mismo está con clientes, puede probar a darles esa dirección al finalizar el servicio y enviarlos a escribir una opinión.</p>

<p>Un par de recomendaciones:</p>
<ul>
    <li>Los viajeros que dejan mejores opiniones son los que han viajado con usted durante varios días, porque se crea una relación más fuerte.</li>
    <li>Si puede hacerse una foto con ellos y decirles que la pongan junto con la opinión sería genial! La foto hace que la opinión y su perfil se vean mucho mejor.</li>
</ul>

<p>Al recibir una opinión usted será el primer chofer que se mostrará en nuestro catálogo, desde donde otros posibles clientes le pueden enviar una solicitud directamente sin que le llegue a otros choferes.</p>

<p>Muchos saludos y esperamos tenga en cuenta la sugerencia,</p>
<p>El equipo de <a href="https://yotellevocuba.com">YoTeLlevo</a></p>