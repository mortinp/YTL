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
            if(Configure::read('debug') > 0) $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/'.str_replace('\\', '/', $conversation['Driver']['DriverProfile']['avatar_filepath']);
        ?>
        <div class="chat_people">
            <a data-toggle="tab" href="#tab-<?php echo $thread['id'] ?>"><div class="chat_img"> <img src="<?php echo $src; ?>" alt="<?php echo $conversation['Driver']['DriverProfile']['driver_name']?>"> </div></a>
            <div class="chat_ib">
              <h5><?php echo $conversation['Driver']['DriverProfile']['driver_name']?> <span class="chat_date"><?php echo $conversation['DriverTravel']['created']; ?></span></h5>
              <p>alguna otra cosa...</p>
            </div>
        </div>
    <?php else:?>
        <img src="" class="info" title="No hay avatar para este chofer" style="max-height: 20px; max-width: 20px"/>
    <?php endif;?>
    
    <?php echo $this->Html->link(__('Ver conversación con %s', '<code><big>'.$conversation['Driver']['DriverProfile']['driver_name'].'</big></code>' ), array('controller'=>'conversations', 'action'=>'messages/'.$thread['id']), array('style'=>'text-decoration:none','target'=>'_blank', 'escape'=>false));?>
        
    <!-- CANTIDAD TOTAL DE MENSAJES --> 
    <?php if($thread['message_count'] > 0): // Respondido ?> 
            <small style="padding-left: 10px"><span class="label label-primary info" title="<?php echo __('%s mensajes', $thread['message_count'])?>"><?php echo $thread['message_count'];?></span></small>
    <?php endif?>

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
