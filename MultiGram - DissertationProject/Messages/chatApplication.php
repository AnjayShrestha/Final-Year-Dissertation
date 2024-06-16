<!-- 
//index.php
 -->

 <?php 
include("../Main/database.php");
 include('../Main/databaseTable.php');
 session_start();
 if (!isset($_SESSION['id'])) 
 {
 	header('location: ../Layouts/index.php');//if not logged in then it will take you to login page.
 }
 else{


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
  	<form class="form-inline mr-auto my-2  my-lg-0" action="../profile/search.php" method="POST">
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
  	<body>
  		<br><br><br>
  		<div class="container"> <br>
		<div class="row">
			<div>
					<h4>Online User</h4>
			</div>
			<!-- <div class="col-md-2 col-sm-3">
				<input type="hidden" id="is_active_group_chat_window" value="no" />
				<button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs">Group Chat</button>
			</div> -->
			
			</div>
			<div class="table-responsive">
				<br>
				<div id="user_details"></div>
				<div id="user_model_details"></div>
			</div>
  		
  		</div>
  
  </body>
  </html>
  	</body>
  	<footer class="bg-secondary">
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
  	<!-- for search system. -->
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

.chat_message_area
{
	position: relative;
	width: 100%;
	height: auto;
	background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 3px;
}

#group_chat_message
{
	width: 100%;
	height: auto;
	min-height: 80px;
	overflow: auto;
	padding:6px 24px 6px 12px;
}

.image_upload
{
	position: absolute;
	top:3px;
	right:3px;
}
.image_upload > form > input
{
    display: none;
}

.image_upload img
{
    width: 24px;
    cursor: pointer;
}

</style>

  <script >
  	$(document).ready(function(){
  		fetch_user();//run the function fetch_user.
		// fetch_user function is to fetch the data of other users.

  		//refresh the page every 1 second.
  		setInterval(function(){
		  update_last_activity();
		  fetch_user();
		  update_chat_history_data();
		  fetch_group_chat_history();
		 }, 1000);


  		function fetch_user()
  		{
  			$.ajax({
  				url:"fetch_user.php",
  				method:"POST",
  				success: function(data){
  					$('#user_details').html(data);
  				}
  			})
  		}

  		function update_last_activity()
			 {
			  $.ajax({
			   url:"update_last_activity.php",
			   success:function()
			   {

			   }
			  })
			 }

// this function will show the chat box.
		function make_chat_dialog_box(to_user_id, to_user_name)
		{
			var modal_content = '<div id= "user_dialog_'+to_user_id+'" class = "user_dialog" title = "You have chat with ' +to_user_name+'">';

			modal_content += '<div style="height: 300px; border:1px solid #ccc; overflow-y: scroll; margin-bottom: 24px; padding:16px;" class="chat_history" data-touserid = "'+to_user_id+'" id="chat_history_'+to_user_id+'">';
			
			modal_content += fetch_user_chat_history(to_user_id);

			modal_content += '</div>';

			modal_content += '<div class = "form-group">';

			modal_content += '<textarea name = "chat_message_'+to_user_id+'" id = "chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';

			modal_content += '</div><div class = "form-group" align ="right">';

			modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
			$('#user_model_details').html(modal_content);
		}
	//jquery to open chat box
		$(document).on('click', '.start_chat', function(){
			var to_user_id = $(this).data('touserid');
			var to_user_name = $(this).data('tousername');
			make_chat_dialog_box(to_user_id, to_user_name);
			$("#user_dialog_"+to_user_id).dialog({
				autoOpen:false,
				width:400
			});
			$('#user_dialog_'+to_user_id).dialog('open');
			$('#chat_message_'+to_user_id).emojioneArea({
				pickerPosition : "top",
				toneStyle: "bullet"
			});
		});

		//to send text message.
		$(document).on('click', '.send_chat', function(){
			var to_user_id = $(this).attr('id');
			var chat_message = $('#chat_message_'+to_user_id).val();
			$.ajax({
				url: "insert_chat.php",
				method: "POST",
				data: {to_user_id:to_user_id, chat_message:chat_message},
				success:function(data)
				{
					// $('#chat_message_'+to_user_id).val('');
					var element = $('#chat_message_'+to_user_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#chat_history_'+to_user_id).html(data);
				}

			})
		});

		//to get all chat history.
		function fetch_user_chat_history(to_user_id)
		{
			$.ajax({
				url: "fetch_user_chat_history.php",
				method: "POST",
				data: {to_user_id:to_user_id},
				success:function(data){
					$('#chat_history_'+to_user_id).html(data);

				}
			})
		}
		//to update chat history.
		function update_chat_history_data()
		{
			$('.chat_history').each(function(){
				var to_user_id = $(this).data('touserid');
				fetch_user_chat_history(to_user_id);
			});
		}

		$(document).on('click', '.ui-button-icon', function(){
			$('.user_dialog').dialog('destroy').remove();
		});
		
		$(document).on('focus', '.chat_message', function(){
			var is_type = 'yes';
			$.ajax({
				url: "update_is_type_status.php",
				method: "POST",
				data: {is_type:is_type},
				success:function()
				{
					
				}

			})
		});

		//to show typing notification.
		$(document).on('blur', '.chat_message', function(){
			var is_type='no';
			$.ajax({
				url: "update_is_type_status.php",
				method: "POST",
				data: {is_type:is_type},
				success:function()
				{

				}
			})
		});

		//for removing the message.
		$(document).on('click', '.remove_chat', function(){
			var chat_message_id = $(this).attr('id');
			if (confirm("Are You sure you want to remove this chat?")) 
			{
				$.ajax({
					url: "remove_chat.php",
					method: "POST",
					data:{chat_message_id:chat_message_id},
					success: function(data)
					{
						update_chat_history_data();
					}
				})
			}

		});


  	});



  </script>

  <?php 
}
   ?>

