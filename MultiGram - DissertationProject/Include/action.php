<?php

//action.php

include('../Main/database.php');
session_start();
//this will fetch user to connect.
 if($_POST['action'] == 'fetch_user')
 {
  $query = "
  SELECT * FROM users 
  WHERE user_id != '".$_SESSION["id"]."'
  AND (activation = 1 AND verified = 1)
  ORDER BY user_id DESC 
  LIMIT 5
  ";
  $statement = $pdo->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  foreach($result as $row)
  {
   $output .= '
   <div class="row" >
    <div class="col-md-4" style="width: 12%;">
     '.get_profile_picture($pdo, $row['user_id']).'
    </div>
    <div class="col-md-8">
     <h6><b><a href="../profile/otherUsersProfile.php?id='.$row['user_id'].'">'.$row["firstname"].' '.$row['lastname'].'</a></b></h6>
     '.make_follow_button($pdo, $row["user_id"], $_SESSION["id"]).'
     <span class="bg-success"> '.$row["follower_number"].' connecters</span>
    </div>
   </div>
   <hr />
   ';
  }
  echo $output;
 }


//to aonnect the user.
 if($_POST['action'] == 'follow')
 {
  $query = "
  INSERT INTO tbl_follow 
  (sender_id, receiver_id) 
  VALUES ('".$_POST["sender_id"]."', '".$_SESSION["id"]."')
  ";
  $statement = $pdo->prepare($query);
  if($statement->execute())
  {
   $sub_query = "
   UPDATE users SET follower_number = follower_number + 1 WHERE user_id = '".$_POST["sender_id"]."'
   ";
   $statement = $pdo->prepare($sub_query);
   $statement->execute();
  }
 }


//to disconnect the users.
 if($_POST['action'] == 'unfollow')
 {
  $query = "
  DELETE FROM tbl_follow 
  WHERE sender_id = '".$_POST["sender_id"]."' 
  AND receiver_id = '".$_SESSION["id"]."'
  ";
  $statement = $pdo->prepare($query);
  if($statement->execute())
  {
   $sub_query = "
   UPDATE users 
   SET follower_number = follower_number - 1 
   WHERE user_id = '".$_POST["sender_id"]."'
   ";
   $statement = $pdo->prepare($sub_query);
   $statement->execute();
  }
 }


//making follow button which user will click to connecct with other user.
function make_follow_button($pdo, $sender_id, $receiver_id)
{
 $query = "
 SELECT * FROM tbl_follow 
 WHERE sender_id = '".$sender_id."' 
 AND receiver_id = '".$receiver_id."'
 ";
 $statement = $pdo->prepare($query);
 $statement->execute();
 $total_row = $statement->rowCount();
 $output = '';
 if($total_row > 0)
 {
  $output = '<button type="button" name="follow_button" class="btn btn-success action_button" data-action="unfollow" data-sender_id="'.$sender_id.'"> Connected</button>';
 }
 
 else
 {
  $output = '<button type="button" name="follow_button" class="btn btn-info action_button" data-action="follow" data-sender_id="'.$sender_id.'"><i class="glyphicon glyphicon-plus"></i>Connect</button>';
 }
 return $output;
}

?>
