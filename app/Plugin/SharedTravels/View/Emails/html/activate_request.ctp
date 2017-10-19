<?php App::uses('TimeUtil', 'Util')?>
<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<?php
$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>

<p>Hola <?php echo $request['SharedTravel']['name_id']?>,</p>

<p><?php echo __d('shared_travels', 'Usted solicitó un transfer de %s personas desde %s hasta %s el día %s con recogida a las %s.', '<b>'.$request['SharedTravel']['people_count'].'</b>', '<b>'.$modality['origin'].'</b>', '<b>'.$modality['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>', '<b>'.$modality['time'].'</b>')?></p>

<p><?php echo __d('shared_travels', 'Precio total por las %s personas: %s', $request['SharedTravel']['people_count'], '<b>'.$request['SharedTravel']['people_count']*$modality['price'].' CUC</b>')?></p>

<p><?php echo __d('shared_travels', 'Antes de comenzar los arreglos, usted debe confirmar la solicitud haciendo click en el siguiente enlace')?>:</p>

<?php $urlDef = array('language'=>$request['SharedTravel']['lang'], 'controller' => 'shared_travels', 'action' => 'activate/' . $request['SharedTravel']['activation_token'], 'base'=>false) ?>
<p><a href='<?php echo $this->Html->url($urlDef, true)?>'><?php echo $this->Html->url($urlDef, true)?></a></p>


<p><?php echo __d('shared_travels', 'Gracias de antemano, y saludos')?>,</p>

<p><?php echo __d('shared_travels', 'El equipo de')?> <a href="http://yotellevocuba.com">YoTeLlevo</a>.</p>