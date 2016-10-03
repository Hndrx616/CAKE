<?php
//*******************************************************************
//Template Name: exampleSettings.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: exampleSettings
//*******************************************************************/

require_once(CAKE_DIR.'cake_lib.php');
require_once(CAKE_DIR.'cake_view.php');
require_once(CAKE_DIR.'cake_adminController.php');

class cake_exampleSettingsController extends cake_adminController {
	
	function __construct($params) {
	
		parent::__construct($params);
		$this->type = 'options';
		$this->setRequiredCapability('edit_settings');
	}
	
	function action() {
					
		// add data to container
		$this->setView('base.options');
		$this->setSubview('base.exampleSettings');
	}
	
}

class cake_exampleSettingsView extends cake_view {
	
	function __construct($params) {
		//set page type
		$this->_setPageType('Administration Page');		
		return parent::__construct($params);
	}
	
	function render($data) {
		
		// load template
		$this->body->setTemplateFile('hello', 'example_settings.php');
		// assign headline
		$this->body->set('headline', 'Example Settings Page');
	}
	
	
}

?>