<?php App::uses('TimeUtil', 'Util')?>
<?php
$this->Html->css('common/bootstrap-3.1.1-dist/css/bootstrap.css', array('inline' => false));
$this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));
$this->Html->script('common/jquery-1.9.0.min', array('inline' => false));
$this->Html->script('common/bootstrap-3.1.1-dist/js/bootstrap.min', array('inline' => false));

?>
<style type="text/css">
    .container{max-width:1200px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 35%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:80%;}

.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

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
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

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
 .received_withd_msg p {
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
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 56%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
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
  top: 11px;
  width: 33px;
}
.msg_attach_btn {
    left: -45px;
    cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 557px;
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
.fileinput-filename{vertical-align:middle;display:inline-block;overflow:hidden}.form-control .fileinput-filename{vertical-align:bottom}.fileinput.input-group{display:table}.fileinput.input-group>*{position:relative;z-index:2}
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
          <div class="headind_srch">
            <div class="recent_heading">
                <h4><?php echo __("Todas las conversaciones"); ?></h4>
            </div>            
          </div>       
                
        <!--All Messages-->
        <?php if(count($driver_travels) > 0):?>          
          <div class="inbox_chat">
           <?php foreach ($driver_travels as $keyc=>$t): ?>
            <div class="chat_list <?php if($keyc==0) echo 'active_chat'; ?>">
                <a data-toggle="tab" href="#tab-<?php echo $t['DriverTravel']['id'] ?>">
                   <?php echo $this->element('conversation_widget_for_user/chat_conversation_data', array('conversation'=>$t)); ?>
                </a>
            </div>            
           <?php endforeach; ?>
          </div>
        <?php endif; ?>
        </div>
      <div class="tab-content">
       <?php if(count($conversations)>0):  ?>        
        <?php foreach ($conversations as $keyc => $conversation): ?>          
        <div id="tab-<?php echo $travels[$keyc]['DriverTravel']['id'] ?>" class="mesgs tab-pane <?php if($keyc==0) echo 'active' ?>">
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
                  <img src="<?php echo $src ?>" alt="<?php echo $travels[$keyc]['Driver']['DriverProfile']['driver_name']; ?>"> 
              </div>
           <?php endif; ?>
              <div class="received_msg">
                <div class="received_withd_msg">
                    <p><?php if($msgWasShortened) echo $fullText; else echo $shortText;?></p>
                  <span class="time_date"><?php echo TimeUtil::prettyDate($message['created'], false); ?></span></div>
              </div>
            </div>
            <?php else: ?>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p><?php if($msgWasShortened) echo $fullText; else echo $shortText;?></p>
               <!--Mostrando los adjuntos si hay-->
        <?php if($message['attachments_ids'] != null && $message['attachments_ids'] != ''):?>
                    <?php $messageId = 'message-'.$message['id']?>
                    <div class="alert">
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
                <span class="time_date"><?php echo TimeUtil::prettyDate($message['created'], false); ?></span> </div>
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
                <div class="fileinput fileinput-new msg_attach_btn" data-provides="fileinput">
                    <span class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-paperclip"></i></span><span class="fileinput-exists"><i class="fa fa-copy"></i> </span><?php echo $this->Form->file('adjunto',array('id'=>'adjunto-'.$travels[$keyc]['DriverTravel']['id'],'multiple'=>'multiple')); ?></span>
                    <span class="fileinput-filename"></span>
                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                </div>
                    <?php echo $this->Form->input('body', array('cols'=>'3','rows'=>'3','class'=>'write_msg','label' => false, 'type' => 'textarea', 'id'=>'tab-'.$travels[$keyc]['DriverTravel']['id'],'placeholder'=>__("Escriba su mensaje"))); ?>
                <button id="btn-<?php echo $travels[$keyc]['DriverTravel']['id'] ?>" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
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
    
 
/*    
$(".write_msg").on("keydown", function(e){
    
});*/
        
      
        
       

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
                    if(msg=='true' || msg=='1'){                        
                        container.append("<div class='outgoing_msg'>"+
                          "<div class='sent_msg'>"+
                            "<p>"+text+"</p>"+
                            "</div></div>").scrollTop(container.prop('scrollHeight'));
            
                         $('.input_msg_write #tab-'+id).val('');
                         
                   
                }
                else{alert("An error occured"); }

                },
                error: function (error) { alert("Error"); 
                
                 }

            });         
           
              
        
        }  
        
//     location.href = location+'#tab-'+id;
//     location.reload();   
});

});

</script>