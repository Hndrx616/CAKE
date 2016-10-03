<?php
//*******************************************************************
//Template Name: index.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: index
//*******************************************************************/

require_once('cake_env.php');
require_once(CAKE_DIR.'cake_php.php');

// Initialize cake admin
$cake = new cake_php;


if (!$cake->isCakeInstalled()) {
	// redirect to install
	cake_lib::redirectBrowser(cake_coreAPI::getSetting('base','public_url').'install.php');
}

if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {

	// run controller or view and echo page content
	echo $cake->handleRequestFromURL();
} else {
	
	// unload cake
	$cake->restInPeace();
}

?>