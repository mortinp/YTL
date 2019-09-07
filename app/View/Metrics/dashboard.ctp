<?php
App::uses('DriverTravelerConversation', 'Model');
?>

<?php 
$cantViajes = 0;
$cantViajesExpirados = 0;
$cantViajesRealizados = 0;
$cantViajesRealizadosNoPagados = 0;
foreach ($travels_count as $c) {
    if(isset ($c['travels_created_count'])) $cantViajes += $c['travels_created_count'];
    if(isset ($c['travels_expired_count'])) $cantViajesExpirados += $c['travels_expired_count'];
    if(isset ($c['travels_done_count'])) $cantViajesRealizados += $c['travels_done_count'];
    if(isset ($c['travels_done_not_paid_count'])) $cantViajesRealizadosNoPagados += $c['travels_done_not_paid_count'];
}

$paidAmount = 0;
$savedAmount = 0;
foreach ($incomes as $inc) {
    $paidAmount += $inc['income'];
    $savedAmount += $inc['income_saving'];
}
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div><?php echo $this->element('date_range_form')?></div>
            <br/>
            Período del <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_ini']?></span></big> al <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_end']?></span></big>
        </div>
        <div class="col-md-8 col-md-offset-2" style="text-align: center">
            <br/><br/>
            <div class="col-md-6">
                <big><span class="label label-warning">Índice Realizados (Realizados / Expirados)</span></big>
                <div><b><big><big><?php echo round($cantViajesRealizados*100 / $cantViajesExpirados, 0)?>%</big></big></b></div>
            </div>
            <div class="col-md-6">
                <big><span class="label label-success">Ingreso Medio por Viaje Realizado</span></big>
                <div><b><big><big>$<?php echo round($paidAmount / $cantViajesRealizados, 0)?></big></big></b></div>
            </div>
        </div>
    </div>
    <br/>
    <br/><br/>
    <div class="row">
        
        <div class="col-md-12" style="text-align: center">
            <legend>Viajes</legend>
            <br/>
            <div>
                <big><span class="label label-primary"><?php echo $cantViajes?> solicitudes creadas</span></big>
                <big><span class="label label-default info" title="Estas son solicitudes que la fecha de realización del viaje expira ese mes. Puede ser que la solicitud se haya creado antes."><?php echo $cantViajesExpirados?> solicitudes expiradas</span></big>
                <big><span class="label label-warning info" title="Un viaje puede consistir en recorridos por varios destinos durante varios días con un mismo chofer -de hecho esto es lo que más sucede."><i class="glyphicon glyphicon-thumbs-up"></i> <?php echo $cantViajesRealizados?> viajes realizados</span></big>
                <big><span class="label label-danger"><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $cantViajesRealizadosNoPagados?> viajes sin pagar</span></big>
            </div>
            <br/>
        </div>
        <div class="col-md-12" style="padding-bottom: 50px">
            <div id="travels-count-div" style="width: 100%; height: 400px;"></div>
        </div>
        
        
        <div class="col-md-12" style="text-align: center">
            <legend>Ganancias</legend>
            <br/>
            <div>            
                <big><span class="label label-success info" title="Esto es dinero en mano. No se cuentan viajes realizados de los que no hemos recibido el dinero."><i class="glyphicon glyphicon-usd"></i><?php echo $paidAmount?> de ingresos totales</span></big>
                <?php if($userLoggedIn && $userRole == 'admin'):?><big><span class="label label-default"><i class="glyphicon glyphicon-usd"></i><?php echo $savedAmount?> de ahorro total</span></big><?php endif?>
            </div>
            <br/>
        </div>
        <div class="col-md-12" style="text-align: center">
            <div id="incomes-div" style="width: 100%; height: 400px;"></div>
        </div>
        
        
        <div class="col-md-12" style="text-align: center">
            <legend>Engagement</legend>
            <br/>
            <?php 
            $totalMsgDrivers = 0;
            $totalMsgTravelers = 0;
            foreach ($messages_count as $msgs) {
                if(isset ($msgs['messages_count_drivers'])) $totalMsgDrivers += $msgs['messages_count_drivers'];
                if(isset ($msgs['messages_count_travelers'])) $totalMsgTravelers += $msgs['messages_count_travelers'];
            }
            ?>
            <div>            
                <big><span class="label label-primary"><i class="glyphicon glyphicon-comment"></i> <?php echo $totalMsgDrivers?> mensajes de choferes</span></big>
                <big><span class="label label-warning"><i class="glyphicon glyphicon-comment"></i> <?php echo $totalMsgTravelers?> mensajes de viajeros</span></big>
            </div>
            <br/>
        </div>
        <div class="col-md-12" style="text-align: center;padding-bottom: 50px">
            <div id="messages-count-div" style="width: 100%; height: 400px;"></div>
        </div>
        
        
    </div>
