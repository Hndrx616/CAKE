<?php
//*******************************************************************
//Template Name: cake_env.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_env
//*******************************************************************/

if (!defined('CAKE_PATH')) {
	define('CAKE_PATH', dirname(__FILE__));
}
define('CAKE_DIR', CAKE_PATH . '/');
define('CAKE_MODULES_DIR', CAKE_DIR.'modules/');
define('CAKE_BASE_DIR', CAKE_PATH); // depricated
define('CAKE_BASE_CLASSES_DIR', CAKE_DIR); //depricated
define('CAKE_BASE_MODULE_DIR', CAKE_DIR.'modules/base/');
define('CAKE_BASE_CLASS_DIR', CAKE_BASE_MODULE_DIR.'classes/');
define('CAKE_INCLUDE_DIR', CAKE_DIR.'includes/');
define('CAKE_PEARLOG_DIR', CAKE_INCLUDE_DIR.'Log-1.12.7');
define('CAKE_UAPARSER_DIR', CAKE_INCLUDE_DIR.'ua-parser-2.1.1');
define('CAKE_UAPARSER_LIB', CAKE_UAPARSER_DIR.'/uaparser.php');
define('CAKE_PHPMAILER_DIR', CAKE_INCLUDE_DIR.'PHPMailer_5.2.0/');
define('CAKE_HTTPCLIENT_DIR', CAKE_INCLUDE_DIR.'httpclient-2009-09-02/');
define('CAKE_PLUGINS_DIR', CAKE_DIR.'plugins'); //depricated
define('CAKE_PLUGIN_DIR', CAKE_DIR.'plugins/');
define('CAKE_CONF_DIR', CAKE_DIR.'conf/');
define('CAKE_THEMES_DIR', CAKE_DIR.'themes/');
define('CAKE_VERSION', '1.6.0');

?>