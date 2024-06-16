<?php 
	include("../Main/database.php");
	session_start();//session start.
	$query = 
	"INSERT INTO login_details
	 				(user_id, last_activity, logout) 
	 				VALUES ('".$_SESSION['id']."', now(), 0)
	 				";

	$statement = $pdo->prepare($query);

	$statement->execute();

	session_unset();//session unset.
	session_destroy();//session destroy.
	header('refresh: 0.1; url=../HTML/userLayout.php');
	?>
