
<div id="DateRangeFormDiv">
<?php echo $this->Form->create('DateRange', array('type' => 'get', 'url' => array('controller' => 'metrics', 'action' => 'dashboard'), 'id'=>'DateRangeForm'));?>
<fieldset>
    <div class="col-md-6"><?php echo $this->Form->custom_date('date_ini', array('label' => __('Fecha Incio'), 'dateFormat' => 'dd/mm/yyyy'))?></div>
    <div class="col-md-6"><?php echo $this->Form->custom_date('date_end', array('label' => __('Fecha Fin'), 'dateFormat' => 'dd/mm/yyyy'))?></div>
    <?php $submitOptions = array('id'=>'DateRangeSubmit', 'class'=>'btn btn-primary btn-block')?>
    <div class="col-md-12"><?php echo $this->Form->submit('Ver', $submitOptions)?></div>
</fieldset>
<?php echo $this->Form->end(); ?>
</div>


<?php
// CSS
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));

//JS
$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));

$this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
$this->Html->script('jquery-validation-1.10.0/localization/messages_es', array('inline' => false));



echo $this->Js->writeBuffer(array('inline' => false));

?>

<script type="text/javascript">    
    $(document).ready(function() {   
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo Configure::read('Config.language')?>',
            endDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        
        $('#DateRangeForm').validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });
    })
</script>