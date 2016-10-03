<?php
//*******************************************************************
//Template Name: installCheckEnv.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: installCheckEnv
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_view.php');
require_once(CAKE_BASE_CLASS_DIR.'installController.php');

class cake_installCheckEnvController extends cake_installController {
		
	function __construct($params) {
		
		return parent::__construct($params);
	}
	
	function action() {
		
		$errors = array();
		$bad_environment = false;
		$config_file_present = false;
		
		// check PHP version
		$version = explode( '.', phpversion() );
		
		if ( $version[0] < 5 && $version[1] < 2 ) {
			$errors['php_version']['name'] = 'PHP Version';
			$errors['php_version']['value'] = phpversion();
			$errors['php_version']['msg'] = $this->getMsg(3301);
			$bad_environment = true;
		}
		
		// Check permissions on log directory
		
		// check for magic_quotes
		if ( function_exists( 'get_magic_quotes_gpc' ) ) {
			
			$magic_quotes = get_magic_quotes_gpc();
			
			if ( $magic_quotes ) {
				
				$errors['magic_quotes_gpc']['name'] = 'magic_quotes_gpc';
				$errors['magic_quotes_gpc']['value'] = $magic_quotes;
				$errors['magic_quotes_gpc']['msg'] = "The magic_quotes_gpc PHP INI directive must be set to 'OFF' in order for CAKE domstreams to operate correctly.";
				$bad_environment = true;
				
			}
		}
		
		// Check for config file and then test the db connection
		if ($this->c->isConfigFilePresent()) {
			$config_file_present = true;
			$conn = $this->checkDbConnection();
			if ($conn != true) {
				$errors['db']['name'] = 'Database Connection';
				$errors['db']['value'] = 'Connection failed';
				$errors['db']['msg'] = 'Check the connection settings in your configuration file.' ;
				$bad_environment = true;
			}
		}
		
		// if the environment is good
		if ($bad_environment != true) {
			// and the config file is present
			if ($config_file_present === true) {
				//skip to defaults entry step
				$this->setRedirectAction('base.installDefaultsEntry');
				return;		
			} else {
				// otherwise show config file entry form
				$this->setView('base.install');
				// Todo: prepopulate public URL.
				//$config = array('public_url', $url);
				//$this->set('config', $config);
				$this->setSubview('base.installConfigEntry');
				return;
			}
		// if the environment is bad, then show environment error details.
		} else {
			$this->set('errors', $errors);
			$this->setView('base.install');
			$this->setSubview('base.installCheckEnv');
		}
	}
}

/**Installer Server Environment Setup Check View*/

class cake_installCheckEnvView extends cake_view {
		
	function render($data) {
		
		//page title
		$this->t->set('page_title', 'Server Environment Check');
		$this->body->set('errors', $this->get('errors'));
		// load body template
		$this->body->set_template('install_check_env.tpl');
		$this->setJs("cake", "base/js/cake.js");
	}
}

?>