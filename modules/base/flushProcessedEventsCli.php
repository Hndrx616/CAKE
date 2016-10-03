<?php
//*******************************************************************
//Template Name: flushProcessedEventsCli.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: flushProcessedEventsCli
//*******************************************************************/

class cake_flushProcessedEventsCliController extends cake_cliController {
	
	function action() {
		
		$this->e->notice('About to delete handled events from database event queue.');
		$d = cake_coreAPI::getEventDispatch();
		$q = $d->getAsyncEventQueue( 'database' );
	    $this->e->notice('Events removed: ' . $q->flushHandledEvents() );
	}
}

?>