<?php
$casasExpert = Configure::read('casas_expert');
?>
<div>
    <p>Hola <?php echo $casasExpert['name']?> y equipo,</p>
    <p>Aquí les va una nueva solicitud de casas (#<?php echo $request_id?>). Estos son los detalles:</p>
        <p><b>Nombre(s):</b> <?php echo $guests_names?></p>
        <p><b>Detalles:</b> <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $details);?></p>
        <p><b>Correo de contacto:</b> <?php echo $contact_email?></p>
    <p>Pónganse en contacto con ellos para atender su solicitud.</p>    
    <p>Saludos,</p>    
    <p>Martín</p>
</div>

<p><small>Nota: Este correo lo generó automáticamente <a href="http://yotellevocuba.com">YoTeLlevo</a> después de haberse creado la solicitud de casas.</small></p>