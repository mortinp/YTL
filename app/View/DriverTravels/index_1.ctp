<?php App::uses('TimeUtil', 'Util')?>
<?php
$this->Html->css('common/bootstrap-3.1.1-dist/css/bootstrap.min.css', array('inline' => false));
$this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));
$this->Html->script('common/jquery-1.9.0.min', array('inline' => false));
$this->Html->script('common/bootstrap-3.1.1-dist/js/bootstrap.min', array('inline' => false));

?>
<style type="text/css">
    .container{max-width:800px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}

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
  width: 46%;
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
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
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
              <h4>All Messages</h4>
            </div>            
          </div>       
                
        <!--All Messages-->
        <?php if(count($driver_travels) > 0):?>          
          <div class="inbox_chat">
           <?php foreach ($driver_travels as $keyc=>$t): ?>
            <div class="chat_list <?php if($keyc==0) echo 'active_chat'; ?>">
                <!--<a data-toggle="tab" href="#tab-<?php echo $t['DriverTravel']['id'] ?>">-->
                   <?php echo $this->element('conversation_widget_for_user/chat_conversation_data', array('conversation'=>$t)); ?>
                <!--</a>-->
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
            <?php if($message ['response_by']=='driver'): ?>
            <div class="incoming_msg">               
          <?php         
           if(isset ($travels[$keyc]['Driver']['DriverProfile']) && $travels[$keyc]['Driver']['DriverProfile'] != null && !empty ($travels[$keyc]['Driver']['DriverProfile'])): ?>
           <?php
            $src = '';
            if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/'.str_replace('\\', '/', $travels[$keyc]['Driver']['DriverProfile']['avatar_filepath']);
           
            ?>
              <div class="incoming_msg_img">
                  <img src="<?php echo $src ?>" alt="<?php echo $travels[$keyc]['Driver']['DriverProfile']['driver_name']; ?>"> 
              </div>
           <?php endif; ?>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p><?php echo $message['response_text'] ?></p>
                  <span class="time_date"><?php echo TimeUtil::prettyDate($message['created'], false); ?></span></div>
              </div>
            </div>
            <?php else: ?>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p><?php echo $message['response_text'] ?></p>
                <span class="time_date"><?php echo TimeUtil::prettyDate($message['created'], false); ?></span> </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>                 
        </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
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