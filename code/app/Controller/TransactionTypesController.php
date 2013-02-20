<?php
App::uses('AppController', 'Controller');
/**
 * TransactionTypes Controller
 *
 * @property TransactionType $TransactionType
 */
class TransactionTypesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TransactionType->recursive = 0;
		$this->set('transactionTypes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TransactionType->exists($id)) {
			throw new NotFoundException(__('Invalid transaction type'));
		}
		$options = array('conditions' => array('TransactionType.' . $this->TransactionType->primaryKey => $id));
		$this->set('transactionType', $this->TransactionType->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TransactionType->create();
			if ($this->TransactionType->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction type could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TransactionType->exists($id)) {
			throw new NotFoundException(__('Invalid transaction type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TransactionType->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction type could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TransactionType.' . $this->TransactionType->primaryKey => $id));
			$this->request->data = $this->TransactionType->find('first', $options);
		}
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
		$this->TransactionType->id = $id;
		if (!$this->TransactionType->exists()) {
			throw new NotFoundException(__('Invalid transaction type'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TransactionType->delete()) {
			$this->Session->setFlash(__('Transaction type deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
