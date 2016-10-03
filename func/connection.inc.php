<?php
//*******************************************************************
// @Author: Stephen Hilliard
// @Date: 7/13/2016
// @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// MySQL Connection with PHP and SQL
//*******************************************************************
function dbConnect($usertype, $connectionType = 'mysqli') {
	$host = 'localhost';
	$db = 'phpsols';
	if ($usertype == 'read') {
		$user = 'psread';
		$pwd = 'K1y0mi$u';
	} elseif ($usertype == 'write') {
		$user = 'pswrite';
		$pwd = '0Ch@Nom1$u';
	} else {
		exit('Unrecognized connection type');
	}
	if ($connectionType == 'mysqli') {
		return new mysqli($host, $user, $pwd, $db) or die ('Cannot open database');
	} else {
		try {
			return new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
		} catch (PDOException $e) {
			echo 'Cannot connect to database';
			exit;
		}
	}
}
?>