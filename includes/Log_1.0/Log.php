<?php
//*******************************************************************
//Template Name: log.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************

define('GIG_LOG_EMERG',    0);     /* System is unusable */
define('GIG_LOG_ALERT',    1);     /* Immediate action required */
define('GIG_LOG_CRIT',     2);     /* Critical conditions */
define('GIG_LOG_ERR',      3);     /* Error conditions */
define('GIG_LOG_WARNING',  4);     /* Warning conditions */
define('GIG_LOG_NOTICE',   5);     /* Normal but significant */
define('GIG_LOG_INFO',     6);     /* Informational */
define('GIG_LOG_DEBUG',    7);     /* Debug-level messages */

define('GIG_LOG_ALL',      0xffffffff);    /* All messages */
define('GIG_LOG_NONE',     0x00000000);    /* No message */

/* Log types for PHP's native error_log() function. */
define('GIG_LOG_TYPE_SYSTEM',  0); /* Use PHP's system logger */
define('GIG_LOG_TYPE_MAIL',    1); /* Use PHP's mail() function */
define('GIG_LOG_TYPE_DEBUG',   2); /* Use PHP's debugging connection */
define('GIG_LOG_TYPE_FILE',    3); /* Append to a file */
define('GIG_LOG_TYPE_SAPI',    4); /* Use the SAPI logging handler */

/**
 * The Log:: class implements both an abstraction for various logging
 * mechanisms and the Subject end of a Subject-Observer pattern.
 */
class Log
{
    /**
     * Indicates whether or not the log can been opened / connected.
     */
    var $_opened = false;

    /**
     * Instance-specific unique identification number.
     */
    var $_id = 0;

    /**
     * The label that uniquely identifies this set of log messages.
     */
    var $_ident = '';

    /**
     * The default priority to use when logging an event.
     */
    var $_priority = GIG_LOG_INFO;

    /**
     * The bitmask of allowed log levels.
     */
    var $_mask = GIG_LOG_ALL;

    /**
     * Holds all Log_observer objects that wish to be notified of new messages.
     */
    var $_listeners = array();

    /**
     * Starting depth to use when walking a backtrace in search of the 
     * function that invoked the log system.
     */
    var $_backtrace_depth = 0;

    /**
     * Maps canonical format keys to position arguments for use in building
     */
    var $_formatMap = array('%{timestamp}'  => '%1$s',
                            '%{ident}'      => '%2$s',
                            '%{priority}'   => '%3$s',
                            '%{message}'    => '%4$s',
                            '%{file}'       => '%5$s',
                            '%{line}'       => '%6$s',
                            '%{function}'   => '%7$s',
                            '%{class}'      => '%8$s',
                            '%\{'           => '%%{');

    /**
     * Attempts to return a concrete Log instance of type $handler.
     */
    public static function factory($handler, $name = '', $ident = '',
                                   $conf = array(), $level = GIG_LOG_DEBUG)
    {
        $handler = strtolower($handler);
        $class = 'Log_' . $handler;
        $classfile = 'Log/' . $handler . '.php';

        /*
         * Attempt to include our version of the named class, but don't treat
         * a failure as fatal.  The caller may have already included their own
         * version of the named class.
         */
        if (!class_exists($class, false)) {
            include_once $classfile;
        }

        /* If the class exists, return a new instance of it. */
        if (class_exists($class, false)) {
            $obj = new $class($name, $ident, $conf, $level);
            return $obj;
        }

        $null = null;
        return $null;
    }

    /**
     * Attempts to return a reference to a concrete Log instance of type
     * $handler, only creating a new instance if no log instance with the same
     * parameters currently exists.
     */
    public static function singleton($handler, $name = '', $ident = '',
                                     $conf = array(), $level = GIG_LOG_DEBUG)
    {
        static $instances;
        if (!isset($instances)) $instances = array();

        $signature = serialize(array($handler, $name, $ident, $conf, $level));
        if (!isset($instances[$signature])) {
            $instances[$signature] = Log::factory($handler, $name, $ident,
                                                  $conf, $level);
        }

        return $instances[$signature];
    }

    /**
     * Abstract implementation of the open() method.
     */
    function open()
    {
        return false;
    }

    /**
     * Abstract implementation of the close() method.
     */
    function close()
    {
        return false;
    }

    /**
     * Abstract implementation of the flush() method.
     */
    function flush()
    {
        return false;
    }

    /**
     * Abstract implementation of the log() method.
     * @since Log 1.0
     */
    function log($message, $priority = null)
    {
        return false;
    }

    /**
     * A convenience function for logging a emergency event.  It will log a
     * message at the GIG_LOG_EMERG log level.
     */
    function emerg($message)
    {
        return $this->log($message, GIG_LOG_EMERG);
    }

