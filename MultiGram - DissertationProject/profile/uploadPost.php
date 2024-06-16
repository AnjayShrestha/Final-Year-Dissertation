<?php 
// uploadPost.php

include('../Main/database.php');
session_start();

$id = $_SESSION['id'];

$query = "SELECT * FROM users WHERE user_id ='$id'";
$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row){

if(!empty($_FILES)) 
{
	if (is_uploaded_file($_FILES['uploadFile']['tmp_name'])) 
	{
		$_source_path = $_FILES['uploadFile']['tmp_name'];
		$target_path  = '../Datas/'.$row['emailAddress'].'/files/'. $_FILES['uploadFile']['name'];
		if (move_uploaded_file($_source_path, $target_path)) 
		{
			echo '<img src="'.$target_path.'" class="img-thumbnail"  width="600">';
		}
	}
}
}

 ?>
