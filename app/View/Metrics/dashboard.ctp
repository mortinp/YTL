<?php
App::uses('DriverTravelerConversation', 'Model');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div><?php echo $this->element('date_range_form')?></div>
            <br/>
            Período del <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_ini']?></span></big> al <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_end']?></span></big>
        </div>
    </div>
    <br/>
    <div class="row">
        
        <div class="col-md-6">
            
            <legend>Respuestas <span class="text-muted"><small>(viajes creados y expirados en el período)</small></span></legend>
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
                if($c['TravelConversationMeta']['income'] != null) $paidAmount += $c['TravelConversationMeta']['income'];
                
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
            
            <?php 
            $cantViajes = 0;
            $cantViajesRealizados = 0;
            foreach ($map as $m) {
                $cantViajes += count($m) - count($metaInfo) /*Los indices extra*/;
                $cantViajesRealizados += $m['cant_viajes_done'];
            }
            
            $paidAmount = 0;
            $savedAmount = 0;
            foreach ($incomes as $inc) {
                $paidAmount += $inc['income'];
                $savedAmount += $inc['income_saving'];
            }
            ?>
            <div>
                <big><span class="label label-primary"><?php echo $cantViajes?> viajes encontrados</span></big>
                <big><span class="label label-warning"><i class="glyphicon glyphicon-thumbs-up"></i> <?php echo $cantViajesRealizados?> viajes realizados</span></big>
                <big><span class="label label-success"><i class="glyphicon glyphicon-usd"></i><?php echo $paidAmount?> de ganancia total</span></big>
                <big><span class="label label-default"><i class="glyphicon glyphicon-usd"></i><?php echo $savedAmount?> de ahorro total</span></big>
            </div>
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
        
        <div class="col-md-6">
            <legend>Ganancias <span class="text-muted"><small>(viajes ralizados en el período)</small></span></legend>
            <br/>
            <div id="incomes-div" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>

<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('typeaheadjs-bootstrapcss/typeahead.js-bootstrap', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('typeaheadjs/typeahead-martin', array('inline' => false));
$this->Html->script('amcharts/amcharts', array('inline' => false));


$this->Js->set('incomes', $incomes);
echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">
$(document).ready(function() {

    $('.view-travels, .hide-travels').click(function() {
        $('#' + $(this).data('show') +', #' + $(this).data('hide')).toggle();
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    var chart;
    var chartData = window.app.incomes;
    
    var index = 0;
    for(var i in chartData) {
        chartData[index].date = parseDate(chartData[index].date);
        index++;
    }
        
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "date";
    chart.startDuration = 1;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 90;
    categoryAxis.gridPosition = "start";
    categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
    categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "income";
    graph.balloonText = "[[month]]: $[[value]]";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 0.8;
    chart.addGraph(graph);

    chart.write("incomes-div");
});
</script>
<script type="text/javascript">
    function parseDate(dateString) {            
        var dt = dateString.split(" ");
        var date = dt[0];

        var day, month, year;
        var dateArray = date.split("-");
        if(dateArray.length > 1) {
            day = Number(dateArray[2]);
            month = Number(dateArray[1]) - 1;
            year = Number(dateArray[0]);
        } else {
            dateArray = date.split("/");

            day = Number(dateArray[0]);
            month = Number(dateArray[1]) - 1;
            year = Number(dateArray[2]);
        }  

        date = new Date(year , month , day);
        return date;
    }
</script>