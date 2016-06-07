<?php $casasExpert = Configure::read('casas_expert')?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <p class="lead"><?php echo __d('casas', 'Muchas gracias por solicitar la ayuda de %s y su equipo para encontrar casas.', $casasExpert['name'])?></p>

        <p><?php echo __d('casas', 'Ya les enviamos un correo con los datos de tu solicitud junto con tu correo para que te contacten y comiencen a buscar las casas juntos.')?></p>

        <p><?php echo __d('casas', 'Ellos te harán propuestas hasta que encuentres la casa de renta que te gusta y harán la reservación en tu nombre.')?> <?php echo __d('casas', 'El pago lo realizas directamente a los dueños de las casas cuando llegues.')?></p>

        <p><b><?php echo __d('casas', 'Ahora sólo espera a que %s o alguno de su equipo te contacten para comenzar.', $casasExpert['name'])?></b></p>
        
        <br/>
        <?php echo $this->Html->link('<div class="btn btn-default"><big>&laquo;	'.__('Ver mis anuncios de viajes').'</big></div>', array('controller'=>'travels', 'action'=>'index'), array('escape'=>false))?>
    </div>
</div>



