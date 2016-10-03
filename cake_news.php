<?php
//*******************************************************************
//Template Name: cake_news.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_news
//*******************************************************************/

require_once(CAKE_BASE_DIR.'/cake_env.php');
require_once(CAKE_INCLUDE_DIR.'/lastRSS.php');
require_once(CAKE_BASE_DIR.'/cake_httpRequest.php');

class cake_news extends lastRSS {
	
	/**
	 * Configuration
	 * @var array
	 */
	var $config;
	
	/**
	 * Error handler
	 * @var object
	 */
	var $e;
	
	var $crawler;
	
	function __construct() {
	
		$c = cake_coreAPI::configSingleton();
		$this->config = $c->fetch('base');
		$this->e = cake_coreAPI::errorSingleton();
		$this->crawler = new cake_http;
		$this->crawler->read_timeout = 20;
		$this->cache_dir = '';
		$this->date_format = "F j, Y";
		$this->CDATA = 'content';
		$this->items_limit = 3;
	}
	
	/**
	 * This is a redefined Parse function that uses Snoopy to fetch the file instead of fopen.
	 * @param unknown_type $rss_url
	 * @return unknown
	 */
	function Parse ($rss_url) {
		// Open and load RSS file
		
		$this->crawler->getRequest($rss_url);
		$rss_content = $this->crawler->response;
		
		if (!empty($rss_content)) {
			
			// Parse document encoding
			$result['encoding'] = $this->my_preg_match("'encoding=[\'\"](.*?)[\'\"]'si", $rss_content);
			// if document codepage is specified, use it
			if ($result['encoding'] != '')
				{ $this->rsscp = $result['encoding']; } // This is used in my_preg_match()
			// otherwise use the default codepage
			else
				{ $this->rsscp = $this->default_cp; } // This is used in my_preg_match()

			// Parse CHANNEL info
			preg_match("'<channel.*?>(.*?)</channel>'si", $rss_content, $out_channel);
			foreach($this->channeltags as $channeltag)
			{
				$temp = $this->my_preg_match("'<$channeltag.*?>(.*?)</$channeltag>'si", $out_channel[1]);
				if ($temp != '') $result[$channeltag] = $temp; // Set only if not empty
			}
			// If date_format is specified and lastBuildDate is valid
			if ($this->date_format != '' && ($timestamp = strtotime($result['lastBuildDate'])) !==-1) {
						// convert lastBuildDate to specified date format
						$result['lastBuildDate'] = date($this->date_format, $timestamp);
			}

			// Parse TEXTINPUT info
			preg_match("'<textinput(|[^>]*[^/])>(.*?)</textinput>'si", $rss_content, $out_textinfo);
				// This a little strange regexp means:
				// Look for tag <textinput> with or without any attributes, but skip truncated version <textinput /> (it's not beggining tag)
			if (isset($out_textinfo[2])) {
				foreach($this->textinputtags as $textinputtag) {
					$temp = $this->my_preg_match("'<$textinputtag.*?>(.*?)</$textinputtag>'si", $out_textinfo[2]);
					if ($temp != '') $result['textinput_'.$textinputtag] = $temp; // Set only if not empty
				}
			}
			// Parse IMAGE info
			preg_match("'<image.*?>(.*?)</image>'si", $rss_content, $out_imageinfo);
			if (isset($out_imageinfo[1])) {
				foreach($this->imagetags as $imagetag) {
					$temp = $this->my_preg_match("'<$imagetag.*?>(.*?)</$imagetag>'si", $out_imageinfo[1]);
					if ($temp != '') $result['image_'.$imagetag] = $temp; // Set only if not empty
				}
			}
			// Parse ITEMS
			preg_match_all("'<item(| .*?)>(.*?)</item>'si", $rss_content, $items);
			$rss_items = $items[2];
			$i = 0;
			$result['items'] = array(); // create array even if there are no items
			foreach($rss_items as $rss_item) {
				// If number of items is lower then limit: Parse one item
				if ($i < $this->items_limit || $this->items_limit == 0) {
					foreach($this->itemtags as $itemtag) {
						$temp = $this->my_preg_match("'<$itemtag.*?>(.*?)</$itemtag>'si", $rss_item);
						if ($temp != '') $result['items'][$i][$itemtag] = $temp; // Set only if not empty
					}
					// Strip HTML tags and other bullshit from DESCRIPTION
					if ($this->stripHTML && $result['items'][$i]['description'])
						$result['items'][$i]['description'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['description'])));
					// Strip HTML tags and other bullshit from TITLE
					if ($this->stripHTML && $result['items'][$i]['title'])
						$result['items'][$i]['title'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['title'])));
					// If date_format is specified and pubDate is valid
					if ($this->date_format != '' && ($timestamp = strtotime($result['items'][$i]['pubDate'])) !==-1) {
						// convert pubDate to specified date format
						$result['items'][$i]['pubDate'] = date($this->date_format, $timestamp);
					}
					// Item counter
					$i++;
				}
			}

			$result['items_count'] = $i;
			return $result;
		}
		else // Error in opening return False
		{
			$this->e->notice('no rss content found at: '.$rss_url);
			return False;
		}
	}
	
}

?>