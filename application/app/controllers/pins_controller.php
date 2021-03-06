<?php
class PinsController extends AppController {

	var $scaffold = 'admin';

	/**
	 * Array of application models that users controller has access to.
	 *
	 * @var Array
	 * @access public
	 */
	public $uses = array('Pin', 'Message');

	public $components = array('RequestHandler');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'list_markers', 'search', 'filter_pins_form');
	}
	
	function admin_add() {
		if(true == $this->params['isAjax']) {
			$this->layout = 'modal';
		}
		$success = false;
		if($this->RequestHandler->isPost()) {
			$success = $this->Pin->save($this->data);
		}
		$category_options = $this->Pin->Category->find('list', array(
			'conditions' => array('Category.deleted' => false)
		));
		$this->set('categories', $category_options);
		$this->data['Pin']['close'] = (false == $success) ? 0 : 1;
	}
	
	function list_markers() {
		$this->layout = 'ajax';
		$sw_lat = isset($_REQUEST['sw_lat']) ? $_REQUEST['sw_lat'] : null;
		$sw_lon = isset($_REQUEST['sw_lon']) ? $_REQUEST['sw_lon'] : null;
		$ne_lat = isset($_REQUEST['ne_lat']) ? $_REQUEST['ne_lat'] : null;
		$ne_lon = isset($_REQUEST['ne_lon']) ? $_REQUEST['ne_lon'] : null;
		
		$markers = array('markers' => array());
		if(null != $sw_lat &&  null != $sw_lon && null != $ne_lat && null != $ne_lon) {
			
			$conditions = array(
				'NOT' => array('Pin.latitude' => null),
				'NOT' => array('Pin.longitude' => null),
				'Pin.latitude >' => $sw_lat,
				'Pin.latitude <' => $ne_lat,
				'Pin.longitude >' => $sw_lon,
				'Pin.longitude <' => $ne_lon
			);
			if(isset($_REQUEST['name'])) {
				$conditions['Pin.name LIKE'] = "%{$_REQUEST['name']}%"; 
			}
			if(isset($_REQUEST['category'])) {
				$categories = explode(',', $_REQUEST['category']);
				$this->Pin->bindModel(array('hasOne' => array('CategoriesPin')));
				$conditions['CategoriesPin.category_id'] = $categories; 
			}
			$data = $this->Pin->find('all', array(
				'conditions' => $conditions,
				'fields' => array(
					'Pin.id',
					'Pin.name',
					'Pin.latitude',
					'Pin.longitude',
					'Pin.address',
					'Pin.telephone',
					'Pin.work_hours',
				),
				'recursive' => 2
			));
			foreach($data as $pin) {
				$categories = array();
				$category_ids = array();
				foreach($pin['Category'] as $category) {
					$categories[] = $category['name'];
					$category_ids[] = $category['id'];
				}
				$pin['Pin']['category'] = implode(', ', $categories);
				$pin['Pin']['category_ids'] = implode(', ', $category_ids);
				unset($pin['Category']);
				$pin['Pin']['type'] = 'pin';
				$markers['markers'][]['marker'] = $pin['Pin'];
			}
		}

		// Add messages data
		$conditions = array(
			'NOT' => array('Message.latitude' => null),
			'NOT' => array('Message.longitude' => null),
			'Message.latitude >' => $sw_lat,
			'Message.latitude <' => $ne_lat,
			'Message.longitude >' => $sw_lon,
			'Message.longitude <' => $ne_lon
		);
		$data = $this->Message->find('all', array(
			'conditions' => $conditions,
			'fields' => array(
				'Message.id',
				'Message.text',
				'Message.latitude',
				'Message.longitude',
			),
			'recursive' => -1
		));
		foreach($data as $pin) {
			$pin['Message']['type'] = 'message';
			$pin['Message']['id'] = 'mes_' . $pin['Message']['id'];
			$markers['markers'][]['marker'] = $pin['Message'];
		}
		// Filter markers by area
		if(isset($_REQUEST['area']) && isset($_REQUEST['latitude']) && isset($_REQUEST['longitude'])) {
			foreach($markers['markers'] as $key => &$marker) {
				if($this->distance($_REQUEST['latitude'], $_REQUEST['longitude'], $marker['marker']['latitude'], $marker['marker']['longitude'], 'k') > $_REQUEST['area']) {
					unset($markers['markers'][$key]);
				}
			}	
		}

		$this->set('markers', $markers);
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
		$theta = $lon1 - $lon2; 
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
		$dist = acos($dist); 
		$dist = rad2deg($dist); 
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344); 
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
	
	function filter_pins_form() {
		$categories = $this->Pin->Category->find('list');
		$this->set('categories', $categories);
	}
	
	function search() {
		$this->layout = 'ajax';
		$term = isset($_REQUEST['term']) ? $_REQUEST['term'] : null;
		$result = $this->Pin->find('all', array(
			'conditions' => array(
				'Pin.name LIKE' => "%$term%",
				'Pin.confirmed' => true,
				'Pin.deleted' => false
			),
			'fields' => array('Pin.name', 'Pin.latitude', 'Pin.longitude'),
			'recursive' -1,
			'limit' => 10
		));
		$this->set('result', array_values($result));
	}

	function send_notification() {
		$pins = $this->Pin->find('list');
		$this->set('pins', $pins);
		if($this->RequestHandler->isPost()) {
			$this->Pin->id = $this->data['Pin']['id'];
			$text = $this->data['Pin']['text'];
			$pin_data = $this->Pin->read();
			$latitude = $pin_data['Pin']['latitude'];
			$longitude = $pin_data['Pin']['longitude'];
			$categories = array();
			foreach($pin_data['Category'] as $category) {
				$categoies[] = $category['id'];
			}
			$categories = implode(',', $categoies);
			
			$this->sendPushNotification($text, $latitude, $longitude, $categories);
			$this->Session->setFlash('Poruka je poslata');
		}
	}

}
