<?php

$id = $_GET['id'];

include('Classes/database.php');
$db = new SH_Database();
$bookmarks = new Bookmark($db);

$bookmarks->delete($id);
header('Location: http://shiemstr.dev/bookmarks/marks.php');
?>



