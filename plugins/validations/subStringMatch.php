<?php
//*******************************************************************
//Template Name: subStringMatch.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: subStringMatch
//*******************************************************************/
 
 class cake_subStringMatchValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	function validate() {
 		
 		$value = $this->getValues();
 		$length = strlen($this->getConfig('match'));
 		$str = substr($value, $this->getConfig('position'), $length);
 		
 		switch ($this->getConfig('operator')) {
 			
 			case "=":
 				
 				if ($str != $this->getConfig('match')) {
 					$this->hasError();
 					//print $str;
 				}
 				
 			break;
 			
 			case "!=":
 				
 				if ($str === $this->getConfig('match')) {
 					$this->hasError();
 				}
 			
 			break;
 		}
		
		$error = $this->getErrorMsg();
		
		if (empty($error)) {
			$error = $this->setErrorMessage(sprintf('The string "%s" was found within the value at position %d', $this->getConfig('match'), $this->getConfig('position')));
		} 		
 	}
 	
 }
?>