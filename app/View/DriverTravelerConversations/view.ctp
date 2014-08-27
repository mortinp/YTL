<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <legend>Acuerdo de viaje del chofer <?php echo $data['Driver']['username']?></legend>
        <?php echo $this->element('travel', array('travel'=>$data, 'actions'=>false))?>
    </div>
</div>
<br/>

<?php if(empty ($conversations)):?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        No hay conversaciones hasta el momento
    </div>
</div>   
<?php endif?>

<?php foreach ($conversations as $c):?>
<div class="row">
    <div class="col-md-6">
        <?php if($c['DriverTravelerConversation']['response_by'] == 'driver') {
            echo "<b>Chofer:</b> ";
            echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $c['DriverTravelerConversation']['response_text']);
        }?>
    </div>
    <div class="col-md-6">        
        <?php if($c['DriverTravelerConversation']['response_by'] == 'traveler'){
            echo "<b>Viajero:</b> ";
            echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $c['DriverTravelerConversation']['response_text']);
            
        }?>
    </div>
</div>    
<?php endforeach;?>