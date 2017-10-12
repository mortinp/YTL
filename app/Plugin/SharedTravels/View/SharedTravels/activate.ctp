<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>
<div class="container">
    <div class="row" style="margin-top: 40px">
        <div class="col-md-8 col-md-offset-2">
            <p class="lead"><?php echo __d('shared_travels', 'Muchas gracias %s', $request['SharedTravel']['name_id'])?>!</p> 
            <p class="lead"><?php echo __d('shared_travels', 'Nuestros operadores acaban de recibir los datos de tu solicitud y enseguida empiezan a organizar todo. En menos de 24 horas recibirás la confirmación.')?></p> 
            <p><?php echo __d('shared_travels', 'En cuanto todo esté listo recibirás un correo de tu operador asistente, con quien quedarás en contacto mientras llega la fecha del servicio.')?></p>
            <p><?php echo __d('shared_travels', 'Estos son todos los datos de tu solicitud')?>:</p>
        </div>
        
        <div class="col-md-8 col-md-offset-2">
            <hr/>
            <?php echo $this->element('shared_travel', compact('request'))?>
        </div>
    </div>
</div>