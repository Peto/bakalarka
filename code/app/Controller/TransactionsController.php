<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 */
class TransactionsController extends AppController {

	
	public $paginate;
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->paginate = array(
			'limit' => 20,
			'order' => array(
				'Transaction.post_date' => 'asc'
			),
			'conditions' => array(
				'Transaction.user_id' => $this->Session->read('User.id'),
			),
		);
		
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}
	
	public function income() {
	
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.transaction_type_id' => '1',
				),
		);
	
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}
	
	public function expense() {
	
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.transaction_type_id' => '2',
				),
		);
	
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}
	
	public function date_test() {
	
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.post_date' => '2013-04-26',
				),
		);
	
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
		$this->set('transaction', $this->Transaction->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		/* Array
		(
				[Transaction] => Array
				(
						[transaction_type_id] => 1
						[name] => name 30
						[amount] => 30
						[category_id] => 3
						[subcategory_id] => 3
						[user_id] => 8
						[post_date] => 2013-03-04
						[repeat] => 0
						[repeat_every] => mesiac
						[number_of_cycles] => 1
				)
		
		) */
		
		if ($this->request->is('post')) {
			$this->Transaction->create();
			//print_r($this->request->data);
			$data= $this->request->data['Transaction'];
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));  // zistit IDcku novo ulozeneho objektu
				//$this->redirect(array('action' => 'index'));
			
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
			if ($data['repeat'] == 1) {
				$pom_data= array();
				for ($i = 1; $i<= $data['number_of_cycles']; $i++) {
					$timestamp= strtotime($data['post_date']);
					$day_of_the_month= date('j', $timestamp);	// kolky den v mesiaci bol nastaveny
					$month_of_the_year=date('n', $timestamp);
					if ($data['repeat_every'] == 'tyzden') {   //  ak je nastavene opakovanie kazdy tyzden
						$future_timestamp= strtotime("+$i week", $timestamp);
						  
						$pom_data[] =
						    array(
						    		'transaction_type_id' => $data['transaction_type_id'],
						    		'name' => $data['name'],
						    		'amount' => $data['amount'],
						    		'category_id' => $data['category_id'],
						    		'subcategory_id' => $data['subcategory_id'],
						    		'user_id' => $data['user_id'],
						    		'post_date' => date('Y-m-d', $future_timestamp), 
						    		'original_transaction_id' => $this->Transaction->id );
						
					}
					if ($data['repeat_every'] == 'mesiac') { 		// ak je nastavene opakovanie kazdy mesiac
						if ($day_of_the_month < 29) {
							$future_timestamp= strtotime("+$i month", $timestamp);
						
							$pom_data[] =
							array(
									'transaction_type_id' => $data['transaction_type_id'],
									'name' => $data['name'],
									'amount' => $data['amount'],
									'category_id' => $data['category_id'],
									'subcategory_id' => $data['subcategory_id'],
									'user_id' => $data['user_id'],
									'post_date' => date('Y-m-d', $future_timestamp),
									'original_transaction_id' => $this->Transaction->id );
						}
						else {			// nastaveny prilis neskory datum v mesiaci	
							if (!$this->Transaction->exists()) {
								throw new NotFoundException(__('Zlá transakcia'));
							}
							$this->request->onlyAllow('post', 'delete');   // potrebujem zmazat prvu vytvorenu originalnu transakciu, pretoze ostatne sa nemohli vytvorit
							if ($this->Transaction->delete()) {
								//$this->Session->setFlash(__('Zbytocna transakcia bola zmazaná'));
								$this->Session->setFlash(__('Zadajte prosím skorší deň v mesiaci pri výbere dátumu. Najneskorší povolený je 28. deň.'));
								//$this->redirect(array('action' => 'index'));
							}
							//$this->Session->setFlash(__('Zbytočnú transakciu sa nepodarilo zmazať'));
							//$this->redirect(array('action' => 'index'));
						}
					
					}
					if ($data['repeat_every'] == 'rok') { 		// ak je nastavene opakovanie kazdy rok
						if (($day_of_the_month == 29) && ($month_of_the_year == 2)) {
							$future_timestamp= strtotime("+$i year -1 day", $timestamp);   // ak je nastaveny 29.feb tj. priestupny rok zmeni nasledujuce opakovania na 28.feb
					
							$pom_data[] =
							array(
									'transaction_type_id' => $data['transaction_type_id'],
									'name' => $data['name'],
									'amount' => $data['amount'],
									'category_id' => $data['category_id'],
									'subcategory_id' => $data['subcategory_id'],
									'user_id' => $data['user_id'],
									'post_date' => date('Y-m-d', $future_timestamp),
									'original_transaction_id' => $this->Transaction->id );
						}
						else {			
							$future_timestamp= strtotime("+$i year", $timestamp);
					
							$pom_data[] =
							array(
									'transaction_type_id' => $data['transaction_type_id'],
									'name' => $data['name'],
									'amount' => $data['amount'],
									'category_id' => $data['category_id'],
									'subcategory_id' => $data['subcategory_id'],
									'user_id' => $data['user_id'],
									'post_date' => date('Y-m-d', $future_timestamp),
									'original_transaction_id' => $this->Transaction->id );
						}
							
					}
				}
			$this->Transaction->create();
			$this->Transaction->saveMany($pom_data);
			//print_r($pom_data);
			}
			
		}
		
		$user_id = $this->Session->read('User.id'); 
		
		//print_r($this->Session->read('User.id'));
		$users = $this->Transaction->User->find('list');
		$this->set('transaction_types', $this->Transaction->TransactionType->find('list'));
		$this->set('categories', $this->Transaction->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		$this->set('subcategories', $this->Transaction->Subcategory->find('list', array('conditions' => array('Subcategory.user_id' => $user_id))));
		$this->set('user', $user_id); 	
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
			$this->request->data = $this->Transaction->find('first', $options);
			$this->set('data', $this->request->data);
		}
		
		$user_id = $this->Session->read('User.id');
		
		$users = $this->Transaction->User->find('list');
		$this->set('transaction_types', $this->Transaction->TransactionType->find('list'));
		$this->set('categories', $this->Transaction->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		$this->set('subcategories', $this->Transaction->Subcategory->find('list', array('conditions' => array('Subcategory.user_id' => $user_id))));
		$this->set('user', $user_id);
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transaction deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	/**
	* delete_next_repeats method
	*
	* @throws NotFoundException
	* @throws MethodNotAllowedException
	* @param string $id
	* @return void
	*/
	public function delete_next_repeats($id = null) {
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		//$this->request->onlyAllow('post', 'delete');
		
		$original_id = $this->Transaction->field('original_transaction_id');
		$post_date = $this->Transaction->field('post_date');
		
		if ($this->Transaction->delete()) {
// 			$original_id = $this->Transaction->original_transaction_id;
// 			$post_date = $this->Transaction->post_date;
// echo $original_id.' | '.$post_date;
			if($original_id != '') {
				if($this->Transaction->deleteAll(array('Transaction.original_transaction_id' => $original_id, 'Transaction.post_date >' => $post_date ), false)) {
					$this->Session->setFlash(__('Vybratá transakcia a jej neskoršie opakovania boli vymazané.'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				if($this->Transaction->deleteAll(array('Transaction.original_transaction_id' => $id, 'Transaction.post_date >' => $post_date ), false)) {
					$this->Session->setFlash(__('Vybratá transakcia a jej neskoršie opakovania boli vymazané. 2'));
					$this->redirect(array('action' => 'index'));
				}
			}
// 			$this->Session->setFlash(__('Vybratá transakcia a jej neskoršie opakovania boli vymazané.'));
// 			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transakcia nebola vymazaná.'));
		//$this->redirect(array('action' => 'index'));
	}
}



