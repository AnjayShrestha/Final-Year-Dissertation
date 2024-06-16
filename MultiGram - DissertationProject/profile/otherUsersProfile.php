<?php 
include("../Main/database.php");
include("../Main/databaseTable.php");
session_start();


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
  $output = '<button type="button" name="follow_button" class="btn btn-info btn-xs action_button" data-action="unfollow" data-sender_id="'.$sender_id.'"> Connected</button>';
 }
 else
 {
  $output = '<button type="button" name="follow_button" class="btn btn-light btn-xs action_button" data-action="follow" data-sender_id="'.$sender_id.'"><i class="glyphicon glyphicon-plus"></i>Connect</button>';
 }
 return $output;
}


if(isset($_SESSION['id'])){

 		?>
 <!DOCTYPE html>
 <html>
  <head>
 	<link rel="stylesheet" type="text/css" href="../Styles/Style.css">
		
  		<link rel="stylesheet" type="text/css" href="../Bootstrap/bootstrap.min.css">
	
		<link rel="stylesheet" type="text/css" href="../Bootstrap/jquery-ui.css">
		
  		<!-- <link rel="stylesheet" type="text/css" href="../Bootstrap/weblesson/bootstrap.min.css"> -->

  		<link rel="stylesheet" href="../Bootstrap/emojionearea.min.css">
		
		
		<script src="../Bootstrap/jquery-1.12.4.js"></script>

		<script src="../Bootstrap/jquery-ui.js"></script>


		<script src="../Bootstrap/emojionearea.min.js"></script>
		
		<script src="../Bootstrap/jquery.form.js"></script>

		<script src="../Bootstrap/bootstrap.min.js"></script>
 	<title>
 	</title>
 </head>
 <body>
 <header class="userHeader">
 	 <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
 
  <a class="navbar-brand"  href="../HTML/userlayout.php?user=userIndex"><b id="logo">MultiGram</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  	<form class="form-inline mr-auto my-2  my-lg-0" action="search.php" method="POST">
      <input class="form-control" type="search" id="search" name="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-light my-2 my-sm-0" type="submit" name="search-user"><img src="../Icons/search.png" alt="Search" style="width:20px; "></button>
    </form>
    <div class="dropdown-menu" id="back_result" ></div>

    <!-- <br> -->
    <ul class="navbar-nav">

	  <li class="nav-item">
      	<a class="nav-link bg-secondary active" href="../profile/userProfile.php">
      	<?php 
 			$users = new DatabaseTable($pdo, 'users');//new database table for users.
			$users = $users->search('user_id', $_SESSION['id']);
			//display users information.
			foreach($users as $user){		
 			echo $user['firstname'];
			}
 			 ?>
        </a>
      </li>

      <li class="nav-item ">
        <a class="nav-link  bg-secondary active" href="../HTML/userlayout.php?user=userIndex">Home <span class="sr-only">(current)</span></a>
      </li>


      
      <!-- message -->
       <li class="nav-item ">
        <a class="nav-link  bg-secondary active" href="../Messages/chatApplication.php"><img src="../Icons/msg.png" alt="MESSAGES" style="width:25px; margin-bottom: 4px;"></a>
      </li>

      <!-- notification -->
       <li class="nav-item">
        <a class="nav-link  bg-secondary active" href="#"><img src="../Icons/ntf.png" alt="NOTIFICATION" style="width:23px; margin-bottom: 4px;"></a>
      </li>


      <!-- more section -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle bg-secondary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          More
        </a>
        <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
        	<a class="dropdown-item" href="../settings/editProfile.php">Setting</a>
          	<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="../HTML/userLayout.php?user=userLogouts">Logout</a>
        
        </div>
      </li>
    
    </ul>   
      
  </div>
</nav>

 <style>

  	.navbar:hover {box-shadow: 1px 4px 3px lightgrey}
  	#logo:hover  {box-shadow: 1px 4px 4px lightgrey}
  </style>
 </header>	
 	<script>
 		$(document).ready(function(){
 			$('#search').keyup(function(){
 				var name = $(this).val();
 				$.ajax({
				url: "../Include/get_users.php",
				method: "POST",
				data: {name:name},
				success:function(data){
					$('#back_result').html(data);
					$('#back_result').css({'display':'block'});
					
					}
				}) 				
 			});
 		});
 	</script>
<style>


.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}


