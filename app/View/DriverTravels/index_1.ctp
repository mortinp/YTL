<?php App::uses('TimeUtil', 'Util')?>
<?php
//$this->layout = 'driver_panel';
$this->Html->css('common/bootstrap-3.1.1-dist/css/bootstrap.css', array('inline' => false));
$this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));
$this->Html->css('toastr/toastr.min.css', array('inline' => false));
$this->Html->script('common/jquery-1.9.0.min', array('inline' => false));
$this->Html->script('common/bootstrap-3.1.1-dist/js/bootstrap.min', array('inline' => false));
$this->Html->script('jasny/jasny-bootstrap.min', array('inline' => false));
$this->Html->script('toastr/toastr.min', array('inline' => false));

?>
<style type="text/css">
    .container{max-width:1200px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 30%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
  border-radius: 15px;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:100%;}

.headind_srch{ padding:10px 29px 10px 5px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 25%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 70%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 650px; overflow-y: scroll;}

.active_chat{ background:rgba(131, 143, 184, .2);}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}

.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;  
 }
.incoming_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg .msg-body {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 3px 0 0;
}
.received_withd_msg {word-wrap: break-word; overflow: hidden; width: 60%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 5px;
  width: 70%;
}

 .sent_msg .msg-body {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:98%;
}

.msg-body a{
    color:#fff;
    margin-top: 5px;
    font-stretch: ultra-expanded;
    font-style: italic;
}

.outgoing_msg{overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 65%;
  word-wrap: break-word; overflow: hidden; 
}
.input_msg_write textarea{
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
}

.write_msg{
   float: right;
   width: 90%;
   margin-bottom:10px;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 30px;
  width: 33px;
}
.msg_attach_btn {
  /*left: -20px;*/
  cursor: pointer;
  font-size: 10px;
  /*height: 33px;
  position: absolute;
  top: 30px;
  width: 33px;*/
  color: blue;
}

.msg_attach_btn .btn-file{
    top: -70px;   
    
}

@media (max-width: 720px) {
        .msg_attach_btn .btn-file{left: -18px;}
        .received_msg {margin-left: -40px}
    }

.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 570px;
  overflow-y: auto;  
}

/*Necesitamos cargar ese css tomado de:*/
/*!
 * Jasny Bootstrap v3.1.2 (http://jasny.github.io/bootstrap)
 * Copyright 2012-2014 Arnold Daniels
 * Licensed under Apache-2.0 (https://github.com/jasny/bootstrap/blob/master/LICENSE)
 */
