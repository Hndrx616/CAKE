<?php
//*******************************************************************
//Template Name: module.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: module
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_module.php');

class cake_helloModule extends cake_module {
	
	
	function __construct() {
		
		$this->name = 'hello';
		$this->display_name = 'Hello World';
		$this->group = 'hello';
		$this->author = 'Stephen Hilliard';
		$this->version = '1.0';
		$this->description = 'Hello world sample module.';
		$this->config_required = false;
		$this->required_schema_version = 1;
		
		return parent::__construct();
	}
	
	/**Registers Admin panels with the core API*/
	function registerAdminPanels() {
		
		$this->addAdminPanel(array( 'do' 			=> 'hello.exampleSettings', 
									'priviledge' 	=> 'admin', 
									'anchortext' 	=> 'Hello World!',
									'group'			=> 'Test',
									'order'			=> 1));
		
									
		return;
		
	}
	
	public function registerNavigation() {
		$this->addNavigationSubGroup('Hello World', 'hello.reportDashboard', 'Hello Dashboard');
		$this->addNavigationLinkInSubGroup('Hello World','hello.reportSearchterms','also to the dashboard',1);
		
	}
	
	/**Registers Event Handlers with queue queue*/
	function _registerEventHandlers() {
		
		
		// Clicks
		//$this->_addHandler('base.click', 'clickHandlers');
		
		return;
		
	}
	
	function _registerEntities() {
		
		//$this->entities[] = 'myentity';
	}
	
	
}

?>