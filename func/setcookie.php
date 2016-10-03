<?php
//*******************************************************************
// @Author: Stephen Hilliard
// @Date: 7/13/2016
// @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// Set Value for Cookie Interaction
//*******************************************************************
HTTP/1.1 200 OK
Date:
Server: Apache/2.2.8(Unix) PHP/5.2.5
X-Powered-By: PHP/5.2.5
Set-Cookie: vegetable=artichoke; path=/; domain=yourdomain.com
Connection: close
Content-Type: text/html/xml

echo $_SERVER["HTTP_COOKIE"];	// will print "vegtable=artichoke"

echo get env("HTTP_COOKIE");	// will print "vegetable=artichoke"

echo $_COOKIE["vegetable"];		// will print "artichoke"

header ("Set-Cookie: vegetable=artichoke; expires= Mon, 01-Jan-17 14:39:58 GMT; path=/; domain=yourdomain.com");
?>

<?php
setcookie("vegetable", "artichoke", time()+3600, "/", ".yourdomain.com", 0);

if (isset($_COOKIE["vegetable"])) {
	echo "<p>Hello Again, you have chosen:	".$_COOKIE["vegtable"].".</p>";
} else {
	echo "<p>Hello you. This may be your first visit.</p>";
}
?>
<?php //Startingor a Resuming a Session
session_start();
echo "<p>Your session ID is ".seesion_id().".</p>";
?>
<?php //Storing Variables in a Session
session_start();
$_SESSION["product1"] = "Sonic Screwdriver";
$_SESSION["product2"] = "Hal 2000";
echo "The products have been registered.";
?>
<?php//Accessing Stored Session Variables
session_start();
echo "Your chosen products are:";
echo "<ul>";
echo "<li>".$_SESSION["product1"]."</li>";
echo "<li>".$_SESSION["product2"]."</li>";
echo "</ul>";
?>
<?php//Adding an Array Variable to a Session Variable
session_start();
?>
<html>
<head>
<title>Storing an array with a session</title>
</head>
<body>
<h1>Product Choice Page</h1>
<?php
if (isset($_POST["form_products"])) {
	if (!empty($_SESSION["products"])) {
		$products = array_unique(
		array_merge(unserialize($_SESSION["products"]),
		$_POST["form_products"]));
		$_SESSION["products"] = serialize($products);
	} else {
		$_SESSION["products"] = serialize($_POST["form_products"]);
	}
	echo "<p>Your Pproducts have been registered!</p>";
}
?>
<form method="POST" action="<?php echo $_SERVER["PHP_SElF"]; ?>">
<P><strong>Select some products:</strong></p><br>
<select name="form_products[]" multiple="multiple" size="3">
<option value="Sonic Screwdriver">Sonic Screwdriver</option>
<option value="Hal 2000">Hal 2000</option>
<option value="Tardis">Tardis</option>
<option value="ORAC">ORAC</option>
<option value="Transporter Bracelet">Transporter Bracelet</option>
</select>
<P><input type="submit" value="choose" /></p>
</form>
<p><a href="session1.php">go to content page</a></p>
</body>
</html>