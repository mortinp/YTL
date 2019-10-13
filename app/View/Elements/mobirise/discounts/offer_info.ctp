<?php App::uses('PathUtil', 'Util');?>

<?php
if(!isset($showButton)) $showButton = true;
?>

<div class="plan-header text-center pt-5">
    <div>
        <img src="<?php echo PathUtil::getFullPath($discount['Driver']['DriverProfile']['avatar_filepath'])?>" style="max-height: 40px;max-width: 40px"/> 
        <?php echo __d('mobirise/cheap_taxi', '%s ofrece', $discount['Driver']['DriverProfile']['driver_name']);?>:
    </div>
    <h3 class="plan-title mbr-fonts-style display-5">
        <br><br>
        <b><?php echo $discount['DiscountRide']['origin']; ?></b> > <b><?php echo $discount['DiscountRide']['destination']; ?></b></h3>
    <div class="plan-price">
        <span class="price-value mbr-fonts-style display-5">$</span>
        <span class="price-figure mbr-fonts-style display-2"><?php echo $discount['DiscountRide']['price']; ?></span>
        <small class="price-term mbr-fonts-style display-7">CUC <br><b><?php echo __d('mobirise/cheap_taxi', 'hasta %s personas', $discount['Driver']['max_people_count'])?></b></small>
    </div>
</div>
<div class="plan-body">
    <div class="plan-list align-center">
        <ul class="list-group list-group-flush mbr-fonts-style display-7">
            <li class="list-group-item"><?php echo __d('mobirise/cheap_taxi', 'Sólo disponible')?>:<br><?php echo __d('mobirise/cheap_taxi', 'Fecha / Horario salida')?></li>
            <li class="list-group-item"><strong><?php echo TimeUtil::prettyDateShort($discount['DiscountRide']['date'],false); ?> / <span style="display: inline-block"><?php echo TimeUtil::AmPm($discount['DiscountRide']['hour_min'])?> .. <?php echo TimeUtil::AmPm($discount['DiscountRide']['hour_max'])?></span></strong></li>
        </ul>
    </div>
    <?php if($showButton):?>
        <div class="mbr-section-btn text-center py-4 pb-5"><?php echo $this->Html->link(__d('mobirise/testimonials', 'Contactar a %s', $discount['Driver']['DriverProfile']['driver_name']), array('controller'=>'drivers', 'action'=>'profile', $discount['Driver']['DriverProfile']['driver_nick'],'?'=>array('discount'=>$discount['DiscountRide']['id'])), array('class'=>'btn btn-success display-4', 'escape'=>false,'target'=>'_blank'))?></div>
    <?php endif?>
</div>