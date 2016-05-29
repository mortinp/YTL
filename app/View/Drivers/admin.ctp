<div class="row">
    <div class="col-md-8 col-md-offset-2">
        
        <legend><?php echo $driver['Driver']['username']?></legend>
        
        <br/>
        <legend>Timeline de conversaciones</legend>
        <div id="timeline-div" style="width: 100%; height: 400px;"></div>
        
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
$this->Html->script('amcharts3/amcharts', array('inline' => false));
$this->Html->script('amcharts3/xy', array('inline' => false));
$this->Html->script('amcharts3/light', array('inline' => false));


$this->Js->set('timeline', $timeline);
echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">
$(document).ready(function() {
    timeline_chart();
});

function timeline_chart() {
    var chartData = window.app.timeline;
    
    AmCharts.makeChart("timeline-div", {
        "type": "xy",
        "theme": "light",
        //"marginRight": 80,
        "dataDateFormat": "YYYY-MM-DD",
        "startDuration": 0,
        "trendLines": [],
        "balloon": {
            "adjustBorderColor": false,
            "shadowAlpha": 0,
            "fixedPosition":true
        },
        "graphs": [{
            "balloonText": "<b>[[x]]</b> <b>[[timestr]]</b><br/>[[response_text]]",
            "bullet": "diamond",
            "id": "AmGraph-1",
            "lineAlpha": 0,
            "lineColor": "#b0de09",
            "valueField": "timestr",
            "xField": "date",
            "yField": "driver"
        }, {
            "balloonText": "<b>[[x]]</b> <b>[[timestr]]</b><br/>[[response_text]]",
            "bullet": "round",
            "id": "AmGraph-2",
            "lineAlpha": 0,
            "lineColor": "#fcd202",
            "valueField": "timestr",
            "xField": "date",
            "yField": "traveler"
        }],
        "valueAxes": [{
            "id": "ValueAxis-1",
            "axisAlpha": 0,
            "labelFunction": function(valueText, date, value) {
                var hour = parseInt(valueText / 60);
                if(hour < 10) hour = "0" + hour;

                var min = valueText % 60;
                if(min < 10) min = "0" + min;

                // Sanity check
                if(hour > 24) return "";

                return hour + ":" + min;
            }
        }, {
            "id": "ValueAxis-2",
            "axisAlpha": 0,
            "position": "bottom",
            "type": "date"
        }],
        "allLabels": [],
        "titles": [],
        "dataProvider": chartData,

        "export": {
            "enabled": true
        },

        "chartScrollbar": {
            "offset": 15,
            "scrollbarHeight": 5
        },

        "chartCursor":{
           "pan":false,
           "cursorAlpha":0,
           "valueLineAlpha":0
        }
    });
}
</script>