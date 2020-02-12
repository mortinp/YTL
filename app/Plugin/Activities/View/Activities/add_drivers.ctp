<?php
$this->layout ='discounts';
$this->Html->script('common/jquery-1.9.0.min.js', array('inline' => false)); 
$this->Html->script('common/bootstrapnew/bootstrap.min.js', array('inline' => false));
$this->Js->set('drivers', $drivers);
echo $this->Js->writeBuffer(array('inline' => false));

?>
<?php
echo $this->element('form_add_drivers_activity');
?>

<script type="text/javascript">
 $(document).ready(function() {
    // Crear los typeahead
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
       
        
    }
    );
</script>