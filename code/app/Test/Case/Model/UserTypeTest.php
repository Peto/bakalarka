<?php
App::uses('UserType', 'Model');

/**
 * UserType Test Case
 *
 */
class UserTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserType = ClassRegistry::init('UserType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserType);

		parent::tearDown();
	}

}
