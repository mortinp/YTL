<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('PathUtil', 'Util')?>

<div class="media-container-row" id="<?php echo $testimonial['id']; ?>">
    <div class="media-content px-3 align-self-center mbr-white py-2">
        <p class="mbr-author-name pt-4 mb-2 mbr-fonts-style display-6">
            <?php echo $testimonial['author']?>
            <?php if($testimonial['country'] != null && !empty($testimonial['country'])):?>
            <span style="font-weight: normal;"><?php echo __d('mobirise/testimonials', 'de %s', '<b>'.$testimonial['country'].'</b>')?></span>
            <?php endif;?>
        </p>
        <p class="mbr-author-desc mbr-fonts-style display-6 text-muted">
           <?php echo __d('mobirise/testimonials', 'Escrita el %s', TimeUtil::prettyDate($testimonial['created'], false))?>
        </p>
        <p class="mbr-text testimonial-text mbr-fonts-style display-7">
            <span style="font-style: normal;">
                <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?>
            </span>
        </p>
        <!--<p class="mbr-author-desc mbr-fonts-style display-4">Compartir: <a  style="padding:4px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none;border-radius: 5px"
            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$drv['DriverProfile']['driver_nick'],'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" 
            target="_blank">
                <b><span class="fa fa-facebook"></span></b>
            </a>&nbsp;
            <a  style="padding:4px;background-color: #3b5998;color: #FFFFFF !important;text-decoration: none;border-radius: 5px"
            href="https://twitter.com/home?status=<?php echo $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$drv['DriverProfile']['driver_nick'],'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true) ?>" 
            target="_blank">
                <b><span class="fa fa-twitter"></span></b>
            </a>
        </p>-->
        
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
            <img src='<?php echo PathUtil::getFullPath($testimonial['image_filepath']) ?>' alt="" title=""/>
        </div>
    <?php endif ?>

    
</div>