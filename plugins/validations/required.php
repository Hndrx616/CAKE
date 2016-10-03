<?php
//*******************************************************************
//Template Name: required.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: required
//*******************************************************************/
 
 class cake_requiredValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	function validate() {
 		
 		$value = $this->getValues();
 		
 		$error = $this->getErrorMsg();
 		
 		if (empty($error)) {
 			$this->setErrorMessage('Required field was empty.');
 		}
 		
 		if (empty($value)):
 			$this->hasError();
 		endif;
 		
 		return;
 	}
 }
?>