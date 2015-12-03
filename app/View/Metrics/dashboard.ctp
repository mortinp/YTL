<?php
App::uses('DriverTravelerConversation', 'Model');
?>

<div class="container">
    <div class="row">
        
        <div class="col-md-8 col-md-offset-2">
            <div><?php echo $this->element('date_range_form')?></div>
            <br/>
            
            <?php if(!empty ($conversations)):?>
            
            <?php
            $map = array();
            
            $metaInfo = array('cant_viajes_rep_by_traveler'=>0, 'cant_conv_rep_by_traveler'=>0, 'cant_viajes_done'=>0);
            
            $current = $conversations[0];
            $cantDrivers = 0; // Para contar la cantidad de choferes que respondieron un viaje
            $cantRepliedByTraveler = 0; // Para contar la cantidad de conversaciones respondidos por el viajero
            $counting = true;
            $done = false;
            $paidAmount = 0;
            ?>
            <?php            
            foreach ($conversations as $c) { 
                if($c['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE ||
                   $c['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) 
                {
                    $done = true;
                }
                       
                
                if($current['Travel']['id'] == $c['Travel']['id']) {
                    /*if($c[0]['driver_responses_count'] > 0)*/ $cantDrivers++;
                    if($c[0]['traveler_responses_count'] > 0) $cantRepliedByTraveler++;
                }
                else $counting = false;
                
                if(!$counting){
                    if(!isset ($map[$cantDrivers])) $map[$cantDrivers] = $metaInfo;
                    
                    $map[$cantDrivers][] = $current;
                    $map[$cantDrivers]['cant_conv_rep_by_traveler'] = $map[$cantDrivers]['cant_conv_rep_by_traveler'] + $cantRepliedByTraveler;
                    if($cantRepliedByTraveler > 0) $map[$cantDrivers]['cant_viajes_rep_by_traveler'] = $map[$cantDrivers]['cant_viajes_rep_by_traveler'] + 1;
                    if($done) $map[$cantDrivers]['cant_viajes_done'] = $map[$cantDrivers]['cant_viajes_done'] + 1;
                    
                    $current = $c;
                    $cantDrivers = 1;
                    $counting = true;
                    $done = false;
                    
                    if($c[0]['traveler_responses_count'] > 0) $cantRepliedByTraveler = 1;
                    else $cantRepliedByTraveler = 0;
                }                        
            }
            
            // La ultima conversacion no se analiza en el foreach, asi que hay que hacerlo aqui afuera
            // TODO: Verificar bien si esto pincha asi
            if(!isset ($map[$cantDrivers])) $map[$cantDrivers] = $metaInfo;
            $map[$cantDrivers][] = $current;
            $map[$cantDrivers]['cant_conv_rep_by_traveler'] = $map[$cantDrivers]['cant_conv_rep_by_traveler'] + $cantRepliedByTraveler;
            if($cantRepliedByTraveler > 0) $map[$cantDrivers]['cant_viajes_rep_by_traveler'] = $map[$cantDrivers]['cant_viajes_rep_by_traveler'] + 1;
            if($done) $map[$cantDrivers]['cant_viajes_done'] = $map[$cantDrivers]['cant_viajes_done'] + 1;
            ?>
            <?php ksort($map)?>
            
            
            <div>Estás viendo los <big><span class="label label-primary">viajes respondidos</span></big> creados y expirados dentro del período <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_ini']?></span></big> al <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_end']?></span></big></div>
            <?php 
            $cantViajes = 0;
            foreach ($map as $m) {
                $cantViajes += count($m) - count($metaInfo) /*Los indices extra*/;
            }
            ?>
            <div><big><span class="label label-primary"><?php echo $cantViajes?> viajes encontrados</span></big></div>
            <br/>
            <br/>
            
            
            <?php foreach ($map as $i=>$m):?>
            
                <?php $countTravels = count($m) - count($metaInfo) /*Los indices extra*/?>
                <?php $countConversations = $countTravels * $i?>
                <div><b>Viajes respondidos por <?php echo $i?> choferes</b></div>
                <div>
                    Viajes <span class="badge"><?php echo $countTravels?></span> | 
                    Respondidos por viajero <span class="badge"><?php echo $m['cant_viajes_rep_by_traveler']?></span>
                    <big><span class="label label-success"><?php echo round(($m['cant_viajes_rep_by_traveler']/$countTravels)*100, 2)?>%</span></big> | 
                    Realizados <span class="badge"><?php echo $m['cant_viajes_done']?></span>
                    <big><span class="label label-warning"><?php echo round(($m['cant_viajes_done']/$countTravels)*100, 2)?>%</span></big>
                </div>
                <div>
                    Conversaciones <span class="badge"><?php echo $countConversations?></span> | 
                    Respondidas por viajero <span class="badge"><?php echo $m['cant_conv_rep_by_traveler']?></span>
                    <big><span class="label label-success"><?php echo round(($m['cant_conv_rep_by_traveler']/$countConversations)*100, 2)?>%</span></big>
                </div>
                
                <div id="view-travels-<?php echo $i?>">
                    <a href="#!" class="view-travels" data-show="travels-<?php echo $i?>" data-hide="view-travels-<?php echo $i?>">
                        &ndash; Ver viajes
                    </a>
                </div>
                <div id='travels-<?php echo $i?>' style="display:none">
                    <div>
                        <a href="#!" class="hide-travels" data-show="view-travels-<?php echo $i?>" data-hide="travels-<?php echo $i?>">
                            &ndash; Ocultar viajes
                        </a>
                    </div>
                    <?php foreach ($m as $i=>$c):?>
                        <?php if(key_exists($i, $metaInfo)) continue?>
                        <div><?php echo $c['Travel']['origin'].' - '.$c['Travel']['destination']?></div>
                    <?php endforeach;?>
                </div>
                
                <hr/>
                <br/>
            
            <?php endforeach;?>
                
            <?php endif?>
            
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {

    $('.view-travels, .hide-travels').click(function() {
        $('#' + $(this).data('show') +', #' + $(this).data('hide')).toggle();
    });
});
</script>