<div class="row" style="margin: 0px">
    <div class="col-md-10 col-md-offset-1" style="text-align: center">
        <p class="lead">
            <?php echo __d('shared_travels', 'Solicita un transfer de %s a %s por un precio de %s por persona', 
                    '<code><big>'.$modality['origin'].'</big></code>', 
                    '<code><big>'.$modality['destination'].'</big></code>', 
                    '<code><big><big>'.$modality['price'].' CUC'.'</big></big></code>')?>
        </p>
        <p>
            <?php echo __d('shared_travels', 'Recogida a las %s en el lugar y fecha que indiques','<code><big><big><big>'.$modality['time'].'</big></big></big></code>')?> • <?php echo __d('shared_travels', 'Taxi compartido por <code><big><big>%s pasajeros</big></big></code>', '4')?>
        </p>
    </div>
</div>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12">
        <?php echo $this->element('shared_travel_form_bootbox', compact('modality') + compact('code'))?>
    </div>
</div>