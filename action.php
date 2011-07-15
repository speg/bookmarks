<?php

$action = $_REQUEST['action'];

include('Classes/database.php');
$bookmarks = new Bookmark();

switch($action){
	case 'delete':
		$bookmarks->delete($_REQUEST['id']);
		header('Location: http://test.dev/bookmarks/marks.php');
		break;
	case 'like':
		$bookmarks->like($_REQUEST['id']);
		header('Location: http://test.dev/bookmarks/marks.php');
		break;
	case 'add':
		$bookmarks->add($_REQUEST['name'],$_REQUEST['url']);
		break;
	default:
		echo "false";
}
echo "true";
?>