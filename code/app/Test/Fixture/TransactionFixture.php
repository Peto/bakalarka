<?php
/**
 * TransactionFixture
 *
 */
class TransactionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'transaction_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'amount' => array('type' => 'float', 'null' => true, 'default' => null),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'subcategory_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'original_transaction_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'post_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'transaction_type_id_idx' => array('column' => 'transaction_type_id', 'unique' => 0),
			'category_id_idx' => array('column' => 'category_id', 'unique' => 0),
			'subcategory_id_idx' => array('column' => 'subcategory_id', 'unique' => 0),
			'user_id_idx' => array('column' => 'user_id', 'unique' => 0),
			'original_transaction_id_idx' => array('column' => 'original_transaction_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_slovak_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'transaction_type_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'amount' => 1,
			'category_id' => 1,
			'subcategory_id' => 1,
			'user_id' => 1,
			'original_transaction_id' => 1,
			'post_date' => '2013-02-21'
		),
	);

}
