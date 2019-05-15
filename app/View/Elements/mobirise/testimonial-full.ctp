<?php App::uses('TimeUtil', 'Util')?>

<?php
$src = '';
if (Configure::read('debug') > 0)
    $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
$src .= '/' . str_replace('\\', '/', $testimonial['image_filepath']);
?>

<div class="media-container-row" id="<?php echo $testimonial['id']; ?>">
    <div class="media-content px-3 align-self-center mbr-white py-2">
        <p class="mbr-author-name pt-4 mb-2 mbr-fonts-style display-6">
            <?php echo $testimonial['author']?>
            <?php if($testimonial['country'] != null && !empty($testimonial['country'])):?>
            <span style="font-weight: normal;"><?php echo __d('mobirise/testimonials', 'de %s', '<b>'.$testimonial['country'].'</b>')?></span>
            <?php endif;?>
        </p><span class="pull-right" id="star-<?php echo $testimonial['id']; ?>"></span>
        <p class="mbr-author-desc mbr-fonts-style display-6 text-muted">
           <?php echo __d('mobirise/testimonials', 'Escrita el %s', TimeUtil::prettyDate($testimonial['created'], false))?>
        </p>
        <p class="mbr-text testimonial-text mbr-fonts-style display-7">
            <span style="font-style: normal;">
                <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?>
            </span>
        </p>
        
        <?php if(isset($driver) && isset ($driver['DriverProfile']) && !empty($driver['DriverProfile'])):?>
        <p class="mbr-author-desc mbr-fonts-style display-6">
            <?php 
            $driver_name = $driver['DriverProfile']['driver_name'];

            $fullBaseUrl = Configure::read('App.fullBaseUrl');
            if(Configure::read('debug') > 0) $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien

            $driver_avatar = $fullBaseUrl.'/'.str_replace('\\', '/', $driver['DriverProfile']['avatar_filepath']);


            if($driver['active']) $driver_hint = $this->Html->link('<code><big>'.$driver_name.'</big></code>', array('controller'=>'drivers', 'action'=>'profile', $driver['DriverProfile']['driver_nick']), array('escape'=>false));
            else $driver_hint = '<b>'.$driver_name.'</b>';
            ?>
            <img src="<?php echo $driver_avatar?>" class="info" title="<?php echo $driver_name?>" style="max-width:60px"/>
            <?php echo $this->Html->link(__d('mobirise/testimonials', 'Ver perfil de %s', $driver_name), array('controller'=>'drivers', 'action'=>'profile', $driver['DriverProfile']['driver_nick']), array('class'=>'btn btn-success display-4', 'escape'=>false))?>
        </p>
        <?php endif;?>
    </div>
    
    <?php if (isset($testimonial['image_filepath']) && $testimonial['image_filepath']): ?>
        <div class="mbr-figure pl-lg-5" style="width: 100%;">
            <?php
            $src = '';
            if (Configure::read('debug') > 0)
                $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/' . str_replace('\\', '/', $testimonial['image_filepath']);
            ?>
            <img src='<?php echo $src ?>' alt="" title=""/>
        </div>
    <?php endif ?>

    
</div>