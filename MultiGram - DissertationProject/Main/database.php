
<?php 
// connection to database name dissertation.
   $pdo= new PDO("mysql:host=localhost; dbname=dissertation; charset=utf8mb4", "root", "");


function get_user_name($user_id, $pdo)
{
	$query = "SELECT * FROM users WHERE user_id ='$user_id'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row)
	{
	return  '<b>'.$row['firstname'].' '.$row['lastname'].'</b>';
	}
}


// show the post uploaded by users only
function fetch_post_history($pdo)
{	
	$id =  $_SESSION["id"];
	$query = "
	SELECT * FROM post
	WHERE user_Id = '$id'
	ORDER BY postDate DESC
	";

	$statement = $pdo->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	$output = '<ul class="list-unstyled" >';
	
	foreach($result as $row)
	{	
		
		$user_name = '';
		$dynamic_background = '';
		
		$user_name = '<b class="text-success">'.get_user_name($row['user_Id'], $pdo).'</b> uploaded a <b>'.$row['postType'].'</b>';
	
		$dynamic_background  = 'background_color: #ffe6e6;';

		$output .= '

		<li style="border: 1px solid black; border-radius: 5px; background: lightgrey; margin-top: 20px;">
			<p><div style="display: flex; flex-direction: row;"><div style="width: 10%;">'.get_profile_picture($pdo, $row['user_Id']).' </div><div>'.$user_name.' - 
					</div></div>';
					$output .= $row['textPost'].' 
				<div align="right">
					- <small><em>'.$row['postDate'].'</em></small>
				</div>';

				if ($row['liked']==0) {
				$output .= '';
				}
				else{
				$output	.= '<div align="left" style="margin-left: 10px;">'.$row['liked'].' Liked this post </div>';
				}
			$output .=	make_like_button($pdo, $row["post_Id"], $_SESSION["id"]).'<button style="margin-left: 10px;" type="button" class="btn btn-light btn-xs comment" data-topostid="'.$row['post_Id'].'" data-tousername="'.$row['user_Id'].'">Comment</button>'.make_delete_button($pdo, $row["post_Id"], $_SESSION["id"]).'
					</p>
		</li>
		';
		}
	$output .= '</ul>';
	return $output;
		
	}


// show all post uploaded by every users that you are connected
function fetch_all_post_story($pdo)
{

$query = "
  SELECT * FROM post 
  INNER JOIN users ON users.user_id = post.user_id 
  LEFT JOIN tbl_follow ON tbl_follow.sender_id = post.user_id 
  WHERE (tbl_follow.receiver_id = '".$_SESSION["id"]."' OR post.user_id = '".$_SESSION["id"]."') 
  AND (users.activation = 1)
  GROUP BY post.post_Id 
  ORDER BY post.post_Id DESC
  ";

	$statement = $pdo->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	$output = '<ul class="list-unstyled" >';

	foreach($result as $row)
	{	
		$user_name = '';
		$dynamic_background = '';
		
		if ($row['user_Id'] == $_SESSION['id']) 
		{
			$user_name = '<b class="text-success">'.get_user_name($row['user_Id'], $pdo).'</a></b> uploaded a <b>'.$row['postType'].'</b>';

		}
		else
		{
			$user_name ='<b><a href="../profile/otherUsersProfile.php?id='.$row['user_Id'].'">'.get_user_name($row['user_Id'], $pdo).'</a></b> uploaded a <b>'.$row['postType'].'</b>';
		}
	
		$dynamic_background  = 'background_color: #ffe6e6;';

		$output .= '

		<li style="border: 1px solid black; border-radius: 5px; background: lightgrey; margin-top: 20px;">
			<p><div style="display: flex; flex-direction: row;"><div style="width: 10%;">'.get_profile_picture($pdo, $row['user_Id']).' </div><div>'.$user_name.' - </div></div>';
			
					$output .= $row['textPost'].' 
				<div align="right">
					- <small><em>'.$row['postDate'].'</em></small>
				</div>';

			if ($row['liked']==0) {
				$output .= '';
				}
				else{
				$output	.= '<div align="left" style="margin-left: 10px;">'.$row['liked'].' Liked this post </div>';
				}
				if ($row['user_Id'] == $_SESSION['id']) 
					{
						$output .= 	 make_like_button($pdo, $row["post_Id"], $_SESSION["id"]).'<button style="margin-left: 10px;" type="button" class="btn btn-light btn-xs comment" data-topostid="'.$row['post_Id'].'" data-tousername="'.$row['user_Id'].'">Comment</button>'.make_delete_button($pdo, $row["post_Id"], $_SESSION["id"]).'
						</p>
					</li>
					';

					}
					else
					{
						$output .= 	 make_like_button($pdo, $row["post_Id"], $_SESSION["id"]).'<button style="margin-left: 10px;" type="button" class="btn btn-light btn-xs comment" data-topostid="'.$row['post_Id'].'" data-tousername="'.$row['user_Id'].'">Comment</button>
						</p>
					</li>
					';
					}
			
		}
	$output .= '</ul>';
	return $output;
	}

