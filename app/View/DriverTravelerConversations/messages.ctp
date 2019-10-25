<?php $driverName = __('el chofer')?>
<?php $hasProfile = isset ($data['Driver']['DriverProfile']) && $data['Driver']['DriverProfile'] != null && !empty ($data['Driver']['DriverProfile'])?>
<?php if($hasProfile) :?>
    <?php
        $src = '';
        if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
        $src .= '/'.str_replace('\\', '/', $data['Driver']['DriverProfile']['avatar_filepath']);
        
        $driverName = $data['Driver']['DriverProfile']['driver_name'];
    ?>
<?php endif;?>
<?php $topPosition = 60?>
<div class="col-md-8 col-md-offset-2" id="fixed" style="position: fixed;top: <?php echo $topPosition?>px;z-index: 100;background-color: white;padding:10px;border-bottom: #efefef solid 1px;">
    <div style="width: 100%">
        <?php if($hasProfile):?>
            <div style="float: left">
                <img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name']?>" class="info" style="max-height: 30px; max-width: 30px"/>
            </div>
            <div style="float: left;padding-left: 10px" class="h5">
                <?php $linkToProfile = $this->Html->link('<code><big>'.$driverName.'</big> -'.__d('driver_profile', 'mira fotos').' »</code>', array('controller'=>'driver_traveler_conversations', 'action'=>'show_profile', $data['DriverTravel']['id']), array('style'=>'color:inherit', 'class'=>'info', 'title'=>__('Mira fotos de %s', $driverName), 'escape'=>false))?>
                <?php echo __('Tus mensajes con %s', $linkToProfile)?>
            </div>
        <?php else:?>
            <div style="float: left;padding-left: 10px" class="h5"><?php echo __('Tus mensajes con %s', '<code><big>'.$driverName.'</big></code>')?></div>
        <?php endif;?>
        
        <div style="float: left;padding-left: 20px;padding-top: 9px"><span class="text-muted"><?php echo __('Solicitud')?> <small>#</small></span><?php echo DriverTravel::getIdentifier($data)?><?php if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT): ?>
            - <span title="discount ride" class="badge" style="background: #B4E5FF"><span class="glyphicon glyphicon-gift" style="color:blue"></span></span>
                <?php endif; ?></div>
    </div>
</div>
<div style="height: 85px;"></div> <!-- Separator -->
    

<!-- VIAJES Y CONTROLES -->
<div class="row" style="top: 200px">
    <div class="col-md-6 col-md-offset-3">
        <?php if ($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT): ?>
          <?php echo $this->element('description_discount_travel',array('data'=>$data)); ?>
        <?php endif; ?>
        
        <?php
            if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                echo $this->element('direct_message', array('data'=>$data, 'show_header' => false, 'show_perfil' => false));
            else if ($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT)
              echo $this->element('discount_travel', array('travel'=>$data, 'details'=>true, 'showConversations'=>false, 'actions'=>false, 'changeDate'=>false));  
              else
                echo $this->element('travel', array('travel'=>$data, 'details'=>true, 'showConversations'=>false, 'actions'=>false, 'changeDate'=>true));
        ?>
        

        
        
        
        
        
    </div>
</div>

<br/>
<br/>

