<?php
//*******************************************************************
//Template Name: cake_controller.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_controller
//*******************************************************************/

class cake_controller extends cake_base {
	
	/**
	 * Request Parameters passed in from caller
	 * @var array
	 */
	var $params = array();
	
	/**
	 * Controller Type
	 * @var array
	 */
	var $type;
	
	/**
	 * Is the controller for an admin function
	 * @var boolean
	 */
	var $is_admin;
	
	/**
	 * The priviledge level required to access this controller
	 * @var string
	 */
	var $priviledge_level;
	
	/**
	 * data validation control object
	 * @var Object
	 */
	var $v;
	
	/**
	 * Data container
	 * @var Array
	 */
	var $data = array();
	
	/**
	 * Capability
	 * @var string
	 */
	var $capability;
	
	/**
	 * Available Views
	 * @var Array
	 */
	var $available_views = array();
	
	/**
	 * Time period
	 * @var Object
	 */
	var $period;
	
	/**
	 * Dom id
	 * @var String
	 */
	var $dom_id;
	
	/**
	 * Flag for requiring authenciation before performing actions
	 * @var Bool
	 */
	var $authenticate_user;
	
	var $state;
	
	/**
	 * Flag for requiring nonce before performing write actions
	 * @var Bool
	 */
	var $is_nonce_required = false;
		
	/**
	 * Constructor
	 * @param array $params
	 */
	function __construct($params) {
	
		// call parent constructor to setup objects.
		parent::__construct();
		
		// set request params
		$this->params = $params;
		
		// set the default view method
		$this->setViewMethod('delegate');	
	}
	
	/**Handles request from caller*/
	function doAction() {
		
		cake_coreAPI::debug('Performing Action: '.get_class($this));
		
		// check if the schema needs to be updated and force the update
		// not sure this should go here...
		if ($this->is_admin === true) {
			// do not intercept if its the updatesApply action or a re-install else updates will never apply
			$do = $this->getParam('do');
			if ($do != 'base.updatesApply' && !defined('CAKE_INSTALLING') && !defined('CAKE_UPDATING')) {
				
				if (cake_coreAPI::isUpdateRequired()) {
					$this->e->debug('Updates Required. Redirecting action.');
					$data = array();
					$data['view_method'] = 'redirect';
					$data['action'] = 'base.updates';
					return $data;
				}
			}
		}

		/* CHECK USER FOR CAPABILITIES */
		if (!$this->checkCapabilityAndAuthenticateUser($this->getRequiredCapability())) {
			return $this->data;
		}
		
		/* Check validity of nonce */		 
		if ($this->is_nonce_required == true) {
			$nonce = $this->getParam('nonce');
			
			if (!$nonce || !$this->verifyNonce($nonce)) {
				$this->e->debug('Nonce is not valid.');
				return $this->finishActionCall($this->notAuthenticatedAction());
			}
		}

		//$this->set('auth_status', true);
		//set request params
		$this->set('params', $this->params);
		// set site_id
		$this->set('site_id', $this->get('site_id'));
				
		// set status msg - NEEDED HERE? doesnt cake_ view handle this?
		if (array_key_exists('status_code', $this->params)) {
			$this->set('status_code', $this->getParam('status_code'));
		}
		
		// get error msg from error code passed on the query string from a redirect.
		if (array_key_exists('error_code', $this->params)) {
			$this->set('error_code', $this->getParam('error_code'));
		}
		 
		// check to see if the controller has created a validator
		if (!empty($this->v)) {
			// if so do the validations required
			$this->v->doValidations();
			//check for errors
			if ($this->v->hasErrors === true) {
				//print_r($this->v);
				// if errors, do the errorAction instead of the normal action
				$this->set('validation_errors', $this->getValidationErrorMsgs());
				return $this->finishActionCall($this->errorAction());
			}
		}
		
		/* PERFORM PRE ACTION */
		// often used by abstract descendant controllers to set various things
		$this->pre();
		/* PERFORM MAIN ACTION */
	   	return $this->finishActionCall($this->action());	
	}
	
	/**
	 * Checks for the action result, calls the post method and returns correct result
	 * Usage return $this->finishActionCall($this->action()))
	 * @return mixed
	 */
	protected function finishActionCall($actionResult) {
		// controllers that donot use $this->data
		if (!empty($actionResult)) {
			$this->post();
			return $actionResult;
		} else {
			$this->post();
			return $this->data;
		}	
	}
	
