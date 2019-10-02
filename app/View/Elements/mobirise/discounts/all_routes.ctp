<?php foreach($discounts as $date => $travel ): ?>
<div class="card">
    <div class="card-header" role="tab" id="heading<?php echo $date; ?>">
        <a role="button" class="panel-title collapsed text-black" data-toggle="collapse" data-core="" href="#collapse<?php echo $date; ?>" aria-expanded="false" aria-controls="collapse1">
            <h4 class="mbr-fonts-style display-5">
                <span class="sign mbr-iconfont mbri-arrow-down inactive"></span>
                <b><?php echo $date; ?></b>
            </h4>
        </a>
    </div>
    <div id="collapse<?php echo $date; ?>" class="panel-collapse noScroll collapse " role="tabpanel" aria-labelledby="headingOne" data-parent="#bootstrap-accordion_3">
        <div class="panel-body p-4">
            
            <div style="padding:10px !important" class="row cid-rDj8V5iu3T justify-content-center">
               <?php foreach($travel as $d): ?>
                <div class="plan col-12 mx-2 my-2 justify-content-center favorite col-lg-6"><?php echo $this->element('mobirise/discounts/route_info',array('discount'=>$d)) ?></div>
               <?php endforeach; ?> 
            </div>
            
        </div>
    </div>
</div>
<?php endforeach; ?>