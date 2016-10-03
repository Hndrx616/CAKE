<?php
//*******************************************************************
//Template Name: syslog.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @syslog.php
//*******************************************************************
class Log_syslog extends Log
{
    /**
     * Integer holding the log facility to use.
     * @var integer
     * @access private
     */
    var $_name = LOG_SYSLOG;

    /**
     * @var boolean
     * @access private
     */
    var $_inherit = false;

    /**
     * Should we re-open the syslog connection for each log event?
     * @var boolean
     * @access private
     */
    var $_reopen = false;

    /**
     * @var integer
     * @access private
     */
    var $_maxLength = 500;

    /**
     * @var string
     * @access private
     */
    var $_lineFormat = '%4$s';

    /**
     * @var string
     * @access private
     */
    var $_timeFormat = '%b %d %H:%M:%S';

    /**
     * @param string $name     The syslog facility.
     * @param string $ident    The identity string.
     * @param array  $conf     The configuration array.
     * @param int    $level    Log messages up to and including this level.
     * @access public
     */
    function Log_syslog($name, $ident = '', $conf = array(),
                        $level = PEAR_LOG_DEBUG)
    {
        /* Ensure we have a valid integer value for $name. */
        if (empty($name) || !is_int($name)) {
            $name = LOG_SYSLOG;
        }

        if (isset($conf['inherit'])) {
            $this->_inherit = $conf['inherit'];
            $this->_opened = $this->_inherit;
        }
        if (isset($conf['reopen'])) {
            $this->_reopen = $conf['reopen'];
        }
        if (isset($conf['maxLength'])) {
            $this->_maxLength = $conf['maxLength'];
        }
        if (!empty($conf['lineFormat'])) {
            $this->_lineFormat = str_replace(array_keys($this->_formatMap),
                                             array_values($this->_formatMap),
                                             $conf['lineFormat']);
        }
        if (!empty($conf['timeFormat'])) {
            $this->_timeFormat = $conf['timeFormat'];
        }

        $this->_id = md5(microtime());
        $this->_name = $name;
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);
    }

    /**
     * @access public
     */
    function open()
    {
        if (!$this->_opened || $this->_reopen) {
            $this->_opened = openlog($this->_ident, LOG_PID, $this->_name);
        }

        return $this->_opened;
    }

    /**
     * @access public
     */
    function close()
    {
        if ($this->_opened && !$this->_inherit) {
            closelog();
            $this->_opened = false;
        }

        return true;
    }

    /**
     * @param mixed $message String or object containing the message to log.
     * @param int $priority (optional) The priority of the message.
     * @return boolean  True on success or false on failure.
     * @access public
     */
    function log($message, $priority = null)
    {
        if ($priority === null) {
            $priority = $this->_priority;
        }

        if (!$this->_isMasked($priority)) {
            return false;
        }

        if ((!$this->_opened || $this->_reopen) && !$this->open()) {
            return false;
        }

        $message = $this->_extractMessage($message);

        $priority = $this->_toSyslog($priority);
        if ($this->_inherit) {
            $priority |= $this->_name;
        }

        $message = $this->_format($this->_lineFormat,
                                  strftime($this->_timeFormat),
                                  $priority, $message);

        $parts = str_split($message, $this->_maxLength);
        if ($parts === false) {
            return false;
        }

        foreach ($parts as $part) {
            if (!syslog($priority, $part)) {
                return false;
            }
        }

        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }

    /**
     * Converts a PEAR_LOG_* constant into a syslog LOG_* constant.
     * @param int $priority     PEAR_LOG_* value to convert to LOG_* value.
     * @return  The LOG_* representation of $priority.
     * @access private
     */
    function _toSyslog($priority)
    {
        static $priorities = array(
            PEAR_LOG_EMERG   => LOG_EMERG,
            PEAR_LOG_ALERT   => LOG_ALERT,
            PEAR_LOG_CRIT    => LOG_CRIT,
            PEAR_LOG_ERR     => LOG_ERR,
            PEAR_LOG_WARNING => LOG_WARNING,
            PEAR_LOG_NOTICE  => LOG_NOTICE,
            PEAR_LOG_INFO    => LOG_INFO,
            PEAR_LOG_DEBUG   => LOG_DEBUG
        );

        /* If we're passed an unknown priority, default to LOG_INFO. */
        if (!is_int($priority) || !in_array($priority, $priorities)) {
            return LOG_INFO;
        }

        return $priorities[$priority];
    }
}
