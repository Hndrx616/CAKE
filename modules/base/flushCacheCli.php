<?php
//*******************************************************************
//Template Name: flushCacheCli.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: flushCacheCli
//*******************************************************************/

class cake_flushCacheCliController extends cake_cliController {
	
	function action() {
		
		$cache = cake_coreAPI::cacheSingleton(); 
		$cache->flush();
				
		$this->e->notice("Cache Flushed");
	}
}

?>