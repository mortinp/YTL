<?php
App::uses('TestimonialsReply', 'Model');

/**
 * TestimonialsReply Test Case
 *
 */
class TestimonialsReplyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.testimonials_reply'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TestimonialsReply = ClassRegistry::init('TestimonialsReply');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TestimonialsReply);

		parent::tearDown();
	}

}
