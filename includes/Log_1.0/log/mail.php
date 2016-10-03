<?php
/**
//*******************************************************************
//Template Name: mail.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package Log
// @mail.php
//*******************************************************************/
class Log_mail extends Log
{
    /**
     * String holding the recipients' email addresses.
     * @var string
     * @access private
     */
    var $_recipients = '';

    /**
     * String holding the sender's email address.
     * @var string
     * @access private
     */
    var $_from = '';

    /**
     * String holding the email's subject.
     * @var string
     * @access private
     */
    var $_subject = '[Log_mail] Log message';

    /**
     * String holding an optional preamble for the log messages.
     * @var string
     * @access private
     */
    var $_preamble = '';

    /**
     * String containing the format of a log line.
     * @var string
     * @access private
     */
    var $_lineFormat = '%1$s %2$s [%3$s] %4$s';

    /**
     * String containing the timestamp format.
     * @var string
     * @access private
     */
    var $_timeFormat = '%b %d %H:%M:%S';

    /**
     * String holding the mail message body.
     * @var string
     * @access private
     */
    var $_message = '';

    /**
     * Flag used to indicated that log lines have been written to the message
     * @var boolean
     * @access private
     */
    var $_shouldSend = false;

    /**
     * String holding the backend name of PEAR::Mail
     * @var string
     * @access private
     */
    var $_mailBackend = '';

    /**
     * Array holding the params for PEAR::Mail
     * @var array
     * @access private
     */
    var $_mailParams = array();

    /**
     * Constructs a new Log_mail object.
     * @param string $name      The message's recipients.
     * @param string $ident     The identity string.
     * @param array  $conf      The configuration array.
     * @param int    $level     Log messages up to and including this level.
     * @access public
     */
    function Log_mail($name, $ident = '', $conf = array(),
                      $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_recipients = $name;
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);

        if (!empty($conf['from'])) {
            $this->_from = $conf['from'];
        } else {
            $this->_from = ini_get('sendmail_from');
        }

        if (!empty($conf['subject'])) {
            $this->_subject = $conf['subject'];
        }

        if (!empty($conf['preamble'])) {
            $this->_preamble = $conf['preamble'];
        }

        if (!empty($conf['lineFormat'])) {
            $this->_lineFormat = str_replace(array_keys($this->_formatMap),
                                             array_values($this->_formatMap),
                                             $conf['lineFormat']);
        }

        if (!empty($conf['timeFormat'])) {
            $this->_timeFormat = $conf['timeFormat'];
        }

        if (!empty($conf['mailBackend'])) {
            $this->_mailBackend = $conf['mailBackend'];
        }

        if (!empty($conf['mailParams'])) {
            $this->_mailParams = $conf['mailParams'];
        }

        register_shutdown_function(array(&$this, '_Log_mail'));
    }

    /**
     * Destructor. Calls close().
     * @access private
     */
    function _Log_mail()
    {
        $this->close();
    }

    /**
     * Starts a new mail message.
     * @access public
     */
    function open()
    {
        if (!$this->_opened) {
            if (!empty($this->_preamble)) {
                $this->_message = $this->_preamble . "\r\n\r\n";
            }
            $this->_opened = true;
            $_shouldSend = false;
        }

        return $this->_opened;
    }

    /**
     * Closes the message, if it is open, and sends the mail.
     * @access public
     */
    function close()
    {
        if ($this->_opened) {
            if ($this->_shouldSend && !empty($this->_message)) {
                if ($this->_mailBackend === '') {  // use mail()
                    $headers = "From: $this->_from\r\n";
                    $headers .= 'User-Agent: PEAR Log Package';
                    if (mail($this->_recipients, $this->_subject,
                             $this->_message, $headers) == false) {
                        return false;
                    }
                } else {  // use PEAR::Mail
                    include_once 'Mail.php';
                    $headers = array('From' => $this->_from,
                                     'To' => $this->_recipients,
                                     'User-Agent' => 'PEAR Log Package',
                                     'Subject' => $this->_subject);
                    $mailer = &Mail::factory($this->_mailBackend,
                                             $this->_mailParams);
                    $res = $mailer->send($this->_recipients, $headers,
                                         $this->_message);
                    if (PEAR::isError($res)) {
                        return false;
                    }
                }

                /* Clear the message string now that the email has been sent. */
                $this->_message = '';
                $this->_shouldSend = false;
            }
            $this->_opened = false;
        }

        return ($this->_opened === false);
    }

    /**
     * @access public
     * @since Log 1.8.2
     */
    function flush()
    {
        /*
         * It's sufficient to simply call close() to flush the output.
         */
        return $this->close();
    }

    /**
     * Writes $message to the currently open mail message.
     * Calls open(), if necessary.
     * @param mixed  $message  String or object containing the message to log.
     * @param string $priority The priority of the message.
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

        if (!$this->_opened && !$this->open()) {
            return false;
        }

        $message = $this->_extractMessage($message);

        $this->_message .= $this->_format($this->_lineFormat,
                                          strftime($this->_timeFormat),
                                          $priority, $message) . "\r\n";
        $this->_shouldSend = true;

        /* Notify observers about this log message. */
        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }
}