// make like button to add like or remove like.
	function make_like_button($pdo, $post_id, $user_id)
	{
	 $query = "
	 SELECT * FROM likes 
	 WHERE post_id = '".$post_id."' 
	 AND user_id = '".$user_id."'
	 ";
	 $statement = $pdo->prepare($query);
	 $statement->execute();
	 $total_row = $statement->rowCount();
	 $output = '';
	 if($total_row > 0)
	 {
	  $output = '<button type="button" name="like_button" style="margin-left: 10px;" class="btn btn-info btn-xs likeAction_button" data-action="unlike" data-post_id="'.$post_id.'"> Liked</button>';
	 }
	 else
	 {
	  $output = '<button type="button" name="like_button" style="margin-left: 10px;" class="btn btn-light btn-xs likeAction_button" data-action="like" data-post_id="'.$post_id.'"><i class="glyphicon glyphicon-plus"></i>Like</button>';
	 }
	 return $output;
	}

// make delete button to delete post uploaded by the user
	function make_delete_button($pdo, $post_id, $user_id)
	{
	 $query = "
	 SELECT * FROM post 
	 WHERE post_Id = '".$post_id."'
	 AND user_Id = '".$user_id."'
	 ";
	 $statement = $pdo->prepare($query);
	 $statement->execute();
	 $total_row = $statement->rowCount();

	 $output = '';
	 if($total_row > 0)
	 {
	  $output = '<button type="button" name="delete_button" style="margin-left: 10px;" class="btn btn-light btn-xs deleteAction_button" data-action="delete" data-post_id="'.$post_id.'">Delete</button>';
	 }
	 return $output;
	}



// ---------------------------------------------------------------
	// fetch all coment sent in a post
function fetch_post_comment_history($from_user_id, $to_post_Id, $pdo)
{
	$query = "
  SELECT * FROM comments 
  WHERE  post_id = '".$to_post_Id."' 
  ORDER BY commentDate DESC";

//now excuting the query by pdoing to database.

$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
  $output .= '
  <div class="panel panel-default" Style="border-radius: 10px; margin-top:10px; border: 2px solid grey;">
    <div class="panel-heading" style="display: flex; flex-direction: row;"><div style="width: 10%;">'.get_profile_picture($pdo, $row['commenter']).'</div>';
    	if ($row['commenter'] == $_SESSION['id']) 
		{
		$output .=	'<b class="text-success">'.get_user_name($row['commenter'], $pdo).' </b>';
		}
		else
		{
		
		$output .=	'<b><a href="../profile/otherUsersProfile.php?id='.$row['commenter'].'">'.get_user_name($row['commenter'], $pdo).' </a></b>';
		}
    
   $output .= ' 
    - on -<i>'.$row["commentDate"].'</i>
    </div>
    <div style="margin-left:1%">'.$row["comment"].'</div>
  </div>
  ';

}
echo $output;

}

// get the profile picture of users.
function get_profile_picture($pdo, $id)
{
$query = "
      SELECT * FROM post
      WHERE user_Id = '$id'
      AND postType = 'Profile Picture'
      ORDER BY postDate DESC 
      LIMIT 1;
      ";
      $statement = $pdo->prepare($query);
      $statement->execute();
      $row = $statement->fetch();
	if (empty($row['textPost'])) {
		 return '<img src="../Datas/default.png" width="70%">';
	}

	else{
			return $row['textPost'];	
	}
}


// for message section
date_default_timezone_set('Asia/Kolkata');

//fetch the user last activity.
function fetch_user_last_activity($user_id, $pdo)
{
 $query = "
 SELECT * FROM login_details
 WHERE user_id = '$user_id'
 ORDER BY last_activity DESC
 LIMIT 1
 ";

 $statement = $pdo->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}


