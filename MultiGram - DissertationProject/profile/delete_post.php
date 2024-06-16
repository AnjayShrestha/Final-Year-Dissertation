<?php

//delete post.php

include('../Main/database.php');

session_start();
 if($_POST['action'] == 'delete')
 {  
 	$id = $_POST['post_id'];
  $query = "
 	DELETE FROM post WHERE post_Id = '$id' AND user_Id = '".$_SESSION['id']."'
  ";
  $statement = $pdo->prepare($query);
  if($statement->execute())
  {
   echo 'post deleted.';
  }
 }
