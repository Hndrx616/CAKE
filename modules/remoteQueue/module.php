<?php
//*******************************************************************
//Template Name: module.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: module
//*******************************************************************/
require_once(CAKE_BASE_DIR.'/cake_module.php');

class cake_remoteQueueModule extends cake_module {
	
	function __construct() {
		
		$this->name = 'remoteQueue';
		$this->display_name = 'Remote Queue';
		$this->group = 'logging';
		$this->author = 'Stephen Hilliard';
		$this->version = '1.0';
		$this->description = 'Posts incoming tracking events to a remote instance of CAKE';
		$this->config_required = false;
		$this->required_schema_version = 1;
		
		// register named queues
		
		$endpoint = cake_coreAPI::getSetting( 'remoteQueue', 'endpoint' );
		
		if ( $endpoint ) {
		
			$this->registerEventQueue( 'incoming_tracking_events', array(
				
				'queue_type'			=> 	'http',
				'endpoint'				=>	$endpoint
			));
		} 
		
		return parent::__construct();
	}
}

?>