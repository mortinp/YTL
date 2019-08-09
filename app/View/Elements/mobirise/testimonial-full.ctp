<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('PathUtil', 'Util')?>

<?php
if(!isset($shareReview)) $shareReview = true;
if(!isset($linkToProfile)) $linkToProfile = false;
if(!isset($driverReplies)) $driverReplies = array();


$hasProfile = isset($driver) && isset ($driver['DriverProfile']) && !empty($driver['DriverProfile']);
?>

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
        <?php if (isset($testimonial['image_filepath']) && $testimonial['image_filepath']): ?>
        <div class="mbr-figure pl-lg-5 d-xs-block d-sm-block d-lg-none d-md-block" style="width: 100%;">
            <img class=""  src='<?php echo PathUtil::getFullPath($testimonial['image_filepath']) ?>' alt="" title=""/>
        </div>
    <?php endif ?>
        <p class="mbr-text testimonial-text mbr-fonts-style display-7">
            <span style="font-style: normal;">
                <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $testimonial['text']);?>
            </span>
        </p>
        
        <?php if($linkToProfile && $hasProfile):?>
            <p class="mbr-author-desc mbr-fonts-style display-6">
                <?php 
                $driver_name = $driver['DriverProfile']['driver_name'];
                $driver_avatar = PathUtil::getFullPath($driver['DriverProfile']['avatar_filepath']);

                if($driver['active']) $driver_hint = $this->Html->link('<code><big>'.$driver_name.'</big></code>', array('controller'=>'drivers', 'action'=>'profile', $driver['DriverProfile']['driver_nick']), array('escape'=>false));
                else $driver_hint = '<b>'.$driver_name.'</b>';
                ?>
                <img src="<?php echo $driver_avatar?>" class="info" title="<?php echo $driver_name?>" style="max-width:60px"/>
                <?php echo $this->Html->link(__d('mobirise/testimonials', 'Ver perfil de %s', $driver_name), array('controller'=>'drivers', 'action'=>'profile', $driver['DriverProfile']['driver_nick']), array('class'=>'btn btn-success display-4', 'escape'=>false))?>
            </p>
        <?php endif;?>
        
        <?php if($shareReview && $hasProfile):?>
            <?php
            $reviewHasImage = isset($testimonial['image_filepath']) && $testimonial['image_filepath'];
            $share_img = 
                $reviewHasImage?
                    PathUtil::getFullPath($testimonial['image_filepath']):
                    $driver['DriverProfile']['featured_img_url'];
                    
            $reviewUrl = $this->Html->url(array('language'=>$testimonial['lang'], 'controller' => 'drivers', 'action' => 'profile',$driver['DriverProfile']['driver_nick'],'?'=>array('see-review'=>$testimonial['id']), 'base'=>false), true);
            ?>
            <br>
            <p class="mbr-author-desc mbr-fonts-style display-4">
                <a  style="padding:4px; padding-left: 7px;background-color: #1877f2;color: #FFFFFF !important;text-decoration: none;border-radius:5px"
                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $reviewUrl ?>" 
                    target="_blank"
                    title="Facebook">
                    <b><small><span class="fa fa-facebook"></span></small></b>
                </a>&nbsp;            
                <a  style="padding:4px;background-color: #bd081c;color: #FFFFFF !important;text-decoration: none;border-radius:5px"
                    href="https://pinterest.com/pin/create/button/?url=<?php echo $reviewUrl ?>&media=<?php echo $share_img ?>&description=<?php echo __d('testimonials', 'Testimonio de %s sobre su chofer en Cuba, %s', $testimonial['author'], $driver['DriverProfile']['driver_name'])?>" 
                    target="_blank"
                    title="Pinterest">
                    <b><small><span class="fa fa-pinterest"></span></small></b>
                </a>&nbsp;
                <a  style="padding:4px;background-color: #1da1f2;color: #FFFFFF !important;text-decoration: none;border-radius:5px"
                    href="https://twitter.com/home?status=<?php echo $reviewUrl ?>" 
                    target="_blank"
                    title="Twitter">
                    <b><small><span class="fa fa-twitter"></span></small></b>
                </a>
            </p>
        <?php endif?>
        
    </div>
    
    <?php if (isset($testimonial['image_filepath']) && $testimonial['image_filepath']): ?>
        <div class="mbr-figure pl-lg-5 d-none d-lg-block" style="width: 100%;">
            <img class=""  src='<?php echo PathUtil::getFullPath($testimonial['image_filepath']) ?>' alt="" title=""/>
        </div>
    <?php endif ?>
</div>

<?php foreach($driverReplies as $reply):?>
    <?php if(sizeof($reply)>0 && $reply['state'] == TestimonialsReply::$statesValues['approved']): ?>
        <?php echo $this->element('mobirise/testimonial-reply-full', array('reply'=>$reply,'driver'=>$driver))?>
    <?php endif; ?>
<?php endforeach;?>