<?php
class UploadsController extends AppController {

	var $components = array('RequestHandler');
	 
	var $helpers = array('Html', 'Session', 'Javascript');
	
	function beforeFilter() {
		$this->Auth->allow('add', 'list_markers');
		$this->layout = 'html5mobilenocache';
	}
	
	function add() {
		if($this->RequestHandler->isPost() && is_uploaded_file($_FILES['file_r']['tmp_name'])) {
			$upload = array('Upload' => array(
            	'name' => $_FILES['file_r']['name'],
            	'type' => $_FILES['file_r']['type'],
            	'size' => $_FILES['file_r']['size'],
            	'data' => fread(fopen($_FILES['file_r']['tmp_name'], "r"), $_FILES['file_r']['size']),
				'latitude' => isset($this->data['latitude']) ? $this->data['latitude'] : null,
				'longitude' => isset($this->data['longitude']) ? $this->data['longitude'] : null,
				'title' => $_POST['title_r'],
				'description' => $_POST['description_r']
            ));
            $this->Upload->save($upload);
		}
	}
	
	function list_markers() {
		$this->layout = 'ajax';
		$sw_lat = isset($_REQUEST['sw_lat']) ? $_REQUEST['sw_lat'] : null;
		$sw_lon = isset($_REQUEST['sw_lon']) ? $_REQUEST['sw_lon'] : null;
		$ne_lat = isset($_REQUEST['ne_lat']) ? $_REQUEST['ne_lat'] : null;
		$ne_lon = isset($_REQUEST['ne_lon']) ? $_REQUEST['ne_lon'] : null;
		
		$markers = array('markers' => array());
		if(null != $sw_lat &&  null != $sw_lon && null != $ne_lat && null != $ne_lon) {
			$data = $this->Upload->find('all', array(
				'conditions' => array(
					'AND' => array(
						'NOT' => array('Upload.latitude' => null),
						'NOT' => array('Upload.longitude' => null),
						'Upload.latitude >' => $sw_lat,
						'Upload.latitude <' => $ne_lat,
						'Upload.longitude >' => $sw_lon,
						'Upload.longitude <' => $ne_lon
					)),
					'fields' => array('Upload.id', 'Upload.latitude', 'Upload.longitude')
				));
			foreach($data as $upload) {
				$markers['markers'][]['marker'] = $upload['Upload'];
			}
		}
		$this->set('markers', $markers);
	}

	function isUploadedFile($params) {
		$val = array_shift($params);
		if ((isset($val['error']) && $val['error'] == 0) ||
		(!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) {
			return is_uploaded_file($val['tmp_name']);
		}
		return false;
	}
}