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
	
	public $components = array('Auth', 'Session', 'Cookie');
	
	public $is_mobile = false;
	public $layouts = array('desktop', 'mobile');
	
	 
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
		
		////// MOBILE VIEW stuff //////
		// Using "rijndael" encryption because the default "cipher" type of encryption fails to decrypt when PHP has the Suhosin patch installed.
		// See: http://cakephp.lighthouseapp.com/projects/42648/tickets/471-securitycipher-function-cannot-decrypt
		$this->Cookie->type('rijndael');
		
		// When using "rijndael" encryption the "key" value must be longer than 32 bytes.
		$this->Cookie->key = 'qSI242342432qs*&sXOw!adre@34SasdadAWQEAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^'; // When using rijndael encryption this value must be longer than 32 bytes.
		
		// Flag whether the layout is being "forced" i.e overwritten/controlled by the user (true or false)
		$forceLayout = $this->Cookie->read('Options.forceLayout');
		
		// Identify the layout the user wishes to "force" (mobile or desktop)
		$forcedLayout = $this->Cookie->read('Options.forcedLayout');
		
		// Check URL paramaters for ?forcedLayout=desktop or ?forcedLayout=mobile and persist this decision in a COOKIE
		if( isset($this->params->query['forcedLayout']) && in_array($this->params->query['forcedLayout'], $this->layouts) )
		{
			$forceLayout = true;
			$forcedLayout = $this->params->query['forcedLayout'];
			$this->Cookie->write('Options.forceLayout', $forceLayout);
			$this->Cookie->write('Options.forcedLayout', $forcedLayout);
		}
		
		// We use CakePHP's built in "mobile" User-Agent detection (a pretty basic list of UA's see: /lib/Cake/Network/CakeRequest.php)
		// Note: For more robust detection consider using "Mobile Detect" (https://github.com/serbanghita/Mobile-Detect) or WURL (http://wurfl.sourceforge.net/)
		if( ( $forceLayout && $forcedLayout == 'mobile' ) || ( !$forceLayout && $this->request->is('mobile') ) )  {
			$this->is_mobile = true;
			$this->autoRender = false; // take care of rendering in the afterFilter()
		}
		
		$this->set('is_mobile', $this->is_mobile);
	}
	 
	public function isAuthorized($user) {
		if (($this->params['prefix'] === 'admin') && ($user['user_type_id'] != 1)) {
			return false;
		}
		return true;
	}
	
	// executed after all controller logic, including the view render.
	function afterFilter() {
	
		// if in mobile mode, check for a vaild layout and/or view and use it
		if( $this->is_mobile ) {
			$has_mobile_view_file = file_exists( ROOT . DS . APP_DIR . DS . 'View' . DS . $this->name . DS . 'mobile' . DS . $this->action . '.ctp' );
			$has_mobile_layout_file = file_exists( ROOT . DS . APP_DIR . DS . 'View' . DS . 'Layouts' . DS . 'mobile' . DS . $this->layout . '.ctp' );
	
			$view_file = ( $has_mobile_view_file ? 'mobile' . DS : '' ) . $this->action;
			$layout_file = ( $has_mobile_layout_file ? 'mobile' . DS : '' ) . $this->layout;
	
			$this->render( $view_file, $layout_file );
		}
	}
}
