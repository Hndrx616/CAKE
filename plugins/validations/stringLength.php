<?php
//*******************************************************************
//Template Name: stringLength.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: stringLength
//*******************************************************************/
 
 class cake_stringLengthValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	function validate() {
 		
 		$value = $this->getValues();
 		$length = $this->getConfig('length');
 		$operator = $this->getConfig('operator');
 		
 		// default error msg
 		$errorMsg = $this->getErrorMsg();
 		if (empty($errorMsg)) {
 			
 			$this->setErrorMessage(sprintf("Must be %s %d character in length.", $operator, $length));
 		}
 		
 		switch ($operator) {
 		
 			case '<':
 				if (strlen($value) >= $length) {	
					$this->hasError();
				}
 				break;
 			
 			case '>':
 				if (strlen($value) <= $length) {	
					$this->hasError();
				}
 				break;
 				
 			case '<=':
 				if (strlen($value) > $length) {	
					$this->hasError();
				}
 				break;
 			
 			case '>=':
 				if (strlen($value) < $length) {	
					$this->hasError();
				}
 				break;	
 				
 		}
 		 
 		return;
 		
 	}
 }
?>