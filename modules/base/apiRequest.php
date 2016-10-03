<?php
//*******************************************************************
//Template Name: apiRequest.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: apiRequest
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_view.php');
require_once(CAKE_BASE_DIR.'/cake_controller.php');

class cake_apiRequestController extends cake_controller {
		
	function __construct($params) {
		
		return parent::__construct($params);
	}
	
	function getRequiredCapability() {
	
		$s = cake_coreAPI::serviceSingleton();
			// lookup method class
		$do = $s->getApiMethodClass($this->getParam('do'));

		if ($do) {
		
			// check for capability
			if (array_key_exists('required_capability', $do)) {
				return $do['required_capability'];
			}
		}
	}
	
	function doAction() {
		
					
		/* CHECK USER FOR CAPABILITIES */
		if ( ! $this->checkCapabilityAndAuthenticateUser( $this->getRequiredCapability() ) ) {
		
			return $this->data;
		}
		
		/* PERFORM PRE ACTION */
		// often used by abstract descendant controllers to set various things
		$this->pre();
		/* PERFORM MAIN ACTION */
	   	return $this->finishActionCall($this->action());			
	}
	
	function action() {
		
		$map = cake_coreAPI::getRequest()->getAllCakeParams();
		echo cake_coreAPI::executeApiCommand($map);
	}
	
	function notAuthenticatedAction() {
		
		$this->setErrorMsg('Authentication failed.');
		$this->setView('base.apiError');
	}
	
	function authenticatedButNotCapableAction($additionalMessage = '') {
		$this->setErrorMsg('Thus user is not capable to perform this api method.');
		$this->setView('base.apiError');
	}
}

/**API Error View*/

class cake_apiErrorView extends cake_view {

	function render() {
		
		$this->t->set_template('wrapper_blank.tpl');
		$this->body->set_template('apiError.php');
		$this->body->set( 'error_msg', $this->get( 'error_msg' ) );
	}
}

?>