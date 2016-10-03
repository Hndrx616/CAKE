<?php
//*******************************************************************
//Template Name: cake_view.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_view
//*******************************************************************/

require_once(CAKE_BASE_CLASSES_DIR.'cake_template.php');
require_once(CAKE_BASE_CLASSES_DIR.'cake_requestContainer.php'); // ??

class cake_view extends cake_base {

	/**
	 * Main view template object
	 * @var object
	 */
	var $t;
	
	/**
	 * Body content template object
	 * @var object
	 */
	var $body;
	
	/**
	 * Sub View object
	 * @var object
	 */
	var $subview;
	
	/**
	 * Rednered subview
	 * @var string
	 */
	var $subview_rendered;
	
	/**
	 * CSS file for main template
	 * @var unknown_type
	 */
	var $css_file;
	
	/**
	 * The priviledge level required to access this view
	 * @depricated
	 * @var string
	 */
	var $priviledge_level;
	
	/**
	 * Type of page
	 * @var unknown_type
	 */
	var $page_type;
	
	/**
	 * Request Params
	 * @var unknown_type
	 */
	var $params;
	
	/**
	 * Authorization object
	 * @var object
	 */
	var $auth;
	
	var $module; // set by factory.
	
	var $data;
	
	var $default_subview;
	
	var $is_subview;
	
	var $js = array();
	
	var $css = array();
	
	var $postProcessView = false;
	
	var $renderJsInline;
	
	/**Constructor*/
	function __construct($params = null) {
	
		parent::__construct($params);
		
		$this->t = new cake_template();
		$this->body = new cake_template($this->module);
		$this->setTheme();
		$this->setCss("base/css/cake.css");
	}
	
	/**
	 * Assembles the view using passed model objects
	 * @param unknown_type $data
	 * @return unknown
	 */
	function assembleView($data) {
		
		$this->e->debug('Assembling view: '.get_class($this));
		
		
		// set view name in template class. used for navigation.
		if (array_key_exists('view', $this->data)) {
			$this->body->caller_params['view'] = $this->data['view'];
		}
		
		if (array_key_exists('params', $this->data)):
			$this->body->set('params', $this->data['params']);
		endif;
		
		if (array_key_exists('subview', $this->data)):
			$this->body->caller_params['subview'] = $this->data['subview'];
		endif;
		
		// Assign status msg
		if (array_key_exists('status_msg', $this->data)):
			$this->t->set('status_msg', $this->data['status_msg']);
		endif;
		
		// get status msg from code passed on the query string from a redirect.
		if (array_key_exists('status_code', $this->data)):
			$this->t->set('status_msg', $this->getMsg($this->data['status_code']));
		endif;
		
		// set error msg directly if passed from constructor
		if (array_key_exists('error_msg', $this->data)):
			$this->t->set('error_msg', $this->data['error_msg']);
		endif;		
		
		// authentication status
		if (array_key_exists('auth_status', $this->data)):
			$this->t->set('authStatus', $this->data['auth_status']);
		endif;
		
		// get error msg from error code passed on the query string from a redirect.
		if (array_key_exists('error_code', $this->data)):
			$this->t->set('error_msg', $this->getMsg($this->data['error_code']));
		endif;
		
		// load subview
		if (!empty($this->data['subview']) || !empty($this->default_subview)):
			// Load subview
			$this->loadSubView($this->data['subview']);
		endif;
		
		// construct main view.  This might set some properties of the subview.
		if (method_exists($this, 'render')) {
			$this->render($this->data);
		} else {
			// old style
			$this->construct($this->data);
		}
		//array of errors usually used for field validations
		if (array_key_exists('validation_errors', $this->data)):
			$this->body->set('validation_errors', $this->data['validation_errors']);
		endif;
		
		// pagination
		if (array_key_exists('pagination', $this->data)):
			$this->body->set('pagination', $this->data['pagination']);
		endif;
		
		//$this->_setLinkState();
			
		// assemble subview
		if (!empty($this->data['subview'])):
			
			// set view name in template. used for navigation.
			$this->subview->body->caller_params['view'] = $this->data['subview'];
			
			// Set validation errors
			$this->subview->body->set('validation_errors', $this->get('validation_errors'));
			
			// pagination
			if (array_key_exists('pagination', $this->data)):
				$this->subview->body->set('pagination', $this->data['pagination']);
			endif;
			
			if (array_key_exists('params', $this->data)):
				$this->subview->body->set('params', $this->data['params']);
				$this->subview->body->set('do', $this->data['params']['do']);
			endif;
			
			// Load subview 
			$this->renderSubView($this->data);
			
			// assign subview to body template
			$this->body->set('subview', $this->subview_rendered);
			
			
		endif;
		
		// assign validation errors
		if (!empty($this->data['validation_errors'])) {
			$ves = new cake_template('base');
			$ves->set_template('error_validation_summary.tpl');
			$ves->set('validation_errors', $this->data['validation_errors']);
			$validation_errors_summary = $ves->fetch();
			$this->t->set('error_msg', $validation_errors_summary);
		}		
		
		
		// fire post method
		$this->post();
		
		// assign css and js ellements if the view is not a subview.
		// subview css/js have been merged/pulls from subview and assigned here.
		if ($this->is_subview != true) {
			if (!empty($this->css)) {
				$this->t->set('css', $this->css);
			}
			
			if (!empty($this->js)) {
				$this->t->set('js', $this->js);
			}
		}
		
		//Assign body to main template
		$this->t->set('config', $this->config);
					
		//Assign body to main template
		$this->t->set('body', $this->body);
		
		if ($this->postProcessView === true){
			return $this->postProcess();
		} else {
			// Return fully asembled View
			return $this->t->fetch();
		}
	}
	
