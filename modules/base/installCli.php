<?php
//*******************************************************************
//Template Name: installCli.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: installCli
//*******************************************************************/

class cake_installCliController extends cake_cliController {
	
	function __construct($params) {
		define('CAKE_INSTALLING', true);
		return parent::__construct($params);
	}

	function action() {
		
		$service = cake_coreAPI::serviceSingleton();
	    $im = cake_coreAPI::supportClassFactory('base', 'installManager');
	    $this->e->notice('Starting CAKE Install from command line.');
	    
	    //create config file
	    $present = $this->c->isConfigFilePresent();
	    
	    if ( $present ) {
	    
			$this->c->applyConfigConstants();
				
			// install schema
			$status = $im->installSchema();
			
			// schema was installed successfully
			if ($status === true) {
			    
			    //create admin user
			    //cake_coreAPI::debug('password: '.cake_lib::encryptPassword( $this->c->get('base', 'db_password') ) );
			    $im->createAdminUser($this->getParam('email_address'), $this->getParam('real_name'), $this->c->get('base', 'db_password') );
			    
			    // create default site
				$im->createDefaultSite(
						$this->getParam('domain'), 
						$this->getParam('domain'), 
						$this->getParam('description'), 
						$this->getParam('site_family')
				);
				
				// Persist install complete flag. 
				$this->c->persistSetting('base', 'install_complete', true);
				$save_status = $this->c->save();
				
				if ($save_status === true) {
					$this->e->notice('Install Completed.');
				} else {
					$this->e->notice('Could not persist Install Complete Flag to the Database');
				}
	
			// schema was not installed successfully
			} else {
				$this->e->notice('Aborting embedded install due to errors installing schema. Try dropping all CAKE tables and try again.');
				return false;
			}	
			
				    
	    } else {
	    	$this->e->notice("Could not locate config file. Aborting installation.");
	    }
	}
}

?>