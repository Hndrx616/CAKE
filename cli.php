<?php
//*******************************************************************
//Template Name: cli.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cli
//*******************************************************************/

require_once('cake_env.php');
require_once(CAKE_DIR.'cake_caller.php');
require_once(CAKE_BASE_CLASS_DIR.'cliController.php');

define('CAKE_CLI', true);

if (!empty($_POST)) {
	exit();
} elseif (!empty($_GET)) {
	exit();
} elseif (!empty($argv)) {
	$params = array();
	// get params from the command line args
	// $argv is a php super global variable
	
	   for ($i=1; $i<count($argv);$i++)
	   {
		   $it = explode("=",$argv[$i]);
		   $params[$it[0]] = $it[1];
	   }
	 unset($params['action']);
	 unset($params['do']);
	
} else {
	// No params found
	exit();
}

// Initialize cake
$cake = new cake_caller;

if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {

	// setting CLI mode to true
	$cake->setSetting('base', 'cli_mode', true);
	// setting user auth
	$cake->setCurrentUser('admin', 'cli-user');
	// run controller or view and echo page content
	$s = cake_coreAPI::serviceSingleton();
	$s->loadCliCommands();
	
	if (array_key_exists('cmd', $params)) {
		
		$cmd = $s->getCliCommandClass($params['cmd']);
		
		if ($cmd) {
			$params['do'] = $cmd;
			echo $cake->handleRequest($params);
		} else {
			echo "Invalid command name.";
		}
		
	} else {
		echo "Missing a command argument.";
	}

} else {
	// unload cake
	$cake->restInPeace();
}

?>