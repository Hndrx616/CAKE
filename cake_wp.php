<?php
//*******************************************************************
//Template Name: cake_wp.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_wp
//*******************************************************************/

require_once(CAKE_BASE_CLASS_DIR.'client.php');

class cake_wp extends cake_client {
	
	/**
	 * Constructor
	 * @return cake_wp
	 */
	
	function __construct($config = null) {
		
		ob_start();
		
		return parent::__construct($config);
	
	}
	

	function add_link_tracking($link) {
		
		// check for presence of '?' which is not present under URL rewrite conditions
	
		if ($this->config['track_feed_links'] == true):
		
			if (strpos($link, "?") === false):
				// add the '?' if not found
				$link .= '?';
			endif;
			
			// setup link template
			$link_template = "%s&amp;%s=%s&amp;%s=%s";
				
			return sprintf($link_template,
						   $link,
						   $this->config['ns'].'medium',
						   'feed',
						   $this->config['ns'].$this->config['feed_subscription_param'],
						   $_GET[$this->config['ns'].$this->config['feed_subscription_param']]);
		else:
			return;
		endif;
	}
	
	/**
	 * Wordpress filter method. Adds tracking to feed links.
	 * @var string the feed link
	 * @return string link string with special tracking id
	 */
	function add_feed_tracking($binfo) {
		
		if ($this->config['track_feed_links'] == true):
			$guid = crc32(getmypid().microtime());
		
			return $binfo."&amp;".$this->config['ns'].$this->config['feed_subscription_param']."=".$guid;
		else:
			return;
		endif;
	}
}

?>