    /**
     * A convenience function for logging an alert event.  It will log a
     * message at the GIG_LOG_ALERT log level.
     */
    function alert($message)
    {
        return $this->log($message, GIG_LOG_ALERT);
    }

    /**
     * A convenience function for logging a critical event.  It will log a
     * message at the GIG_LOG_CRIT log level.
     */
    function crit($message)
    {
        return $this->log($message, GIG_LOG_CRIT);
    }

    /**
     * A convenience function for logging a error event.  It will log a
     * message at the GIG_LOG_ERR log level.
     */
    function err($message)
    {
        return $this->log($message, GIG_LOG_ERR);
    }

    /**
     * A convenience function for logging a warning event.  It will log a
     * message at the GIG_LOG_WARNING log level.
     */
    function warning($message)
    {
        return $this->log($message, GIG_LOG_WARNING);
    }

    /**
     * A convenience function for logging a notice event.  It will log a
     * message at the GIG_LOG_NOTICE log level.
     */
    function notice($message)
    {
        return $this->log($message, GIG_LOG_NOTICE);
    }

    /**
     * A convenience function for logging a information event.  It will log a
     * message at the GIG_LOG_INFO log level.
     */
    function info($message)
    {
        return $this->log($message, GIG_LOG_INFO);
    }

    /**
     * A convenience function for logging a debug event.  It will log a
     * message at the GIG_LOG_DEBUG log level.
     */
    function debug($message)
    {
        return $this->log($message, GIG_LOG_DEBUG);
    }

    /**
     * Returns the string representation of the message data.
     * If $message is an object, _extractMessage() will attempt to extract
     * the message text using a known method (such as a GIG_Error object's
     * getMessage() method).
     */
    function _extractMessage($message)
    {
        /*
         * If we've been given an object, attempt to extract the message using
         * a known method.  If we can't find such a method, default to the
         * "human-readable" version of the object.
         */
        if (is_object($message)) {
            if (method_exists($message, 'getmessage')) {
                $message = $message->getMessage();
            } else if (method_exists($message, 'tostring')) {
                $message = $message->toString();
            } else if (method_exists($message, '__tostring')) {
                $message = (string)$message;
            } else {
                $message = var_export($message, true);
            }
        } else if (is_array($message)) {
            if (isset($message['message'])) {
                if (is_scalar($message['message'])) {
                    $message = $message['message'];
                } else {
                    $message = var_export($message['message'], true);
                }
            } else {
                $message = var_export($message, true);
            }
        } else if (is_bool($message) || $message === NULL) {
            $message = var_export($message, true);
        }

        /* Otherwise, we assume the message is a string. */
        return $message;
    }

    /**
     * Using debug_backtrace(), returns the file, line, and enclosing function
     * name of the source code context from which log() was invoked.
     */
    function _getBacktraceVars($depth)
    {
        /* Start by generating a backtrace from the current call (here). */
        $bt = debug_backtrace();

        /* Store some handy shortcuts to our previous frames. */
        $bt0 = isset($bt[$depth]) ? $bt[$depth] : null;
        $bt1 = isset($bt[$depth + 1]) ? $bt[$depth + 1] : null;

        /*
         * If we were ultimately invoked by the composite handler, we need to
         * increase our depth one additional level to compensate.
         */
        $class = isset($bt1['class']) ? $bt1['class'] : null;
        if ($class !== null && strcasecmp($class, 'Log_composite') == 0) {
            $depth++;
            $bt0 = isset($bt[$depth]) ? $bt[$depth] : null;
            $bt1 = isset($bt[$depth + 1]) ? $bt[$depth + 1] : null;
            $class = isset($bt1['class']) ? $bt1['class'] : null;
        }

        /*
         * We're interested in the frame which invoked the log() function, so
         * we need to walk back some number of frames into the backtrace.  The
         * $depth parameter tells us where to start looking.   We go one step
         * further back to find the name of the encapsulating function from
         * which log() was called.
         */
        $file = isset($bt0) ? $bt0['file'] : null;
        $line = isset($bt0) ? $bt0['line'] : 0;
        $func = isset($bt1) ? $bt1['function'] : null;

        /*
         * However, if log() was called from one of our "shortcut" functions,
         * we're going to need to go back an additional step.
         */
        if (in_array($func, array('emerg', 'alert', 'crit', 'err', 'warning',
                                  'notice', 'info', 'debug'))) {
            $bt2 = isset($bt[$depth + 2]) ? $bt[$depth + 2] : null;

            $file = is_array($bt1) ? $bt1['file'] : null;
            $line = is_array($bt1) ? $bt1['line'] : 0;
            $func = is_array($bt2) ? $bt2['function'] : null;
            $class = isset($bt2['class']) ? $bt2['class'] : null;
        }

        /*
         * If we couldn't extract a function name (perhaps because we were
         * executed from the "main" context), provide a default value.
         */
        if ($func === null) {
            $func = '(none)';
        }

        /* Return a 4-tuple containing (file, line, function, class). */
        return array($file, $line, $func, $class);
    }

