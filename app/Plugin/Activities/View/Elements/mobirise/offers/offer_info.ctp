<?php App::uses('PathUtil', 'Util');?>

<?php
if(!isset($showButton)) $showButton = true;
?>

<div class="plan-header text-center pt-5">
    <div>
        <img src="<?php echo PathUtil::getFullPath($offer['Driver']['DriverProfile']['avatar_filepath'])?>" style="max-height: 40px;max-width: 40px"/> 
        <?php echo __d('mobirise/cheap_taxi', '%s ofrece', $offer['Driver']['DriverProfile']['driver_name']);?>:
    </div>
  
    <div class="plan-price">
        <span class="price-value mbr-fonts-style display-5">$</span>
        <span class="price-figure mbr-fonts-style display-2"><?php echo $offer['ActivityDriverSubscription']['price']; ?></span>
        <small class="price-term mbr-fonts-style display-7">CUC <br><b><?php echo __d('mobirise/cheap_taxi', 'hasta %s personas', $offer['Driver']['max_people_count'])?></b></small>
    </div>
</div>
<div class="plan-body">  
    <?php if($showButton):?>
        <div class="mbr-section-btn text-center py-4 pb-5"><?php echo $this->Html->link(__d('mobirise/cheap_taxi', 'Contactar a %s para este traslado', $offer['Driver']['DriverProfile']['driver_name']), array('controller'=>'drivers', 'action'=>'profile', $offer['Driver']['DriverProfile']['driver_nick'],'?'=>array('activity_offer'=>$id)), array('class'=>'btn btn-success display-4', 'escape'=>false,'target'=>'_blank'))?></div>
    <?php endif?>
</div>