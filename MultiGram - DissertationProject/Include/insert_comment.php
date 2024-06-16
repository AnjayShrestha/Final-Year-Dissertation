<?php 

// insert_chat.php


include('../Main/database.php');

session_start();
if (!empty($_POST['chat_message'])) {
	$data = array(
	':to_post_id' 		=> $_POST['to_post_id'],
	':from_user_id' 	=> $_SESSION['id'],
	':chat_message'		=> $_POST['chat_message'],
	
);
	//inserting data into comments database.
$query = "
INSERT INTO comments
( post_id, comment, commenter)
VALUES (:to_post_id, :chat_message,  :from_user_id)
";

//preparing the query
$statement = $pdo->prepare($query);

// executer the query.
if($statement->execute($data))
	{
		echo fetch_post_comment_history($_SESSION['id'], $_POST['to_post_id'], $pdo);
		
	}

}
else{
	echo fetch_post_comment_history($_SESSION['id'], $_POST['to_post_id'], $pdo);
}
	


 ?> 