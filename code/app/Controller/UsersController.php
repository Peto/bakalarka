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
	
	var $helpers=array("Html","Form","Session");
	
	
	public function index() {
				
		if ($this->Session->read('User.user_type_id') == '2') {
			$this->paginate = array(
				'limit' => 20,
				'conditions' => array(
						'User.id' => $this->Session->read('User.id'),
						
				),
			);
		}
		
		else {
			$this->paginate = array(
					'limit' => 20,
					
			);
		}
		
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array(
				'add', 'account_created', 'forgetpwd', 'reset'
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
		if (!$this->check_ownership($id) ) {
			if ($this->Session->read('User.user_type_id') == '2') {
				throw new PrivateActionException(__('Na prístup k tejto stránke nemáte oprávnenie.'));
			}
		}
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Neplatný používateľ'));
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
				$this->Session->setFlash(__('Registrácia prebehla úspešne.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Registrácia neprebehla úspešne. Skúste prosím znovu.'));
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
		if (!$this->check_ownership($id) ) {
			if ($this->Session->read('User.user_type_id') == '2') {
				throw new PrivateActionException(__('Na prístup k tejto stránke nemáte oprávnenie.'));
			}
		}
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Vaše údaje boli uložené.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Vaše údaje sa nepodarilo uložiť. SKúste prosím znovu.'));
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
		if (!$this->check_ownership($id) ) {
			if ($this->Session->read('User.user_type_id') == '2') {
				throw new PrivateActionException(__('Na prístup k tejto stránke nemáte oprávnenie.'));
			}
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Zlý používateľ'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('Používateľ bol vymazaný.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Používateľ nebol vymazaný.'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function login() { 
		$this->layout='login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				//return $this->redirect($this->Auth->redirect());
				$user = $this->Auth->user();
				$this->Session->write('User.id', $user['id']);
				$this->Session->write('User.user_type_id', $user['user_type_id']);
				return $this->redirect('/');
			} else {
				$this->Session->setFlash(__('Zadali ste chybný mail alebo heslo.'));
			}
		}
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('Ste prihlásený.');
			$this->redirect('/', null, false);
	
		}
	}
	
	
	public function logout() {
		$this->Session->setFlash('Boli ste úspešne odhlásený.');
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}
	
	function forgetpwd(){
		$this->layout='login';
		$this->User->recursive=-1;
		if(!empty($this->data))
		{
			if(empty($this->data['User']['email']))
			{
				$this->Session->setFlash('Prosím poskytnite emailovú adresu s ktorou ste sa u nás zaregistrovali.');
			}
			else
			{
				$email=$this->data['User']['email'];
				$fu=$this->User->find('first',array('conditions'=>array('User.email'=>$email)));
				if($fu)
				{
					//debug($fu);
					if($fu['User']['active'])
					{
						$key = Security::hash(String::uuid(),'sha512',true);
						$hash=sha1($fu['User']['email'].rand(0,100));
						$url = Router::url( array('controller'=>'users','action'=>'reset'), true ).'/'.$key.'#'.$hash;
						$ms=$url;
						$ms=wordwrap($ms,1000);
						//debug($url);
	
						$fu['User']['tokenhash']=$key;
						$this->User->id=$fu['User']['id'];
						if($this->User->saveField('tokenhash',$fu['User']['tokenhash'])){
	
							//============Email================//

							$this->Email = new CakeEmail();
							
							$this->Email->config('smtp');
							
							$this->Email->template('resetpw');
							$this->Email->viewVars(array('ms' => $ms));
							$this->Email->from(array('ucto@bestvideos.sk' => 'Domace uctovnictvo'));
							$this->Email->to($fu['User']['email']);
							$this->Email->subject('Domace uctovnictvo - Zabudnute heslo');
							$this->Email->sendAs = 'both';
	
							//$this->Email->transport('Smtp');
							$this->set('ms', $ms);
							$this->Email->send();
							//$this->set('smtp_errors', $this->Email->smtpError);
							$this->Session->setFlash(__('Email pre zmenu hesla Vám bol odoslaný', true));
	
							//============EndEmail=============//
						}
						else{
							$this->Session->setFlash("Nastal problém s generovaním resetovacieho linku.");
						}
					}
					else
					{
						$this->Session->setFlash('Tento účet ešte nie je aktívny.');
					}
				}
				else
				{
					$this->Session->setFlash('Email ktorý ste zadali u nás nie je zaregistrovaný.');
				}
			}
		}
	}
	
	function reset($token=null){     // resetovanie hesla pouzivatela po navsteve URL s tokenom z mailu
		$this->layout='login';
		$this->User->recursive=-1;
		if(!empty($token)){
			$u=$this->User->findBytokenhash($token);
			if($u){
				$this->User->id=$u['User']['id'];
				if(!empty($this->data)){
					$this->User->data=$this->data;
					$this->User->data['User']['email']=$u['User']['email'];
					$new_hash=sha1($u['User']['email'].rand(0,100));	// vytvorenie noveho tokenu
					$this->User->data['User']['tokenhash']=$new_hash;
					if($this->User->validates(array('fieldList'=>array('password')))){
						if($this->User->save($this->User->data))
						{
							$this->Session->setFlash('Heslo bolo zmenené. Môžete sa prihlásiť.');
							$this->redirect(array('controller'=>'users','action'=>'login'));
						}
	
					}
					else{
	
						$this->set('errors',$this->User->invalidFields());
					}
				}
			}
			else
			{
				$this->Session->setFlash('Token bol už pravdepodobne použitý. Požiadajte prosím o nový resetovací link. Každý sa dá použiť len raz.');
			}
		}
	
		else{
			$this->redirect('/');
		}
	}
	
	private function check_ownership($id) {
		$user_logged = $this->User->find('first', array(
				'conditions' => array('User.id' => $id),));
		if ($this->Session->read('User.id') == $user_logged['User']['id']) {
			return true;
		}
		else {
			return false;
		}
	}
	

}