	/**
	 * Checks if the current controller requires privileges and authenticates the user and checks for capabilities.
	 * @uses ->getRequiredCapability and ->getCurrentSiteId
	 * @param string $capability
	 * @return boolean
	 */
	protected function checkCapabilityAndAuthenticateUser($capability) {
		if ( !empty($capability) && ! cake_coreAPI::isEveryoneCapable( $capability ) ) {
			/* PERFORM AUTHENTICATION */	
			$auth = cake_auth::get_instance();
			if (!cake_coreAPI::isCurrentUserAuthenticated()) {
				$status = $auth->authenticateUser();
				if ($status['auth_status'] != true) {
					$this->notAuthenticatedAction();
					return false;
				} 
			}
			
			$currentUser = cake_coreAPI::getCurrentUser();
			if (!$currentUser->isCapable($this->getRequiredCapability(),$this->getCurrentSiteId())) {			
				cake_coreAPI::debug('User does not have capability required by this controller.');
				$this->authenticatedButNotCapableAction();
				//$this->set('go', urlencode(cake_lib::get_current_url())); $this->set('auth_status', true);
				return false;
			}
			
		}
		return true;
	}
	
	protected function isEveryoneCapable($capability) {
		
		return cake_coreAPI::isEveryoneCapable( $capability );
	}
	
	function logEvent($event_type, $properties) {
		
		$ed = cake_coreAPI::getEventDispatch();
		
		if (!is_a($properties, 'cake_event')) {
	
			$event = cake_coreAPI::supportClassFactory('base', 'event');
			$event->setProperties($properties);
			$event->setEventType($event_type);
		} else {
			$event = $properties;
		}
		
		return $ed->notify( $event );
	}
	
	function createValidator() {
		
		$this->v = cake_coreAPI::supportClassFactory('base', 'validator');		
	}
	
	function addValidation($name, $value, $validation, $conf = array()) {
	
		if ( empty( $this->v ) ) {
		
			$this->createValidator();
		}
	
		return $this->v->addValidation($name, $value, $validation, $conf);
		
	}
	
	function setValidation($name, $obj) {
	
		if (empty($this->v)) {
			$this->createValidator();
		}
	
		return $this->v->setValidation($name, $obj);
	}
	
	function getValidationErrorMsgs() {
		
		return $this->v->getErrorMsgs();
		
	}
	
	function isAdmin() {
		
		if ($this->is_admin == true) {
			return true;
		}
	}
	
	// depricated
	function _setCapability($capability) {
	
		$this->setRequiredCapability($capability);
	}
	
	function setRequiredCapability($capability) {
	
		$this->capability = $capability;
	}
		
	function getRequiredCapability() {
		
		return $this->capability;
	}
	
	function getParam($name) {
	
		if (array_key_exists($name, $this->params)) {
			return $this->params[$name];
		} 
	}
	
	function setParam($name, $value) {
	
		$this->params[$name] = $value;
	}
	
	function isParam($name) {
	
		if (array_key_exists($name, $this->params)) {
			return true;
		}
	}
	
	function get($name) {
		
		return $this->getParam($name);
	}
	
	function getAllParams() {
		
		return $this->params;
	}
	
	function pre() {
	
		return false;
	}
	
	function post() {
		return false;
	}
	
	function getPeriod() {
		
		return $this->period;
	}
	
	function setPeriod() {
		// set period 
	
		$period = $this->makeTimePeriod($this->getParam('period'), $this->params);
		
		$this->period = $period;
		$this->set('period', $this->getPeriod());	
		$this->data['params'] = array_merge($this->data['params'], $period->getPeriodProperties());
	}
	
	function makeTimePeriod($time_period, $params = array()) {
		
		return cake_coreAPI::makeTimePeriod($time_period, $params);
	}
	
	function setTimePeriod($period) {
		
		$this->period = $period;
		$this->set('period', $this->getPeriod());	
		//$this->data['params'] = array_merge($this->data['params'], $period->getPeriodProperties());
	}
	
		
	function setView($view) {
	
		$this->data['view'] = $view;
	}
	
	function setSubview($subview) {
	
		$this->data['subview'] = $subview;
	
	}
	
	function setViewMethod($method = 'delegate') {
	
		$this->data['view_method'] = $method;
	
	}
	
	function setRedirectAction($do) {
	
		$this->set('view_method', 'redirect');
		$this->set('do', $do);
		
		// need to remove these unsets once they are no longer set in the main doAction method
		if (array_key_exists('params', $this->data)) {
			unset($this->data['params']);
		}
		if (array_key_exists('site_id', $this->data)) {
		//	unset($this->data['site_id']);
		}
	}
	
