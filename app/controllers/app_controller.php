<?php
class AppController extends Controller {

	/**
	 * Array of application models that users controller has access to.
	 *
	 * @var Array
	 * @access public
	 */
	public $uses = array();

	/**
	 * Components that are used by controller
	 *
	 * @var Array
	 * @access public
	 */
	public $components = array('Auth', 'Session', 'RequestHandler');

	/**
	 * Helpers that are used by controller
	 *
	 * @var Array
	 * @access public
	 */
	public $helpers = Array('Form', 'Html', 'Session', 'Javascript', 'Js' => array('Jquery'));

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display', 'homepage');
		//$this->Auth->allow();
		if(isset($this->params['admin']) && true == $this->params['admin']) {
			$this->layout = 'admin';
		}
	}

}