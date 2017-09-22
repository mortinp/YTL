<?php
App::uses('DriverTravelerConversation', 'Model');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div><?php echo $this->element('date_range_form', array('url'=>array('controller' => 'metrics', 'action' => 'analisis')))?></div>
            <br/>
            Período del <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_ini']?></span></big> al <big><span class="label label-primary"><?php echo $this->request->data['DateRange']['date_end']?></span></big>
        </div>
    </div>
    <br/>
    <div class="row">
        <span class="alert alert-info" style="display: inline-block">
            Este análisis hace lo siguiente:
            <div>
                Busca cuántos de los viajes expirados en el rango de fecha dado fueron solicitados en cada mes; además, también muestra de estos solicitados, cuántos se realizaron.
            </div>
            <div>
                Esto sirve para tener una proyección de en qué meses se solicitan viajes para un mes específico, y cual es el mejor mes para hacer una solicitud.
            </div>
            <div>
                Por ejemplo, puedo saber cuántos viajes de los de Diciembre del 2016 fueron solicitados en cada mes, y de estos cuántos se realizaron, para saber la efectividad de solicitar viajes para Diciembre en cada mes.
            </div>
            <div>
                No se distinguen los viajes por cantidades de personas ni nada... es un analisis global.
            </div>
        </span>
        
        <div class="col-md-12" style="padding-bottom: 50px">
            <div id="analisis-div" style="width: 100%; height: 400px;"></div>
        </div>
        
        
    </div>
</div>

<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('amcharts/amcharts', array('inline' => false));


$this->Js->set('expired_vs_done', $expired_vs_done);
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
    expired_vs_done_chart();
});

function expired_vs_done_chart() {
    var chart;
    var chartData = window.app.expired_vs_done;
    
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
    
    
    // EXPIRADOS
    var graph = new AmCharts.AmGraph();
    graph.title = 'Solicitados';
    graph.valueField = "travels_expired_count";
    graph.balloonText = "[[month]]: [[value]] solicitudes";
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
    
    var legend = new AmCharts.AmLegend();
    legend.position = 'top';
    legend.align = 'center';
    chart.addLegend(legend);

    chart.write("analisis-div");
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