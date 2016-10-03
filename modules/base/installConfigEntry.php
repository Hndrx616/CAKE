<?php
//*******************************************************************
//Template Name: installConfigEntry.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: installConfigEntry
//Installer Configuration Entry View
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_view.php');

class cake_installConfigEntryView extends cake_view {
			
	function render($data) {
		
		//page title
		$this->t->set('page_title', 'Configuration File Generator');
		// load body template
		$this->body->set('config', $this->get('config'));
		$this->body->set_template('install_config_entry.php');
		// prepopulate the public url based on the current url.
		$public_url = cake_lib::get_current_url();
		$pos = strpos($public_url, 'install.php');
		$public_url = substr($public_url, 0, $pos);
		$this->body->set('public_url', $public_url);
		$this->setJs("cake", "base/js/cake.js");
	}
}

?>