<?php 
$target_part = 'viajero';
$subject = 'AAA';
$body = 'AAA';

?>


<p><?php echo __d('user_email', 'Hola')?>,</p>

<p>    
    <?php echo __d('user_email', 'Notamos que una respuesta que usted envió recientemente no pudo llegarle al %s. El problema es que probablemente usted haya modificado el asunto del correo original.', $target_part)?>
</p>

<p>    
    <?php echo __d('user_email', '¿No es eso molesto?')?> :)
</p>

<p>    
    <?php echo __d('user_email', 'Para asegurarse de que su respuesta llegue sin problemas al %s solamente <b>vuelva a responder</b> pero esta vez <b>NO MODIFIQUE EL ASUNTO DEL CORREO</b>. ¿De acuerdo?', $target_part)?>
</p>

<p>    
    <?php echo __d('user_email', 'Por otra parte, siéntase libre de hacernos saber cualquier otro problema respondiendo este correo.')?>
</p>

<p>    
    <?php echo __d('user_email', 'A continuación ponemos una copia de su mensaje:')?>
</p>

<div style="border-left: #efefef solid 2px;padding-left: 15px">
    
    <p>    
        <b><?php echo __d('user_email', 'Asunto')?>:</b> <?php echo $subject?>
    </p>
    
    <p>    
        <b><?php echo __d('user_email', 'Mensaje')?>:</b> <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $body)?>
    </p>    
   
</div>

<br/>

<hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-top: 10px;margin-bottom: 10px;"/>
<div class="email-salute">
    <p><?php echo __d('conversation', 'Atentamente, el equipo de <em>YoTeLlevo</em>')?></p>
</div>
