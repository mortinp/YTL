<?php App::uses('SharedTravel', 'SharedTravels.Model')?>

<p>Hola Andiel, recibimos una nueva solicitud de viaje compartido.</p>

<p><b>NOTA:</b> En cuanto hayas gestionado el servicio, <b>responde este correo sin modificar el asunto</b> para confirmarle al cliente.</p>

<p>A continuación los detalles de la solicitud:</p>

<div><?php echo $this->element('shared_travel_facilitator', compact('request'))?></div>