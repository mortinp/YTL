<?php 
    $total_pages = $this->Paginator->counter("{:pages}"); 
    switch($case['case']){
        case 'EMAIL':     $header = "Viajes del usuario {$case['value']}";  break;
        case 'INT':       $header = "Solicitud de viaje #{$case['value']}";  break;
        case 'DATE': 
        case 'DMY_DATE':  $header = "Solicitudes de viaje para el día {$case['value']}";  break;
        case 'DM_DATE':   $header = "Solicitudes de viaje para el día {$case['DAY']} del mes {$case['MONTH']}";  break;
        case 'MY_DATE':   $header = "Solicitudes de viaje para el mes {$case['MONTH']} del año {$case['YEAR']}";  break;     
    }
?>

<div class="container">
    <div class="row">
    <?php if(!empty ($travels) || !empty ($travels_by_email)): ?>
        <div class="col-md-6 col-md-offset-3">
            <h3><?php echo $this->Paginator->counter("({:count}) ").$header; ?></h3>
            <?php if($total_pages > 1): ?><div>Páginas: <?php echo $this->Paginator->numbers();?></div><?php endif;?>
            <?php if(!empty ($travels)): ?>                
                <br/>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($travels as $travel) :?>                
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>false, 'details'=>true, 'showMoreUserRequests'=>true))?>
                    </li>                
                <?php endforeach; ?>
                </ul>
                <br/>
            <?php endif; ?>
            
        </div>

    <?php else :?>
        NO HAY ANUNCIOS DE VIAJES<br/>
        <i><?php echo "[parámetros de la búsqueda => ({$case['case']}: {$case['value']})]"; ?></i>
    <?php endif; ?>

    </div>
</div>

<?php
    $drivers_in = array();
    foreach($travels as $travel)
        foreach($travel['DriverTravel'] as $conversation)
            $drivers_in[ $conversation['travel_id'] ][] = $conversation['driver_id'];

    echo $this->element('addon_scripts_notify_driver', compact('drivers_in'));
?>