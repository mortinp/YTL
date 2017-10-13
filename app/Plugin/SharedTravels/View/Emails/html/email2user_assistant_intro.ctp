<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>

<?php $assistant = Configure::read('customer_assistant');?>

<p>Hola <?php echo $request['SharedTravel']['name_id']?>,</p>

<p>
    <?php echo __d('shared_travels', 'Le quiero informar que recibimos su solicitud de viaje compartido desde %s hasta %s para el día %s', '<b>'.$modality['origin'].'</b>', '<b>'.$modality['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>')?> 
</p>

<p>
    <?php echo __d('shared_travels', 'Mi nombre es %s y voy a ser su asistente mientras llega la fecha de la recogida, para este viaje y cualquier otro que usted solicite.', $assistant['name'])?> 
</p>

<p>
    <?php echo __d('shared_travels', 'Como asistente voy a estar a cargo de resolver cualquier problema que pueda surgir, problemas con el sitio y cualquier duda que usted pueda tener.')?>
</p>

<p>
    <?php echo __d('shared_travels', 'Por ahora <b>este viaje está sin confirmar</b> porque recién comenzamos a gestionarlo. Yo voy a estar al tanto de la confirmación de su viaje y le haré saber enseguida.')?>
</p>

<p>
    <?php echo __d('shared_travels', 'En cualquier momento puede ver los datos de su solicitud en el siguiente enlace')?>:
</p>
<?php $urlDef = array('language'=>$request['SharedTravel']['lang'], 'controller' => 'shared_travels', 'action' => 'view/' . $request['SharedTravel']['id_token'], 'base'=>false) ?>
<p><a href='<?php echo $this->Html->url($urlDef, true) ?>'><?php echo $this->Html->url($urlDef, true) ?></a></p>

<p>
    <?php echo __d('shared_travels', 'Un cordial saludo desde Cuba', $modality['destination'])?>,
</p>

<p>
    <?php echo __d('shared_travels', '%s y el equipo de', $assistant['name'])?> <a href="http://yotellevocuba.com">YoTeLlevo</a>.
</p>