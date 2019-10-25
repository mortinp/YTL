<?php


    $pretty_date = TimeUtil::prettyDate($discount['DiscountRide']['date']);
    $date_converted = strtotime($discount['DiscountRide']['date']);

    $expired = CakeTime::isPast($date_converted) && !CakeTime::isToday($date_converted);
    if($expired) $pretty_date .= ' <span class="badge">Expirado</span>';
?>

            <div>
                <h2>
                    
                    <span style="display: inline-block">                     
                        <small><?php echo $discount['DiscountRide']['origin']. ' - '. $discount['DiscountRide']['destination']; ?></small>    

                    </span> 
                </h2>
                <div class="plan-price">
                    <span class="price-value mbr-fonts-style display-5">$</span>
                    <span class="price-figure mbr-fonts-style display-2"><?php echo $discount['DiscountRide']['price']; ?></span>
                    <small class="price-term mbr-fonts-style display-7">CUC <br><b><?php echo __d('mobirise/cheap_taxi', 'hasta %s personas', $discount['DiscountRide']['people_count'])?></b></small>
                </div>
            </div>
            <hr/>