	/**Abstract Alternative rendering method reuires the setting of $this->postProcessView to fire*/
	function postProcess() {
		
		return false;
	}
	
	/**Post method fired right before view is rendered and returned as output*/
	function post() {
		
		return false;
	}
	
	
	/**Sets the theme to be used by a view*/
	function setTheme() {
		
		$this->t->set_template($this->config['report_wrapper']);
		
		return;
	}
	
	/**
	 * Abstract method for assembling a view
	 * @depricated
	 * @param array $data
	 */
	function construct($data) {
		
		return;
		
	}
	
	/**
	 * Assembles subview
	 * @param array $data
	 */
	function loadSubView($subview) {
		
		if (empty($subview)):
			if (!empty($this->default_subview)):
				$subview = $this->default_subview;
				$this->data['subview'] = $this->default_subview;
			else:
				return $this->e->debug("No Subview was specified by caller.");
			endif;
		endif;
		
		$this->subview = cake_coreAPI::subViewFactory($subview);
		//print_r($subview.'///');
		$this->subview->setData($this->data);
	}
	
	/**
	 * Assembles subview
	 * @param array $data
	 */
	function renderSubView($data) {
		
		// Stores subview as string into $this->subview
		$this->subview_rendered = $this->subview->assembleSubView($data);
		
		// pull css and js elements needed by subview
		$this->css = array_merge($this->css, $this->subview->css);
		$this->js = array_merge($this->js, $this->subview->js);		
	}
	
	/**
	 * Assembles the view using passed model objects
	 * @param unknown_type $data
	 * @return unknown
	 */
	function assembleSubView($data) {
		
		// construct main view.  This might set some properties of the subview.
		if (method_exists($this, 'render')) {
			$this->render($data);
		} else {
			// old style
			$this->construct($data);
		}
		
		$this->t->set_template('wrapper_subview.tpl');
		
		//Assign body to main template
		$this->t->set('body', $this->body);

		// Return fully asembled View
		$page =  $this->t->fetch();
	
		return $page;
					
	}
	
	function setCss($path, $version = null, $deps = array(), $ie_only = false) {
		
		if ( ! $version ) {
			$version = CAKE_VERSION;
		}
		
		$uid = $path;
		$url = sprintf('%s?version=%s', cake_coreAPI::getSetting('base', 'modules_url').$path, $version);
		$this->css[$uid]['url'] = $url;
		// build file system path just in case we need to concatenate the JS into a single file.
		$fs_path = CAKE_MODULES_DIR.$path;
		$this->css[$uid]['path'] = $fs_path;
		$this->css[$uid]['deps'] = $deps;
		$this->css[$uid]['version'] = $version;
		$this->css[$uid]['ie_only'] = $ie_only;
	}
	
	function setJs($name, $path, $version ='', $deps = array(), $ie_only = false) {
		
		if (empty($version)) {
			$version = CAKE_VERSION;
		}
		
		$uid = $name.$version;
		
		$url = sprintf('%s?version=%s', cake_coreAPI::getSetting('base', 'modules_url').$path, $version);
		$this->js[$uid]['url'] = $url;
		
		// build file system path just in case we need to concatenate the JS into a single file.
		$fs_path = CAKE_MODULES_DIR.$path;
		$this->js[$uid]['path'] = $fs_path;
		$this->js[$uid]['deps'] = $deps;
		$this->js[$uid]['version'] = $version;
		$this->js[$uid]['ie_only'] = $ie_only;
	}
	
