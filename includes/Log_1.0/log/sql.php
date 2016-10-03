<?php
//*******************************************************************
//Template Name: sql.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @sql.php
//*******************************************************************
class Log_sql extends Log
{
    /**
     * Variable containing the DSN information.
     * @var mixed
     * @access private
     */
    var $_dsn = '';

    /**
     * String containing the SQL insertion statement.
     * @var string
     * @access private
     */
    var $_sql = '';

    /**
     * Array containing our set of DB configuration options.
     * @var array
     * @access private
     */
    var $_options = array('persistent' => true);

    /**
     * @var object
     * @access private
     */
    var $_db = null;

    /**
     * @var resource
     * @access private
     */
    var $_statement = null;

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
     * @var string
     * @access private
     */
    var $_sequence = 'log_id';

    /**
     * @var integer
     * @access private
     */
    var $_identLimit = 16;


    /**
     * @param string $name         The target SQL table.
     * @param string $ident        The identification field.
     * @param array $conf          The connection configuration array.
     * @param int $level           Log messages up to and including this level.
     * @access public
     */
    function Log_sql($name, $ident = '', $conf = array(),
                     $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_table = $name;
        $this->_mask = Log::UPTO($level);

        /* Now that we have a table name, assign our SQL statement. */
        if (!empty($conf['sql'])) {
            $this->_sql = $conf['sql'];
        } else {
            $this->_sql = 'INSERT INTO ' . $this->_table .
                          ' (id, logtime, ident, priority, message)' .
                          ' VALUES(?, CURRENT_TIMESTAMP, ?, ?, ?)';
        }

        /* If an options array was provided, use it. */
        if (isset($conf['options']) && is_array($conf['options'])) {
            $this->_options = $conf['options'];
        }

        /* If a specific sequence name was provided, use it. */
        if (!empty($conf['sequence'])) {
            $this->_sequence = $conf['sequence'];
        }

        /* If a specific sequence name was provided, use it. */
        if (isset($conf['identLimit'])) {
            $this->_identLimit = $conf['identLimit'];
        }

        /* Now that the ident limit is confirmed, set the ident string. */
        $this->setIdent($ident);

        /* If an existing database connection was provided, use it. */
        if (isset($conf['db'])) {
            $this->_db = &$conf['db'];
            $this->_existingConnection = true;
            $this->_opened = true;
        } else {
            $this->_dsn = $conf['dsn'];
        }
    }

    /**
     * Opens a connection to the database.
     * @return boolean   True on success, false on failure.
     * @access public
     */
    function open()
    {
        if (!$this->_opened) {
            /* Use the DSN and options to create a database connection. */
            $this->_db = &DB::connect($this->_dsn, $this->_options);
            if (DB::isError($this->_db)) {
                return false;
            }

            /* Create a prepared statement for repeated use in log(). */
            if (!$this->_prepareStatement()) {
                return false;
            }

            /* We now consider out connection open. */
            $this->_opened = true;
        }

        return $this->_opened;
    }

    /**
     * Closes the connection to the database.
     * @return boolean   True on success, false on failure.
     * @access public
     */
    function close()
    {
        if ($this->_opened && !$this->_existingConnection) {
            $this->_opened = false;
            $this->_db->freePrepared($this->_statement);
            return $this->_db->disconnect();
        }

        return ($this->_opened === false);
    }

    /**
     * @param string    $ident      The new identification string.
     * @access  public
     * @since   Log 1.8.5
     */
    function setIdent($ident)
    {
        $this->_ident = substr($ident, 0, $this->_identLimit);
    }

    /**
     * @param mixed  $message  String or object containing the message to log.
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

        /* If we don't already have our statement object yet, create it. */
        if (!is_object($this->_statement) && !$this->_prepareStatement()) {
            return false;
        }

        /* Extract the string representation of the message. */
        $message = $this->_extractMessage($message);

        /* Build our set of values for this log entry. */
        $id = $this->_db->nextId($this->_sequence);
        $values = array($id, $this->_ident, $priority, $message);

        /* Execute the SQL query for this log entry insertion. */
        $result =& $this->_db->execute($this->_statement, $values);
        if (DB::isError($result)) {
            return false;
        }

        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }

    /**
     * Prepare the SQL insertion statement.
     * @return boolean  True if the statement was successfully created.
     * @access  private
     * @since   Log 1.9.1
     */
    function _prepareStatement()
    {
        $this->_statement = $this->_db->prepare($this->_sql);

        /* Return success if we didn't generate an error. */
        return (DB::isError($this->_statement) === false);
    }
}
