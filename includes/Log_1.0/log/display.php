<?php
/**
//*******************************************************************
//Template Name: display.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @display.php
//*******************************************************************/
class Log_display extends Log
{
    /**
     * String containing the format of a log line.
     * @var string
     * @access private
     */
    var $_lineFormat = '<b>%3$s</b>: %4$s';

    /**
     * @var string
     * @access private
     */
    var $_timeFormat = '%b %d %H:%M:%S';

    /**
     * @var boolean
     * @access private
     */
    var $_rawText = false;

    /**
     * @param string $name     Ignored.
     * @param string $ident    The identity string.
     * @param array  $conf     The configuration array.
     * @param int    $level    Log messages up to and including this level.
     * @access public
     */
    function Log_display($name = '', $ident = '', $conf = array(),
                         $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);

        /* Start by configuring the line format. */
        if (!empty($conf['lineFormat'])) {
            $this->_lineFormat = str_replace(array_keys($this->_formatMap),
                                             array_values($this->_formatMap),
                                             $conf['lineFormat']);
        }

        /* We may need to prepend a string to our line format. */
        $prepend = null;
        if (isset($conf['error_prepend'])) {
            $prepend = $conf['error_prepend'];
        } else {
            $prepend = ini_get('error_prepend_string');
        }
        if (!empty($prepend)) {
            $this->_lineFormat = $prepend . $this->_lineFormat;
        }

        /* We may also need to append a string to our line format. */
        $append = null;
        if (isset($conf['error_append'])) {
            $append = $conf['error_append'];
        } else {
            $append = ini_get('error_append_string');
        }
        if (!empty($append)) {
            $this->_lineFormat .= $append;
        }

        /* Lastly, the line ending sequence is also configurable. */
        if (isset($conf['linebreak'])) {
            $this->_lineFormat .= $conf['linebreak'];
        } else {
            $this->_lineFormat .= "<br />\n";
        }

        /* The user can also change the time format. */
        if (!empty($conf['timeFormat'])) {
            $this->_timeFormat = $conf['timeFormat'];
        }

        /* Message text conversion can be disabled. */
        if (isset($conf['rawText'])) {
            $this->_rawText = $conf['rawText'];
        }
    }

    /**
     * Opens the display handler.
     * @access  public
     * @since   Log 1.9.6
     */
    function open()
    {
        $this->_opened = true;
        return true;
    }

    /**
     * Closes the display handler.
     * @access  public
     * @since   Log 1.9.6
     */
    function close()
    {
        $this->_opened = false;
        return true;
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

        /* Abort early if the priority is above the maximum logging level. */
        if (!$this->_isMasked($priority)) {
            return false;
        }

        /* Extract the string representation of the message. */
        $message = $this->_extractMessage($message);

        /* Convert the message to an HTML-friendly represention unless raw 
         * text has been requested. */
        if ($this->_rawText === false) {
            $message = nl2br(htmlspecialchars($message));
        }

        /* Build and output the complete log line. */
        echo $this->_format($this->_lineFormat,
                            strftime($this->_timeFormat),
                            $priority,
                            $message);

        /* Notify observers about this log message. */
        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }
}
