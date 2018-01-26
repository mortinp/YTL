<?php App::uses('SharedTravel', 'SharedTravels.Model')?>
<?php App::uses('TimeUtil', 'Util')?>

<?php 
if(!isset($fromEmail)) $fromEmail = false;
if(!isset($showEmail)) $showEmail = true;
if(!isset($showDetails)) $showDetails = false;
if(!isset($admin)) $admin = false;
?>

<?php $modality = SharedTravel::$modalities[$request['SharedTravel']['modality_code']]?>

<div class="row">
    
    <?php if($fromEmail):?><hr/><?php endif?>
    
    <div class="col-md-6">
        <p><b><?php echo __d('shared_travels', 'DATOS DEL TRANSFER')?></b></p><hr/>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Referencia')?>:</span> <code><big><?php echo $request['SharedTravel']['modality_code'].$request['SharedTravel']['id']?></big></code></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Cantidad de personas')?>:</span> <?php echo $request['SharedTravel']['people_count']?></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Precio %s personas x %s', $request['SharedTravel']['people_count'], $modality['price'].' CUC')?>:</span> <code><big><?php echo $request['SharedTravel']['people_count']*$modality['price']?> CUC</big></code></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Fecha recogida')?>:</span> <?php echo __d('shared_travels', '%s <span class="text-muted">a las</span> %s', TimeUtil::prettyDate($request['SharedTravel']['date'], false), $modality['time'])?></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Lugar de recogida en %s', $modality['origin'])?>:</span> <div><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></div></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Lugar de destino en %s', $modality['destination'])?>:</span> <div><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></div></p>
    </div>
    
    <?php if($fromEmail):?><hr/><?php endif?>
    
    <div class="col-md-6">
        <p><b><?php echo __d('shared_travels', 'DATOS DE CONTACTO')?></b></p><hr/>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Nombre')?>:</span> <?php echo $request['SharedTravel']['name_id']?></p>
        <?php if($showEmail):?><p><span class="text-muted"><?php echo __d('shared_travels', 'Correo')?>:</span> <?php echo $request['SharedTravel']['email']?></p><?php endif?>
        
        <?php if($request['SharedTravel']['contacts'] != null):?>
            <p><span class="text-muted"><?php echo __d('shared_travels', 'Contactos')?>:</span> <?php echo $request['SharedTravel']['contacts']?></p>
        <?php endif?>
            
        <?php $st = SharedTravel::getStateDesc($request['SharedTravel']['state'])?>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Estado')?>:</span> <big><abbr class="info" title="<?php echo $st['description']?>" style="text-decoration: none"><span class="<?php echo $st['class']?>"><?php echo $st['title'] ?></span></abbr></big></p>
            
        <?php if($showDetails):?>
            <p><span class="text-muted"><?php echo __d('shared_travels', 'Idioma')?>:</span> <?php echo $request['SharedTravel']['lang']?></p>
            <p><?php echo $this->Html->link('Permalink', array('controller'=>'shared_travels', 'action' => 'view/' . $request['SharedTravel']['id_token']))?></p>
        <?php endif?>
        <?php if($admin):?>
            <p><?php echo $this->Html->link('admin', array('controller'=>'shared_travels', 'action' => 'admin/' . $request['SharedTravel']['id']))?></p>
        <?php endif?>
    </div>
</div>