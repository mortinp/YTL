<div>  
    <span id="date-change-set-<?php echo $request['SharedTravel']['id']?>" style="display: inline-block">
        <a href="#!" class="open-form edit-date-change-<?php echo $request['SharedTravel']['id']?>" data-form="date-change-form-<?php echo $request['SharedTravel']['id']?>">&ndash; <?php echo __('cambiar fecha')?></a>
    </span>
    <span id="date-change-cancel-<?php echo $request['SharedTravel']['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-date-change-<?php echo $request['SharedTravel']['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='date-change-form-<?php echo $request['SharedTravel']['id']?>' style="display:none">
        <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared_travels', 'action' => 'change_date/'.$request['SharedTravel']['id'])));?>
        <fieldset>
            <?php echo $this->Form->custom_date('date', array('label' => 'Cambiar fecha', 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'))?>
            <?php if($keepOriginal) echo $this->Form->input('original_date', array('type' => 'hidden', 'value' => CakeTime::format($originalDate, '%Y/%m/%d')))?>
            <?php echo $this->Form->submit('Cambiar')?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));

$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));

$this->Html->script('bootbox/bootbox', array('inline' => false));
$this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

$this->Html->script('jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
$this->Html->script('jquery-validation-1.10.0/localization/messages_'.Configure::read('Config.language'), array('inline' => false));

echo $this->Js->writeBuffer(array('inline' => false));
?>
<script type="text/javascript">
    
    function openForm(event) {
        bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('form') ).html()});
        
        form = $('.bootbox form');
        datepicker = form.find('.datepicker');

        datepicker.datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo Configure::read('Config.language')?>',
            //startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        form.validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });

        $('.bootbox .datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo Configure::read('Config.language')?>',
            //startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        
        event.preventDefault();
    }
            

    $(document).ready(function(){
        $( ".open-form" ).click(openForm);
    });
 </script>