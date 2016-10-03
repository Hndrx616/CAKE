<?php
//*******************************************************************
//Template Name: null.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @null.php
//*******************************************************************
class Log_null extends Log
{
    /**
     * @param string $name     Ignored.
     * @param string $ident    The identity string.
     * @param array  $conf     The configuration array.
     * @param int    $level    Log messages up to and including this level.
     * @access public
     */
    function Log_null($name, $ident = '', $conf = array(),
					  $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);
    }

    /**
     * Opens the handler.
     * @access  public
     * @since   Log 1.9.6
     */
    function open()
    {
        $this->_opened = true;
        return true;
    }

    /**
     * Closes the handler.
     * @access  public
     * @since   Log 1.9.6
     */
    function close()
    {
        $this->_opened = false;
        return true;
    }

    /**
     * Simply consumes the log event.
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

        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }
}
