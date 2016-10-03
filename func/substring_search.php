<?php
//*******************************************************************
//Template Name: SubString_Search.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************
if (!defined('GIG_CATALYSTKEY_DOCUMENT_ROOT')) {
    define('GIG_CATALYSTKEY_DOCUMENT_ROOT', dirname(__FILE__) == '/' ? '' : dirname(__FILE__));
}
if (file_exists(GIG_CATALYSTKEY_DOCUMENT_ROOT . '/substring_lib_api.php')) {
    require_once GIG_CATALYSTKEY_DOCUMENT_ROOT . '/substring_lib_api.php';
}
if (!defined('GIG_CATALYSTKEY_INCLUDE_PATH')) {
    define('GIG_CATALYSTKEY_INCLUDE_PATH', GIG_CATALYSTKEY_DOCUMENT_ROOT);
}

require_once GIG_CATALYSTKEY_INCLUDE_PATH . 'api/lib/bootstrap.php';
require_once GIG_CATALYSTKEY_INCLUDE_PATH . 'api/lib/dispatch.php';
?>
<?php
//Longest Common Substring
public function LongestCommonSubstring($maxSubstr) {
	$str1 = ("", $str1Len);
	$str2 = ("", $str2Len);
	$value;
	$maxSubstr = LongestCommonSubstring($str1, $str2, $value);
}

//Longest Repeated Substring
public function LongestRepeatedSubstring($value) {
	$data = array("", $a, "", $b);
	$value = LongestRepeatedSubstring($data);
}

//Brute Force Subtring
public function bfSub_String($result) {
	$result = bfSub_String($pattern, $subject);
}
?>