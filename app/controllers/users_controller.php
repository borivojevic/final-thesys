<?php
class UsersController extends AppController {

	var $scaffold = 'admin';

	/**
	 * Array of application models that users controller has access to.
	 *
	 * @var Array
	 * @access public
	 */
	public $uses = array('User');

	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow();
	}

	/**
	 * User login method
	 *
	 * @return void
	 */
	function login() {
	}

	/**
	 * User logout page
	 *
	 * @return void
	 */
	function logout() {
		$this->redirect($this->Auth->logout());
	}

}