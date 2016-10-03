<?php
//*******************************************************************
//Template Name: cake-config-dist.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake-config-dist
//*******************************************************************/

/**CAKE Configuration*/
 
/**
 * DATABASE CONFIGURATION
 * Connection info for databases that will be used by CAKE. 
 */

define('CAKE_DB_TYPE', 'yourdbtypegoeshere'); // options: mysql
define('CAKE_DB_NAME', 'yourdbnamegoeshere'); // name of the database
define('CAKE_DB_HOST', 'yourdbhostgoeshere'); // host name of the server housing the database
define('CAKE_DB_USER', 'yourdbusergoeshere'); // database user
define('CAKE_DB_PASSWORD', 'yourdbpasswordgoeshere'); // database user's password

/**
 * AUTHENTICATION KEYS AND SALTS
 * Change these to different unique phrases.
 */
define('CAKE_NONCE_KEY', 'yournoncekeygoeshere');  
define('CAKE_NONCE_SALT', 'yournoncesaltgoeshere');
define('CAKE_AUTH_KEY', 'yourauthkeygoeshere');
define('CAKE_AUTH_SALT', 'yourauthsaltgoeshere');

/** 
 * PUBLIC URL
 * Define the URL of CAKE's base directory e.g. http://www.domain.com/path/to/cake/ 
 * Don't forget the slash at the end.
 */
 
define('CAKE_PUBLIC_URL', 'http://domain/path/to/cake/');  

/** 
 * CAKE ERROR HANDLER
 * Overide CAKE error handler. This should be done through the admin GUI, but 
 * can be handy during install or development. 
 * 
 * Choices are: 
 * 'production' - will log only critical errors to a log file.
 * 'development' - logs al sorts of useful debug to log file.
 */

//define('CAKE_ERROR_HANDLER', 'development');

/** 
 * LOG PHP ERRORS
 * Log all php errors to CAKE's error log file. Only do this to debug.
 */

//define('CAKE_LOG_PHP_ERRORS', true);
 
/** 
 * OBJECT CACHING
 * Override setting to cache objects. Caching will increase performance. 
 */

//define('CAKE_CACHE_OBJECTS', true);

/**
 * CONFIGURATION ID
 * Override to load an alternative user configuration
 */
 
//define('CAKE_CONFIGURATION_ID', '1');

?>