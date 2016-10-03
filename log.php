<?php
//*******************************************************************
//Template Name: log.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: log
//*******************************************************************/

include_once('cake_env.php');
require_once(CAKE_BASE_DIR.'/cake_lib.php');

ignore_user_abort(true);

// turn off gzip compression
if ( function_exists( 'apache_setenv' ) ) {
	apache_setenv( 'no-gzip', 1 );
}

ini_set('zlib.output_compression', 0);

// turn on output buffering if necessary
if (ob_get_level() == 0) {
   	ob_start();
}

// removing any content encoding like gzip etc.
header('Content-encoding: none', true);

//check to se if request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// redirect to blank.php
	cake_lib::redirectBrowser( str_replace('log.php', 'blank.php', cake_lib::get_current_url() ) );
	// necessary or else buffer is not actually flushed
	echo ' ';
} else {
	// return 1x1 pixel gif
	header("Content-type: image/gif");
	// needed to avoid cache time on browser side
	header("Content-Length: 42");
	header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
	header("Expires: Wed, 11 Jan 2000 12:59:00 GMT");
	header("Last-Modified: Wed, 11 Jan 2006 12:59:00 GMT");
	header("Pragma: no-cache");
	
	echo sprintf(
		'%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%',
		71,73,70,56,57,97,1,0,1,0,128,255,0,192,192,192,0,0,0,33,249,4,1,0,0,0,0,44,0,0,0,0,1,0,1,0,0,2,2,68,1,0,59
	);	
}

// flush all output buffers. No reason to make the user wait for CAKE.
ob_flush();
flush();
ob_end_flush();

// Create instance of CAKE
require_once(CAKE_BASE_DIR.'/cake_php.php');
$cake = new cake_php();

// check to see if this endpoint is enabled.
if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {
	
	$cake->e->debug('Logging new tracking event from request.');
	$cake->logEventFromUrl();
	
} else {
	// unload cake
	$cake->restInPeace();
}

?>