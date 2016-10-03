<?php
//*******************************************************************
//Template Name: install.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: install
//*******************************************************************/

include_once('cake_env.php');
require_once(CAKE_BASE_DIR.'/cake_php.php');

// Initialize cake
//define('CAKE_ERROR_HANDLER', 'development');
define('CAKE_CACHE_OBJECTS', false);
define('CAKE_INSTALLING', true);
$cake = new cake_php();
if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {

	// need third param here so that seting is not persisted.
	$cake->setSetting('base','main_url', 'install.php');
	// run controller, echo page content
	$do = cake_coreAPI::getRequestParam('do'); 
	$params = array();
	if (empty($do)) {
		
		$params['do'] = 'base.installStart';
	}
	
	// run controller or view and echo page content
	echo $cake->handleRequest($params);

} else {
	// unload cake
	$cake->restInPeace();
}

?>