<!-- Notificación a otros choferes-->
<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('typeaheadjs-bootstrapcss/typeahead.js-bootstrap', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('typeaheadjs/typeahead-martin', array('inline' => false));


$this->Js->set('drivers', $drivers);
echo $this->Js->writeBuffer(array('inline' => false));

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('input.driver-typeahead').typeahead({
            valueKey: 'driver_id',
            local: window.app.drivers,
            template: function(datum) {
                var display = datum.driver_id + ':';
                if(datum.driver_name != null) display += ' <b> ' + datum.driver_name + ' </b>';// Los espacios entre las <b> y el nombre son importantes para poder matchear por el nombre
                display += ' | ' + datum.driver_username;
                display += ' | ' + ' <b> ' + datum.province_name + ' </b>';// Los espacios entre las <b> y la provincia son importantes para poder matchear por la provincia
                display += ' | ' + datum.driver_pax + ' pax';
                
                return display;
            },
            limit: 50
        });
        
        $('input.tt-hint').addClass('form-control');
        $('.twitter-typeahead').css('display', 'block');
    });

</script>