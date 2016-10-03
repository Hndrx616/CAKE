<?php
//*******************************************************************
//Template Name: module.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: module
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_module.php');

class cake_maxmind_geoipModule extends cake_module {
	
	var $method;
	
	function __construct() {
		
		$this->name = 'maxmind_geoip';
		$this->display_name = 'Maxmind GeoIP';
		$this->group = 'geoip';
		$this->author = 'Stephen Hilliard';
		$this->version = '1.0';
		$this->description = 'Performs Maxmind Geo-IP lookups.';
		$this->config_required = false;
		$this->required_schema_version = 1;
		
		$mode = cake_coreAPI::getSetting('maxmind_geoip', 'lookup_method');
		
		switch ( $mode ) {
			
			case "geoip_city_isp_org_web_service":
				$method = 'getLocationFromWebService';
				break;
				
			case "city_lite_db":
				$method = 'getLocation';
				break;
				
			default:
				$method = 'getLocation';
		}
		
		$this->method = $method;
		
		// needed so default filters will not fun
		cake_coreAPI::setSetting('base', 'geolocation_service', 'maxmind');
		
		
		return parent::__construct();
	}
	
	function registerFilters() {
		
		if ( cake_coreAPI::getSetting('base', 'geolocation_service') === 'maxmind' ) {
		
			$this->registerFilter('geolocation', 'maxmind', $this->method, 0, 'classes');
		}
	}
}

?>