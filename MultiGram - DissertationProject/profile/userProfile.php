<?php 

include("../Main/database.php");
include("../Main/databaseTable.php");
session_start();

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
        	<a class="dropdown-item " href="../settings/editProfile.php">Setting</a>
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
	 	
 			// TO SEARCH OTHER USERS
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

<main class="user">
<?php
$users = new DatabaseTable($pdo, 'users');//new database table for users.
$users = $users->search('user_id', $_SESSION['id']);//matching the user id with the current loggin id

foreach ($users as $user){
	?>
	<!-- profile section -->
<div id="profile-details" class="container">
	<?php  ?>
	<div id="profile-pic" style="" class="container">
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
	<!-- styling -->
	<style>
	#profile-pic{margin-top: 5px; width: auto; border: 1px solid black;
 border-radius: 5px;}

</style>

	<div class="container" id="users-details" style="">
		<h1 id="userfullname"  style="color: black; font-size: 25px; margin-right: 3px"><?php echo ' '.$user['firstname'].' '.$user['lastname']?></h1>

		<div id="users" class="" style="">
		<!-- <div></div>		 -->
    	<div >
    	<button type="submit" id="user_info" class="btn btn-light" style="border-radius: 5px; border: 1px solid grey; text-align: center;">About</button>
      
    	</div>
   		<div>
   			<button type="submit" class="btn btn-light" style="border-radius: 5px; border: 1px solid grey; text-align: center;"><a style="color: black;" href="../settings/editProfile.php">Edit</a></button>
     
    	</div>
    	<div id="drop">
     		
			 <button type="submit" class="btn btn-light dropbtn" style="border-radius: 5px; border: 1px solid grey; text-align: center;">Post</button>
			  <div class="drop-content"  style="border-radius: 5px;  text-align: center;">
			  	<input type="hidden" id="is_active_post_window" value="no" />
			  <button type="submit" id="postUp" class="btn btn-light" >Image</button>
			  <input type="hidden" id="is_active_video_window" value="no" />
			  <button type="submit" id="postVideo" class="btn btn-light">Video</button>
			  </div>
			</div>
		</div>
	</div>
</div>

<style>
	div#users{width: 100%;display: flex; flex-direction:row;}
	div.drop-content{display: none;}
	div#drop:hover .drop-content{display: flex;}
	@media (max-width: 1000px){
		div#users{display: flex; flex-direction: column;}
	}
</style>

<div id="post_history" style="">
	
</div>
<div id="user_post_details"></div>
</main>


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

 ?>


<footer class="bg-secondary">
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 
 </body>
 </html>

 <style>
/* profile pic upload style*/


</style>

<!-- profile picture change -->
<div id="profile_dialog" title="Change your profile picture.">
	
	<div class="form-group">
		<div class="profile_text_area">
			<div id="profile_message" class="form-control">
				
			</div>
			<div class="profile_image_upload">
			<form id="uploadProfileImage" method="POST" action="uploadProfile.php">
			<label for="uploadProfileFile"><img src="upload.png"></label>
			<input type="file" name="uploadProfileFile" id="uploadProfileFile" accept=".jpg, .png" />
			</form>
			</div>
		</div>		
	</div>

	<div class="form-group" align="right">
		<button type="button" name="change_profile" id="change_profile" class="btn btn-info">Upload</button>
	</div>

</div>

<!-- post image upload -->
<div id="post_dialog" title="Share your story.">
	
	<div class="form-group">
		<div class="post_text_area">
			<div id="post_message" contenteditable class="form-control">
				
			</div>
			<div class="image_upload">
			<form id="uploadImage" method="POST" action="uploadPost.php">
			<label for="uploadFile"><img src="upload.png"></label>
			<input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" />
			</form>
			</div>
		</div>
			
	</div>
	<div class="form-group" align="right">
		<button type="button" name="send_post" id="send_post" class="btn btn-info">Send</button>
	</div>
</div>

<!-- post video -->
<div id="video_dialog" title="Share your Video.">
	
	<div class="form-group">
		<div class="video_text_area">
			<div id="video_message">
				
			</div>
			<div class="video_upload">
			<form id="uploadVideoFile" method="POST" action="uploadVideo.php">
			<label for="uploadVideo"><img src="upload.png"></label>
			<input type="file" name="uploadVideo" id="uploadVideo" accept=".mp4" />
			</form>
			</div>
		</div>
			
	</div>
	<div class="form-group" align="right">
		<button type="button" name="send_video" id="send_video" class="btn btn-info">Send</button>
	</div>