.dropdown-content button:hover {background-color: #f1f1f1}

#dropdown:hover .dropdown-content {
  display: block;
}

</style>
<main class="user">
<?php
$uId = $_GET['id'];
$users = new DatabaseTable($pdo, 'users');//new database table for users.
$users = $users->search('user_id', $uId);//matching the user id with the current loggin id

foreach ($users as $user){
	?>

<div id="profile-details">
	<div id="profile-pic" style="">
		<?php 
 		 	$uid = $user['user_id'];
			$query = "
			SELECT * FROM post
			WHERE user_Id = '$uid'
			AND postType = 'Profile Picture'
			ORDER BY postDate DESC 
			LIMIT 1;
			";
			$statement = $pdo->prepare($query);
			$statement->execute();
			$row = $statement->fetch();
			if (empty($row['textPost'])) {
				 echo '<img src="../Datas/default.png">';
			}

			else{
					echo $row['textPost'];	
			}
 		 	 ?>
	</div>
	<div class="container" id="users-details" style="">
		<h1 id="userfullname" style="color: black; font-size: 25px;"><?php echo ' '.$user['firstname'].' '.$user['lastname']?></h1>
		<div id="">
		<input type="submit" id="user_info" class="btn btn-light btn-xs" name="aboutP" value="About" style="margin-left: 1px;">
			<?php echo make_follow_button($pdo, $user["user_id"], $_SESSION["id"]).'<br><span class="bg-success"> '.$user["follower_number"].' connecters</span>' ?>
		</div>
	</div>
</div>
<!-- styling -->
<style>
	#profile-pic{margin-top: 5px; width: auto; border: 1px solid black;
 border-radius: 5px;}
 @media (max-width: 1000px){
		#profile-pic{margin-left: 16.5%; margin-right:16.5%;}
	}
</style>
		
<div id="user_post_details">
	<?php 
	$pid = $user['user_id'];
	 	$query = "
	SELECT * FROM post
	WHERE user_Id = '$pid'
	ORDER BY postDate DESC 
	";

	$statement = $pdo->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	echo '<ul class="list-unstyled" >';
	
	foreach($result as $row)
	{	
		
		$user_name = '';
		$dynamic_background = '';
		
		$user_name = '<b class="text-success">'.get_user_name($row['user_Id'], $pdo).'</b> uploaded a <b>'.$row['postType'].'</b>';
	
		$dynamic_background  = 'background_color: #ffe6e6;';

		echo '

		<li style="border: 1px solid black; border-radius: 5px; background: lightgrey; margin-top: 20px;">
			<p><div style="display: flex; flex-direction: row;"><div style="width: 10%;">'.get_profile_picture($pdo, $row['user_Id']).' </div><div>'.$user_name.' - </div></div>';
					echo $row['textPost'].' 
				<div align="right">
					- <small><em>'.$row['postDate'].'</em></small>
				</div>';
				if ($row['liked']==0) 
				{
					echo '';
				}
				else
				{
					echo  '<div align="left" style="margin-left: 10px;">'.$row['liked'].' Liked this post </div>';
				}

			echo make_like_button($pdo, $row["post_Id"], $_SESSION["id"]).'<button style="margin-left: 10px;" type="button" class="btn btn-info btn-xs comment" data-topostid="'.$row['post_Id'].'" data-tousername="'.$row['user_Id'].'">Comment</button>
			</p>
		</li>
		';
		}
	echo '</ul>';	
?>

</div>

<div id="user_post_comment_details"></div>

</main>



<!-- javascript ajax for like button -->
<script>
	$(document).ready(function(){

	$(document).on('click', '.likeAction_button', function(){
        var post_id = $(this).data('post_id');
        var action = $(this).data('action');

        $.ajax({
            url:"../Include/likeAction.php",
            method:"POST",
            data:{post_id:post_id, action:action},
            success:function(data)
            {
                self['location']['reload']();//self reload the page.
            }
        })
    })
   });	
</script>

