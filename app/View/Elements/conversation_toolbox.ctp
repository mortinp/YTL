<?php $hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);?>          

<div class="control-panel">
    <div style="width: 200px">
        <div class="btn-wrapper">
            <!-- CANTIDAD TOTAL DE MENSAJES-->
            <?php if($data['DriverTravel']['driver_traveler_conversation_count'] > 0):?>
                <span class="label label-primary info" title="Total de mensajes"><?php echo $data['DriverTravel']['driver_traveler_conversation_count']?></span>
            <?php endif?>

            <!-- MENSAJES NUEVOS & MARCAR COMO LEIDOS -->
            <?php 
            $unreadMessages = 0;
            if($hasMetadata) {
                if($data['TravelConversationMeta']['read_entry_count'] < $data['DriverTravel']['driver_traveler_conversation_count']) {
                    $unreadMessages = $data['DriverTravel']['driver_traveler_conversation_count'] - $data['TravelConversationMeta']['read_entry_count'];
                }
            } else if($data['DriverTravel']['driver_traveler_conversation_count'] > 0) {
                $unreadMessages = $data['DriverTravel']['driver_traveler_conversation_count'];
            }
            ?>
            <?php if($unreadMessages != 0):?>
                <span class="label label-success info" style="margin-left:5px" title="Mensajes nuevos">+<?php echo $unreadMessages?></span>

                <?php $firstUnreadMessage = $conversations[count($conversations) - $unreadMessages]['DriverTravelerConversation'];?>
                <span><a href="#message-<?php echo $firstUnreadMessage['id']?>">&ndash; leer nuevos</a></span>

                <br/>
                <br/>
                <?php echo $this->Form->button('Marcar todos como leídos', array('class'=>'btn-primary', 'action'=>'update_read_entries/'.$data['DriverTravel']['id'].'/'.count($conversations)), true);?>
            <?php else:?>
                &nbsp;No mensajes nuevos
            <?php endif?>
        </div>
        
        <div class="btn-wrapper">
            <!-- FOLLOW / UNFOLLOW -->
            <?php $following = $hasMetadata? $data['TravelConversationMeta']['following']: false;?>
            <?php
            if($following) echo $this->Form->button('Quitar seguimiento', array('class'=>'btn-danger', 'action'=>'unfollow/'.$data['DriverTravel']['id']), true);
            else echo $this->Form->button('Seguir esta conversación', array('class'=>'btn-info', 'action'=>'follow/'.$data['DriverTravel']['id']), true);
            ?>
        </div>

        <div class="btn-wrapper">
            <!-- STATES -->
            <?php
            $btnType = 'default';
            if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) $btnType = 'warning';
            else if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) $btnType = 'success';
            ?>
            <div class="btn-group">
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
                        <?php echo $this->Form->button('Ninguno', array('class'=>'btn btn-default', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_NONE), true);?>
                    <?php endif?>

                    <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
                        <?php echo $this->Form->button('<i class="glyphicon glyphicon-thumbs-up"></i> Realizado', array('class'=>'btn btn-warning', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_DONE, 'escape'=>false), true);?>
                    <?php endif?>

                    <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
                        <?php echo $this->Form->button('<i class="<i class="glyphicon glyphicon-usd"></i> Pagado', array('class'=>'btn btn-success', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_PAID, 'escape'=>false), true);?>
                    <?php endif?>
                </div>
            </div>

            <!-- INCOME CONTROLS -->
            <?php
            if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) {
                echo $this->element('travel_income_controls', array('thread'=>$data['DriverTravel'], 'conversation'=>$data, 'modal'=>true));
            }
            ?>
        </div>

        <div class="btn-wrapper">
            <!-- TRAVEL DATE -->
            <?php $fechaCambiada = isset ($data['Travel']['original_date']) && $data['Travel']['original_date'] != null;?>
            <span id='travel-date-label' class="alert alert-success" style="display: inline-block">
                <b><?php echo TimeUtil::prettyDate($data['Travel']['date'])?></b>
                <?php echo $this->element('form_travel_date_controls', array('travel'=>$data, 'keepOriginal'=>!$fechaCambiada, 'originalDate'=>strtotime($data['Travel']['date']), 'modal'=>true))?>
            </span>
            <?php if($fechaCambiada):?>
            <span class="label label-default" title="Fecha original del viaje">
                <span id='travel-date-label'>
                    <?php echo TimeUtil::prettyDate($data['Travel']['original_date'])?>
                </span>
            </span>
            <?php endif;?>
        </div>
    </div>
</div>

<?php
$this->Html->css('bootstrap', array('inline' => false));
$this->Html->css('vitalets-bootstrap-datepicker/datepicker.min', array('inline' => false));

$this->Html->script('jquery', array('inline' => false));
$this->Html->script('bootstrap', array('inline' => false));
$this->Html->script('bootbox/bootbox', array('inline' => false));
$this->Html->script('vitalets-bootstrap-datepicker/bootstrap-datepicker.min', array('inline' => false));

echo $this->Js->writeBuffer(array('inline' => false));
?>


<style type="text/css">
    .control-panel{
        right: 10px;
        position: fixed;
        z-index: 10;
        top: 130px;
        padding: 0px;

    }
    .btn-group-vertical .btn {
        margin: 10px;
    }
    
    .btn-wrapper {
        margin-bottom: 10px;
        padding: 10px;
        border: #efefef solid 2px
    }
    
    .btn-wrapper .btn {
        min-width: 180px;
        max-width: 180px;
    }
    
    /* Esto es un hack para que el datepicker salga por delante del bootbox*/
    .datepicker {
        z-index: 99999 !important;
    }
</style>

<script type="text/javascript">
     $(document).ready(function(){
        $( ".open-form" ).click(function( event ) {
            bootbox.dialog({message:$( '#' + $(this).data('form') ).html()});
            
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                language: '<?php echo Configure::read('Config.language')?>',
                //startDate: 'today',
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: true
            });
            
            event.preventDefault();
        });
     });
 </script>