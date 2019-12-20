<style type="text/css">
    /*Ocultar el panel superior*/
    #main-header {      
      transition: top 0.5s!important;
      display: block;
      background-color: white;
      position: fixed;
      z-index: 10;
      top: 45px
           
   }
</style>
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
<div class="col-md-8 col-md-offset-2 main-header" id="main-header" style="z-index: 100;background-color: white;padding:10px;border-bottom: #efefef solid 1px;">
    <div style="width: 100%;padding-top: 30px">
        <?php if($hasProfile):?>
            <div style="float: left">
                <img src="<?php echo $src?>" title="<?php echo $data['Driver']['DriverProfile']['driver_name']?>" class="info" style="max-height: 40px; max-width: 40px"/>
                &nbsp;&nbsp;
                <?php 
                $linkToProfile = $this->Html->link('<big>'.__d('driver_profile', 'Ver perfil de %s', $driverName).'</big>', array('controller'=>'driver_traveler_conversations', 'action'=>'show_profile', $data['DriverTravel']['id']), array('class'=>'btn btn-sm btn-success info', 'title'=>__('Mira fotos de %s', $driverName), 'escape'=>false));
                echo $linkToProfile;
                ?>
            </div>
        <?php else:?>
            <div style="float: left;padding-left: 10px" class="h5"><?php echo __('Tus mensajes con %s', '<code><big>'.$driverName.'</big></code>')?></div>
        <?php endif;?>
        
        <div style="float:left;padding-left:20px;padding-top:9px;">
            <span class="text-muted"><?php echo __('Solicitud')?> <small>#</small></span>
            <?php echo DriverTravel::getIdentifier($data)?>
        </div>
        <?php if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST): ?>
            <div style="float:left;padding-left:20px;padding-top:9px">&nbsp;<span class="label label-success"><i class="glyphicon glyphicon-gift"></i> Promo</span></div>
        <?php endif; ?>
        
    </div>
</div>
<div style="height: 85px;"></div> <!-- Separator -->
    

<!-- VIAJES Y CONTROLES -->
<div class="row" style="top: 200px">
    <div class="col-md-6 col-md-offset-3">
        <?php
            if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DIRECT_MESSAGE)
                echo $this->element('direct_message', array('data'=>$data, 'show_header' => false, 'show_perfil' => false));
            else if($data['DriverTravel']['notification_type'] == DriverTravel::$NOTIFICATION_TYPE_DISCOUNT_OFFER_REQUEST)
                echo $this->element('discount_travel', array('travel'=>$data, 'details'=>true, 'actions'=>false, 'changeDate'=>false));  
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
    <div class="col-md-6 col-md-offset-4">
        <div class="">
            <br/>
            <?php
               echo $this->Form->create('DriverTravelerConversation', array('type'=>'file', 'id'=>'DriverTravelerConversationForm', 'url' => array('action' => 'msg_to_driver')));
               echo $this->Form->input('conversation_id', array('type' => 'hidden', 'value' => $data['DriverTravel']['id']));

               echo $this->Form->input('body', array('label' => __d('conversation', 'Envía un mensaje a %s', '<big><code>'.$driverName.'</code></big>'), 'type' => 'textarea', 'required' => 'required'));

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
   <!--Formulario para conformacion y cambio de fechas por el viajero-->
    <?php if($driverMsgsCount >0 && $travelerMsgsCount>0):?> 
    <?php if($data['TravelConversationMeta']['confirmed_by_traveler']==0):?>      
       <div class="col-md-6 col-md-offset-3 alert alert-success" style="display: inline-block; margin-top:20px">
           <h3><?php echo __d('default','Usted puede confirmar su viaje ahora'); ?></h3><br>
            <?php echo $this->element('mobirise/form_confirm_by_user',array('conversation_id'=>$data['DriverTravel']['id'])); ?>
       </div>
    <?php else: ?><!--Si ya esta confirmado poder desconfirmar-->
      <div class="col-md-6 col-md-offset-3 alert alert-success" style="display: inline-block; margin-top:20px">
           <h3><?php echo __d('default','Su viaje está confirmado'); ?></h3><br>                   
                
                     <small><span class="label label-success" style="margin-left:5px"><i class="glyphicon glyphicon-ok-sign"></i> <?php echo TimeUtil::prettyDate($data['TravelConversationMeta']['date_confirmed']); ?></span></small> 
                  
            <?php echo $this->Form->create('TravelConversationMeta', array('id' => 'CDirectForm', 'url' => array('controller' => 'driver_traveler_conversations',  'action'=>'unconfirm_travel'))); ?>
            <?php
            echo $this->Form->input('conversation_id', array('type' => 'hidden', 'value' => $data['DriverTravel']['id']));
            
            ?>

            <br>
            <span class="input-group-btn">
                <input type="submit" class="btn btn-warning btn-form btn-block display-5" id="CDirectSubmit" 
                       value="<?php echo __d('default', 'QUITAR CONFIRMACIÓN')?>"> 

            </span>

<?php echo $this->Form->end(); ?>
       </div>
    <?php endif; ?><!--Para confirmar/desconfirmar-->
    <?php endif; ?><!--Para la confirmacion-->
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
   
   /************** Logica para ocultar el panel superior****************/
    var prevscroll=window.pageYOffset;
        // on scroll, let the interval function know the user has scrolled
        $(window).scroll(function(event){
            var current = window.pageYOffset;
            
            if(prevscroll > current)
                document.getElementById("main-header").style.top="45px";
            else
                document.getElementById("main-header").style.top="-150px";
           
           prevscroll = current;
        });
    /************** FIN Logica para ocultar el panel superior****************/
    
    $(window).scroll(function(){
        $("#fixed").css("top", Math.max(50, <?php echo $topPosition?> - $(this).scrollTop()));
    });
</script>