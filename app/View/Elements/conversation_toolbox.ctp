<?php app::uses('TimeUtil', 'Util'); ?>
<?php App::uses('DriverTravel', 'Model')?>

<?php 
$hasMetadata = (isset ($data['TravelConversationMeta']) && $data['TravelConversationMeta'] != null && !empty ($data['TravelConversationMeta']) && strlen(implode($data['TravelConversationMeta'])) != 0);

$now = new DateTime(date('Y-m-d', time()));

$travelDate = DriverTravel::extractDate($data);
$date_converted = strtotime($travelDate);
$expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
if($expired) {
    $daysExpired = $now->diff(new DateTime($travelDate), true)->format('%a');
}

$hasMessages = count($conversations) > 0;
if($hasMessages) {
    $lastMessage = $conversations[count($conversations) - 1]['DriverTravelerConversation'];
    $daysLastMessage = $now->diff(new DateTime($lastMessage['created']), true)->format('%a');
}

$daysToGo = $now->diff(new DateTime($travelDate), true)->format('%a');


echo $this->Html->script('ajaxify/buttons');
$this->Html->script('jquery', array('inline' => false));
$this->Js->set('operator', User::prettyName( AuthComponent::user() ));
echo $this->Js->writeBuffer(array('inline' => false));

?>          
<div class="row">

        <div class="col-md-12">     
            <!-- CANTIDAD TOTAL DE MENSAJES-->
            <?php if($data['DriverTravel']['message_count'] > 0):?>
                <span class="label label-primary info" title="Total de mensajes"><?php echo $data['DriverTravel']['message_count']?></span>
            <?php endif?>

            <!-- MENSAJES NUEVOS & MARCAR COMO LEIDOS -->
            <?php 
            $unreadMessages = 0;
            if($hasMetadata) {
                if($data['TravelConversationMeta']['read_entry_count'] < $data['DriverTravel']['message_count']) {
                    $unreadMessages = $data['DriverTravel']['message_count'] - $data['TravelConversationMeta']['read_entry_count'];
                }
            } else if($data['DriverTravel']['message_count'] > 0) {
                $unreadMessages = $data['DriverTravel']['message_count'];
            }
            ?>
            <?php if($unreadMessages != 0):?>
                <span id="unreadMessages">
                    <span class="label label-success info" style="margin-left:5px" title="Mensajes nuevos">+<?php echo $unreadMessages?></span>

                    <?php $firstUnreadMessage = $conversations[count($conversations) - $unreadMessages]['DriverTravelerConversation'];?>
                    <span><a href="#!" class="last-msg" data-where="message-<?php echo $firstUnreadMessage['id']?>">&ndash; leer nuevos</a></span>

                    <br/>
                    <br/>
                    <?php echo $this->Form->button('Marcar todos como leídos', array('id' => 'ajax-leer', 'data-url' => $this->Html->url(array('action' => 'update_read_entries', $data['DriverTravel']['id'], count($conversations)), true), 'class'=>'btn btn-primary'), true);?>
                </span>
            <?php else:?>
                &nbsp;No mensajes nuevos
            <?php endif?>
            <br/>
            <br/>
            <?php echo $this->Html->link('Otras conversaciones »', array('controller'=>'travels', 'action'=>'admin', $data['Travel']['id']), array('target'=>'_blank', 'title'=>'Ver las demás conversaciones de este viajero con otros choferes', 'class'=>'info', 'data-placement'=>'bottom','style'=>'color: #0c0b0b!important'));?>
        <hr>
        </div>
        <br/>
        <br/>
		
        
        <!-- <div class="btn-wrapper">
            <div class="input-group" title="Enviar mensaje directo al chofer" data-placement="left">                
                <span class="btn btn-info">Escribir al chofer                
                    <span class="glyphicon glyphicon-send"></span>                
                </span>
            </div>
        </div>-->
        <div class="col-md-12">
        
            <!-- FOLLOW / UNFOLLOW -->
            <?php $following = $hasMetadata? $data['TravelConversationMeta']['following']: false;?>
            
            <div class="input-group info follow col-md-9" title="Esta conversación se está Siguiendo" data-placement="bottom" style="display: <?php echo ($following) ? 'table' : 'none'; ?>;">
                <span class="input-group-addon">
                    <span class="label label-info">Siguiendo</span>
                </span>
                <span class="input-group-btn">
                    <?php echo $this->Form->button('Quitar', array('class'=>'btn-danger follow-btn', 'data-url' => $this->Html->url(array('action' => 'unfollow', $data['DriverTravel']['id']), true)), true);?>
                </span>
            </div>

            <div class="input-group info follow" style="display: <?php echo ($following) ? 'none' : 'table'; ?>">
                <?php echo $this->Form->button('<i class="glyphicon glyphicon-check"></i> Seguir', array('class'=>'btn-info follow-btn col-md-12', 'data-url' => $this->Html->url(array('action' => 'follow', $data['DriverTravel']['id']), true)), true);?>
                <br/>
				
            </div>
            
            <br/>
            
            <!-- FLAG / UNFLAG -->
            <?php $flagged = $hasMetadata && $data['TravelConversationMeta']['flag_type'] != null? true:false?>
            <?php if($flagged) :?>
            
            <div class="input-group info" title="<b>Comentario Pin:</b><br/><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $data['TravelConversationMeta']['flag_comment']);?>" data-placement="bottom">
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
                <?php echo $this->Form->static_button('<i class="glyphicon glyphicon-pushpin"></i> Pinear', array('class'=>'btn-warning open-form info', 'data-form'=>'form-flag-comment', 'data-placement'=>'bottom', 'title'=>'Pinea este viaje para darle un seguimiento especial: si hay problemas, si te parece importante, si lo estás gestionando personalmente, etc.'));?>
            <?php endif?>
            
            <div id="form-flag-comment" style="display: none">
                <?php echo $this->element('form_conversation_flag_comment', array('data' => $data)); ?>
            </div>    
            <hr>
        </div>
        
        <div id="states" class="col-md-12" style="margin-top: 10px">        
            <?php echo $this->element('conversation_toolbox_states'); ?>
        
        </div>
		<br>
        
   
    
