<div class="team-item col-lg-3 col-md-6">
    <div class="item-image">
        <?php if ($testimonial['image_filepath']): ?>
            <?php
            $src = '';
            if (Configure::read('debug') > 0)
                $src .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien
            $src .= '/' . str_replace('\\', '/', $testimonial['image_filepath']);
            ?>
            <img src='<?php echo $src ?>' alt="" title=""/>
        <?php endif ?> 
    </div>
    <div class="item-caption py-3">
        <div class="item-name px-2">
            <p class="mbr-fonts-style display-7"><?php echo __d('mobirise/testimonials', '%s sobre %s', $testimonial['author'], $driver['DriverProfile']['driver_name'])?><br><br></p>
            
            <?php 
            //$created_converted = strtotime($testimonial['created']);
            $now = new DateTime(date('Y-m-d', time()));
            $daysPosted = $now->diff(new DateTime($testimonial['created']), true)->format('%a');
            
            if($daysPosted == 0) $daysPosted = __d('mobirise/testimonials', 'Hoy');
            else if($daysPosted == 1) $daysPosted = __d('mobirise/testimonials', 'Ayer');
            else $daysPosted = __d('mobirise/testimonials', 'Hace %s días', $daysPosted);
            
            ?>
            <p class="mbr-fonts-style display-6"><?php echo $daysPosted?><br><br></p>
            
        </div>
        <div class="item-role px-2">
            <p><?php echo preg_replace("/(\r\n|\n|\r)/", " ", substr($testimonial['text'], 0, 300))?> ...</p>
        </div>

    </div>
</div>