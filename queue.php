<?php
//*******************************************************************
//Template Name: queue.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: queue
//*******************************************************************/

ignore_user_abort(true);
set_time_limit(180);

include_once('cake_env.php');
require_once(CAKE_BASE_DIR.'/cake_php.php');

$cake = new cake_php();

if ( $cake->isEndpointEnabled( basename( __FILE__ ) ) ) {
	
	
	$cake->setSetting('base', 'is_remote_event_queue', true);
	$cake->e->debug('post: ' . print_r($_POST, true) );
	$raw_event = cake_coreAPI::getRequestParam('event');
	
	if ( $raw_event ) { 
		
		$dispatch = cake_coreAPI::getEventDispatch();
		$event = $dispatch->makeEvent();
		$event->loadFromArray($raw_event);
		
		$cake->e->debug(print_r($event,true));
		$dispatch->asyncNotify($event);
	}
		
} else {
	// unload cake
	$cake->restInPeace();
}

?>