</div>
<div class="row"><hr>
    <?php if($data['DriverTravel']['notification_type'] != DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE): ?> <!--En conversaciones directas no se tiene cantidad de viajeros-->
    <!-- CHANGING PEOPLE COUNT -->
    <div class="col-md-4 col-xs-4" style="margin-bottom: 20px">
        <?php echo $this->element('people_count_controls', array('thread' => $data['DriverTravel'], 'conversation'=>$data)); ?>
    </div>
    <?php endif; ?>
    <div id="comment-icon" class="col-md-4 col-xs-4" style="margin-bottom: 20px">
        
    </div>
    <div id="messaging-icon" style="margin-bottom: 20px">
        
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
    
</style>

<script type="text/javascript">
    
    function openForm(event) {
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
    }
            

    $(document).ready(function(){
        $( ".open-form" ).click(openForm);

        $('.last-msg').click(function() {
            goTo($(this).data('where'), 100, -70);
        });
    });
 </script>
 
<script type="text/javascript">
    function pretty_date(date){
        var months = new Array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        return date.getDate() + ' ' + months[date.getMonth()] + ', ' + date.getFullYear(); 
    }
    
    function onError(error){
        alert(error.responseText);
    }
     
    function followSuccess(response){
        $(".follow").toggle();
        
        if(response == 'unfollow')
            $('#travel_verification_div').css('display', 'none');
        else
            $('#travel_verification_div').css('display', 'inline-block');
    }
    
    function readSuccess(response){
        var operator = window.app.operator;
        $('#unreadMessages').after('&nbsp;No mensajes nuevos').remove();
      
        $('.porleer').after("<small><code class='pull-right info' title='Leído por" +  operator + "'>" + operator + " el " + pretty_date(new Date()) + "</code></small>").removeClass('porleer');
        $('#content').prepend("<div class='alert alert-success alert-dismissable' style='text-align: center'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + response + "</div>");
    }
    
    ajaxifyButton($('.follow-btn'), followSuccess, onError);
    ajaxifyButton($('#ajax-leer'), readSuccess, onError);
       

    
    
 </script>