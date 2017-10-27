<?php if($userLoggedIn && $userRole == 'admin' && in_array($data['Travel']['people_count'], array(2, 3))):?>
<div id="shared_ride_addon">
    <span class="alert alert-warning" style="display: inline-block; width: 100%">
        <?php if(!$data['Travel']['User']['shared_ride_offered']):?>
           Se enviará correo en <b><?php echo $data['Travel']['User']['lang']?></b>  
        <?php echo $this->Form->button('<i style="padding: 5px" class="glyphicon glyphicon-heart-empty"></i> Enviar oferta de viajes compartidos', 
            array('controller' => 'driver_travels',
                  'action' => "offer_shared_ride/".$data['DriverTravel']['id'],
                  'confirm' => 'Está a punto de enviar un correo de oferta de viaje compartido a este viajero. ¿Desea continuar?',
                  'class'=>'btn-warning btn btn-block',
            ), array('escape'=>false));
        ?>	
        <?php else: ?>
        Ya se envió la oferta de viaje compartido...
        <?php endif; ?>
    </span>
</div>   
<?php endif; ?>