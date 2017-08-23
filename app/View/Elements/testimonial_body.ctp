<?php App::uses('TimeUtil', 'Util')?>

<?php
$src = '';
if (Configure::read('debug') > 0)
    $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
$src .= '/' . str_replace('\\', '/', $testimonial['image_filepath']);

if (!isset($width)) $width = 100;
if (!isset($height)) $height = 100;

if (!isset($isReverse)) $isReverse = false;
if (!isset($bgColor)) $bgColor = 'default';
?>

<div> <!--style="font-family:'Engagement', cursive"-->
    <blockquote class='<?php if($isReverse) echo 'blockquote-reverse'?>' style="padding: 0px">
        <div class="alert bg-<?php echo $bgColor?>">
            <?php
            if($testimonial['country'] != null && !empty($testimonial['country'])) 
                $intro = __d('testimonials', '%s de %s escribió el %s', '<b>'.$testimonial['author'].'</b>', '<b>'.$testimonial['country'].'</b>', TimeUtil::prettyDate($testimonial['created'], false));
            else 
                $intro = __d('testimonials', '%s escribió el %s', '<b>'.$testimonial['author'].'</b>', TimeUtil::prettyDate($testimonial['created'], false));
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
                
                if($driver['active']) $driver_hint = $this->Html->link('<b>'.$driver_name.'</b>', array('controller'=>'drivers', 'action'=>'profile', $driver['DriverProfile']['driver_nick']), array('escape'=>false));
                else $driver_hint = '<b>'.$driver_name.'</b>';
                
                $about = __d('testimonials', 'comentario sobre %s', $driver_hint.' <img src="'.$driver_avatar.'"class="info" title="'.$driver_name.'" style="max-width:30px"/> ')?>
            <?php endif?>
            
            <footer><big><?php echo $intro?></big> <?php if($about):?><span class="pull-right" style="font-size: 8pt"><?php echo $about?></span><?php endif?></footer>
            <br/>
            <span style="font-size: 11pt"><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?></span>

            <?php if ($testimonial['image_filepath']): ?>
                <div style="max-width:640px">
                    <br/>
                    <span><img src='<?php echo $src ?>' class='img-responsive' style='max-width: <?php echo $width?>%; max-height: <?php echo $height?>%'/></span>
                </div>
            <?php endif ?> 
        </div>
    </blockquote>
</div>