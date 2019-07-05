<?php App::uses('TimeUtil', 'Util')?>

<?php

if (!isset($width)) $width = 100;
if (!isset($height)) $height = 100;

if (!isset($isReverse)) $isReverse = false;
if (!isset($bgColor)) $bgColor = 'default';

if (!isset($nameAsLink)) $nameAsLink = true;
?>

<div> <!--style="font-family:'Engagement', cursive"-->
    <blockquote class='<?php if($isReverse) echo 'blockquote-reverse'?>' style="padding: 0px">
        <div class="alert bg-<?php echo $bgColor?>">
            <?php
              $intro = __d('testimonials', '%s escribió el %s', '<b>'.$driver['DriverProfile']['driver_name'].'</b>', TimeUtil::prettyDate($reply['created'], false));
            ?>
            
            <?php $about = null?>
            <?php if(isset($driver) && isset ($driver['DriverProfile']) && !empty($driver['DriverProfile'])):?>
                <?php
                $driver_name = $driver['DriverProfile']['driver_name'];

                $fullBaseUrl = Configure::read('App.fullBaseUrl');
                if(Configure::read('debug') > 0) $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien

                $driver_avatar = $fullBaseUrl.'/'.str_replace('\\', '/', $driver['DriverProfile']['avatar_filepath']);
                ?>

                <?php 
                
                if($driver['active'] && $nameAsLink) $driver_hint = $this->Html->link('<code><big>'.$driver_name.'</big></code>', array('controller'=>'drivers', 'action'=>'profile', $driver['DriverProfile']['driver_nick']), array('escape'=>false));
                else $driver_hint = '<b>'.$driver_name.'</b>';
                
                $about = __d('testimonials', 'respuesta a comentario sobre %s', $driver_hint.' <img src="'.$driver_avatar.'"class="info" title="'.$driver_name.'" style="max-width:30px"/> ')?>
            <?php endif?>
            
            <footer><big><?php echo $intro?></big> <?php if($about):?><span class="pull-right" style="font-size: 8pt"><?php echo $about?></span><?php endif?></footer>
            <br/>
            <span style="font-size: 11pt"><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $reply['reply_text']);?></span>
             
        </div>
    </blockquote>
</div>