<?php
//*******************************************************************
//Template Name: entityInstall.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: entityInstall
//*******************************************************************/

require_once(CAKE_BASE_CLASS_DIR.'cliController.php');

class cake_entityInstallController extends cake_cliController {
	
	function __construct($params) {
	
		$this->setRequiredCapability('edit_modules');
		return parent::__construct($params);
	}
	
	function action() {
		
		$e = cake_coreAPI::entityFactory($this->getParam('entity'));
		$e->createTable();
	}
}

?>