    /**
     * Sets the starting depth to use when walking a backtrace in search of 
     * the function that invoked the log system.  This is used on conjunction 
     * with the 'file', 'line', 'function', and 'class' formatters.
     */
    public function setBacktraceDepth($depth)
    {
        $this->_backtrace_depth = $depth;
    }

    /**
     * Produces a formatted log line based on a format string and a set of
     * variables representing the current log record and state.
     */
    function _format($format, $timestamp, $priority, $message)
    {
        /*
         * If the format string references any of the backtrace-driven
         * variables (%5 %6,%7,%8), generate the backtrace and fetch them.
         */
        if (preg_match('/%[5678]/', $format)) {
            /* Plus 2 to account for our internal function calls. */
            $d = $this->_backtrace_depth + 2;
            list($file, $line, $func, $class) = $this->_getBacktraceVars($d);
        }
        /*
         * Build the formatted string.  We use the sprintf() function's
         * "argument swapping" capability to dynamically select and position
         * the variables which will ultimately apGIG in the log string.
         */
        return sprintf($format,
                       $timestamp,
                       $this->_ident,
                       $this->priorityToString($priority),
                       $message,
                       isset($file) ? $file : '',
                       isset($line) ? $line : '',
                       isset($func) ? $func : '',
                       isset($class) ? $class : '');
    }

    /**
     * Returns the string representation of a GIG_LOG_* integer constant.
     */
    function priorityToString($priority)
    {
        $levels = array(
            GIG_LOG_EMERG   => 'emergency',
            GIG_LOG_ALERT   => 'alert',
            GIG_LOG_CRIT    => 'critical',
            GIG_LOG_ERR     => 'error',
            GIG_LOG_WARNING => 'warning',
            GIG_LOG_NOTICE  => 'notice',
            GIG_LOG_INFO    => 'info',
            GIG_LOG_DEBUG   => 'debug'
        );

        return $levels[$priority];
    }

    /**
     * Returns the the GIG_LOG_* integer constant for the given string
     * representation of a priority name.  This function performs a
     * case-insensitive search.
     */
    function stringToPriority($name)
    {
        $levels = array(
            'emergency' => GIG_LOG_EMERG,
            'alert'     => GIG_LOG_ALERT,
            'critical'  => GIG_LOG_CRIT,
            'error'     => GIG_LOG_ERR,
            'warning'   => GIG_LOG_WARNING,
            'notice'    => GIG_LOG_NOTICE,
            'info'      => GIG_LOG_INFO,
            'debug'     => GIG_LOG_DEBUG
        );

        return $levels[strtolower($name)];
    }

    public static function MASK($priority)
    {
        return (1 << $priority);
    }

    public static function UPTO($priority)
    {
        return Log::MAX($priority);
    }

    public static function MIN($priority)
    {
        return GIG_LOG_ALL ^ ((1 << $priority) - 1);
    }

    public static function MAX($priority)
    {
        return ((1 << ($priority + 1)) - 1);
    }

    /**
     * Set and return the level mask for the current Log instance.
     */
    function setMask($mask)
    {
        $this->_mask = $mask;

        return $this->_mask;
    }

    function getMask()
    {
        return $this->_mask;
    }

    function _isMasked($priority)
    {
        return (Log::MASK($priority) & $this->_mask);
    }

    function getPriority()
    {
        return $this->_priority;
    }

    function setPriority($priority)
    {
        $this->_priority = $priority;
    }

    function attach(&$observer)
    {
        if (!is_a($observer, 'Log_observer')) {
            return false;
        }

        $this->_listeners[$observer->_id] = &$observer;

        return true;
    }

    function detach($observer)
    {
        if (!is_a($observer, 'Log_observer') ||
            !isset($this->_listeners[$observer->_id])) {
            return false;
        }

        unset($this->_listeners[$observer->_id]);

        return true;
    }

    function _announce($event)
    {
        foreach ($this->_listeners as $id => $listener) {
            if ($event['priority'] <= $this->_listeners[$id]->_priority) {
                $this->_listeners[$id]->notify($event);
            }
        }
    }

    function isComposite()
    {
        return false;
    }

    function setIdent($ident)
    {
        $this->_ident = $ident;
    }

    function getIdent()
    {
        return $this->_ident;
    }
}
