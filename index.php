<?php
include('Classes/database.php');
include('Classes/functions.php');
$bookmarks = new Bookmark();

if(isset($_POST['submit'])){
	//echo "<pre>".print_r($_POST,TRUE)."</pre>";	
	$bookmarks->add($_POST['name'],$_POST['url']);
}

if(startSession()){
	$loggedIn = true;
	$user = new User_Bookmark($_SESSION['userid']);
}else{
	$loggedIn = false;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>FFavourites &hearts;</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<div id="header" class="bodywrapper">

<?php
if($loggedIn){
	echo "<a href='authenticate/logout.php'>Logout</a>";
}else{
	echo "<a href='authenticate/login_form.php'>Login</a>";

}
?>
	<h1>&hearts; FFavourites</h1>
	<h2>Your FFavourite sites. &hearts;</h2>	
</div>

<!--
<form action="" method="post">
<fieldset>
<label for="b1">Name</label>
<input id="b1" type="text" name="name" />
<label for="b2">Address</label>
<input id="b2" type="text" name="url" />
<input type="submit" name="submit" value="Add Bookmark" />
</fieldset>
</form>
-->
<div class="bodywrapper">
<div class="box">
<h4>New &hearts;'s</h4>

<?php
$l = array();
foreach($bookmarks->query("SELECT * FROM bookmarks ORDER BY id DESC LIMIT 5") as $mark){
	$l[] .= '<a href="'.$mark['url'].'">'.$mark['title'].'</a>';
}
echo implode(" <br /> ",$l);
?>
</div>
<div class="box"><h4>Popular &hearts;'s</h4>

<?php
$l = array();
foreach($bookmarks->query("SELECT * FROM bookmarks ORDER BY favourites DESC LIMIT 5") as $mark){
	$l[] .= '<a href="'.$mark['url'].'">'.$mark['title'].'</a>';
}
echo implode(" <br /> ",$l);
?>
</div>


<?php
if($loggedIn):
echo "<div class='box'><h4>Your &hearts;'s</h4>";
$l = array();
foreach($user->read() as $mark){
	$l[] .= '<a href="'.$mark['url'].'">'.$mark['title'].'</a>';
}
echo implode(" <br /> ",$l);
echo "</div>";
endif;
?>

<!-- <a href="marks.php">Manage Your Bookmarks</a> -->
</div> <!-- //END BODY WRAPPER -->
</body>
</html>