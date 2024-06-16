<?php 
// update_last_activity.php


include("../Main/database.php");

session_start();

$query = "
UPDATE login_details 
SET last_activity = now(),
 logout = 1 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";
//update login_details database to show user is active.
$statement = $pdo->prepare($query);

$statement->execute();

 ?>