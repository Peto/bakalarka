<?php
/**
 * ImportFixture
 *
 */
class ImportFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'date_from' => array('type' => 'date', 'null' => true, 'default' => null),
		'date_to' => array('type' => 'date', 'null' => true, 'default' => null),
		'xml_file' => array('type' => 'binary', 'null' => true, 'default' => null),
		'processed' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'filename' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id_imports_idx' => array('column' => 'user_id', 'unique' => 0)
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
			'date_from' => '2013-02-20',
			'date_to' => '2013-02-20',
			'xml_file' => 'Lorem ipsum dolor sit amet',
			'processed' => 1,
			'filename' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1
		),
	);

}
