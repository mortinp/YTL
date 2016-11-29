<?php 
$hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);

$now = new DateTime(date('Y-m-d', time()));

$date_converted = strtotime($data['Travel']['date']);
$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
if($expired) {
    $daysExpired = $now->diff(new DateTime($data['Travel']['date']), true)->format('%a');
}

$hasMessages = count($conversations) > 0;
if($hasMessages) {
    $lastMessage = $conversations[count($conversations) - 1]['DriverTravelerConversation'];
    $daysLastMessage = $now->diff(new DateTime($lastMessage['created']), true)->format('%a');
}

$daysToGo = $now->diff(new DateTime($data['Travel']['date']), true)->format('%a');
?>          

<div class="control-panel">
    <div class="control-panel-frame">
        
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
                <span><a href="#!" class="last-msg" data-where="message-<?php echo $firstUnreadMessage['id']?>">&ndash; leer nuevos</a></span>
                <!--<span><a href="#!" class="next-msg" data-where="message-<?php echo $conversations[0]['DriverTravelerConversation']['id']?>">&ndash; próximo</a></span>-->

                <br/>
                <br/>
                <?php echo $this->Form->button('Marcar todos como leídos', array('class'=>'btn btn-primary', 'action'=>'update_read_entries/'.$data['DriverTravel']['id'].'/'.count($conversations)), true);?>
            <?php else:?>
                &nbsp;No mensajes nuevos
            <?php endif?>
            <br/>
            <br/>
            <?php echo $this->Html->link('Ver otras conversaciones »', array('controller'=>'travels', 'action'=>'admin', $data['Travel']['id']), array('target'=>'_blank', 'title'=>'Ver las demás conversaciones de este viajero con otros choferes', 'class'=>'info', 'data-placement'=>'left'));?>
        </div>
        <br/>
        <br/>
        
        <div class="btn-wrapper">
            <!-- FOLLOW / UNFOLLOW -->
            <?php $following = $hasMetadata? $data['TravelConversationMeta']['following']: false;?>
            
            <?php if($following):?>
                <div class="input-group info" title="Esta conversación se está Siguiendo" data-placement="left">
                    <span class="input-group-addon">
                        <span class="label label-info">Siguiendo</span>
                    </span>
                    <span class="input-group-btn">
                        <?php echo $this->Form->button('Quitar', array('class'=>'btn-danger', 'action'=>'unfollow/'.$data['DriverTravel']['id']), true);?>
                    </span>
                </div>
            <?php else:?>
                <?php echo $this->Form->button('Seguir esta conversación', array('class'=>'btn-info', 'action'=>'follow/'.$data['DriverTravel']['id']), true);?>
                <br/>
            <?php endif?>
            
            <br/>
            
            <!-- FLAG / UNFLAG -->
            <?php $flagged = $hasMetadata && $data['TravelConversationMeta']['flag_type'] != null? true:false?>
            <?php if($flagged) :?>
            
            <div class="input-group info" title="<b>Comentario Pin:</b><br/><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $data['TravelConversationMeta']['flag_comment']);?>" data-placement="left">
                    <span class="input-group-addon">
                        <span class="label label-warning">
                            <a href="#!" class="open-form" data-form="form-flag-comment"><i class="glyphicon glyphicon-pushpin"></i> Pineado</a>
                        </span>
                    </span>
                    <span class="input-group-btn">
                        <?php echo $this->Form->button('Quitar', array('class'=>'btn-danger', 'action'=>'unpin/'.$data['DriverTravel']['id']), true);?>
                    </span>
                </div>
            
            <?php else:?>
                <?php echo $this->Form->static_button('<i class="glyphicon glyphicon-pushpin"></i> Pinear', array('class'=>'btn-warning open-form info', 'data-form'=>'form-flag-comment', 'data-placement'=>'left', 'title'=>'Pinea este viaje para darle un seguimiento especial: si hay problemas, si te parece importante, si lo estás gestionando personalmente, etc.'));?>
            <?php endif?>
            
            <div id="form-flag-comment" style="display: none">
                <?php echo $this->element('form_conversation_flag_comment', array('data' => $data)); ?>
            </div>
            
        </div>

        <div class="btn-wrapper">
            <!-- STATES -->
            <?php
            $btnType = 'default';
            if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_DONE) $btnType = 'warning';
            else if($data['TravelConversationMeta']['state'] == DriverTravelerConversation::$STATE_TRAVEL_PAID) $btnType = 'success';
            ?>
            <div class="btn-group">
                <div class="input-group">
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
                                <div><?php echo $this->Form->button('Ninguno', array('class'=>'btn btn-default', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_NONE), true);?></div>
                            <?php endif?>

                            <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_DONE):?>
                                <div><?php echo $this->Form->button('<i class="glyphicon glyphicon-thumbs-up"></i> Realizado', array('class'=>'btn btn-warning', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_DONE, 'escape'=>false), true);?></div>
                            <?php endif?>

                            <?php if($data['TravelConversationMeta']['state'] != DriverTravelerConversation::$STATE_TRAVEL_PAID):?>
                                <div><?php echo $this->Form->button('<i class="glyphicon glyphicon-usd"></i> Pagado', array('class'=>'btn btn-success', 'action'=>'set_state/'.$data['DriverTravel']['id'].'/'.DriverTravelerConversation::$STATE_TRAVEL_PAID, 'escape'=>false), true);?></div>
                            <?php endif?>
                        </div>
                    </span>
                    <span class="input-group-addon">Estado</span>
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
            <span class="alert alert-success" style="display: inline-block; margin-bottom: 0px">
                <b><?php echo TimeUtil::prettyDate($data['Travel']['date'])?></b>
                <?php echo $this->element('form_travel_date_controls', array('travel'=>$data, 'keepOriginal'=>!$fechaCambiada, 'originalDate'=>strtotime($data['Travel']['date'])))?>
            </span>
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
        top: 120px;
        padding: 0px;

    }
    .control-panel-frame {
        width: 210px;
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
        min-width: 100%;
    }
    
    /* Esto es un hack para que el datepicker salga por delante del bootbox*/
    .datepicker {
        z-index: 99999 !important;
    }
</style>

<script type="text/javascript">
    
    function goTo(id) {
        $('html, body').animate({
            scrollTop: $('#' + id).offset().top
        }, 300);
    };
    
    $(document).ready(function(){
        $( ".open-form" ).click(function( event ) {
            bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('form') ).html()});

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

        $('.last-msg').click(function() {
            goTo($(this).data('where'));
        });
    });
 </script>
 
 <script type="text/javascript">
    
    
</script>