<footer class="bg-secondary">
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 
 </body>
 </html>
 <!-- to show user profile details -->
<div id="about_user" class="" style="">
 	<div id="about_user_content" style="">
 		<div id="exit" style="">+</div>
 		 <form action="" >
 		 	<?php
 		 	$uid = $user['user_id']; 
			$query = "
			SELECT * FROM post
			WHERE user_Id = '$uid'
			AND postType = 'Profile Picture'
			ORDER BY postDate DESC 
			LIMIT 1;
			";
			$statement = $pdo->prepare($query);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach ($result as $row) {
			echo '	 	
				'.$row['textPost'].'
				';		 	 
 		 	 }
 		 	 ?>
 		 	<label style="">Name:</label>
 		 	<h4 id="userfullname" style="color: black;"><?php echo ' '.$user['firstname'].' '.$user['lastname']?></h4>

 		 	<label>Username:</label>
 		 	<?php if(empty($user['username'])){?> 
 		 	<h4 id="user_name" style="color: black;">No Username</h4>
 		 	<?php } 
 		 	else { ?>
 		 	<h4 id="user_name" style="color: black;"><?php echo ' '.$user['username']?></h4>
 		 	<?php } ?>

 		 	<label>Email_adress:</label>
 		 	<h4 id="Email_address" style="color: black;"><?php echo ' '.$user['emailAddress']?>		
 		 	</h4>

 		 	<label>Date_of_brth:</label>
 		 	<h4 id="Email_address" style="color: black;"><?php echo ' '.$user['date_of_birth']?>		
 		 	</h4>

 		 	<label>Phone_no:</label>
 		 	<?php if(empty($user['contactNo'])){?> 
 		 	<h4 id="Phone_no" style="color: black;">No contact number</h4>
 		 	<?php } 
 		 	else { ?>
 		 	<h4 id="Phone_no" style="color: black;"><?php echo ' '.$user['contactNo']?></h4>
 		 	<?php } ?>
 		 	<label>Gender:</label>
 		 	<h4 id="user_gender" style="color: black;"><?php echo ' '.$user['gender']?></h4>

 		 	<label>Account_Activated:</label>
 		 	<h4 id="account_activated" style="color: black;"><?php echo ' '.$user['registeredDate']?></h4>
 		 </form>
		
 	</div>
 </div>

 <script type="text/javascript">
 	document.getElementById('user_info').addEventListener('click', function(){
document.querySelector('#about_user').style.display='flex';
 	});
 	document.querySelector('#exit').addEventListener('click', function(){
document.querySelector('#about_user').style.display='none';
 	});
 </script>



<?php 
	}
?>

<script >
	$(document).ready(function(){
		
		setInterval(function(){
  		update_post_history_data();
		 }, 5000);


		$(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var action = $(this).data('action');

        $.ajax({
            url:"../Include/action.php",
            method:"POST",
            data:{sender_id:sender_id, action:action},
            success:function(data)
            {
                self['location']['reload']();//self reload the page.
            }
        })
    });


// this function will show the chat box.
		function make_post_comment_dialog_box(to_post_id, to_user_name)
		{
			var modal_content = '<div id= "post_dialog_'+to_post_id+'" class = "post_dialog" title="Comment on this post.">';
			
			modal_content += '<div class = "form-group">';

			modal_content += '<textarea name = "post_comment_'+to_post_id+'" id = "post_comment_'+to_post_id+'" class="form-control chat_message"></textarea>';

			modal_content += '</div><div class = "form-group" align ="right">';

			modal_content+= '<input type="hidden" name="comment_id" id="comment_id" value="0"><button type="button" name="send_comment" id="'+to_post_id+'" class="btn btn-info send_comment">Comment</button></div>';

			modal_content += '<div style="height: 300px; border:1px solid #ccc; overflow-y: scroll; margin-bottom: 24px; padding:16px;" class="post_history" data-topostid = "'+to_post_id+'" id="post_history_'+to_post_id+'">';
			
			modal_content += fetch_post_comment_history(to_post_id);

			modal_content += '</div></div>';

			$('#user_post_comment_details').html(modal_content);
		}


		$(document).on('click', '.comment', function(){
			var to_post_id = $(this).data('topostid');
			var to_user_name = $(this).data('tousername');
			make_post_comment_dialog_box(to_post_id, to_user_name);
			$("#post_dialog_"+to_post_id).dialog({
				autoOpen:false,
				width:500
			});
			$('#post_dialog_'+to_post_id).dialog('open');
			$('#post_comment_'+to_post_id).emojioneArea({
				pickerPosition : "bottom",
				toneStyle: "bullet"
			});
		});

		$(document).on('click', '.send_comment', function(){
			var to_post_id = $(this).attr('id');
			var chat_message = $('#post_comment_'+to_post_id).val();
			$.ajax({
				url: "../Include/insert_comment.php",
				method: "POST",
				data: {to_post_id:to_post_id, chat_message:chat_message},
				success:function(data)
				{
					var element = $('#post_comment_'+to_post_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#post_history_'+to_post_id).html(data);
				}

			})
		});	



		function fetch_post_comment_history(to_post_id)
		{
			$.ajax({
				url: "../Include/fetch_post_comment_history.php",
				method: "POST",
				data: {to_post_id:to_post_id},
				success:function(data){
					$('#post_history_'+to_post_id).html(data);
				}
			})
		}

		function update_post_history_data()
		{
			$('.post_history').each(function(){
				var to_post_id = $(this).data('topostid');
				fetch_post_comment_history(to_post_id);
			});
		}

	});