.btn-file{overflow:hidden;position:relative;vertical-align:middle}
.btn-file>input{position:absolute;top:0;right:0;margin:0;opacity:0;filter:alpha(opacity=0);font-size:23px;height:100%;width:100%;direction:ltr;cursor:pointer}
.fileinput{margin-bottom:9px;display:inline-block}.fileinput .form-control{padding-top:7px;padding-bottom:5px;display:inline-block;margin-bottom:0;vertical-align:middle;cursor:text}
.fileinput .thumbnail{overflow:hidden;display:inline-block;margin-bottom:5px;vertical-align:middle;text-align:center}.fileinput .thumbnail>img{max-height:100%}.fileinput .btn{vertical-align:middle}
.fileinput-exists .fileinput-new,.fileinput-new .fileinput-exists{display:none}.fileinput-inline .fileinput-controls{display:inline}
.fileinput-filename{font-size: 8px; vertical-align:middle;display:inline-block;overflow:hidden}.form-control .fileinput-filename{vertical-align:bottom}.fileinput.input-group{display:table}.fileinput.input-group>*{position:relative;z-index:2}
.fileinput.input-group>.btn-file{z-index:1}.fileinput-new.input-group .btn-file,.fileinput-new .input-group .btn-file{border-radius:0 4px 4px 0}
.fileinput-new.input-group .btn-file.btn-xs,.fileinput-new .input-group .btn-file.btn-xs,.fileinput-new.input-group .btn-file.btn-sm,.fileinput-new .input-group .btn-file.btn-sm{border-radius:0 3px 3px 0}.fileinput-new.input-group .btn-file.btn-lg,.fileinput-new .input-group .btn-file.btn-lg{border-radius:0 6px 6px 0}
.form-group.has-warning .fileinput .fileinput-preview{color:#8a6d3b}.form-group.has-warning .fileinput .thumbnail{border-color:#faebcc}.form-group.has-error .fileinput .fileinput-preview{color:#a94442}.form-group.has-error .fileinput .thumbnail{border-color:#ebccd1}
.form-group.has-success .fileinput .fileinput-preview{color:#3c763d}.form-group.has-success .fileinput .thumbnail{border-color:#d6e9c6}.input-group-addon:not(:first-child){border-left:0}
/*Fin uso de Jasny*/
</style>
<div class="container">
    <div class="row">
    <?php if(!empty ($driver_travels)): ?>
        
    <?php
    //die(print_r($driver_travels));
     $travel = null;
     $data = array();
     $index = 0;
    ?>
     <div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch row">
            <div class="recent_heading">
                <p class="col-md-12"><b><?php echo __("Conversaciones"); ?></b></p>
            </div>            
          </div>       
                
        <!--All Messages-->
        <?php if(count($driver_travels) > 0):?>          
          <div class="inbox_chat">
           <?php foreach ($driver_travels as $keyc=>$t): ?>
              <div id="head-<?php echo $t['DriverTravel']['id'] ?>" class="chat_list <?php if($keyc==0) echo 'active_chat'; ?>">
                  <a class="conversation-lnk" id="link-<?php echo $t['DriverTravel']['id'] ?>" data-toggle="tab" href="#tab-<?php echo $t['DriverTravel']['id'] ?>">
                   <?php echo $this->element('conversation_widget_for_user/chat_conversation_data', array('conversation'=>$t)); ?>
                </a>
            </div>
              <!--Esta div es para tomar datos del viaje y mostrar en el toastr-->
              <?php $personW = __('persona');?>
              <?php $pretty_people_count = $t['Travel']['people_count']. ' '; ?>
              <div id="modal-<?php echo $t['DriverTravel']['id'] ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog modal-sm">                    
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <span class="fa fa-info-circle fa-2x"> Detalles del viaje</span>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 b-r"><h3 class="m-t-none m-b text-muted">#<?php echo DriverTravel::getIdentifier($t)?></h3>                                    
                                </div>
                                <div class="col-sm-12">
                                    <p><?php if($t['Travel']['people_count'] > 1) $pretty_people_count .= Inflector::pluralize ($personW);
                                      else { if($t['Travel']['people_count'] > 0) $pretty_people_count .= $personW; else $pretty_people_count= "Sin detalles del viaje"; } 
                                      echo "<p>".$pretty_people_count."</p>";
                                      if($pretty_people_count>0) 
                                      echo "<p><span class='fa fa-map-marker'></span> ".$t['Travel']['origin']." - <span class='fa fa-map-marker'></span> ".$t['Travel']['destination']."</p>";                      
                                      ?></p>
                                    <p class="hidden-lg"><?php echo $this->html->link(__('Ver perfil de %s', $t['Driver']['DriverProfile']['driver_name'] ),array('controller'=>'drivers', 'action'=>'profile/'.$t['Driver']['DriverProfile']['driver_nick']),array('target'=>'_blank', 'style'=>'color:inherit')); ?></p>

                                </div>
                            </div>
                       </div>
                    </div>
                </div>
              </div>             
             
           <?php endforeach; ?>
          </div>
        <?php endif; ?>
        </div>
      <div class="tab-content">
       <?php if(count($conversations)>0):  ?>        
        <?php foreach ($conversations as $keyc => $conversation): ?>          
        <div id="tab-<?php echo $travels[$keyc]['DriverTravel']['id'] ?>" class="mesgs tab-pane <?php if($keyc==0) echo 'active' ?>">
            <div class="incoming_msg" style="position: fixed">
                <a data-toggle="modal" href="#modal-<?php echo $travels[$keyc]['DriverTravel']['id'] ?>" class="btn btn-default btn-xs">Ver detalles</a>
            </div>
            <div class="msg_history">            
            <?php foreach ($conversation as $key => $value): ?>            
            <?php foreach($value as $message): ?>            
            <?php 
                $msgWasShortened = false;
                $text = strip_tags(trim($message['response_text']));

                $originalText = $text;

                $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", $text);                
                $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*)/i", '<span style="color:tomato"><b>$0</b></span>', $text);
                $text = preg_replace("/(\r\n|\n|\r)/", "<br/>", $text);

                $fullText = $shortText = $text;

                if(strpos($originalText, Configure::read('email_message_separator_stripped'))) {
                    $shortText = substr($originalText, 0, strpos($originalText, Configure::read('email_message_separator_stripped')));
                    $shortText = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", $shortText);
                    $shortText = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*)/i", '<span style="color:tomato"><b>$0</b></span>', $shortText);
                    $shortText = preg_replace("/(\r\n|\n|\r)/", "<br/>", $shortText);

                    $msgWasShortened = true;
                }
             ?>
            <?php if($message ['response_by']=='driver'): ?>
            <div class="incoming_msg">               
          <?php         
           if(isset ($travels[$keyc]['Driver']['DriverProfile']) && $travels[$keyc]['Driver']['DriverProfile'] != null && !empty ($travels[$keyc]['Driver']['DriverProfile'])): ?>
           <?php
            $src = '';
            // if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/ytl-last/yuni-clone/ytl'.'/'.str_replace('\\', '/', $travels[$keyc]['Driver']['DriverProfile']['avatar_filepath']);
           
            ?>
              <div class="incoming_msg_img">
                  <img class="hidden-xs" src="<?php echo $src ?>" alt="<?php echo $travels[$keyc]['Driver']['DriverProfile']['driver_name']; ?>"> 
              </div>
           <?php endif; ?>
              <div class="received_msg">
                <div class="received_withd_msg">
                      <div class="msg-body">
                          <?php if($msgWasShortened) echo $fullText; else echo $shortText;?>
                              <!--Mostrando los adjuntos si hay-->
                    <?php if($message['attachments_ids'] != null && $message['attachments_ids'] != ''):?>
                                <?php $messageId = 'message-'.$message['id']?>
                                <div>
                                    <a href="#!" id="show-attachments-<?php echo $messageId?>" data-attachments-ids="<?php echo $message['attachments_ids']?>">
                                        <i class="glyphicon glyphicon-link"></i> <?php echo __('Ver adjuntos de este mensaje')?>
                                    </a>
                                    <div id="attachments-<?php echo $messageId?>" style="display:none"></div>
                                </div>
                                <script type="text/javascript">
                                    $('#show-attachments-<?php echo $messageId?>').click(function() {

                                        $.ajax({
                                            type: "POST",
                                            data: $('#show-attachments-<?php echo $messageId?>').data('attachments-ids'),
                                            url: '<?php echo $this->Html->url(array('controller'=>'email_queues', 'action'=>'get_attachments/'.$message['attachments_ids']))?>',
                                            success: function(response) {
                                                //alert(response);
                                                response = JSON.parse(response);

                                                var place = $('#attachments-<?php echo $messageId?>');
                                                for (var a in response.attachments) {
                                                    var att = response.attachments[a];
                                                    if(att.mimetype.substr(0, 5) == 'image') {
                                                        place.append($('<img src="' + att.url + '" class="img-responsive"></img>')).append('<br/>');
                                                    } else if(att.mimetype == 'text/plain') {
                                                        place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/>');
                                                    } else {
                                                        place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/>');
                                                    }
                                                }

                                                $('#attachments-<?php echo $messageId?>, #show-attachments-<?php echo $messageId?>').toggle();

                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                alert(jqXHR.responseText);
                                            },
                                            complete: function() {

                                            }
                                        });

                                    });
                                </script>

                  <?php endif?>   
               
                </div> 
                  <span class="time_date"><?php echo TimeUtil::prettyDate($message['created'], false); ?></span></div>
              </div>
            </div>
            <?php else: ?>
            <div class="outgoing_msg">
              <div class="sent_msg">
                  <div class="msg-body"><?php if($msgWasShortened) echo $fullText; else echo $shortText;?>
                              <!--Mostrando los adjuntos si hay-->
                    <?php if($message['attachments_ids'] != null && $message['attachments_ids'] != ''):?>
                                <?php $messageId = 'message-'.$message['id']?>
                                <div>
                                    <a href="#!" id="show-attachments-<?php echo $messageId?>" data-attachments-ids="<?php echo $message['attachments_ids']?>">
                                        <i class="glyphicon glyphicon-link"></i> <?php echo __('Ver adjuntos de este mensaje')?>
                                    </a>
                                    <div id="attachments-<?php echo $messageId?>" style="display:none"></div>
                                </div>
                                <script type="text/javascript">
                                    $('#show-attachments-<?php echo $messageId?>').click(function() {

                                        $.ajax({
                                            type: "POST",
                                            data: $('#show-attachments-<?php echo $messageId?>').data('attachments-ids'),
                                            url: '<?php echo $this->Html->url(array('controller'=>'email_queues', 'action'=>'get_attachments/'.$message['attachments_ids']))?>',
                                            success: function(response) {
                                                //alert(response);
                                                response = JSON.parse(response);

                                                var place = $('#attachments-<?php echo $messageId?>');
                                                for (var a in response.attachments) {
                                                    var att = response.attachments[a];
                                                    if(att.mimetype.substr(0, 5) == 'image') {
                                                        place.append($('<img src="' + att.url + '" class="img-responsive"></img>')).append('<br/>');
                                                    } else if(att.mimetype == 'text/plain') {
                                                        place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/>');
                                                    } else {
                                                        place.append('<a href="'+ att.url + '"> <i class="glyphicon glyphicon-file"></i> ' + att.filename + '</a>').append('<br/>');
                                                    }
                                                }

                                                $('#attachments-<?php echo $messageId?>, #show-attachments-<?php echo $messageId?>').toggle();

                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                alert(jqXHR.responseText);
                                            },
                                            complete: function() {

                                            }
                                        });

                                    });
                                </script>

                  <?php endif?>   
               
                </div>
                            
                <span class="time_date"><?php echo TimeUtil::prettyDate($message['created'], false); ?></span> 
              </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>                 
        </div>
          <div class="type_msg">
            <div class="input_msg_write">
                <?php
                echo $this->Form->create('DriverTravelerConversation', array('type'=>'file', 'id'=>'DriverTravelerConversationForm-'.$travels[$keyc]['DriverTravel']['id'], 'url' => array('action' => 'chat_msg_to_driver')));
                echo $this->Form->input('conversation_id', array('type' => 'hidden', 'value' => $travels[$keyc]['DriverTravel']['id']));
                ?>                
                    <?php echo $this->Form->input('body', array('cols'=>'3','rows'=>'3','class'=>'write_msg','label' => false, 'type' => 'textarea', 'id'=>'tab-'.$travels[$keyc]['DriverTravel']['id'],'placeholder'=>__("Escriba su mensaje"))); ?>
                <button id="btn-<?php echo $travels[$keyc]['DriverTravel']['id'] ?>" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                <div class="fileinput fileinput-new msg_attach_btn col-md-12" data-provides="fileinput">
                    <span class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-paperclip"></i></span><span class="fileinput-exists"><i class="fa fa-copy"></i> </span><?php echo $this->Form->file('adjunto',array('id'=>'adjunto-'.$travels[$keyc]['DriverTravel']['id'],'multiple'=>'multiple')); ?></span>
                    <?php echo __("Fichero(s) adjunto(s): "); ?><span class="fileinput-filename"></span>
                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                </div>
                <?php echo $this->Form->end(); ?>  
            </div>
          </div>            
          </div>
         <?php endforeach; ?>
        <?php endif; ?>
      </div>    
      
    </div>         
   <?php endif; ?>
      
    </div>
