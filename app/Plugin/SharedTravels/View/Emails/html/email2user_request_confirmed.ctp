<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>

<?php $assistant = Configure::read('customer_assistant');?>

<p>Hola <?php echo $request['SharedTravel']['name_id']?>,</p>

<p>
    <?php echo __d('shared_travels', 'Buenas noticias: su viaje desde %s hasta %s el día %s ya fue gestionado y confirmado.', '<b>'.$modality['origin'].'</b>', '<b>'.$modality['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>')?> 
</p>

<?php if($request['SharedTravel']['people_count'] < 4):?><p><?php echo __d('shared_travels', 'En este viaje usted va a compartir un auto moderno de 4 plazas con aire acondicionado con otros viajeros.')?></p><?php endif?>

<p>
    <?php echo __d('shared_travels', 'Recuerde que puede ver los datos de su solicitud en este enlace')?>:
</p>

<?php $urlDef = array('language'=>$request['SharedTravel']['lang'], 'controller' => 'shared_travels', 'action' => 'view/' . $request['SharedTravel']['id_token'], 'base'=>false) ?>
<p><a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo $this->Html->url($urlDef, true) ?></a></p>

<p>
    <?php echo __d('shared_travels', 'Siéntase libre de contactarme en cualquier momento que necesite ayuda.', $modality['destination'])?>
</p>

<p>
    <?php echo __d('shared_travels', 'Le deseo un feliz viaje a Cuba y un cómodo recorrido hasta %s', $modality['destination'])?>,
</p>

<p>
    <?php echo __d('shared_travels', '%s y el equipo de', $assistant['name'])?> <a href="http://yotellevocuba.com">YoTeLlevo</a>.
</p>