	function concatinateJs() {
	
		$js_libs = '';
		
		foreach ($this->js as $lib) {
			
			$js_libs .= file_get_contents($lib['path']);
			$js_libs .= "\n\n";
		}
		
		$this->body->set('js_includes', $js_libs);
		
		return;
	
	}
	
	/**
	 * Sets flag to tell view to render the JS inline as <SCRIPT> blocks
	 * TODO: not yet implemented
	 */
	function renderJsInline() {
	
		$this->renderJsInLine = true;
		
		return;
	}
	
	
	/**
	 * Sets the Priviledge Level required to access this view
	 * @param string $level
	 */
	function _setPriviledgeLevel($level) {
		
		$this->priviledge_level = $level;
		
		return;
	}
	
	/**
	 * Sets the page type of this view. Used for tracking.
	 * @param string $page_type
	 */
	function _setPageType($page_type) {
		
		$this->page_type = $page_type;
		
		return;
	}
	
	
	/**Sets properties that are needed to maintain state across most report and widget requests. This is used by many template functions.*/
	function _setLinkState( $p = array() ) {
		
		// array of params to check
		if ( ! $p ) {
			$p = $this->get('params');
		}
		// control array - will check for these params. If they exist it will return.
		$sp = array(
			'period' => null, 
			'startDate' => null, 
			'endDate' => null,
			'siteId' => null,
			'startTime' => null,
			'endTime' => null  
				);
					
		// result array
		$link_params = array();
		
		if ( ! empty( $p ) ) {
		
			$link_params = array_intersect_key($p, $sp);
		}
		
		// needed for forwards compatability with 
		if ( array_key_exists('site_id', $link_params ) && ! array_key_exists('siteId', $link_params) ) {
			$link_params['siteId'] = $link_params['site_id']; 
		}
		
		$this->t->caller_params['link_state'] =  $link_params;				
		$this->body->caller_params['link_state'] =  $link_params;
		
		if(!empty($this->subview)) {
			$this->subview->body->caller_params['link_state'] =  $link_params;
		}
	}
	
	function get($name) {
		
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		} else {
			return false;
		}
		
	}
	
	function set($name, $value) {
		
		$this->data[$name] = $value;
	}
	
	function setSubViewProperty($name, $value) {
		
		$this->subview->set($name, $value);
	}
	
	function getSubViewProperty($name) {
		return $this->subview->get($name); 
	}
	
	function setData($data) {
		$this->data = $data;
	}
	
	function setTitle($title, $suffix = '') {
		
		$this->t->set('page_title', $title);
		$this->t->set('titleSuffix', $suffix);
	}
	
	function setContentTypeHeader($type = 'html') {
		
		cake_lib::setContentTypeHeader($type);
	}
	
}

/**Generic HTMl Table View. Will produce a generic html table*/
class cake_genericTableView extends cake_view {

	function __construct() {
		
		return parent::__construct();
		
	}
	
	function render($data) {
	
		$this->t->set_template('wrapper_blank.tpl');		
		$this->body->set_template('generic_table.tpl');
		
		if (!empty($data['labels'])):
			$this->body->set('labels', $data['labels']);
			$this->body->set('col_count', count($data['labels']));
		else:
			$this->body->set('labels', '');
			$this->body->set('col_count', count($data['rows'][0]));
		endif;
			
		if (!empty($data['rows'])):
			$this->body->set('rows', $data['rows']);
			$this->body->set('row_count', count($data['rows']));
		else:
			$this->body->set('rows', '');
			$this->body->set('row_count', 0);
		endif;
		
		if (array_key_exists('table_class', $data)):
			$this->body->set('table_class', $data['table_class']);
		else:
			$this->body->set('table_class', 'data');		
		endif;
		
		if (array_key_exists('header_orientation', $data)):
			$this->body->set('header_orientation', $data['header_orientation']);
		else:
			$this->body->set('header_orientation', 'col');		
		endif;
		
		if (array_key_exists('table_footer', $data)):
			$this->body->set('table_footer', $data['table_footer']);
		else:
			$this->body->set('table_footer', '');		
		endif;
		
		if (array_key_exists('table_caption', $data)):
			$this->body->set('table_caption', $data['table_caption']);
		else:
			$this->body->set('table_caption', '');		
		endif;
		
		if (array_key_exists('is_sortable', $data)) {
			if ($data['is_sortable'] != true) {
				$this->body->set('sort_table_class', '');
			}
		} else {
			$this->body->set('sort_table_class', 'tablesorter');		
		}
		
		if (array_key_exists('table_row_template', $data)):
			$this->body->set('table_row_template', $data['table_row_template']);
		else:
			;		
		endif;
		
		// show the no data error msg
		if (array_key_exists('show_error', $data)):
			$this->body->set('show_error', $data['show_error']);
		else:
			$this->body->set('show_error', true);		
		endif;
		
		$this->body->set('table_id', str_replace('.', '-', $data['params']['do']).'-table');
			
	}
}

