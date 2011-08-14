<?php
class CategoriesController extends AppController {

	var $scaffold = 'admin';

	/**
	 * Array of application models that users controller has access to.
	 *
	 * @var Array
	 * @access public
	 */
	public $uses = array('Category');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('get_all');
	}
	
	function get_all() {
		$categories = $this->Category->find('list');
		if (!empty($this->params['requested'])) {
			return $categories;
		} else {
			$this->set(compact('categories'));
		}
	}

}