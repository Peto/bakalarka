<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('CakeTime', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	/*public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'transactions', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home')
        )
    );
	
	public function beforeFilter() {
		$this->Auth->allow('index', 'view');
	}*/
	
	public $components = array('Auth', 'Session');
	 
	public function beforeFilter() {
		$this->Auth->authorize = array('Controller');
		$this->Auth->authenticate = array(
				'all' => array (
						'fields' => array('username' => 'email'),
						'scope' => array('User.active' => 1)
				),
				'Form'
		);
		
		$role = $this->Auth->user('user_type_id'); 	//   na pouzitie s Auth
		//$this->Session->read('User.role'); 		// na pouzitie pri normal login session
		if ($role == '2' || $role == '1') {
			$this->set('user_type_id', $role);
		}
		
		if($role == '1')
		{
			$this->set('is_admin', true);
		}
		else
		{
			$this->set('is_admin', false);
		}
	}
	 
	public function isAuthorized($user) {
		if (($this->params['prefix'] === 'admin') && ($user['user_type_id'] != 1)) {
			return false;
		}
		return true;
	}
}
