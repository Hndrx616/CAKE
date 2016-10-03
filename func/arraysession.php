<?php  
//*******************************************************************
// @Author: Stephen Hilliard
// @Date: 8/18/2016
// @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// Accessing Session Variables
//*******************************************************************
session_start();
?>
<html>
<head>
<title>Acessing Session Variables</title>
</head>
<body>
<h1>Content Page</h1>
<?php
if (isset($_SESSION["products"])) {
	echo "<strong>Your cart:</strong><ol>";
	foreach (unserialize($_SESSION["products"]) as $p) {
		echo "<li>".$p."</li>";
	}
	echo "</ol>";
}
?>
<p> <a href="arraysession.php">return to product choice page</a></p>
</body>
</html>