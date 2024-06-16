<?php

//action.php

include('../Main/database.php');

session_start();
//to like the page.
 if($_POST['action'] == 'like')
 {
 
  $query = "
  INSERT INTO likes 
  (post_id, user_id) 
  VALUES ('".$_POST["post_id"]."', '".$_SESSION["id"]."')
  ";
  $statement = $pdo->prepare($query);
  if($statement->execute())
  {
   $sub_query = "
   UPDATE post SET liked = liked + 1 WHERE post_Id = '".$_POST["post_id"]."'
   ";
   $statement = $pdo->prepare($sub_query);
   $statement->execute();
  }
 }


//to unlike the post.
 if($_POST['action'] == 'unlike')
 {
  $query = "
  DELETE FROM likes 
  WHERE post_Id = '".$_POST["post_id"]."' 
  AND user_id = '".$_SESSION["id"]."'
  ";
  $statement = $pdo->prepare($query);
  if($statement->execute())
  {
   $sub_query = "
   UPDATE post
   SET liked = liked - 1 
   WHERE post_Id = '".$_POST["post_id"]."'
   ";
   $statement = $pdo->prepare($sub_query);
   $statement->execute();
  }
 }

?>
