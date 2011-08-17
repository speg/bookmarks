<?php
//retrieve our data from POST
$username = $_POST['username'];
$pass1 = $_POST['password'];
$pass2 = $_POST['pass2'];
if($pass1 != $pass2)
    header('Location: register_form.php');
if(strlen($username) > 64)
    header('Location: register_form.php');
    
function createSalt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 8);
}
$salt = createSalt();
$hash = hash('whirlpool', $salt . $pass1);
//$hash = $salt.$pass1;

$dbhost = 'localhost';
$dbname = 'ffavourites';
$dbuser = 'root';
$dbpass = 'root'; //not really
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $conn);
//sanitize username
$username = mysql_real_escape_string($username);
$query = "INSERT INTO users ( username, password, salt )
        VALUES ( '$username' , '$hash' , '$salt' );";
mysql_query($query);
mysql_close();
header('Location: login_form.php');

