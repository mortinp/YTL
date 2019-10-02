<div class="plan-header text-center pt-5">
    <div>
        <img src="<?php echo $discount['Driver']['DriverProfile']['featured_img_url']?>" alt="<?php echo $discount['Driver']['DriverProfile']['driver_name']?>" style="max-height: 40px;max-width: 40px"/> 
        <?php echo $discount['Driver']['DriverProfile']['driver_name'];   ?> ofrece:
    </div>
    <h3 class="plan-title mbr-fonts-style display-5">
        <br><br>
        <b><?php echo $discount['DiscountRide']['origin']; ?></b> > <b><?php echo $discount['DiscountRide']['destination']; ?></b></h3>
    <div class="plan-price">
        <span class="price-value mbr-fonts-style display-5">
            $
        </span>
        <span class="price-figure mbr-fonts-style display-2">
            <?php echo $discount['DiscountRide']['price']; ?></span>
        <small class="price-term mbr-fonts-style display-7">CUC <br><b>hasta <?php echo $discount['Driver']['max_people_count']; ?> personas</b></small>
    </div>
</div>
<div class="plan-body">
    <div class="plan-list align-center">
        <ul class="list-group list-group-flush mbr-fonts-style display-7">
            <li class="list-group-item">
                Fecha / Horario salida</li>
            <li class="list-group-item"><strong><?php echo TimeUtil::prettyDateShort($discount['DiscountRide']['date']); ?> / <?php echo $discount['DiscountRide']['hour_min']; ?> - <?php echo $discount['DiscountRide']['hour_max']; ?></strong></li>
        </ul>
    </div>
    <div class="mbr-section-btn text-center py-4 pb-5"><?php echo $this->Html->link(__d('mobirise/testimonials', 'Contactar a %s', $discount['Driver']['DriverProfile']['driver_name']), array('controller'=>'drivers', 'action'=>'profile', $discount['Driver']['DriverProfile']['driver_nick']), array('class'=>'btn btn-success display-4', 'escape'=>false,'target'=>'_blank'))?></div>
</div>