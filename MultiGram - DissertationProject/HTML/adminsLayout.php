<?php
// $pdo = new PDO('mysql:dbname=cars;host=127.0.0.1', 'root', '');//connecting to database.

	require '../main/databaseTable.php';//having dbtable.php file from main.
	require '../main/runTemplate.php';//having runTemplate.php file from main.

	if(!isset($_GET['Admin'])){
		$_GET['Admin'] = 'adminIndex';//getting the name of file.

	}

	require ('../Admins/'.$_GET['Admin'].'.php');
	$templatesVar = [
		'title' => $title,//title of page.
		'content' => $content//content of page.
	];

	echo runTemplate('../AdminTemplates/adminFrame.php',$templatesVar);//using function runTemplate to load template.
?>
