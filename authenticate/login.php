<?php

$username = $_POST['username'];
$password = $_POST['password'];
//connect to the database here
$dbhost = 'localhost';
$dbname = 'test_project';
$dbuser = 'server_bot';
$dbpass = 'bot_me'; //not really
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $conn);
//

$username = mysql_real_escape_string($username);
$query = "SELECT id,password, salt
        FROM users
        WHERE username = '$username';";
$result = mysql_query($query);
if(mysql_num_rows($result) < 1) //no such user exists
{
    header('Location: login_form.php');
}
$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = hash('whirlpool', $userData['salt'] . $password );
//$hash = $userData['salt'].$password;
if($hash != $userData['password']) //incorrect password
{
    header('Location: login_form.php');
    //echo 'Incorrect Password'."<pre>$hash\n\n".$userData['password']."</pre>";
    die;
}
session_start();
session_regenerate_id (); //this is a security measure
$_SESSION['valid'] = 1;
$_SESSION['userid'] = $userData['id'];

header('Location: /bookmarks/');