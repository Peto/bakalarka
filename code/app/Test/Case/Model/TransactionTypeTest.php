<?php
App::uses('TransactionType', 'Model');

/**
 * TransactionType Test Case
 *
 */
class TransactionTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.transaction_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TransactionType = ClassRegistry::init('TransactionType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TransactionType);

		parent::tearDown();
	}

}