</script>


<div id="about_user" style="">
 	<div id="about_user_content" style="">
 		<div id="exit" style="">+</div>
 		 <form action="" >
 		 	<?php
 		 		$uid = $user['user_id']; 
			$query = "
			SELECT * FROM post
			WHERE user_Id = '$uid'
			AND postType = 'Profile Picture'
			ORDER BY postDate DESC
			LIMIT 1;
			";
			$statement = $pdo->prepare($query);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach ($result as $row) {
			echo '<input type="hidden" id="is_active_profile_window" value="no" />	 		 	
				'.$row['textPost'].'
				';
						 	 
 		 	 }
 		 	 ?>
 		 	<label style="">Name:</label>
 		 	<h4 id="userfullname" style="color: black;"><?php echo ' '.$user['firstname'].' '.$user['lastname']?></h4>

 		 	<label>Username:</label>
 		 	<?php if(empty($user['username'])){?> 
 		 	<h4 id="user_name" style="color: black;">No Username</h4>
 		 	<?php } 
 		 	else { ?>
 		 	<h4 id="user_name" style="color: black;"><?php echo ' '.$user['username']?></h4>
 		 	<?php } ?>

 		 	<label>Email_adress:</label>
 		 	<h4 id="Email_address" style="color: black;"><?php echo ' '.$user['emailAddress']?>		
 		 	</h4>

 		 	<label>Date_of_brth:</label>
 		 	<h4 id="Email_address" style="color: black;"><?php echo ' '.$user['date_of_birth']?>		
 		 	</h4>

 		 	<label>Phone_no:</label>
 		 	<?php if(empty($user['contactNo'])){?> 
 		 	<h4 id="Phone_no" style="color: black;">No contact number</h4>
 		 	<?php } 
 		 	else { ?>
 		 	<h4 id="Phone_no" style="color: black;"><?php echo ' '.$user['contactNo']?></h4>
 		 	<?php } ?>
 		 	<label>Gender:</label>
 		 	<h4 id="user_gender" style="color: black;"><?php echo ' '.$user['gender']?></h4>

 		 	<label>Account_Activated:</label>
 		 	<h4 id="account_activated" style="color: black;"><?php echo ' '.$user['registeredDate']?></h4>
 		 </form>
 	</div>
 </div>
 <script type="text/javascript">
 	document.getElementById('user_info').addEventListener('click', function(){
document.querySelector('#about_user').style.display='flex';
 	});
 	document.querySelector('#exit').addEventListener('click', function(){
document.querySelector('#about_user').style.display='none';
 	});
 </script>
 	<?php 
 	}
 	else
 	{
 		header('Refresh: 1; url =../Layouts/index.php');
 	}
 	?>		
 
