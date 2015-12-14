<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Conversaciones (<?php echo count($driver_travels)?>)</h3>
            <div>Filtros: 
                <ul>
                <?php 
                    foreach (DriverTravel::$filtersForSearch as $filter) {
                        echo '<li style="display:inline-block;padding-right:20px">';

                        if(!isset ($filter_applied)) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
                        else if($filter != $filter_applied) echo $this->Html->link($filter, array('action'=>'view_filtered/'.$filter));
                        else echo '<span class="badge"><big>'.$filter.'</big></span>';

                        echo '</li>';
                    }
                ?>
                </ul>
            </div>

            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <?php if(!empty ($driver_travels)): ?>
            
                <br/>
                <br/>
                
                <!-- SUMMARY -->
                <?php 
                $totalIncome = 0.00;
                $totalSavings = 0.00;
                foreach ($driver_travels as $dt) {
                    $hasMetadata = (isset ($dt['TravelConversationMeta']) && $dt['TravelConversationMeta'] != null && !empty ($dt['TravelConversationMeta']) && strlen(implode($dt['TravelConversationMeta'])) != 0);
                    if($hasMetadata && $dt['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID
                        && $dt['TravelConversationMeta']['income'] != null) {
                        $totalIncome += $dt['TravelConversationMeta']['income'];
                        if($dt['TravelConversationMeta']['income_saving'] != null) $totalSavings += $dt['TravelConversationMeta']['income_saving'];
                    }
                }
                ?>
                
                <?php if($totalIncome > 0):?>
                    <div>Resumen de esta página</div>
                    <big><big>
                        <span class="label label-success">
                            Ganancia Total: $<?php echo $totalIncome;?>
                        </span>
                        <span class="label label-default" style="margin-left:5px">
                            Ahorro Total: $<?php echo $totalSavings;?>
                        </span>
                    </big></big>
                    <br/>
                    <br/>
                <?php endif;?>

                <ul style="list-style-type: none;padding: 0px">
                <?php foreach ($driver_travels as $dt) :?>
                    <li style="margin-bottom: 60px">
                        <?php echo $this->element('conversation_widget', array('conversation'=>$dt));?>
                    </li> 
                <?php endforeach; ?>
                </ul>

                <br/>

        <?php else :?>
            No hay conversaciones
        <?php endif; ?>
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
        </div>

    </div>
</div>