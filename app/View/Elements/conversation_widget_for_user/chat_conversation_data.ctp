<?php App::uses('TimeUtil', 'Util')?>

<?php
if(!isset($showComments)) $showComments = true;

if(isset ($conversation['DriverTravel'])) 
    $thread = $conversation['DriverTravel'];
else $thread = $conversation;

$hasMetadata = (isset ($conversation['TravelConversationMeta']) && $conversation['TravelConversationMeta'] != null && !empty ($conversation['TravelConversationMeta']) && strlen(implode($conversation['TravelConversationMeta'])) != 0);
?>


<div>
    <?php 
    if(isset ($conversation['Driver']['DriverProfile']) && $conversation['Driver']['DriverProfile'] != null && !empty ($conversation['Driver']['DriverProfile'])) :?>
        <?php
            $src = '';
            //if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .='/ytl-last/yuni-clone/ytl'.'/'.str_replace('\\', '/', $conversation['Driver']['DriverProfile']['avatar_filepath']);
        ?>
        <div class="chat_people row">
            <div class="chat_img"><img src="<?php echo $src; ?>" alt="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>"></div>
            <div class="chat_ib"><span><span class="text-muted">#</span><big><big><?php echo DriverTravel::getIdentifier($conversation)?></big></big></span></div>
            <div class="chat_ib">
              <h5><div class="hidden-xs"><?php echo $conversation['Driver']['DriverProfile']['driver_name']?></div>
                  <span >                      
                       <!-- CANTIDAD TOTAL DE MENSAJES --> 
                        <?php if($thread['message_count'] > 0): // Respondido ?> 
                                <small style="padding-left: 10px"><span class="label label-primary info" title="<?php echo __('%s mensajes', $thread['message_count'])?>"><?php echo $thread['message_count'];?></span></small>
                        <?php endif?>
                  </span></h5>
              <p class="hidden-xs"><?php echo $this->html->link(__('Ver perfil de %s', $conversation['Driver']['DriverProfile']['driver_name'] ),array('controller'=>'drivers', 'action'=>'profile/'.$conversation['Driver']['DriverProfile']['driver_nick']),array('target'=>'_blank', 'style'=>'color:inherit')); ?></p>
            </div>
        </div>
    <?php else:?>
        <div class="chat_people row">
            <div class="chat_img"><img src="" class="info" title="No hay avatar para este chofer" style="max-height: 20px; max-width: 20px"/></div>
            <div class="chat_ib"><span><span class="text-muted">#</span><big><big><?php echo DriverTravel::getIdentifier($conversation)?></big></big></span></div>
            <div class="chat_ib">
                <h5><div class="hidden-xs"><?php echo $conversation['Driver']['DriverProfile']['driver_name']?></div>                
                  <span class="chat_date">
                      <span><span class="text-muted">#</span><big><big><?php echo DriverTravel::getIdentifier($conversation)?></big></big></span>
                       <!-- CANTIDAD TOTAL DE MENSAJES --> 
                        <?php if($thread['message_count'] > 0): // Respondido ?> 
                                <small style="padding-left: 10px"><span class="label label-primary info" title="<?php echo __('%s mensajes', $thread['message_count'])?>"><?php echo $thread['message_count'];?></span></small>
                        <?php endif?>
                  </span></h5>
                <p class="hidden-xs"><?php echo $this->html->link(__('Ver perfil de %s', $conversation['Driver']['DriverProfile']['driver_name'] ),array('controller'=>'drivers', 'action'=>'profile/'.$conversation['Driver']['DriverProfile']['driver_nick']),array('target'=>'_blank', 'style'=>'color:inherit')); ?></p>
            </div>
        </div>        
    <?php endif;?>
        
   <!-- MENSAJES SIN LEER --> 
    <!--<?php 
    $unread = 0;
    if($hasMetadata) {
         if($conversation['TravelConversationMeta']['read_entry_count'] < $thread['message_count']) {
             $unread = $thread['message_count'] - $conversation['TravelConversationMeta']['read_entry_count'];
         }
    } else if($thread['message_count'] > 0) {
        $unread = $thread['message_count'];
    }
    ?>
    <?php if($unread > 0):?>
        <small><span class="label label-success"><?php echo $unread?> nuevos mensajes</span></small>
    <?php endif?>-->
</div>