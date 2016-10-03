<?php
//*******************************************************************
//Template Name: api.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: api
//*******************************************************************/

include_once('cake_env.php');
require_once(CAKE_BASE_DIR.'/cake_php.php');

// define entry point cnstant
define('CAKE_API', true);
// invoke cake
$cake = new cake_php;

if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {

	// run api command and echo page content
	echo $cake->handleRequest('', 'base.apiRequest');
} else {
	// unload cake
	$cake->restInPeace();
}

?>