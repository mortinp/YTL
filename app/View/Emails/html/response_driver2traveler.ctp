********************
<p>
    <em><?php echo __d('conversation', 'Hola viajero. Este correo contiene la respuesta del chofer <b>#%s</b> de YoTeLlevo, notificado con los datos de tu viaje <b>%s</b>. Para enviar tu respuesta, <b>responde este correo sin modificar el asunto</b>.', $driver_id, $travel['origin'].' - '.$travel['destination'])?></em>   
</p>
********************
<p><b><?php echo __d('conversation', 'El chofer dice')?>:</b></p>
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
<!------------------------>