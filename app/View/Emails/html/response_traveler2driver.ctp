<p>
   <em>Hola chofer. Este correo contiene la respuesta del viajero para el viaje <b>#<?php echo $travel_id?></b>. Para enviar tu respuesta, <b>responde este correo SIN MODIFICAR EL ASUNTO</b>.</em>
</p>
<p><b>El viajero dice:</b></p>
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
