<div id="conversation-header">
    <p>
        <em>Hola chofer. Este correo contiene la respuesta del viajero para el viaje <b>#<?php echo $travel['id']?></b> (<b><?php echo $travel['origin'].' - '.$travel['destination']?></b>). Para enviar tu respuesta, <b>responde este correo sin modificar el asunto</b>.</em>
    </p>
</div>
<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-bottom: 10px;"/>

<p><b>El viajero dice:</b></p>
<div style="border-left: #efefef solid 2px;padding-left: 15px">
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

<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-top: 10px;margin-bottom: 10px;"/>
<div class="email-salute">
    <p><?php echo __d('conversation', 'Atentamente, el equipo de <em>YoTeLlevo</em>')?></p>
</div>