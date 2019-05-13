<?php
if(!isset($shareTitle)) $shareTitle = __d('mobirise/default', 'Comparte esta página');
if(!isset($shareSubtitle)) $shareSubtitle = null;
?>
<section class="cid-r6SRH2DkY0">
    <div class="container">
        <div class="media-container-row">
            <div class="col-md-8 align-center">
                <h2 class="pb-3 mbr-section-title mbr-fonts-style display-2">
                    <?php echo $shareTitle?>
                </h2>
                <?php if($shareSubtitle != null):?>
                <div class="pb-3 mbr-section-title mbr-fonts-style display-5">
                    <?php echo $shareSubtitle?>
                </div>
                <?php endif?>
                <div>
                    <div class="mbr-social-likes" data-counters="false">
                        <span class="btn btn-social facebook mx-2" title="<?php echo __d('mobirise/default', 'Comparte esta página en %s', 'Facebook')?>">
                            <i class="socicon socicon-facebook"></i>
                        </span>
                        <span class="btn btn-social twitter mx-2" title="<?php echo __d('mobirise/default', 'Comparte esta página en %s', 'Twitter')?>">
                            <i class="socicon socicon-twitter"></i>
                        </span>
                        <span class="btn btn-social plusone mx-2" title="<?php echo __d('mobirise/default', 'Comparte esta página en %s', 'Google+')?>">
                            <i class="socicon socicon-googleplus"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>