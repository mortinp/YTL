<div class="plan-header text-center pt-5" style="padding-top: 0px !important">
    <h3 class="plan-title mbr-fonts-style display-5">
        <br><br>
        <b><?php echo TaxiAvailablePost::$localities[$discount['TaxiAvailablePost']['origin_id']]; ?></b> > <b><?php echo TaxiAvailablePost::$localities[$discount['TaxiAvailablePost']['destination_id']]; ?></b></h3>
    <div class="plan-price">
        <small class="price-term mbr-fonts-style display-7"><b><?php echo __d('mobirise/cheap_taxi', 'hasta %s personas', $discount['TaxiAvailablePost']['max_pax'])?></b></small>
    </div>
</div>
<div class="plan-body">
    <div class="plan-list align-center">
        <ul class="list-group list-group-flush mbr-fonts-style display-7">
            <li class="list-group-item">
                <small><?php echo __d('mobirise/cheap_taxi', 'Disponible a partir de:')?></small>
                <br>
                <!--<small><?php echo __d('mobirise/cheap_taxi', 'Fecha / Horario')?></small>
                <br>-->
                <b><?php echo TimeUtil::prettyDateShort($discount['TaxiAvailablePost']['date'],false);?></b> 
                /
                <span style="display: inline-block">
                    <b>
                    <?php echo TimeUtil::AmPm($discount['TaxiAvailablePost']['time_available_start'])?> 
                    <?php if($discount['TaxiAvailablePost']['time_available_end'] != null):?>
                        .. <?php echo TimeUtil::AmPm($discount['TaxiAvailablePost']['time_available_end'])?>
                    <?php endif?>
                    </b>
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