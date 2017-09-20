<?php App::uses('TimeUtil', 'Util')?>

<?php echo Configure::read('email_message_separator')?>

<?php if(!isset ($driver_name)) $driver_name = 'chofer'?>
<p>Hola <?php echo $driver_name?>,</p>
<div>
    <p>
        Has recibido un nuevo mensaje directo de un viajero en nuestro sitio solicitando hacer un viaje contigo. Los detalles del viaje son los siguientes:
    </p>
    <div style="border-left: #efefef solid 2px;padding-left: 15px">
        <p><b>Fecha de inicio del viaje:</b> <?php echo TimeUtil::prettyDate(TimeUtil::dmY_to_Ymd($travel_date))?></p>
        <p><b>Mensaje del viajero:</b></p>
        <p><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $message)?></p>        
    </div>
    
    <p>
        <em><b>NOTA: Este mensaje te llega sólo a tí y a más ningún chofer. Ya este cliente está interesado en hacer el viaje contigo.</b></em>
    </p>
    
    <p> 
        <?php $respondEmail = (Configure::read('conversations_via_app'));?>
        <?php if($respondEmail):?>
            Para comunicarte con el viajero <b>responde este correo sin modificar el asunto</b>
            <b>Nota:</b> Puedes responder desde otro correo, copiando el asunto de este correo en el que vayas a enviar.
        <?php endif?>
    </p>
	
</div>

<p>
    <small>
    Usted recibió este correo porque está registrado en <em>YoTeLlevo</em> como chofer.
    </small>
</p>