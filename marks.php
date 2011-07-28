<?php
include('Classes/database.php');
include('Classes/Functions.php');
startSession();
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
<table>
<thead>
</thead>
<tbody>
<?php
foreach($bookmarks->read() as $mark){
	echo '<tr><td><a href="action.php?action=like&id='.$mark['id'].'">&hearts;</a></td><td>'.$mark['name'].'</td><td><a href="'.$mark['url'].'">'.substr($mark['url'],7).'</a></td><td><a href="action.php?action=delete&id='.$mark['id'].'">delete</a></td></tr>';
}
?>
</tbody>
</table>
<a href="javascript:(function(){document.body.appendChild(document.createElement('script')).src='http://test.dev/bookmarks/bookmarklet.js';})();">Bookmarklet</a>&nbsp;&larr;Drag this to your bookmarks bar to add pages with one click!<br />
<a href="index.php">Home</a>
</body>
</html>