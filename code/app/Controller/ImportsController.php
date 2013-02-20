<?php
App::uses('AppController', 'Controller');
/**
 * Imports Controller
 *
 * @property Import $Import
 */
class ImportsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Import->recursive = 0;
		$this->set('imports', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Import->exists($id)) {
			throw new NotFoundException(__('Invalid import'));
		}
		$options = array('conditions' => array('Import.' . $this->Import->primaryKey => $id));
		$this->set('import', $this->Import->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Import->create();
			if ($this->Import->save($this->request->data)) {
				$this->Session->setFlash(__('The import has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The import could not be saved. Please, try again.'));
			}
		}
		$users = $this->Import->User->find('list');
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
		if (!$this->Import->exists($id)) {
			throw new NotFoundException(__('Invalid import'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Import->save($this->request->data)) {
				$this->Session->setFlash(__('The import has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The import could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Import.' . $this->Import->primaryKey => $id));
			$this->request->data = $this->Import->find('first', $options);
		}
		$users = $this->Import->User->find('list');
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
		$this->Import->id = $id;
		if (!$this->Import->exists()) {
			throw new NotFoundException(__('Invalid import'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Import->delete()) {
			$this->Session->setFlash(__('Import deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Import was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
