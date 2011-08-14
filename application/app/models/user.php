<?php
class User extends AppModel {

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
			'username' => array( 
				'notEmpty' => array('rule' => 'notEmpty', 'message' => __('Username is required field.', true)),
				'isUnique' => array('rule' => 'isUnique', 'message' => __('Selected username has already been taken.', true)),
				'email' => array('rule' => 'email', 'message' => __('Username need to be valid email address.', true))
		),
			'password' => array( 
				'confirmPassword' => array('rule' => 'confirmPassword', 'message' =>  __('Passwords are not identical.', true))
		),
			'password_confirm' => array(
				'notEmpty' => array('rule' => 'notEmpty', 'message' => __('Password is required.', true)),
				'minLength' => array('rule' => array('minLength', 5),  'message' => __('Password must be at least 5 characters long.', true))
		)
		);
	}

	/**
	 * Custom validation rule for user confirm password on registration page.
	 *
	 * @param $data
	 * @param $fieldName
	 */
	function confirmPassword($data, $fieldName) {
		$valid = false;
		if ($data['password'] == Security::hash(Configure::read('Security.salt') . $this->data['User']['password_confirm'])) {
			$valid = true;
		}
			
		return $valid;
	}

}