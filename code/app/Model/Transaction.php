<?php
App::uses('AppModel', 'Model');
/**
 * Transaction Model
 *
 * @property TransactionType $TransactionType
 * @property Category $Category
 * @property Subcategory $Subcategory
 * @property User $User
 */
class Transaction extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'transaction_type_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'subcategory_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'original_transaction_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'post_date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'number_of_cycles' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Zadali ste zlý počet opakovaní transakcie',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TransactionType' => array(
			'className' => 'TransactionType',
			'foreignKey' => 'transaction_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subcategory' => array(
			'className' => 'Subcategory',
			'foreignKey' => 'subcategory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function insert_repeat($data, $original_date) {
		$pom_data= array();
	
		$this->deleteAll(array('Transaction.original_transaction_id' => $data['original_transaction_id'], 'Transaction.post_date >' => $original_date, 'Transaction.id <>' => $data['id']  ), false);  // maze dalsie opakovania transakcie ktore su naplanovane do buducnosti
			
		for ($i = 1; $i<= $data['number_of_cycles']; $i++) {
			$timestamp= strtotime($data['post_date']);
			$day_of_the_month= date('j', $timestamp);	// kolky den v mesiaci bol nastaveny
			$month_of_the_year=date('n', $timestamp);
			if ($data['repeat_every'] == 'tyzden') {   //  ak je nastavene opakovanie kazdy tyzden
				$future_timestamp= strtotime("+$i week", $timestamp);					
			}
			if ($data['repeat_every'] == 'mesiac') { 		// ak je nastavene opakovanie kazdy mesiac
				if ($day_of_the_month < 29) {
					$future_timestamp= strtotime("+$i month", $timestamp);
				}
				else {	// nastaveny prilis neskory datum v mesiaci
					if (!$this->exists()) {
						throw new NotFoundException(__('Zlá transakcia. Zadajte prosím skorší deň v mesiaci pri výbere dátumu. Najneskorší povolený je 28. deň.'));
					}
					//$this->request->onlyAllow('post', 'delete');   // potrebujem zmazat prvu vytvorenu originalnu transakciu, pretoze ostatne sa nemohli vytvorit
					if ($this->delete()) {
						//$this->Session->setFlash(__('Zbytocna transakcia bola zmazaná'));
						return false;
						//$this->redirect(array('action' => 'index'));
					}
					//$this->Session->setFlash(__('Zbytočnú transakciu sa nepodarilo zmazať'));
					//$this->redirect(array('action' => 'index'));
				}
					
			}
			if ($data['repeat_every'] == 'rok') { 		// ak je nastavene opakovanie kazdy rok
				if (($day_of_the_month == 29) && ($month_of_the_year == 2)) {
					$future_timestamp= strtotime("+$i year -1 day", $timestamp);   // ak je nastaveny 29.feb tj. priestupny rok zmeni nasledujuce opakovania na 28.feb
				}
				else {
					$future_timestamp= strtotime("+$i year", $timestamp);
				}
					
			}
			
			$pom_data[] =
			array(
					'transaction_type_id' => $data['transaction_type_id'],
					'name' => $data['name'],
					'amount' => $data['amount'],
					'category_id' => $data['category_id'],
					'subcategory_id' => $data['subcategory_id'],
					'user_id' => $data['user_id'],
					'post_date' => date('Y-m-d', $future_timestamp),
					'original_transaction_id' => $this->id );
		}
		$this->create();
		$this->saveMany($pom_data);
		return true;
		//print_r($pom_data);
	
	}
}
