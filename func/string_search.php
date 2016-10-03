<?php
//*******************************************************************
//Template Name: String_Search.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************
if (!defined('GIG_CATALYSTKEY_DOCUMENT_ROOT')) {
    define('GIG_CATALYSTKEY_DOCUMENT_ROOT', dirname(__FILE__) == '/' ? '' : dirname(__FILE__));
}
if (file_exists(GIG_CATALYSTKEY_DOCUMENT_ROOT . '/string_lib_api.php')) {
    require_once GIG_CATALYSTKEY_DOCUMENT_ROOT . '/string_lib_api.php';
}
if (!defined('GIG_CATALYSTKEY_INCLUDE_PATH')) {
    define('GIG_CATALYSTKEY_INCLUDE_PATH', GIG_CATALYSTKEY_DOCUMENT_ROOT);
}

require_once GIG_CATALYSTKEY_INCLUDE_PATH . 'api/lib/bootstrap.php';
require_once GIG_CATALYSTKEY_INCLUDE_PATH . 'api/lib/dispatch.php';
?>
<?php
//Aho-Corasick
public function FindAllStates($states) {
	$keywords = array( $Out, $FF, $GF, $MaxStates, $MaxChars );
	$text = ('_', $lowestChar, $highestChar);
	$states = FindAllStates($text, $keywords);
}

//Bitap
public function bitapSearchString($index) {
	$index = bitapSearchString($pattern, $text);
}

//Boyer-Moore
public function bmSearchString($value) {
	$data = array('_', $str, $size, &$badchar);
	$value = bmSearchString($data, $pat);
}

//Brute Force
public function bfString($result) {
	$result = bfString($pattern, $subject);
}

//Finite-State Automaton
public function fsaSearchString($value) {
	$data = array('_', $retVal, $M, $N, $state);
	$value = fsaSearchString($data, $pat);
}

//Fuzzy Bitap
public function fbitapSearchString($index) {
	$index = fbitapSearchString($text, $pattern, $k, 1);
}

//Knuth–Morris–Pratt
public function kmpSearchString($value) {
	$data = array('_', $retVal, , $M, $N, $i, $j, $lps);
	$value = kmpSearchString($data, $str, $pat);
}

//Levenshtein Distance
public function LevenshteinDistance($result) {
	$result = LevenshteinDistance($s1len, $s2len);
}

//Morris Pratt
public function MorrisPratt($result) {
	$result = MorrisPratt($text, $pattern);
}

//Naive String Search
public function naivSearchString($value) {
	$data = array('_', $retVal, $M, $N);
	$value = naivSearchString($data, $str, $pat);
}

//Rabin–Karp
public function rkSearchString($value) {
	$data = array('_', $retVal, $siga, $sigb, $Q, $D, $BLen, $ALen);
	$value = rkSearchString($data, $A, $B);
}

//Sørensen–Dice Coefficient
public function DiceMatch($result) {
	$result = DiceMatch($string1, $string2);
}
?>
