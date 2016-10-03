<?php
//*******************************************************************
//Template Name: cake_mw.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_mw
//*******************************************************************/

require_once('cake_env.php');
require_once(CAKE_BASE_CLASS_DIR.'client.php');

class cake_mw extends cake_client {

	function __construct($config = null) {
		
		return parent::__construct($config);
	}
	
	function cake_mw($config = null) {
		
		return cake_mw::__construct($config);
	}
	
	/**
	 * CAKE Singleton Method
	 * Makes a singleton instance of CAKE using the config array
	 */
	function singleton($config = null) {
		
		static $cake;
		
		if(!empty($cake)) {
			return $cake;
		} else {
			$cake = new cake_mw($config);
			return $cake;	
		}
	}


}

?>