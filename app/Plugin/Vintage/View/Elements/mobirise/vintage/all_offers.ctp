<div style="padding:10px !important" class="row cid-rDj8V5iu3T justify-content-center">
    <?php foreach($offers as $o): ?>    
    <div id="offer<?php echo $o['Driver']['id'];  ?>" class="plan col-12 mx-2 my-2 justify-content-center favorite col-lg-6"><?php echo $this->element('mobirise/vintage/offer_info',array('offer'=>$o,'id'=>$o['Driver']['id'])) ?></div>
    <?php endforeach; ?> 
</div>