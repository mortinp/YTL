<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<p>Hola Andiel, recibimos una nueva solicitud de viaje compartido.</p>

<?php $modality = SharedTravel::$modalities[$request['SharedTravel']['modality_code']]?>
<p>Transfer compartido de <b><?php echo $request['SharedTravel']['people_count']?> personas</b> desde <b><?php echo $modality['origin']?></b> hasta <b><?php echo $modality['destination']?></b> con recogida a las <b><?php echo $modality['time']?></b> del <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b></p>

<p>A continuación los detalles:</p>

<div><?php echo $this->element('shared_travel', compact('request') + array('fromEmail'=>true, 'showEmail'=>false))?></div>

<br/>
<p><b>NOTA:</b> En cuanto hayas gestionado el servicio, <b>responde este correo sin modificar el asunto</b> para confirmarle al cliente.</p>