<?php 

// update_is_type_status.php


include("../Main/database.php");

session_start();

$query = "
	UPDATE login_details
	SET is_type = '".$_POST["is_type"]."'
	WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";
//updating login details to show a user is active.
$statement = $pdo->prepare($query);

$statement->execute();




 ?>