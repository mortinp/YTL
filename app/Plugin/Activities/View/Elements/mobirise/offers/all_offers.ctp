<div style="padding:10px !important" class="row cid-rDj8V5iu3T justify-content-center">
    <?php foreach($discounts as $d): ?>
    <?php /*die(print_r($d)); */?>
    <div id="offer<?php echo $d['ActivityDriverSubscription']['id'];  ?>" class="plan col-12 mx-2 my-2 justify-content-center favorite col-lg-6"><?php echo $this->element('mobirise/offers/offer_info',array('offer'=>$d,'id'=>$d['ActivityDriverSubscription']['id'])) ?></div>
    <?php endforeach; ?> 
</div>