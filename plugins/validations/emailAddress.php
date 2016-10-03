<?php
//*******************************************************************
//Template Name: emailAddress.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: emailAddress
//*******************************************************************/
 
 class cake_emailAddressValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	function validate() {
 		
 		$error = $this->getErrorMsg();
 		
 		if (empty($error)) {
 			$this->setErrorMessage('The email address is not valid.');
 		}

 		$email = $this->getValues();
		
		if ( ! filter_var ( $email, FILTER_VALIDATE_EMAIL ) ) { 
		 		
 			$this->hasError();
 		}	
 	}	 	
 }
?>