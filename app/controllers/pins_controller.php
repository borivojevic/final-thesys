<?php
class PinsController extends AppController {

	var $scaffold = 'admin';

	/**
	 * Array of application models that users controller has access to.
	 *
	 * @var Array
	 * @access public
	 */
	public $uses = array('Pin');

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
				foreach($pin['Category'] as $category) {
					$categories[] = $category['name'];
				}
				$pin['Pin']['category'] = implode(', ', $categories);
				unset($pin['Category']);
				$markers['markers'][]['marker'] = $pin['Pin'];
			}
		}
		$this->set('markers', $markers);
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

}
