<div class="panel panel-success control-panel control-panel-in">
    <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="btn-group-vertical btn-group" style="width: 200px">
                        
             <?php $following=false; 
             if(isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta'])){
                $following = $data['TravelConversationMeta']['following'];

             }
            if($following){

                echo $this->Form->button('Quitar seguimiento', array('class'=>'btn-danger', 'action'=>'unfollow/'.$data['DriverTravel']['id']), true);
             }
             else{
                echo $this->Form->button('Seguir esta conversación', array('class'=>'btn-info', 'action'=>'follow/'.$data['DriverTravel']['id']), true);}

             ?>
             
             <?php 
             $hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);

             $unreadMessages = 0;
            if($hasMetadata) {
                if($data['TravelConversationMeta']['read_entry_count'] < $data['DriverTravel']['driver_traveler_conversation_count']) {
                        $unreadMessages = $data['DriverTravel']['driver_traveler_conversation_count'] - $data['TravelConversationMeta']['read_entry_count'];
                }
            } 
                else if($data['DriverTravel']['driver_traveler_conversation_count'] > 0) {
                    $unreadMessages = $data['DriverTravel']['driver_traveler_conversation_count'];
        }
            if($unreadMessages != 0){
                echo $this->Form->button('Marcar todos como leídos', array('class'=>'btn-primary', 'action'=>'update_read_entries/'.$data['DriverTravel']['id'].'/'.count($conversations)), true);
            }

              ?>
             
                <?php
                $color = 'default';
                if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) $color = 'warning';
                else if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) $color = 'success';
                ?>
            <div class="btn-group">
                <button type="button" class="btn btn-<?php echo $color?> dropleft-toggle" data-toggle="dropdown">
                    <?php if ($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_NONE) {
                        echo 'Ninguno';
                    }
                    elseif ($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) {
                         echo '<i class="glyphicon glyphicon-thumbs-up"></i> Realizado';
                     } 
                     elseif ($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) {
                         echo '<i class="glyphicon glyphicon-usd"></i> Pagado';
                     }
                    ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_NONE):?>
                        <li><a class="btn btn-default" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_NONE))?>">Ninguno</a></li>
                    <?php endif?>
                        
                    <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
                        <li><a class="btn btn-warning" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_DONE))?>" title="Marcar si se comprobó que el viaje se realizó"><i class="glyphicon glyphicon-thumbs-up"></i> Realizado</a></li>
                    <?php endif?>

                    <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
                        <li><a class="btn btn-success" href="<?php echo $this->Html->url(array('action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_PAID))?>" title="Marcar si el viaje ya fue pagado por el chofer"><i class="glyphicon glyphicon-usd"></i> Pagado</a></li>
                    <?php endif?>
                </ul>
            </div>
    <?php
    if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) {
        echo $this->element('travel_income_controls', array('thread'=>$data['DriverTravel'], 'conversation'=>$data));
    }
    ?>
        </div>
    </div>
</div>

<?php $this->Html->script('jquery',array('inline' => false)); 
   $this->Html->script('bootbox/bootbox', array('inline' => false));
   echo $this->Js->writeBuffer(array('inline' => false));
?> 

<style type="text/css">
    .control-panel{
        right: 20px;
        position: fixed;
        z-index: 10;
        top: 300px;
        padding: 0px;
        //opacity: 0.5;

        }
        .btn-group-vertical .btn {
            margin: 10px;
        }
</style>

<script type="text/javascript">
     $(document).ready(function(){
        $( ".open-form" ).click(function( event ) {
            //$( '#' + $(this).data('form') ).dialog( "open" );
            bootbox.alert($( '#' + $(this).data('form') ).html());
            event.preventDefault();
        });
     });
 </script>