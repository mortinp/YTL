<legend>
    <big>
        <?php if($travel['TravelByEmail']['direction'] == 0):?>
        <b><span id='travel-locality-label'><?php echo $travel['TravelByEmail']['matched']?></span></b>
        - 
        <b><span id='travel-where-label'><?php echo $travel['TravelByEmail']['where']?></span></b>
        <?php else:?>
        <b><span id='travel-where-label'><?php echo $travel['TravelByEmail']['where']?></span></b>
        - 
        <b><span id='travel-locality-label'><?php echo $travel['TravelByEmail']['matched']?></span></b>
        <?php endif;?>
    </big> 
</legend>


<p><b><?php echo __('Detalles del viaje')?>:</b> <?php echo $travel['TravelByEmail']['description']?></p>
<?php if(isset($showEmail) && $showEmail):?>
<p><b><?php echo __('Correo de contacto')?>:</b> <span id='travel-details-label'><?php echo $travel['User']['username']?></span></p>
<?php endif?>