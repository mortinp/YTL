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
            <footer> <big> <?php echo $intro?></big> </footer>
            <br/>
            <span style="font-size: 12pt"><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?></span>

            <?php if ($testimonial['image_filepath']): ?>
                <div style="max-width:640px">
                    <br/>
                    <span><img src='<?php echo $src ?>' class='img-responsive' style='max-width: <?php echo $width?>%; max-height: <?php echo $height?>%'/></span>
                </div>
            <?php endif ?> 
        </div>
    </blockquote>
</div>