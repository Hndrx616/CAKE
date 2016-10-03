<?php
//*******************************************************************
//Template Name: installConfig.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: installConfig
//Install Configuration Controller
//*******************************************************************/

require_once(CAKE_BASE_CLASS_DIR.'installController.php');

class cake_installConfigController extends cake_installController {
		
	function __construct($params) {
		
		parent::__construct($params);
		
		// require nonce
		$this->setNonceRequired();
		
		//required params
		$v1 = cake_coreAPI::validationFactory('required');
		$v1->setValues($this->getParam('db_host'));
		$v1->setErrorMessage("Database host is required.");
		$this->setValidation('db_host', $v1);
		
		$v2 = cake_coreAPI::validationFactory('required');
		$v2->setValues($this->getParam('db_name'));
		$v2->setErrorMessage("Database name is required.");
		$this->setValidation('db_name', $v2);
		
		$v3 = cake_coreAPI::validationFactory('required');
		$v3->setValues($this->getParam('db_user'));
		$v3->setErrorMessage("Database user is required.");
		$this->setValidation('db_user', $v3);
		
		$v4 = cake_coreAPI::validationFactory('required');
		$v4->setValues($this->getParam('db_password'));
		$v4->setErrorMessage("Database password is required.");
		$this->setValidation('db_password', $v4);
		
		$v7 = cake_coreAPI::validationFactory('required');
		$v7->setValues($this->getParam('db_type'));
		$v7->setErrorMessage("Database type is required.");
		$this->setValidation('db_type', $v7);
		
		// Config for the public_url validation
		$v5 = cake_coreAPI::validationFactory('subStringMatch');
		$v5->setConfig('match', '/');
		$v5->setConfig('length', 1);
		$v5->setValues($this->getParam('public_url'));
		$v5->setConfig('position', -1);
		$v5->setConfig('operator', '=');
		$v5->setErrorMessage("Your URL of CAKE's base directory must end with a slash.");
		$this->setValidation('public_url', $v5);
		
		// Config for the domain validation
		$v6 = cake_coreAPI::validationFactory('subStringPosition');
		$v6->setConfig('substring', 'http');
		$v6->setValues($this->getParam('public_url'));
		$v6->setConfig('position', 0);
		$v6->setConfig('operator', '=');
		$v6->setErrorMessage("Please add http:// or https:// to the beginning of your public url.");
		$this->setValidation('public_url', $v6);
	}
	
	function action() {
		
		// define db connection constants using values submitted
		if ( ! defined( 'CAKE_DB_TYPE' ) ) {
			define( 'CAKE_DB_TYPE', $this->getParam( 'db_type' ) );
		}
		
		if ( ! defined( 'CAKE_DB_HOST' ) ) {
			define('CAKE_DB_HOST', $this->getParam( 'db_host' ) );
		}
		
		if ( ! defined( 'CAKE_DB_NAME' ) ) {		
			define('CAKE_DB_NAME', $this->getParam( 'db_name' ) );
		}

		if ( ! defined( 'CAKE_DB_USER' ) ) {		
			define('CAKE_DB_USER', $this->getParam( 'db_user' ) );
		}
		
		if ( ! defined( 'CAKE_DB_PASSWORD' ) ) {
			define('CAKE_DB_PASSWORD', $this->getParam( 'db_password' ) );
		}
		
		cake_coreAPI::setSetting('base', 'db_type', CAKE_DB_TYPE);
		cake_coreAPI::setSetting('base', 'db_host', CAKE_DB_HOST);
		cake_coreAPI::setSetting('base', 'db_name', CAKE_DB_NAME);
		cake_coreAPI::setSetting('base', 'db_user', CAKE_DB_USER);
		cake_coreAPI::setSetting('base', 'db_password', CAKE_DB_PASSWORD);	
						
		// Check DB connection status
		$db = cake_coreAPI::dbSingleton();
		$db->connect();
		if ($db->connection_status != true) {
			$this->set('error_msg', $this->getMsg(3012));
			$this->set('config', $this->params);
			$this->setView('base.install');
			$this->setSubview('base.installConfigEntry');

		} else {
			//create config file
			$this->c->createConfigFile($this->params);
			$this->setRedirectAction('base.installDefaultsEntry');
		}
		
		// Check socket connection
		
		// Check permissions on log directory
		

		return;
	}	
	
	function errorAction() {
		$this->set('config', $this->params);
		$this->setView('base.install');
		$this->setSubview('base.installConfigEntry');
	}
}

?>