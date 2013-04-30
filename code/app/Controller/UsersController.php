<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->paginate = array(
				'limit' => 20,
				'conditions' => array(
						'User.id' => $this->Session->read('User.id'),
						
				),
		);
		
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	/*public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add'); // moznost registrovat sa pre pouzivatelov
	}
	*/
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array(
				'add', 'account_created'
		));
	}
	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout='login';
		
		$this->set('user_types', $this->User->UserType->find('list'));
		
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function login() { 
		$this->layout='login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				//return $this->redirect($this->Auth->redirect());
				$user = $this->Auth->user();
				$this->Session->write('User.id', $user['id']);
				return $this->redirect('/');
			} else {
				$this->Session->setFlash(__('Zadali ste chybný mail alebo heslo.'));
			}
		}
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			$this->redirect('/', null, false);
	
		}
	}
	
	/*
	 * public function login() {         //  doEditovat ..pouzit auth
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Zadali ste chybný mail alebo heslo.'));
			}
		}
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			$this->redirect('/', null, false);
	
		}
	}
	*/
	
	
	public function logout() {
		$this->Session->setFlash('Boli ste úspešne odhlásený.');
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}
	

}
