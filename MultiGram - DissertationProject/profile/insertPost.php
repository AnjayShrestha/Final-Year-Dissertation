<?php 
// insertPost.php

include('../Main/database.php');

session_start();

if ($_POST["action"] == "insert_data") 
{
	$data = array(
		':user_id' 			=> $_SESSION["id"],
		':post_text'		=> $_POST['post_text'],
		':status'			=> 'POST'
	);

	$query = "
	INSERT INTO post
	(user_id, textPost, postType)
	VALUES (:user_id, :post_text, :status)
	";

	$statement = $pdo->prepare($query);
	if ($statement->execute($data)) 
	{
		echo fetch_post_history($pdo);
	}

}
if ($_POST["action"] == "insert_video") 
{
	$data = array(
		':user_id' 			=> $_SESSION["id"],
		':post_text'		=> $_POST['post_text'],
		':status'			=> 'VIDEO'
	);

	$query = "
	INSERT INTO post
	(user_id, textPost, postType)
	VALUES (:user_id, :post_text, :status)
	";

	$statement = $pdo->prepare($query);
	if ($statement->execute($data)) 
	{
		echo fetch_post_history($pdo);
	}

}

if ($_POST["action"] == "insert_profile") 
{
	$data = array(
		':user_id' 			=> 	$_SESSION["id"],
		':post_text'		=> $_POST['post_text'],
		':status'			=> 'Profile Picture'
	);

	$query = "
	INSERT INTO post
	(user_id, textPost, postType)
	VALUES (:user_id, :post_text, :status)
	";

	$statement = $pdo->prepare($query);
	if ($statement->execute($data)) 
	{
		echo fetch_post_history($pdo);
	}

}

if ($_POST['action'] == "fetch_data") 
{
		echo fetch_post_history($pdo);
}




 ?>