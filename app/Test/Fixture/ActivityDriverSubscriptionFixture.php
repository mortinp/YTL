<?php
/**
 * ActivityDriverSubscriptionFixture
 *
 */
class ActivityDriverSubscriptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'driver_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'activity_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'price' => array('type' => 'float', 'null' => false, 'default' => null),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'driver_id' => '',
			'activity_id' => '',
			'price' => 1
		),
	);

}
