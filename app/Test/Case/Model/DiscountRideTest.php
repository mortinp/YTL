<?php
App::uses('DiscountRide', 'Model');

/**
 * DiscountRide Test Case
 *
 */
class DiscountRideTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DiscountRide = ClassRegistry::init('DiscountRide');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DiscountRide);

		parent::tearDown();
	}

}