/** @depricated*/
class cake_sparklineJsView extends cake_view {

	function __construct() {
	
		return parent::__construct();

	}
	
	function render($data) {
	
		// load template
		$this->t->set_template('wrapper_blank.tpl');
		$this->body->set_template('sparklineJs.tpl');
		// set
		$this->body->set('widget', $data['widget']);
		$this->body->set('type', $data['type']);
		$this->body->set('height', $data['height']);
		$this->body->set('width', $data['width']);
		$this->body->set('values', $data['series']['values']);
		$this->body->set('dom_id', $data['dom_id'].rand());
		//$this->setJs("includes/jquery/jquery.sparkline.js");
		return;
	}
}

class cake_mailView extends cake_view {

	// post office
	var $po;
	var $postProcessView = true;
	
	function __construct() {
		
		// make this a service
		require_once(CAKE_BASE_CLASS_DIR.'mailer.php');
		$this->po = new cake_mailer;
		return parent::__construct();
	}
	
	function postProcess() {
		
		$this->po->setHtmlBody( $this->t->fetch() );
		
		if ( $this->get( 'plainTextView' ) ) {
			$this->po->setAltBody( cake_coreAPI::displayView( $this->get( 'plain_text_view' ) ) );
		}

		return $this->po->sendMail();
	}	
	
	function setMailSubject($sbj) {
	
		$this->po->setSubject( $sbj );
	}
	
	function addMailToAddress($email, $name = '') {
		
		if (empty($name)) {
			$name = $email;
		}
		
		$this->po->addAddress($email, $name);
	}
}

class cake_adminView extends cake_view {
	
	var $postProcessView = true;
	
	function __construct() {
		
		return parent::__construct();
	}
	
	function post() {
		$this->setJs('cake.css');
		$this->setJs('cake.admin.css');
	}
}

class cake_jsonView extends cake_view {

	function __construct() {
		
		if (!class_exists('Services_JSON')) {
			require_once(CAKE_INCLUDE_DIR.'JSON.php');
		}
		
		return parent::__construct();
	}
	
	function render() {
	
		// load template
		$this->t->set_template('wrapper_blank.tpl');
		$this->body->set_template('json.php');
		
		$json = new Services_JSON();
		// set
		
		// look for jsonp callback
		$callback = $this->get('jsonpCallback');
		
		// if not found look on the request scope.
		if ( ! $callback ) {
			$callback = cake_coreAPI::getRequestParam('jsonpCallback');
		}
		
		if ( $callback ) {
			$body = sprintf("%s(%s);", $callback, $json->encode( $this->get( 'json' ) ) );
		} else {
			$body = $json->encode( $this->get( 'json' ) );
		}
		$this->body->set('json', $body);
	}
}

class cake_jsonResultsView extends cake_view {

	function __construct() {
		
		if (!class_exists('Services_JSON')) {
			require_once(CAKE_INCLUDE_DIR.'JSON.php');
		}
		
		return parent::__construct();
	}
	
	function render() {
	
		// load template
		$this->t->set_template('wrapper_blank.tpl');
		$this->body->set_template('json.php');
		
		$json = new Services_JSON();
		// set
		$this->body->set('json', $json->encode($this->get('data')));
	}
}

class cake_adminPageView extends cake_view {
	
	function render() {
		
		// Set Page title
		$this->t->set('page_title', $this->get('title'));
		
		// Set Page headline
		$this->body->set('title', $this->get('title'));
		$this->body->set('titleSuffix', $this->get('titleSuffix'));
		$this->body->set_template('genericAdminPage.php');
		$this->setJs('cake.reporting', 'base/js/cake.reporting-combined-min.js');
		$this->setCss("base/css/cake.reporting-css-combined.css");
	}
}

?>