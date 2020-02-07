<?php
App::uses('ActivityDriverSubscription', 'Model');

/**
 * ActivityDriverSubscription Test Case
 *
 */
class ActivityDriverSubscriptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.activity_driver_subscription',
		'app.driver',
		'app.province',
		'app.locality',
		'app.drivers_locality',
		'app.driver_profile',
		'app.activity'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ActivityDriverSubscription = ClassRegistry::init('ActivityDriverSubscription');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ActivityDriverSubscription);

		parent::tearDown();
	}

}
