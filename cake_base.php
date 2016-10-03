<?php
//*******************************************************************
//Template Name: cake_base.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_base
//*******************************************************************/

require_once('cake_env.php');

class cake_base {
	
	/**
	 * Configuration
	 * @var array
	 */
	var $config;
	
	/**
	 * Error Logger
	 * @var object
	 */
	var $e;
	
	/**
	 * Configuration Entity
	 * @var cake_settings
	 */
	var $c;
	
	/**
	 * Module that this class belongs to
	 * @var unknown_type
	 */
	var $module;
	
	/**
	 * Request Params
	 * @var array
	 */
	var $params;
	
	/**
	 * Base Constructor
	 * @return cake_base
	 */	
	function __construct() {
		cake_coreAPI::profile($this, __FUNCTION__, __LINE__);
		$this->e = cake_coreAPI::errorSingleton();
		$this->c = cake_coreAPI::configSingleton();
		$this->config = $this->c->fetch('base');
	}
	
	/**
	 * Retrieves string message from mesage file
	 * @param integer $code
	 * @param string $s1
	 * @param string $s2
	 * @param string $s3
	 * @param string $s4
	 * @return string
	 */
	function getMsg($code, $s1 = null, $s2 = null, $s3 = null, $s4 = null) {
		
		static $_cake_messages;
		
		if (empty($_cake_messages)) {
			
			require_once(CAKE_DIR.'conf/messages.php');
		}
		
		switch ($_cake_messages[$code][1]) {
			
			case 0:
				$msg = $_cake_messages[$code][0];
				break;
			case 1:
				$msg = sprintf($_cake_messages[$code][0], $s1);
				break;
			case 2:
				$msg = sprintf($_cake_messages[$code][0], $s1, $s2);
				break;
			case 3:
				$msg = sprintf($_cake_messages[$code][0], $s1, $s2, $s3);
				break;
			case 4:
				$msg = sprintf($_cake_messages[$code][0], $s1, $s2, $s3, $s4);
				break;
		}
		
		return $msg;
		
	}

	/**
	 * Sets object attributes
	 * @param unknown_type $array
	 */
	function _setObjectValues($array) {
		
		foreach ($array as $n => $v) {
				
				$this->$n = $v;
		
			}
		
		return;
	}
	
	/**
	 * Sets array attributes
	 * @param unknown_type $array
	 */
	function _setArrayValues($array) {
		
		foreach ($array as $n => $v) {
				
				$this->params['$n'] = $v;
		
			}
		
		return;
	}
	
	function __destruct() {
		cake_coreAPI::profile($this, __FUNCTION__, __LINE__);
	}
	
}

?>