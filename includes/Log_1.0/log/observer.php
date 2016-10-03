<?php
//*******************************************************************
//Template Name: observer.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @observer.php
//*******************************************************************
class Log_observer
{
    /**
     * @var integer
     * @access private
     */
    var $_id = 0;

    /**
     * @var string
     * @access private
     */
    var $_priority = PEAR_LOG_INFO;

    /**
     * Creates a new basic Log_observer instance.
     *
     * @param integer   $priority   The highest priority at which to receive
     *                              log event notifications.
     * @access public
     */
    function Log_observer($priority = PEAR_LOG_INFO)
    {
        $this->_id = md5(microtime());
        $this->_priority = $priority;
    }

    /**
     * @param string    $type       The type of concreate Log_observer subclass
     *                              to return.
     * @param integer   $priority   The highest priority at which to receive
     *                              log event notifications.
     * @param array     $conf       Optional associative array of additional
     *                              configuration values.
     * @return object               The newly created concrete Log_observer
     *                              instance, or null on an error.
     */
    function &factory($type, $priority = PEAR_LOG_INFO, $conf = array())
    {
        $type = strtolower($type);
        $class = 'Log_observer_' . $type;

        /* If the desired class already exists return a new instance.*/
        if (class_exists($class)) {
            $object = new $class($priority, $conf);
            return $object;
        }

        /* Support both the new-style and old-style file naming conventions. */
        $newstyle = true;
        $classfile = dirname(__FILE__) . '/observer_' . $type . '.php';

        if (!file_exists($classfile)) {
            $classfile = 'Log/' . $type . '.php';
            $newstyle = false;
        }

        /*
         * Attempt to include our version of the named class, but don't treat
         * a failure as fatal.
         */
        @include_once $classfile;

        /* If the class exists, return a new instance of it. */
        if (class_exists($class)) {
            /* Support both new-style and old-style construction. */
            if ($newstyle) {
                $object = new $class($priority, $conf);
            } else {
                $object = new $class($priority);
            }
            return $object;
        }

        $null = null;
        return $null;
    }

    /**
     * @param array     $event      A hash describing the log event.
     */
    function notify($event)
    {
        print_r($event);
    }
}
