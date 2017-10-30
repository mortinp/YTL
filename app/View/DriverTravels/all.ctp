<?php 
if(!isset($actions)) $actions = false;
if(!isset($details)) $details = true;
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>Conversaciones (<?php echo count($driver_travels)?>)</h3>
            
            <div>Páginas: <?php echo $this->Paginator->numbers();?></div>
            <br/>
            <?php echo $this->element('addon_filters_for_search', array('filters_for_search'=>DriverTravel::$filtersForSearch))?>
        </div>
        <div class="col-md-8 col-md-offset-2">
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
                            Ganancia Total: $<span id="income-total"><?php echo $totalIncome;?></span>
                        </span>
                        <span class="label label-default" style="margin-left:5px">
                            Ahorro Total: $<span id="income-save-total"><?php echo $totalSavings;?></span>
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
        
        <!-- all .open-form opens in a bootbox -->
        <?php
            $this->Html->css('bootstrap', array('inline' => false));
            $this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));

            $this->Html->script('jquery', array('inline' => false));
            $this->Html->script('bootstrap', array('inline' => false));
            $this->Html->script('bootbox/bootbox', array('inline' => false));
            $this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

            echo $this->Js->writeBuffer(array('inline' => true));
        ?>
        
        <script type="text/javascript"> 
            $(document).ready(function(){
                $(".open-form").click(
                    function (event){
                        bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('form') ).html()});
                        event.preventDefault();
                    }
                );
            });
        </script>

    </div>
</div>