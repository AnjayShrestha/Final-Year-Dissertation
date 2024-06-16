<?php
// $pdo = new PDO('mysql:dbname=Dissertation;host=127.0.0.1', 'root', '');

	require '../Main/database1.php';//having dbtable.php file from main.
	require '../Main/databaseTable.php';//having dbtable.php file from main.
	require '../Main/runTemplate.php';//having runTemplate.php file from main.

	if(!isset($_GET['user'])){
		$_GET['user'] = 'userIndex';//getting the name of file.
	}

	require ('../Users/'.$_GET['user'].'.php');
	$templatesVar = [
		'title' => $title,//title of page.
		'content' => $content//content of page.
	];

	echo runTemplate('../UsersTemplates/userFrame.php', $templatesVar);//using function runTemplate to load template.
?>
