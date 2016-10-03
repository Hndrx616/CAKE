<?php
//*******************************************************************
//Template Name: cake_install.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_install
//*******************************************************************/

require_once (CAKE_BASE_DIR.'/cake_base.php');

class cake_install extends cake_base{
	
	/**
	 * Data access object
	 * @var object
	 */
	var $db;
	
	/**
	 * Version of string
	 * @var string
	 */
	var $version;
	
	/**
	 * Params array
	 * @var array
	 */
	var $params;
	
	/**
	 * @var unknown_type
	 */
	var $module;
	
	/**
	 * Constructor
	 * @return cake_install
	 */

	function __construct() {
		
		parent::__construct();
		$this->db = cake_coreAPI::dbSingleton();
	}
	
	/**
	 * Check to see if schema is installed
	 * @return boolean
	 */
	function checkForSchema() {
		
		$table_check = array();
		//$this->e->notice(print_r($this->tables, true));
		// test for existance of tables
		foreach ($this->tables as $table) {
			$this->e->notice('Testing for existance of table: '. $table);
			$check = $this->db->get_results(sprintf("show tables like 'cake_%s'", $table));
			//$this->e->notice(print_r($check, true));
			
			// if a table is missing add it to this array
			if (empty($check)):
				$table_check[] = $table;
				$this->e->notice('Did not find table: '. $table);
			else:
				$this->e->notice('Table '. $table. ' already exists.');
			endif;
		}
		
		if (!empty($table_check)):
			//$this->e->notice(sprintf("Schema Check: Tables '%s' are missing.", implode(',', $table_check)));
			$this->e->notice(sprintf("Schema Check: Tables to install: %s", print_r($table_check, true)));

			return $table_check;
		else:	
			return false;
		endif;
		
	}
	
}

?>