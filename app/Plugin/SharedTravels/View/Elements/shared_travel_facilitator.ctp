<?php App::uses('SharedTravel', 'SharedTravels.Model')?>
<?php App::uses('TimeUtil', 'Util')?>

<?php $modality = SharedTravel::$modalities[$request['SharedTravel']['modality_code']]?>

<div class="row">
    <hr/>
    <div>Transfer de <b><?php echo $request['SharedTravel']['people_count']?> personas</b> desde <b><?php echo $modality['origin']?></b> hasta <b><?php echo $modality['destination']?></b> con recogida a las <b><?php echo $modality['time']?></b> del <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b></div>
    <br/>
    
    <div class="col-md-6">
        <div><b><?php echo __d('shared_travels', 'DATOS DEL TRANSFER')?></b></div><hr/>
        <div>Referencia: <b><?php echo $request['SharedTravel']['id']?></b></div>
        <div>Fecha recogida: <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b> a las <b><?php echo $modality['time']?></b></div>
        <div>Cantidad de personas: <b><?php echo $request['SharedTravel']['people_count']?></b></div>
        <div>Precio <?php echo $request['SharedTravel']['people_count']?> personas x <?php echo $modality['price']?> CUC: <b><?php echo $request['SharedTravel']['people_count']*$modality['price']?> CUC</b></div>
        <div>Lugar de recogida en <b><?php echo $modality['origin']?></b>: <div><b><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></b></div></div>
        <div>Lugar de destino en <b><?php echo $modality['destination']?></b>: <div><b><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></b></div></div>
    </div>
    
    <hr/>
    
    <div class="col-md-6">
        <div><b>DATOS DEL CLIENTE</b></div><hr/>
        <div>Nombre: <?php echo $request['SharedTravel']['name_id']?></div>
        
        <?php if($request['SharedTravel']['contacts'] != null):?>
            <div>Contactos: <?php echo $request['SharedTravel']['contacts']?></div>
        <?php endif?>
    </div>
</div>