<?php
class MessagesController extends AppController {
	
	var $uses = array('Message');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('save_message');
	}

	function save_message() {
		$this->Message->save(array('Message' => array(
			'text' => $_POST['message'],
			'latitude' => $_POST['latitude'],
			'longitude' => $_POST['longitude']
		)));
		$this->set('status', array('Status' => 'OK'));
	}
	
}
?>
