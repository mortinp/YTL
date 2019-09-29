<?php
/**
 * DiscountRideFixture
 *
 */
class DiscountRideFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'driver_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'origin' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'destination' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'hour_min' => array('type' => 'integer', 'null' => false, 'default' => null),
		'hour_max' => array('type' => 'integer', 'null' => false, 'default' => null),
		'price' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'is_booked' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'driver_id' => array('column' => 'driver_id', 'unique' => 0)
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
			'id' => '5d8e2031-e6c0-459a-8d69-11e810d2655b',
			'driver_id' => '',
			'origin' => 'Lorem ipsum dolor sit amet',
			'destination' => 'Lorem ipsum dolor sit amet',
			'date' => '2019-09-27',
			'hour_min' => 1,
			'hour_max' => 1,
			'price' => 1,
			'is_booked' => 1,
			'created' => '2019-09-27'
		),
	);

}