<!-- MENSAJES -->
<?php if(empty ($conversations)):?><div class="row"><div class="col-md-6 col-md-offset-3">No hay mensajes hasta el momento</div></div>
<?php else:?>
    <?php 
    $driverMsgsCount = 0;
    $travelerMsgsCount = 0;
    ?>
    <?php foreach ($conversations as $message):?>
        <div class="row container-fluid">
            <div class="col-md-9 col-md-offset-1">
                <?php echo $this->element('widget_conversation_message', array('message'=>$message['DriverTravelerConversation'], 'driver_name'=>$driverName))?>
            </div>
            <br/>
        </div>

        <?php 
        // Contar los mensajes del chofer y los mensajes del viajero
        if($message['DriverTravelerConversation']['response_by'] == 'driver') $driverMsgsCount++;
        else if($message['DriverTravelerConversation']['response_by'] == 'traveler') $travelerMsgsCount++;
        ?>
    <?php endforeach;?>
    
    <?php if($driverMsgsCount == 0):?>
    <br/>
    <br/>
    <div class="col-md-6 col-md-offset-3">
        <div class="alert alert-warning" style="display: inline-block"><?php echo __('Esperando respuesta del chofer...')?></div>
    </div>
    <?php endif?>
    
    <div class="col-md-9 col-md-offset-1"><hr/></div>
    
    <?php if(!DriverTravel::isClosed($data['DriverTravel'])):  ?>   
    <!-- FORMULARIO PARA ENVIAR MENSAJE AL CHOFER  -->
    <div class="col-md-6 col-md-offset-4 well">
        <div class="">
            <span><?php echo __d('conversation', 'Envía un mensaje a %s', '<big><code>'.$driverName.'</code></big>')?></span>
            <hr/>
            <?php
               echo $this->Form->create('DriverTravelerConversation', array('type'=>'file', 'id'=>'DriverTravelerConversationForm', 'url' => array('action' => 'msg_to_driver')));
               echo $this->Form->input('conversation_id', array('type' => 'hidden', 'value' => $data['DriverTravel']['id']));

               echo $this->Form->input('body', array('label' => false, 'type' => 'textarea', 'required' => 'required'));

               echo '<br/>';
               echo $this->Form->label('adjunto', __d('conversation', 'Adjuntar archivo (foto, pdf o txt | 2MB máx.)'));
               echo $this->Form->file('adjunto');
               echo '<br/><br/>';
               echo $this->Form->submit('<big>'.__d('conversation', 'Enviar este mensaje').'</big>', array('id'=>'DriverTravelerConversationSubmit', 'class'=>'btn btn-block btn-primary', 'escape'=>false), true);
               echo $this->Form->end();
            ?>

            <?php echo $this->element('addon_scripts_send_form', array('formId'=>'DriverTravelerConversationForm', 'submitId'=>'DriverTravelerConversationSubmit'))?>
        </div>
    </div>
        <?php else: ?>
        <?php if($data['DriverTravel']['child_conversation_id'] != null): ?>
       <div class="col-md-6 col-md-offset-4">
           <div class="alert alert-warning" style="display: inline-block">
           <p>Esta conversación está <b>cerrada</b> por haber expirado hace más de 2 meses y no se pueden enviar mensajes. Se ha generado una nueva conversación con el chofer.</p>
           <p><?php echo $this->Html->link('ver nueva conversación »', array('controller' => 'conversations', 'action' => 'messages', $data['DriverTravel']['child_conversation_id']), array('target'=>'_blank'))?></p>
           </div>
       </div>
        <?php else: ?>
        <?php 
          $profile = array('Driver'=>$data['Driver'],'DriverProfile'=>$data['Driver']['DriverProfile']);
        ?>
    <div class="col-md-6 col-md-offset-4 alert alert-warning" style="display: inline-block">
       <p>Esta conversación está <b>cerrada</b> por haber expirado hace más de 2 meses y no se pueden enviar mensajes. Si desea realizar un nuevo viaje, especifique los datos iniciales debajo. Se creará una nueva conversación con el chofer.</p>
   </div>
    <div class="col-md-6 col-md-offset-4 well">
        <!--SI ES VIEJO SE MANDA UNA SOICITUD DIRECTA-->        
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-8" data-form-type="formoid">
                    <?php echo $this->element('mobirise/form_write_to_driver', array('profile'=>$profile,'expired'=>true,'super'=>$data['DriverTravel']['id']))?>
                                       
                </div>
            </div>  
    </div>
        <?php endif; ?>
        <?php endif; ?>
      
    

<?php endif?>

<script type="text/javascript">
    $(window).scroll(function(){
        $("#fixed").css("top", Math.max(50, <?php echo $topPosition?> - $(this).scrollTop()));
    });
</script>