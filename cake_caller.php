<?php
//*******************************************************************
//Template Name: cake_caller.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_caller
//*******************************************************************/

include_once('cake_env.php');
require_once(CAKE_BASE_DIR.'/cake_base.php');
require_once(CAKE_BASE_DIR.'/cake_requestContainer.php');
require_once(CAKE_BASE_DIR.'/cake_auth.php');
require_once(CAKE_BASE_DIR.'/cake_coreAPI.php');

class cake_caller extends cake_base {
	
	/**
	 * Request Params from get or post
	 * @var array
	 */
	var $params;
		
	var $start_time;
	
	var $end_time;
	
	var $update_required;
	
	var $service;
	
	var $site_id;
			
	/**
	 * Constructor
	 * @param array $config
	 * @return cake_caller
	 */
	function __construct($config = array()) {
		
		if (empty($config)) {
			$config = array();
		}
		
		// Start time
		$this->start_time = cake_lib::microtime_float();
		
		// Parent Constructor. Sets default config entity and error logger
		parent::__construct();
		
		// Log version debug
		$this->e->debug(sprintf('*** Starting Catalyst Analytic Keyword Engine v%s. Running under PHP v%s (%s) ***', CAKE_VERSION, PHP_VERSION, PHP_OS));
		if ( array_key_exists('REQUEST_URI', $_SERVER ) ) {
			cake_coreAPI::debug( 'Request URL: '.$_SERVER['REQUEST_URI'] );
		}
		
		if ( array_key_exists('HTTP_USER_AGENT', $_SERVER ) ) {
			cake_coreAPI::debug( 'User Agent: '.$_SERVER['HTTP_USER_AGENT'] );
		}
		
		if ( array_key_exists('HTTP_HOST', $_SERVER ) ) {
			cake_coreAPI::debug( 'Host: '.$_SERVER['HTTP_HOST'] );
		}
		//cake_coreAPI::debug('cookie domain in caller: '. cake_coreAPI::getSetting('base', 'cookie_domain'));	
		//$bt = debug_backtrace(); $this->e->debug($bt[4]); 		
		// load config values from DB
		
		if (!defined('CAKE_INSTALLING')) {
			if ($this->c->get('base', 'do_not_fetch_config_from_db') != true) {
				if ($this->c->isConfigFilePresent())  {
					$this->c->load( $this->c->get( 'base', 'configuration_id' ) );
				}
			}
		}
		
		// set timezone once config is loaded from DB.
		$this->c->setTimezone();
		
		// overrides all default and user config values except defined in the config file
		
		$this->c->applyModuleOverrides('base', $config);
		
		$this->e->debug('Caller configuration overrides applied.');

		// Sets the correct mode of the error logger now that final config values are in place
		$this->e->setHandler($this->c->get('base', 'error_handler'));
		
		/* PHP ERROR LOGGING */
		
		if (defined('CAKE_LOG_PHP_ERRORS')) {
			
			$this->e->logPhpErrors();
		}
		
		set_exception_handler( array($this->e, 'logException') );
			
		/* LOAD SERVICE LAYER */
		$this->service = cake_coreAPI::serviceSingleton();
		// initialize framework
		$this->service->initializeFramework();	
		// notify handlers of 'init' action
		$dispatch = cake_coreAPI::getEventDispatch();
		$dispatch->notify($dispatch->makeEvent('init'));
		
		/* SET SITE ID */
		// needed in standalone installs where site_id is not set in config file.
		if (!empty($this->params['site_id'])) {
			$this->c->set('base', 'site_id', $this->params['site_id']);
		}
		
		// re-fetch the array now that overrides have been applied.
		$this->config = $this->c->fetch('base');
		
		/* SETUP REQUEST Params */
		$this->params = $this->service->request->getAllCakeParams();
	}
	