</div>
</div>
<script type="text/javascript">

$(document).ready(function() { 
  /*Logica para activar la conversacion actual al hacer click en ella*/  
   $('.conversation-lnk').on("click",function(){ 
    var fullid = $(this).attr('id')
    var id = fullid.substring(5,fullid.length);     
    $('#link-'+id).toggle();
    $('.inbox_chat > .chat_list').removeClass('active_chat');
    $('#head-'+id).addClass('active_chat');  
    
            toastr.options = {
          "closeButton": true,
          "debug": false,
          "progressBar": false,
          "preventDuplicates": true,
          "positionClass": "toast-top-right",
          "onclick": null,
          "showDuration": "4000",
          "hideDuration": "10000",
          "timeOut": "70000",
          "extendedTimeOut": "10000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
    // Display a success toast, with a title
       toastr.info($('#info-'+id).html());
     
    });
  
 
<?php if($this->request->query('show_conversation')): ?>
     
   /*Logica para activar la conversacion que viene por get*/                    

    $('.inbox_chat > .chat_list').removeClass('active_chat');

    $('#head-'+'<?php echo $this->request->query('show_conversation') ?>').addClass('active_chat'); 

    $('.tab-content > tab-pane').removeClass('active');
    $('#tab-'+'<?php echo $this->request->query('show_conversation') ?>').addClass('active');
    var cont =  $('#tab-'+'<?php echo $this->request->query('show_conversation') ?>'+' > .msg_history');
    $('#link-'+'<?php echo $this->request->query('show_conversation') ?>').click();
    
    cont.scrollTop(cont.prop('scrollHeight'))
    $('.inbox_chat').scrollTop($('#head-<?php echo $this->request->query('show_conversation') ?>').prop('scrollHeight')+500);
     
  
 <?php endif;?>  
      
        
       

$(".msg_send_btn").click(function(){
    //$(".write_msg").trigger({type: 'keydown', which: 13, keyCode: 13});
    var fullid = $(this).attr('id')
    var id = fullid.substring(4,fullid.length);
    
     var container =  $('#tab-'+id+' > .msg_history');
        var text = $('.input_msg_write #tab-'+id).val();
        
        if (text !== ""){
           
           var formData = new FormData($('#DriverTravelerConversationForm-'+id)[0]);
        $.ajax({
                url: "driver_traveler_conversations/chat_msg_to_driver", //You can replace this with MVC/WebAPI/PHP/Java etc
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (msg) {
                    if(msg!='false'){
                        container.html('');
                        container.append(msg).scrollTop(container.prop('scrollHeight'));
            
                         $('.input_msg_write #tab-'+id).val('');                         
                         /*Logica para activar la conversacion actual*/                    

                            $('.inbox_chat > .chat_list').removeClass('active_chat');

                            $('#head-'+id).addClass('active_chat'); 

                            $('.tab-content > tab-pane').removeClass('active');
                            $('#tab-'+id).addClass('active');
                            //$('#link-'+id).click(); Ya no es necesario

                        
                        /*Logica para resetear la direccion al cambiar de chat*/              
//                         var loc = location.href;
//                          
//                        /*----------------------------------------------------------*/
//                        /*Recarga javascript de la pagina con el tab a mostrar*/
//                              setTimeout(function(){
//                                  location.href = loc.substring(0,loc.indexOf('#')-0)+'#tab-'+id;
//                                  location.reload(); 
//                              },1);         
                         
                   
                }
                else{alert("An error occured"); }

                },
                error: function (error) { alert("Error"); 
                
                 }

            });         
           
              
        
        }  
        
 
});

});

</script>