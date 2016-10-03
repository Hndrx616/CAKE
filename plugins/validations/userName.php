<?php
//*******************************************************************
//Template Name: userName.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: userName
//*******************************************************************/
 
 class cake_userNameValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	function validate() {
 		
 		$error = $this->getErrorMsg();
 		
 		if (empty($error)) {
 			$this->setErrorMessage('The user name contains illegal characters.');
 		}

 		$u = $this->getValues();
 		
 		$illegals = cake_coreAPI::getSetting('base', 'user_id_illegal_chars');
 		
 		foreach ( $illegals as $k => $char ) {
	 		
	 		if ( strpos( $u, $char ) ) {
		 		
		 		$this->hasError();
		 		break;	
	 		}
 		}
 	}	 	
 }
?>