</div>

<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('amcharts/amcharts', array('inline' => false));


$this->Js->set('incomes', $incomes);
$this->Js->set('travels_count', $travels_count);
$this->Js->set('messages_count', $messages_count);
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
    incomes_chart();
    travels_count_chart();
    messages_count_chart();
});

function incomes_chart() {
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
    
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular";
    valueAxis.gridAlpha = 0.1;
    valueAxis.axisAlpha = 0;
    chart.addValueAxis(valueAxis);

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "income";
    graph.balloonText = "[[month]]: $[[value]] ingresos";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#5cb85c";
    chart.addGraph(graph);
    
    <?php if($userLoggedIn && $userRole == 'admin'):?>
    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "income_saving";
    graph.balloonText = "[[month]]: $[[value]] ahorro";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#999";
    chart.addGraph(graph);
    
    <?php endif?>

    chart.write("incomes-div");
}

function travels_count_chart() {
    var chart;
    var chartData = window.app.travels_count;
    
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
    categoryAxis.minPeriod = "MM"; // our data is monthly, so we set minPeriod to MM
    
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular";
    valueAxis.gridAlpha = 0.1;
    valueAxis.axisAlpha = 0;
    chart.addValueAxis(valueAxis);

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.
    
    
    // CREADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Solicitados';
    graph.valueField = "travels_created_count";
    graph.balloonText = "[[month]]: [[value]] solicitudes creadas";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#428bca";
    chart.addGraph(graph);
    
    // EXPIRADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Expirados';
    graph.valueField = "travels_expired_count";
    graph.balloonText = "[[month]]: [[value]] solicitudes expiradas";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#808080";
    chart.addGraph(graph);

    // REALIZADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Realizados';
    graph.valueField = "travels_done_count";
    graph.balloonText = "[[month]]: [[value]] viajes realizados";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#f0ad4e";
    chart.addGraph(graph);
    
    // REALIZADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Sin pagar';
    graph.valueField = "travels_done_not_paid_count";
    graph.balloonText = "[[month]]: [[value]] viajes sin pagar";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#d9534f";
    chart.addGraph(graph);
    
    
    var legend = new AmCharts.AmLegend();
    legend.position = 'top';
    legend.align = 'center';
    chart.addLegend(legend);

    chart.write("travels-count-div");
}


function messages_count_chart() {
    var chart;
    var chartData = window.app.messages_count;
    
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
    categoryAxis.minPeriod = "MM"; // our data is monthly, so we set minPeriod to MM
    
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular";
    valueAxis.gridAlpha = 0.1;
    valueAxis.axisAlpha = 0;
    chart.addValueAxis(valueAxis);

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.
    
    
    // CREADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Choferes';
    graph.valueField = "messages_count_drivers";
    graph.balloonText = "[[month]]: [[value]] mensajes de choferes";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#428bca";
    chart.addGraph(graph);
    
    // EXPIRADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Viajeros';
    graph.valueField = "messages_count_travelers";
    graph.balloonText = "[[month]]: [[value]] mensajes de viajeros";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.fillColors = "#f0ad4e";
    chart.addGraph(graph);
    
    var legend = new AmCharts.AmLegend();
    legend.position = 'top';
    legend.align = 'left';
    chart.addLegend(legend);

    chart.write("messages-count-div");
}



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