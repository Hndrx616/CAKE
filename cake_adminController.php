<?php
//*******************************************************************
//Template Name: cake_adminController.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_adminController
//*******************************************************************/

require_once(CAKE_BASE_CLASSES_DIR.'cake_controller.php');

class cake_adminController extends cake_controller {
	
	var $is_admin = true;
	
	/**
	 * @param array $params
	 * @return cake_controller
	 */
	function __construct($params) {
	
		return parent::__construct($params);
	}
}

?>