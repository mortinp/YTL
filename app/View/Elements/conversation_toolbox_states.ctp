<!-- STATES -->
<?php
$btnType = 'default';
if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) $btnType = 'warning';
else if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) $btnType = 'success';
?>
<div class="btn-group">
    <div class="input-group">
	<span class="input-group-addon">Estado</span>
        <span class="input-group-btn">
            <button type="button" class="btn btn-<?php echo $btnType?> dropleft-toggle" data-toggle="dropdown">
                <?php 
                if ($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_NONE) echo 'Ninguno';
                elseif ($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) echo '<i class="glyphicon glyphicon-thumbs-up"></i> Realizado';
                elseif ($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) echo '<i class="glyphicon glyphicon-usd"></i> Pagado';
                ?>
                <span class="caret"></span>
            </button>
            <div class="dropdown-menu">
                <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
                    <div><?php echo $this->Form->button('Ninguno', array('class'=>'btn btn-default states-btn col-md-12', 'data-url' => $this->Html->url(array('action' => 'set_state', $data['DriverTravel']['id'], DriverTravelerConversation::$STATE_NONE), true)), true);?></div>
                <?php endif?>

                <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
                    <div><?php echo $this->Form->button('<i class="glyphicon glyphicon-thumbs-up"></i> Realizado', array('class'=>'btn btn-warning states-btn col-md-9 col-xs-9', 'data-url' => $this->Html->url(array('action' => 'set_state', $data['DriverTravel']['id'], DriverTravelerConversation::$STATE_TRAVEL_DONE), true), 'escape'=>false), true);?></div>
                <?php endif?>

                <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
                    <div><?php echo $this->Form->button('<i class="glyphicon glyphicon-usd"></i> Pagado', array('class'=>'btn btn-success states-btn col-md-9 col-xs-9', 'data-url' => $this->Html->url(array('action' => 'set_state', $data['DriverTravel']['id'], DriverTravelerConversation::$STATE_TRAVEL_PAID), true), 'escape'=>false), true);?></div>
                <?php endif?>
            </div>
        </span>        
    </div>
</div> 

<!-- INCOME CONTROLS -->
<?php
if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) {
    echo $this->element('travel_income_controls', array('thread'=>$data['DriverTravel'], 'conversation'=>$data, 'modal'=>true));
}
?>

<?php
    echo $this->Html->script('ajaxify/buttons');
    $this->Html->script('jquery', array('inline' => false));
    echo $this->Js->writeBuffer(array('inline' => false));
?>

<script type="text/javascript">
    function statesSuccess(response){
        var states = $("#states").html(response.conversation_toolbox_states);
        $("#travel_verification_div").html(response.addon_travel_verification).find('button').addClass('btn btn-info btn-block');
        $("#testimonial_request_div").html(response.addon_testimonial_request);
        
        if(response.state == '<?php echo DriverTravelerConversation::$STATE_TRAVEL_PAID; ?>'){
            states.find(".open-form").click(openForm);
            states.find('#income-form-<?php echo $data['DriverTravel']['id']; ?> input[type="text"]').addClass('form-control');
            states.find('#income-form-<?php echo $data['DriverTravel']['id']; ?> input[type="submit"]').addClass('btn btn-primary btn-block');
            states.find('#income-form-<?php echo $data['DriverTravel']['id']; ?> fieldset div').addClass('form-group');
        }    
    }
    
    function statesError(error){
        alert(error.responseText);
    }
    
    ajaxifyButton($('.states-btn'), statesSuccess, statesError);
 </script>