<?php
//*******************************************************************
//Template Name: action.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: action
//*******************************************************************/

include_once('cake_env.php');
require_once(CAKE_BASE_DIR.'/cake_php.php');

$cake = new cake_php;

$cake->e->debug('Special action request received by action.php...');

if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {

	// run controller or view and echo page content
	echo $cake->handleRequestFromURL();
} else {
	// unload cake
	$cake->restInPeace();
}

?>