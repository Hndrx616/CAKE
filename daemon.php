<?php
//*******************************************************************
//Template Name: daemon.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: daemon
//*******************************************************************/

require_once('cake_env.php');
require_once(CAKE_DIR.'cake_php.php');
require_once(CAKE_BASE_CLASS_DIR.'daemon.php');

define('CAKE_DAEMON', true);

if (!empty($_POST)) {
	exit();
} elseif (!empty($_GET)) {
	exit();
}

$cake = new cake_php();

if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {
	// start daemon
	$daemon = new cake_daemon();
	$daemon->start();
	
} else {
	// unload cake
	$cake->restInPeace();
}

?>