	function handleRequestFromUrl()  {
		
		//$this->params = cake_lib::getRequestParams();
		return $this->handleRequest();
		
	}
	
	
	/**
	 * $options = array('do_not_log_pageview' => true); Option keys include: 'do_not_log_pageview', 'do_not_log_clicks', 'do_not_log_domstream'
	 * @param 	$echo
	 * @param	$options
	 * @return 	$tag
	 */
	function placeHelperPageTags($echo = true, $options = array()) {
		
		if(!cake_coreAPI::getRequestParam('is_robot')) {
		
			// check to see if first hit tag is needed
			if ( isset( $options['delay_first_hit'] ) || cake_coreAPI::getSetting('base', 'delay_first_hit')) {
			
				$service = cake_coreAPI::serviceSingleton();
				//check for persistant cookie
				$v = $service->request->getCakeCookie('v');
				
				if (empty($v)) {
					
					$options['first_hit_tag'] = true;
				}		
			}
			
			if ( ! class_exists( 'cake_template' ) ) {
				require_once(CAKE_BASE_CLASSES_DIR.'cake_template.php');
			}
		
			$t = new cake_template();
			$t->set_template('js_helper_tags.tpl');
				
			$tracking_code = cake_coreAPI::getJsTrackerTag( $this->getSiteId(), $options );
			$t->set('tracking_code', $tracking_code);
			$tag = $t->fetch();
			
			if ($echo == false) {
				return $tag;
			} else {
				echo $tag;
			}
		}
	}
	
	// needed?
	function handleHelperPageTagsRequest() {
	
		$params = array();
		$params['do'] = 'base.helperPageTags';
		return $this->handleRequest($params);
	
	}
	
	/**
	 * Handles CAKE internal page/action requests
	 * @return unknown
	 */
	function handleRequest($caller_params = null, $action = '') {
		
		return cake_coreAPI::handleRequest($caller_params, $action);
						
	}
	
	function handleSpecialActionRequest() {
		
		if(isset($_GET['cake_specialAction'])):
			$this->e->debug("special action received");
			echo $this->handleRequestFromUrl();
			$this->e->debug("special action complete");
			exit;
		elseif(isset($_GET['cake_logAction'])):
			$this->e->debug("log action received");
			$this->config['delay_first_hit'] = false;
			$this->c->set('base', 'delay_first_hit', false);
			echo $this->logEventFromUrl();
			exit;
		elseif(isset($_GET['cake_apiAction'])):
			$this->e->debug("api action received");
			define('CAKE_API', true);
			// lookup method class
			echo $this->handleRequest('', 'base.apiRequest');
			exit;
		else:
			cake_coreAPI::debug('hello from special action request method in caller. no action to do.');
			return;
		endif;

	}
	
	function __destruct() {
		
		$this->end_time = cake_lib::microtime_float();
		$total_time = $this->end_time - $this->start_time;
		$this->e->debug(sprintf('Total session time: %s',$total_time));
		$this->e->debug("goodbye from CAKE");
		cake_coreAPI::profileDisplay();
		
		return;
	}
		
	function setSetting($module, $name, $value) {
		
		return cake_coreAPI::setSetting($module, $name, $value);
	}
	
	function getSetting($module, $name) {
		
		return cake_coreAPI::getSetting($module, $name);
	}
		
	function setCurrentUser($role, $login_name = '') {
		$cu = cake_coreAPI::getCurrentUser();
		$cu->setRole($role);
		$cu->setAuthStatus(true);
	}
	
	function makeEvent($type = '') {
	
		$event = cake_coreAPI::supportClassFactory('base', 'event');
		
		if ($type) {
			$event->setEventType($type);
		}
		
		return $event;
	}
	
	function setSiteId($site_id) {
		
		$this->site_id = $site_id;
	}
	
	function getSiteId() {
		
		return $this->site_id;
	}
	
	function setErrorHandler($mode) {
		$this->e->setHandler($mode);
	}
	
	function isCakeInstalled() {
		
		$version = cake_coreAPI::getSetting('base', 'schema_version');
		if ($version > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function isEndpointEnabled($file_name) {
		
		if ( ! $this->getSetting('base', 'disableAllEndpoints') ) {
			$disabled_endpoints = $this->getSetting('base', 'disabledEndpoints');
			
			if ( ! in_array( $file_name, $disabled_endpoints ) ) {
				return true;
			}
		}
	}
	
	function restInPeace() {
	
		return false;
	}
	
}

?>