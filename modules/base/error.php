<?php
//*******************************************************************
//Template Name: error.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: error
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_view.php');

class cake_errorView extends cake_view {
	
	
	function __construct() {
		
		return parent::__construct();
	}
	
	function render($data) {
		
		// Set Page title
		$this->t->set('page_title', 'Error');
			
		if($this->is_subview === true):
			$this->t->set_template('wrapper_blank.tpl');
		endif;
		
		// load body template
		$this->body->set_template('generic_error.tpl');
		
		return;
	}
	
	
}

?>