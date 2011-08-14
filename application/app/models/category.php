<?php
class Category extends AppModel {

	/**
	 * Constructor. Binds the model's database table to the object. Specify model validation array.
	 *
	 * @param integer $id Set this ID for this model on startup
	 * @param string $table Name of database table to use.
	 * @param object $ds DataSource connection object.
	 */
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'name' => array( 
				'notEmpty' => array('rule' => 'notEmpty', 'message' => __('Name is required.', true)),
			)
		);
	}

}