<?php
//*******************************************************************
//Template Name: cake_observer.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_observer
//*******************************************************************/

class cake_observer extends cake_base {

	 /**
     * The type of event that an observer would want to hear about.
     * @var array
     * @access private
     */
    var $_event_type = array();
    
	var $id;
    
    /**
     * Event Message
     * @var array
     */
	var $m;
   
    /**
     * Creates a new basic Log_observer instance.
     * @param integer   $priority   The highest priority at which to receive log event notifications.
     * @access public
     */  
    function __construct() {
    	$this->id = md5(microtime());
    }
    
    function handleEvent($action) {
    
    	$data = cake_coreAPI::performAction($action, array('event' => $this->m));	
    	return cake_coreAPI::debug(sprintf("Handled Event. Action: %s", $action));
    	
    }
    
    function sendMail($email_address, $subject, $msg) {
    	
    	mail($email_address, $subject, $msg);			
		cake_coreAPI::debug('Sent e-mail with subject of "'.$subject.'" to: '.$email_address);
		return;
    }

}

?>