<p>
    <em>Hola viajero. Este correo contiene la respuesta del chofer <b>#<?php echo $driver_id?></b> de YoTeLlevo, notificado con los datos de tu viaje. Para enviar tu respuesta, <b>responde este correo SIN MODIFICAR EL ASUNTO</b>.</em>
</p>
<p><b>El chofer dice:</b></p>
<div>
   <?php 
   //1
   echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $response);
   
   //2
   //echo nl2br($response);
   
   /*//3
   $lines = preg_split("/(\r\n|\n|\r)/", $response);
   foreach ($lines as $l) {
       echo $l."\n";
   }*/
   
   //4
   //echo $response 
   ?>
</div>
<p>-------------</p>