<?php
include('Classes/database.php');
$bookmarks = new Bookmark();

//this page will show you all your bookmarks and let you manage them.
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Your Bookmarks</title>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<h2>Your Marks</h2>
<thead>
</thead>
<table>
<tbody>
<?php
foreach($bookmarks->read() as $mark){
	echo '<tr><td>'.$mark['name'].'</td><td><a href="'.$mark['url'].'">'.substr($mark['url'],7).'</a></td><td><a href="delete.php?id='.$mark['id'].'">delete</a></td></tr>';
}
?>
</tbody>
</table>

</body>
</html>