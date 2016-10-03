<?php
/**
//*******************************************************************
//Template Name: firebug.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @firebug.php
//*******************************************************************/
class Log_firebug extends Log
{
    /**
     * Should the output be buffered or displayed immediately?
     * @var string
     * @access private
     */
    var $_buffering = false;

    /**
     * String holding the buffered output.
     * @var string
     * @access private
     */
    var $_buffer = array();

    /**
     * String containing the format of a log line.
     * @var string
     * @access private
     */
    var $_lineFormat = '%2$s [%3$s] %4$s';

    /**
     * String containing the timestamp format.
     * @var string
     * @access private
     */
    var $_timeFormat = '%b %d %H:%M:%S';

    /**
     * Mapping of log priorities to Firebug methods.
     * @var array
     * @access private
     */
    var $_methods = array(
                        PEAR_LOG_EMERG   => 'error',
                        PEAR_LOG_ALERT   => 'error',
                        PEAR_LOG_CRIT    => 'error',
                        PEAR_LOG_ERR     => 'error',
                        PEAR_LOG_WARNING => 'warn',
                        PEAR_LOG_NOTICE  => 'info',
                        PEAR_LOG_INFO    => 'info',
                        PEAR_LOG_DEBUG   => 'debug'
                    );

    /**
     * Constructs a new Log_firebug object.
     * @param string $name     Ignored.
     * @param string $ident    The identity string.
     * @param array  $conf     The configuration array.
     * @param int    $level    Log messages up to and including this level.
     * @access public
     */
    function Log_firebug($name = '', $ident = 'PHP', $conf = array(),
                         $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);
        if (isset($conf['buffering'])) {
            $this->_buffering = $conf['buffering'];
        }

        if ($this->_buffering) {
            register_shutdown_function(array(&$this, '_Log_firebug'));
        }

        if (!empty($conf['lineFormat'])) {
            $this->_lineFormat = str_replace(array_keys($this->_formatMap),
                                             array_values($this->_formatMap),
                                             $conf['lineFormat']);
        }

        if (!empty($conf['timeFormat'])) {
            $this->_timeFormat = $conf['timeFormat'];
        }
    }

    /**
     * Opens the firebug handler.
     * @access  public
     */
    function open()
    {
        $this->_opened = true;
        return true;
    }

    /**
     * Destructor
     */
    function _Log_firebug()
    {
        $this->close();
    }

    /**
     * Closes the firebug handler.
     * @access  public
     */
    function close()
    {
        $this->flush();
        $this->_opened = false;
        return true;
    }

    /**
     * Flushes all pending ("buffered") data.
     * @access public
     */
    function flush() {
        if (count($this->_buffer)) {
            print '<script type="text/javascript">';
            print "\nif ('console' in window) {\n";
            foreach ($this->_buffer as $line) {
                print "  $line\n";
            }
            print "}\n";
            print "</script>\n";
        };
        $this->_buffer = array();
    }

    /**
     * @param mixed  $message    String or object containing the message to log.
     * @param string $priority The priority of the message.
     * @return boolean  True on success or false on failure.
     * @access public
     */
    function log($message, $priority = null)
    {
        /* If a priority hasn't been specified, use the default value. */
        if ($priority === null) {
            $priority = $this->_priority;
        }

        if (!$this->_isMasked($priority)) {
            return false;
        }

        $message = $this->_extractMessage($message);
        $method  = $this->_methods[$priority];

        $message = preg_replace("/\r?\n/", "\\n", addslashes($message));
        
        $line = $this->_format($this->_lineFormat,
                               strftime($this->_timeFormat),
                               $priority, 
                               $message);

        if ($this->_buffering) {
            $this->_buffer[] = sprintf('console.%s("%s");', $method, $line);
        } else {
            print '<script type="text/javascript">';
            print "\nif ('console' in window) {\n";
            printf('  console.%s("%s");', $method, $line);
            print "\n}\n";
            print "</script>\n";
        }
        /* Notify observers about this log message. */
        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }
}
