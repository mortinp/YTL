<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <?php echo __d('shared_travels', 'Transfer desde %s hasta %s el %s', '<code><big>'.$modality['origin'].'</big></code>', '<code><big>'.$modality['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</big></code>')?>
            <hr/>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <?php echo $this->element('shared_travel', compact('request'))?>
        </div>

        <div class="col-md-3 alert alert-warning" style="display: inline-block">
            <?php echo $this->element('suggest_transfers', compact('modality'))?>
        </div>
    </div>
</div>