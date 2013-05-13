<?php
App::uses('AppController', 'Controller');
/**
 * Subcategories Controller
 *
 * @property Subcategory $Subcategory
 */
class SubcategoriesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->paginate = array(
				'limit' => 20,
				'conditions' => array(
						'subcategory.user_id' => $this->Session->read('User.id'),
				),
		);
		
		$this->Subcategory->recursive = 0;
		$this->set('subcategories', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
		$this->set('subcategory', $this->Subcategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Subcategory->create();
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('Podkategória bola uložená.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Podkategóriu sa nepodarilo uložiť. Skúste prosím znovu.'));
			}
		}
		$user_id = $this->Session->read('User.id');
		$this->set('categories', $this->Subcategory->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		$this->set(compact('categories'));
		$this->set('user', $user_id);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Zlá podkategória'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('Podkategória bola uložená.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Podkategóriu sa nepodarilo uložiť. Skúste prosím znovu.'));
			}
		} else {
			$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
			$this->request->data = $this->Subcategory->find('first', $options);
		}
		$user_id = $this->Session->read('User.id');
		$this->set('categories', $this->Subcategory->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		$this->set(compact('categories'));
		
		$this->set('user', $user_id);
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
		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Zlá podkategória'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Subcategory->delete()) {
			$this->Session->setFlash(__('Podkategória bola vymazaná.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Podkategória nebola vymazaná.'));
		$this->redirect(array('action' => 'index'));
	}
}
