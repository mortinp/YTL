<div class="plan-header text-center pt-5" style="padding-top: 10px !important">
    <div><small>Taxi disponible</small></div>
    <h3 class="plan-title mbr-fonts-style display-5">
        <small><b><?php echo TaxiAvailablePost::$localities[$discount['TaxiAvailablePost']['origin_id']]['name']; ?></b> > <b><?php echo TaxiAvailablePost::$localities[$discount['TaxiAvailablePost']['destination_id']]['name']; ?></b></small></h3>
    <div class="plan-price">
        <small class="price-term mbr-fonts-style display-7"><?php echo __d('mobirise/cheap_taxi', 'hasta <b>%s personas</b>', $discount['TaxiAvailablePost']['max_pax'])?></small>
    </div>
</div>
<div class="plan-body">
    <div class="plan-list align-center">
        <ul class="list-group list-group-flush mbr-fonts-style display-7">
            <li class="list-group-item">
                <small><?php echo __d('mobirise/cheap_taxi', 'Disponible %s a partir de:', '<b><big>'.TimeUtil::prettyDateShort($discount['TaxiAvailablePost']['date'],false).'</big></b>' )?></small>
                <br>
                <span style="display: inline-block">
                    
                    <b><?php echo TimeUtil::AmPm($discount['TaxiAvailablePost']['time_available_start'])?></b>
                    <?php if($discount['TaxiAvailablePost']['time_available_end'] != null):?>
                        .. <b><?php echo TimeUtil::AmPm($discount['TaxiAvailablePost']['time_available_end'])?></b>
                    <?php endif?>
                    
                </span>
            </li>
            <li class="list-group-item">
                <br>
                <b><?php echo __d('mobirise/cheap_taxi', 'CONTACTAR')?></b>
                <br>
                <?php echo __d('mobirise/cheap_taxi', 'Nombre taxista:')?> <b><?php echo $discount['TaxiAvailablePost']['contact_name']?></b>
                <br>
                <b><a href="tel:<?php echo $discount['TaxiAvailablePost']['contact_phone_number']?>">Llamar <?php echo substr($discount['TaxiAvailablePost']['contact_phone_number'], -8)?></a></b>
                <br>
                <a href="https://wa.me/<?php echo substr($discount['TaxiAvailablePost']['contact_phone_number'], -10)?>?text=<?php echo __('Hola %s', $discount['TaxiAvailablePost']['contact_name'])?>!" target="_blank" style="color: #25d366">
                    <span style="display: inline-block"><i class="fa fa-whatsapp"></i> WhatsApp</span>
                </a>
            </li>
        </ul>
    </div>
</div>