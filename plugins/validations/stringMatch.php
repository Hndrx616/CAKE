<?php
//*******************************************************************
//Template Name: stringMatch.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: stringMatch
//*******************************************************************/
 
 class cake_stringMatchValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	
 	function validate() {
 		
 		$values_array = $this->getValues();
 		$string1 = $values_array[0];
 		$string2 = $values_array[1];
 		
 		$error = $this->getErrorMsg();
 		
 		if (empty($error)) {
 			$this->setErrorMessage('Strings do not match.');
 		}

		// validation logic 
 		if ($string1 === $string2) {
 			;
 		} else {
 			$this->hasError();
 		}
 		 		
 		return;
 		
 	}
 }
?>