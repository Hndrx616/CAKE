<?php
//*******************************************************************
//Template Name: entityDoesNotExist.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/validations
// @project: entityDoesNotExist
//*******************************************************************/
 
 class cake_entityDoesNotExistValidation extends cake_validation {
 	
 	function __construct() {
 		
 		return parent::__construct();
 	}
 	
 	
 	function validate() {
 		
 		$entity = cake_coreAPI::entityFactory($this->getConfig('entity'));
 		$entity->getByColumn($this->getConfig('column'), $this->getValues());
 		 		
 		$error = $this->getErrorMsg();
 		
 		if (empty($error)) {
 			$this->setErrorMessage('An entity with that value already exists.');
 		}

		$id = $entity->get('id');
		
		// validation logic 
 		if (!empty($id)) {
 			$this->hasError();
 		}	
					
 		return;
 		
 	}
 		
 }
?>