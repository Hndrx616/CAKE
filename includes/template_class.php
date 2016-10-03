<?php
//*******************************************************************
//Template Name: template_class.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package includes
// @project: template_class
//*******************************************************************/
class Template {

	/**
	 * Template files directory
	 * @var string
	 */
	var $template_dir;
	
	/**
	 * Template Variables
	 * @var array
	 */
    var $vars = array();
    
    /**
     * Template file
     * @var string
     */
    var $file;

    /**
     * Constructor
     * @access public 
     */
    function Template() {
        
        return;
    }
	
    /**
     * Set the template file
     * @param string $file
     */
	function set_template($file = null) {
        $this->file = $this->template_dir.$file;
        return;
    }

	/**
	 * Set a template variable
	 * @param string $name
	 * @param unknown_value $value
	 * @access public
	 */
    function set($name, $value) {
    
    	if (is_object($value)) {
    		$class  = 'Template';
    		if ($value instanceof $this) {
    			$value = $value->fetch();
    		}
    	} 
    
        $this->vars[$name] =  $value;
        return;
    }

    /**
     * Open, parse, and return the template file.
     * @param string $file
     * @return string $contents
     * @access public
     */
    function fetch($file = null) {
        if(!$file):
			 $file = $this->file;
		else:
			$file = $this->template_dir.$file;
		endif;

        extract($this->vars);          // Extract the vars to local namespace
        ob_start();                    // Start output buffering
        include($file);                // Include the file
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;              // Return the contents
    }
	
}

/**
* An extension to Template that provides automatic caching of
* template contents.
*/
class CachedTemplate extends Template {
    var $cache_id;
    var $expire;
    var $cached;

    /**
     * Constructor.
     * @param $cache_id string unique cache identifier
     * @param $expire int number of seconds the cache will live
     */
    function CachedTemplate($cache_id = null, $expire = 900) {
        $this->Template();
        $this->cache_id = $cache_id ? 'cache/' . md5($cache_id) : $cache_id;
        $this->expire   = $expire;
    }

    /**
     * Test to see whether the currently loaded cache_id has a valid
     * corrosponding cache file.
     */
    function is_cached() {
        if($this->cached) return true;

        // Passed a cache_id?
        if(!$this->cache_id) return false;

        // Cache file exists?
        if(!file_exists($this->cache_id)) return false;

        // Can get the time of the file?
        if(!($mtime = filemtime($this->cache_id))) return false;

        // Cache expired?
        if(($mtime + $this->expire) < time()) {
            @unlink($this->cache_id);
            return false;
        }
        else {
            /**
             * Cache the results of this is_cached() call.
             */
            $this->cached = true;
            return true;
        }
    }

    /**
     * This function returns a cached copy of a template (if it exists),
     * otherwise, it parses it as normal and caches the content.
     * @param $file string the template file
     */
    function fetch_cache($file) {
        if($this->is_cached()) {
            $fp = @fopen($this->cache_id, 'r');
            $contents = fread($fp, filesize($this->cache_id));
            fclose($fp);
            return $contents;
        }
        else {
            $contents = $this->fetch($file);

            // Write the cache
            if($fp = @fopen($this->cache_id, 'w')) {
                fwrite($fp, $contents);
                fclose($fp);
            }
            else {
                die('Unable to write cache.');
            }

            return $contents;
        }
    }
}
?>