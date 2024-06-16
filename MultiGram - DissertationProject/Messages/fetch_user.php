<?php 
//fetch_user.php

include("../Main/database.php");
	session_start();
			$query = "
			SELECT * FROM tbl_follow
			JOIN users
				ON tbl_follow.sender_id =users.user_id
			WHERE tbl_follow.receiver_id = '".$_SESSION['id']."'
			AND users.activation = 1
			AND users.verified = 1
			";
			//this query will get only those users who you have connected and are active.
			$statement = $pdo->prepare($query);// preparing the query to execute with database.

			$statement -> execute();//execute the query statement.

			$result = $statement->fetchAll();
			$output = '
			<table class="table table-bordered table-striped">
			<tr>
			 	<td>Full Name</td>
			 	<td>Status</td>
			 	<td>Action</td>
			 </tr>
			';//table header
		foreach ($result as $show )
		{
		 	$status = '';
			$current_timestamp = strtotime(date("Y-m-d H:i:s") . '-10 second');
			$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
			$user_last_activity = fetch_user_last_activity($show['user_id'], $pdo);
			$user_logout_activity = fetch_user_logout_activity($show['user_id'], $pdo);
			if($user_last_activity > $current_timestamp && $user_logout_activity == 1)
			{
				$status = '<span class="btn btn-success">Online</span>';
			}
			else  {
				
				$status = '<span class="btn btn-danger">Offline</span>';
			}
			$output .= '
			<tr>
		 	<td><div style="display:flex; flex-direction: row;"><div style="width: 10%;">'.get_profile_picture($pdo, $show['user_id']).' </div><div><h4><a href="../profile/otherUsersProfile.php?id='.$show['user_id'].'"> '.$show['firstname'].' '.$show['lastname'].'</a></h3> '.count_unseen_message($show['user_id'], $_SESSION['id'], $pdo).' '.fetch_is_type_status($show['user_id'], $pdo).'</div></div></td>
		 	<td>'.$status.'</td>
		 	<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$show['user_id'].'" data-tousername="'.$show['firstname'].' '.$show['lastname'].'">Start Chat</button></td>
		 </tr>
			';
		}
		$output .= '</table>';

		echo $output;
		// }

		
 ?>

 