//last logout activity.
function fetch_user_logout_activity($user_id, $pdo)
{
 $query = "
 SELECT * FROM login_details
 WHERE user_id = '$user_id'
 ORDER BY last_activity DESC
 LIMIT 1
 ";

 $statement = $pdo->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  return $row['logout'];
 }
}

//chat history
function fetch_user_chat_history($from_user_id, $to_user_id, $pdo)
{
	$query = "
	SELECT * FROM chat_message
	WHERE (from_user_id = '".$from_user_id."'
	AND to_user_id = '".$to_user_id."')
	OR (from_user_id = '".$to_user_id."'
	AND to_user_id = '".$from_user_id."')
	ORDER BY timestamp DESC
	";

	$statement = $pdo->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output ='<ul class = "list_unstyled">';
	foreach ($result as $row) {
		$user_name = '';
		$dynamic_background = '';
		$chat_message = '';
		if ($row["from_user_id"] == $from_user_id)
		{
			if($row["status"] == '2')
			{
				$chat_message = '<em>This message has been removed</em>';
				$user_name = '<b class = "text-success">You</b>';
			}
			else
			{
				$chat_message = $row['chat_message'];
				$user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
			}
			
			$dynamic_background = 'background_color: #ffe6e6;';

		}
		else
		{
			if ($row['status']=='2')
			{
				$chat_message = '<em>This message has been removed</em>';
				$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $pdo).'</b>';
			}
			else
			{
				$chat_message = $row['chat_message'];
				$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $pdo).'</b>';

			}

			$dynamic_background = 'background_color: #ffffe6;';
		}

		$output .='
				 <li style="border-bottom: 1px dotted #ccc">
				 	<p>'.$user_name.' - '.$chat_message.'
				 		<div align="right">
				 			- <small><em>'.$row['timestamp'].'</em></small>
				 		</div>
				 	</p>
				 </li>
				 ';
		}
		$output .= '</ul>';
		$query = "
			UPDATE chat_message
			SET status = '0'
			WHERE from_user_id = '".$to_user_id."'
			AND to_user_id = '".$from_user_id."'
			AND status = '1'
		";

		$statement = $pdo->prepare($query);
		$statement->execute();
		return $output;

}


//count unseen messages
function count_unseen_message($from_user_id, $to_user_id, $pdo)
	{
		$query = "
		SELECT * FROM chat_message
		WHERE from_user_id = '$from_user_id'
		AND to_user_id = '$to_user_id'
		AND status = '1'
		";

		$statement = $pdo->prepare($query);

		$statement->execute();

		$count = $statement->rowCount();

		$output = '';

		if ($count > 0) {
			$output = '<span class ="bg bg-success mr-auto">'.$count.' unread message.</span>';
		}
		return $output;
	}



// type notification
function fetch_is_type_status($user_id, $pdo)
{
	$query = "
		SELECT is_type FROM login_details
		WHERE user_id = '".$user_id."'
		ORDER BY last_activity DESC
		LIMIT 1
	";

	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';

	foreach ($result as $row)
	{
		if ($row["is_type"]=='yes') {
			$output =' - <small><em>
					<span class="text-muted">Typing..</span></em></small>';
		}
	}
	return $output;
}

// group chat
function fetch_group_chat_history($pdo)
{
	$query = "
	SELECT * FROM chat_message
	WHERE to_user_id = '0'
	ORDER BY timestamp DESC
	";

	$statement = $pdo->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	$output = '<ul class="list-unstyled">';

	foreach($result as $row)
	{
		$user_name = '';
		$dynamic_background = '';
		$chat_message = '';
		if($row["from_user_id"] == $_SESSION["user_id"])
		{
			if ($row["status"] == '2')
			{
				$chat_message = '<em>This message has been removed</em>';
				$user_name = '<b class = "text-success">You</b>';
			}
			else
			{
				$chat_message = $row['chat_message'];
				$user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
			}
			$dynamic_background  = 'background_color: #ffe6e6;';

		}
		else
		{
			if ($row["status"] == '2')
			{
				$chat_message = '<em>This message has been removed</em>';
				$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $pdo).'</b>';

			}
			else
			{
				$chat_message = $row['chat_message'];
				$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $pdo).'</b>';
			}
			$dynamic_background  = 'background_color: #ffffe6;';

		}

		$output .= '

		<li style="border-bottom:1px dotted #ccc">
			<p>'.$user_name.' - '.$chat_message.'
				<div align="right">
					- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
		</li>
		';
	}
	$output .= '</ul>';
return $output;
}



?>