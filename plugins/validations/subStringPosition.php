<?php
//*******************************************************************
//Template Name: subStringPosition.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: subStringPosition
//*******************************************************************/
 
 class cake_subStringPositionValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	function validate() {
 		
 		$value = $this->getValues();
 		
 		$substring = $this->getConfig('substring');
 		
 		$pos = strpos($value, $substring);
 		
 		$operator = $this->getConfig('operator');
 		$position = $this->getConfig('position');
 		
 		switch ($operator) {
 			
 			case "=":
 				
 				if ($pos === $position) {
 					;
 				} else {
 					$this->hasError();
 				}
 					
 						
 				break;
 			
 			case "!=":
 				
 				if ($pos === $position) {
 					$this->hasError();
 				}
 			
 				break;
 		}
		
		$error = $this->getErrorMsg();
		
		if (empty($error)) {
			$error = $this->setErrorMessage(sprintf('The string "%s" was found within the value at position %d', $substring, $pos));
		} 		
		
 		
 		
 	}
 	
 }
?>