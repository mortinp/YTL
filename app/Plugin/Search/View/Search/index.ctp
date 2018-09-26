<?php 
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
        <div class="col-md-6 col-md-offset-3">
            <p><?php echo "{$case['case']}: <b>{$case['value']}</b>"; ?></p>
            
            <div style="margin-top: 30px">
                <?php if(isset($travels) && !empty ($travels)):?>
                    <p><b>SOLICITUDES DE VIAJE</b></p>
                    <?php if($this->Paginator->counter("{:pages}") > 1): ?><div>Páginas: <?php echo $this->Paginator->numbers();?></div><?php endif;?>
                    <?php if(!empty ($travels)): ?>                
                        <br/>

                        <ul style="list-style-type: none;padding: 0px">
                        <?php foreach ($travels as $travel) :?>                
                            <li style="margin-bottom: 60px">
                                <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>false, 'details'=>true, 'showMoreUserRequests'=>true))?>
                            </li>                
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php elseif(isset($travels)):?>
                    NO HAY SOLICITUDES DE VIAJES
                <?php endif; ?>
            </div>

            <?php if(count($direct_messages) > 0):?>
                <div style="margin-top: 30px">
                    <p><b>SOLICITUDES DIRECTAS</b></p>
                    

                    <ul style="list-style-type: none;padding: 0px">

                        <?php
                        foreach ($direct_messages as $t) {
                            echo '<li style="margin-bottom: 80px">';
                            echo $this->element('conversation_widget', array('conversation'=>$t));
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            <?php endif?>
        
        </div>
    </div>
</div>

<?php
    if(isset($travels) && !empty ($travels)) {
        $drivers_in = array();
        foreach($travels as $travel)
            foreach($travel['DriverTravel'] as $conversation)
                $drivers_in[ $conversation['travel_id'] ][] = $conversation['driver_id'];

        echo $this->element('addon_scripts_notify_driver', compact('drivers_in'));
    }
?>