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

	function sendPushNotification($message, $latitude, $longitude, $categories = false) {
		// Send notification
		$url = 'http://localhost:7777';
		$fields = array(
			'message'=>urlencode($message),
			'latitude'=>urlencode($latitude),
			'longitude'=>urlencode($longitude)
		);
		if(false != $categories) {
			$fields['categories'] = $categories;
		}
		//url-ify the data for the POST
		$fields_string = '';
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string,'&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_PORT,7777);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

		//execute post
		$status = curl_exec($ch);
		//close connection
		curl_close($ch);

		return $status;
	}

}
