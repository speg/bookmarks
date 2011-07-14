<?php
include('Classes/database.php');
$bookmarks = new Bookmark();

if(isset($_POST['submit'])){
	//echo "<pre>".print_r($_POST,TRUE)."</pre>";	
	$bookmarks->add($_POST['name'],$_POST['url']);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Bookmarkly</title>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>

<h1>Bookmarkly</h1>
<h3>Share your bookmarks with the world!</h3>

<form action="" method="post">
<fieldset>
<label for="b1">Name</label>
<input id="b1" type="text" name="name" />
<label for="b2">Address</label>
<input id="b2" type="text" name="url" />
<input type="submit" name="submit" value="Add Bookmark" />
</fieldset>
</form>
<h4>Latest Bookmarks</h4>
<table>
<thead>
</thead>
<tbody>
<?php
foreach($bookmarks->read() as $mark){
	echo '<tr><td>'.$mark['name'].'</td><td><a href="'.$mark['url'].'">'.substr($mark['url'],7).'</a></td></tr>';
}
?>
</tbody>
</table>
<a href="marks.php">Manage Your Bookmarks</a>
</body>
</html>