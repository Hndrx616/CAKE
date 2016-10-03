<?php
//*******************************************************************
//Template Name: build.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: build
//*******************************************************************/

require (CAKE_INCLUDE_DIR.'jsmin-1.1.1.php');
require_once(CAKE_BASE_CLASS_DIR.'cliController.php');

class cake_buildController extends cake_cliController {
	
	function __construct($params) {
		
		parent::__construct($params);
		
		$this->setRequiredCapability('edit_modules');
	}
	
	function action() {
		
		$packages = cake_coreAPI::getBuildPackages();
		
		if ( $this->getParam('package') ) {
			
			$packages = array($packages[$this->getParam('package')]);	
		}
		
		if ($packages) {
			foreach ($packages as $package) {
				
				cake_coreAPI::debug(sprintf("Building %s Package.", $package['name'] ) );
				$con = sprintf("/* CAKE %s package file created %s */ \n\n", $package['name'] ,date( DATE_RFC822 ) );		
				$isMin = false;
				foreach ($package['files'] as $name => $file_info) {
					
					cake_coreAPI::debug("Reading file from: " . $file_info['path'] );
					$con .= "/* Start of $name */ \n\n";
					$content = file_get_contents( $file_info['path'] );
					if (isset($file_info['compression']) && $file_info['compression'] === 'minify') {
						cake_coreAPI::debug("Minimizing Javascript in: " . $file_info['path'] );
						$content = JSMin::minify($content);
						$isMin = true;
					} 
					$con .= $content . "\n\n";
					$con .= "/* End of $name */ \n\n";	
				}
				$file_name = $package['output_dir'].$package['name']."-combined";
				if ($isMin) {
					$file_name .= '-min';
				}
				
				$file_name .= '.' . $package['type'];
				
				cake_coreAPI::debug('Writing package to file: '.$file_name);
				$handle = fopen($file_name, "w");
				fwrite($handle, $con);
				fclose($handle);
			}
		} else {
			cake_coreAPI::debug( "No packages registered to build." );
		}
	}
}

?>