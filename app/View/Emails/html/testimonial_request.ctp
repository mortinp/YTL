<?php
   $driver_travel = $data['DriverTravel'];
   $travel        = $data['Travel'];
   $driver        = $data['Driver'];
   $user          = $data['Travel']['User'];
?>

<div> Aquí va el Texto del Mensaje<br>
      <b>Estructura de los datos:</b>
	  <?php debug($data); ?>
</div>

<!--
array(
	'DriverTravel' => array(
		'id' => '5788e6ca-02f8-47ea-bf9f-135010d2655b',
		'driver_id' => '32',
		'travel_id' => '163',
		'notification_type' => 'A',
		'last_driver_email' => '',
		'driver_traveler_conversation_count' => '0'
	),
	'Driver' => array(
		'id' => '32',
		'username' => 'cubamitaxi@gmail.com',
		'max_people_count' => '14',
		'DriverProfile' => array(
			'driver_nick' => 'ovidio-mitaxi',
			'driver_name' => 'Ovidio (MITAXI)',
			'avatar_filepath' => 'files\1435085784_avatar-ovidio_jpg',
			'show_profile' => false
		)
	),
	'Travel' => array(
		'id' => '163',
		'user_id' => '110',
		'origin' => 'La Habana',
		'destination' => 'Trinidad',
		'date' => '23-07-2016',
		'people_count' => '4',
		'Locality' => array(),
		'User' => array(
			'id' => '110',
			'username' => 'fdasf@hfgdfdf.d',
			'role' => 'regular',
			'lang' => 'en',
			'display_name' => '',
			'travel_count' => '1'
		)
	),
	'TravelConversationMeta' => array(
		'conversation_id' => '5788e6ca-02f8-47ea-bf9f-135010d2655b',
		'following' => false,
		'state' => 'D',
		'read_entry_count' => '0',
		'income' => null,
		'income_saving' => null,
		'comments' => null,
		'arrangement' => null,
		'asked_confirmation' => false,
		'received_confirmation_type' => null,
		'received_confirmation_details' => null,
		'archived' => false,
		'testimonial_requested' => '0'
	),
	'Testimonial' => array()
)
-->