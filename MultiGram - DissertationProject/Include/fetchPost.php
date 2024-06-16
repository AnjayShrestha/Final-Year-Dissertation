<?php 

include('../Main/database.php');

session_start();

if ($_POST['action'] == "fetch_data") 
{
		echo fetch_all_post_story($pdo);
}
 ?>