</div>
 <script >

  	$(document).ready(function(){
		$('#is_active_post_window').val('yes');
		$('#is_active_profile_window').val('yes');
		$('#is_active_video_window').val('yes');
  		fetch_post_history();

  		setInterval(function(){
  		update_post_history_data();
		 }, 5000);




// this function will show the chat box.
		function make_post_dialog_box(to_post_id, to_user_name)
		{
			var modal_content = '<div id= "post_dialog_'+to_post_id+'" class = "post_dialog" title="Comment on this post.">';
			
			modal_content += '<div class = "form-group">';

			modal_content += '<textarea name = "post_comment_'+to_post_id+'" id = "post_comment_'+to_post_id+'" class="form-control chat_message"></textarea>';

			modal_content += '</div><div class = "form-group" align ="right">';

			modal_content+= '<input type="hidden" name="comment_id" id="comment_id" value="0"><button type="button" name="send_comment" id="'+to_post_id+'" class="btn btn-info send_comment">Comment</button></div>';

			modal_content += '<div style="height: 300px; border:1px solid #ccc; overflow-y: scroll; margin-bottom: 24px; padding:16px;" class="post_history" data-topostid = "'+to_post_id+'" id="post_history_'+to_post_id+'">';
			
			modal_content += fetch_post_comment_history(to_post_id);

			modal_content += '</div></div>';

			$('#user_post_details').html(modal_content);
		}


		$(document).on('click', '.comment', function(){
			var to_post_id = $(this).data('topostid');
			var to_user_name = $(this).data('tousername');
			make_post_dialog_box(to_post_id, to_user_name);
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
		// ------------------------------------------------------------------------------------

 		$(document).on('click', '.likeAction_button', function(){
        var post_id = $(this).data('post_id');
        var action = $(this).data('action');

        $.ajax({
            url:"../Include/likeAction.php",
            method:"POST",
            data:{post_id:post_id, action:action},
            success:function(data)
            {
                fetch_post_history();//self reload the page.
            }
        })
    });
// ------------------------------------------------------------------
 		$(document).on('click', '.deleteAction_button', function(){
        var post_id = $(this).data('post_id');
        var action = $(this).data('action');

        $.ajax({
            url:"delete_post.php",
            method:"POST",
            data:{post_id:post_id, action:action},
            success:function(data)
            {
                fetch_post_history();//self reload the page.
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


  		// upload your profile picture.
		$('#profile_dialog').dialog({
			autoOpen: false,
			width: 400
		});

		$('#profile-pic').click(function(){
			$('#profile_dialog').dialog('open');
		});

		$('#change_profile').click(function(){
			var post_text = $('#profile_message').html();
			var action = 'insert_profile';
			if (post_text != '') {
				$.ajax({
					url: "insertPost.php",
					method: "POST",
					data:{post_text:post_text, action:action},
					success:function(data){
						$('#profile_message').html('');
						$('#post_history').html(data);
					}
				})
			}
		});

		// function fetch_post_history()
		// {
		// 	var post_dialog_activity = $('#is_active_post_window').val();
		// 	var action = "fetch_data";
		// 	if (post_dialog_activity == 'yes') 
		// 	{
		// 		$.ajax({
		// 			url: "insertPost.php",
		// 			method: "POST",
		// 			data:{action:action},
		// 			success:function(data)
		// 			{
		// 				$('#profile_history').html(data);
		// 			}
		// 		})
		// 	}
		// }

		$('#uploadProfileFile').on('change', function(){
			$('#uploadProfileImage').ajaxSubmit({
				target : "#profile_message",
				resetForm: true
			})
		})


		// share your story.
		$('#post_dialog').dialog({
			autoOpen: false,
			width: 400
		});

		$('#postUp').click(function(){
			$('#post_dialog').dialog('open');
		});

		$('#send_post').click(function(){
			var post_text = $('#post_message').html();
			var action = 'insert_data';
			if (post_text != '') {
				$.ajax({
					url: "insertPost.php",
					method: "POST",
					data:{post_text:post_text, action:action},
					success:function(data){
						$('#post_message').html('');
						$('#post_history').html(data);
					}
				})
			}
		});

		function fetch_post_history()
		{
			var post_dialog_activity = $('#is_active_post_window').val();
			var action = "fetch_data";
			if (post_dialog_activity == 'yes') 
			{
				$.ajax({
					url: "insertPost.php",
					method: "POST",
					data:{action:action},
					success:function(data)
					{
						$('#post_history').html(data);
					}
				})
			}
		}
		$('#uploadFile').on('change', function(){
			$('#uploadImage').ajaxSubmit({
				target : "#post_message",
				resetForm: true
			})
		})

// video upload dialog

	$('#video_dialog').dialog({
			autoOpen: false,
			width: 400
		});

		$('#postVideo').click(function(){
			$('#video_dialog').dialog('open');
		});

		$('#send_video').click(function(){
			var post_text = $('#video_message').html();
			var action = 'insert_video';
			if (post_text != '') {
				$.ajax({
					url: "insertPost.php",
					method: "POST",
					data:{post_text:post_text, action:action},
					success:function(data){
						$('#video_message').html('');
						$('#video_history').html(data);
					}
				})
			}
		});

		$('#uploadVideo').on('change', function(){
			$('#uploadVideoFile').ajaxSubmit({
				target : "#video_message",
				resetForm: true
			})
		})




  	});
  </script>
 	<?php 
 	}
 	else
 	{
 		header('Refresh: 1; url =../Layouts/index.php');
 	}
 	?>		
 