	function setPagination($pagination, $name = 'pagination') {
	
		$this->data[$name] = $pagination;
	
	}
	
	function set($name, $value) {
	
		$this->data[$name] = $value;
	}
	
	function setControllerType($string) {
	
		$this->type = $string;

	}
	
	function mergeParams($array) {
	
		$this->params = array_merge($this->params, $array);

	}
	
	/**
	 * redirects borwser to a particular view
	 * @param unknown_type $data
	 */
	function redirectBrowser($action, $pass_params = true) {
		
		$control_params = array('view_method', 'auth_status');
		
		$get = '';
		
		$get .= cake_coreAPI::getSetting('base', 'ns').'do'.'='.$action.'&';
		
		if ($pass_params === true) {

			foreach ($this->data as $n => $v) {
				
				if (!in_array($n, $control_params)) {		
				
					$get .= cake_coreAPI::getSetting('base', 'ns').$n.'='.$v.'&';
				
				}
			}
		}
				
		$new_url = sprintf(cake_coreAPI::getSetting('base', 'link_template'), cake_coreAPI::getSetting('base', 'main_url'), $get);
		
		return cake_lib::redirectBrowser($new_url);
		
	}
	
	function redirectBrowserToUrl($url) {
		
		return cake_lib::redirectBrowser($url);
	}
	
	function setStatusCode($code) {
		
		$this->data['status_code'] = $code;
	}
	
	function setStatusMsg($msg) {
		
		$this->data['status_message'] = $msg;
	}
	
	function setErrorMsg( $msg ) {
		
		$this->set( 'error_msg', $msg );
	}
	
	function authenticatedButNotCapableAction($additionalMessage = '') {		
		if ( empty($additionalMessage) ) {
			$siteIdMsg = $this->getCurrentSiteId();
			if ( empty ($siteIdMsg) ) {
				$siteIdMsg = 'No access to any site for the permission "'.$this->getRequiredCapability().'"';
			}
			$additionalMessage = $siteIdMsg;
		}
		$this->setView('base.error');
		$this->set('error_msg', $this->getMsg(2003).' '.$additionalMessage);
	}
	
	function notAuthenticatedAction() {

		$this->setRedirectAction('base.loginForm');
		$this->set('go', urlencode(cake_lib::get_current_url()));
	}
	
	function verifyNonce($nonce) {
		
		$action = $this->getParam('do');
		
		if (!$action) {
			$action = $this->getParam('action');	
		}
		
		$matching_nonce = cake_coreAPI::createNonce($action);
		cake_coreAPI::debug("passed nonce: $nonce | matching nonce: $matching_nonce");
		if ($nonce === $matching_nonce) {
			return true;
		}
	}
	
	/**
	 * Sets nonce flag for the controller.
	 */
	function setNonceRequired() {
		
		$this->is_nonce_required = true;
	}
	
	function getSetting($module, $name) {
		return cake_coreAPI::getSetting($module, $name);
	}
	
	
	/**
	 * Returns array of cake_site entities where the current user has access to, taken the current controller cap into account 
	 * @return array
	 */
	protected function getSitesAllowedForCurrentUser() {
	cake_coreAPI::debug('get Sites Allowed for user');
		$currentUser = cake_coreAPI::getCurrentUser();
		
		if ( $currentUser->isAnonymousUser() || $currentUser->isAdmin() ) {
			$result = array();
			$relations = cake_coreAPI::getSitesList();
			
			foreach ($relations as $siteRow) {
				
				$site = cake_coreAPI::entityFactory('base.site');
				cake_coreAPI::debug('getSitesAllowedforuser');
				
				$site->load($siteRow['id']);
				$result[$siteRow['site_id']] = $site;
			}
			
			return $result;
			
		} else {
			return $currentUser->getAssignedSites();
		}
	}
	
	/**
	 * gets the siteid taking the site access permissions into account
	 * @return string or false if no site access
	 */
	protected function getCurrentSiteId() {
		
		$siteParameterValue = $this->getSiteIdParameterValue();
		return $siteParameterValue;
	}
	
	/**
	 * @return integer or false
	 */
	protected function getSiteIdParameterValue() {
		if ($this->getParam('siteId') ) {
			return $this->getParam('siteId');
		}
		elseif ($this->getParam('site_id') ) {
			return $this->getParam('site_id');
		}
		return false;
	}
	
}

?>