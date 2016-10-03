<?php
//*******************************************************************
//Template Name: sqlite.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @sqlite.php
//*******************************************************************

class Log_sqlite extends Log
{
    /* Array containing the connection defaults */
    var $_options = array('mode'       => 0666,
                          'persistent' => false);

    /* Object holding the database handle. */
    var $_db = null;

    /**
     * @var boolean
     * @access private
     */
    var $_existingConnection = false;

    /**
     * @var string
     * @access private
     */
    var $_table = 'log_table';

    /**
     * @param string $name         The target SQL table.
     * @param string $ident        The identification field.
     * @param mixed  $conf         Can be an array of configuration options used
     * @param int    $level        Log messages up to and including this level.
     * @access public
     */
    function Log_sqlite($name, $ident = '', &$conf, $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_table = $name;
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);

        if (is_array($conf)) {
            foreach ($conf as $k => $opt) {
                $this->_options[$k] = $opt;
            }
        } else {
            $this->_db =& $conf;
            $this->_existingConnection = true;
        }
    }

    /**
     * @return boolean
     * @access public
     */
    function open()
    {
        if (is_resource($this->_db)) {
            $this->_opened = true;
            return $this->_createTable();
        } else {
            if (empty($this->_options['persistent'])) {
                $connectFunction = 'sqlite_open';
            } else {
                $connectFunction = 'sqlite_popen';
            }

            if ($this->_db = $connectFunction($this->_options['filename'],
                                              (int)$this->_options['mode'],
                                              $error)) {
                $this->_opened = true;
                return $this->_createTable();
            }
        }

        return $this->_opened;
    }

    /**
     * @return boolean
     * @access public
     */
    function close()
    {
        if ($this->_existingConnection) {
            return false;
        }

        if ($this->_opened) {
            $this->_opened = false;
            sqlite_close($this->_db);
        }

        return ($this->_opened === false);
    }

    /**
     * @param mixed
     * @param string
     * @return boolean
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

        /* If the connection isn't open and can't be opened, return failure. */
        if (!$this->_opened && !$this->open()) {
            return false;
        }

        // Extract the string representation of the message.
        $message = $this->_extractMessage($message);

        // Build the SQL query for this log entry insertion.
        $q = sprintf('INSERT INTO [%s] (logtime, ident, priority, message) ' .
                     "VALUES ('%s', '%s', %d, '%s')",
                     $this->_table,
                     strftime('%Y-%m-%d %H:%M:%S', time()),
                     sqlite_escape_string($this->_ident),
                     $priority,
                     sqlite_escape_string($message));
        if (!($res = @sqlite_unbuffered_query($this->_db, $q))) {
            return false;
        }
        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }

    /**
     * @return boolean  True on success or false on failure.
     * @access private
     */
    function _createTable()
    {
        $q = "SELECT name FROM sqlite_master WHERE name='" . $this->_table .
             "' AND type='table'";

        $res = sqlite_query($this->_db, $q);

        if (sqlite_num_rows($res) == 0) {
            $q = 'CREATE TABLE [' . $this->_table . '] (' .
                 'id INTEGER PRIMARY KEY NOT NULL, ' .
                 'logtime NOT NULL, ' .
                 'ident CHAR(16) NOT NULL, ' .
                 'priority INT NOT NULL, ' .
                 'message)';

            if (!($res = sqlite_unbuffered_query($this->_db, $q))) {
                return false;
            }
        }

        return true;
    }
}
