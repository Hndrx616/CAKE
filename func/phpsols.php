<?php
//*******************************************************************
// @Author: Stephen Hilliard
// @Date: 7/13/2016
// @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// MySQLi and PDO connection aka phpsols
//*******************************************************************
$conn = new mysqli($hostname, $username, $password, 'phpsols');
$conn = dbConnect('read');
$conn = dbConnect('write');
$conn = dbConnect('read','pdo');
$conn = dbConnect('write','pdo');
try {
	$conn = new PDO("mysql:host=$hostname;dbname=phpsols", $username, $password);
} catch (PDOException $e) {
	echo $e->getMessage();
}
?>