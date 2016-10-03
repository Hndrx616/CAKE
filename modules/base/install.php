<?php
//*******************************************************************
//Template Name: install.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: install
//Installation View
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_view.php');

class cake_installView extends cake_view {
		
	function __construct() {
		
		$this->default_subview = 'base.installStart';
		return parent::__construct();
	}
	
	function render($data) {
		
		//page title
		$this->t->set('page_title', 'Installation');
		
		// load wrapper template
		$this->t->set_template('wrapper_public.tpl');
		// load body template
		$this->body->set_template('install.tpl');
	
		$this->setCss("base/css/cake.css");	
		$this->body->set('headline', 'Welcome to the Catalyst Analytic Keyword Engine Installation Wizard');
		$this->body->set('step', $data['subview']);
		$this->setJs("cake", "base/js/cake.js");
	}
}

?>