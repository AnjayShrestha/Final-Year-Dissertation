<?php
include("../Main/database1.php");
include("../Main/databaseTable.php");
session_start();
 ?>
 
 <?php 
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
 	
 <main id="settingSecurity" >
 	<div class="container bg-secondary" style="display: flex;flex-direction: row;">
 	<div id="sidebar" style="width: 30%; ">
 		<br><br>
 		<ul style="list-style: none">
 			<li><a id="edit" class="btn btn-dark" href="editProfile.php">Edit Profile</a></li><br>
 			<li><a id="change" class="btn btn-dark" href="#">Security</a></li><br>
 			<li><a id="accounts" class="btn btn-dark" href="accounts.php">Accounts</a></li>
 		</ul>
 	</div>
 	<div id="mainbar" style="background-color: lightgrey; padding: 2%;width: 70%; border-top-right-radius: 10%;">
 		

 	<?php  
 	$id = $_SESSION['id'];
 	$user = $pdo->query("SELECT * FROM users WHERE user_id = '$id'")->fetch();
 		?>
 		<div class="container" style="">

 		<h1>Change Your Password</h1> 
 		<p>Are you sure want to change your password.</p>
 		<form method="POST" action="" class="changePassword">
 			<p>Please enter your existing password.</p>
 			<label>Old Password:</label>
 			<input type="password" id="password" class="form-control" name="password">
 			
 			<div class="dropdown-divider"></div>
 			<p>Now enter new password and confirm your new password.</p>
 			<label>New Password:</label>
 			<input type="password" id="newPassword" class="form-control" name="newPassword" placeholder="minimum: 8 character">

 			<label>Confirm Password:</label>
 			<input type="password" id="confirmPassword" class="form-control" name="confirmPassword"><br>

 			<button type="submit" class="btn btn-light">Change Password</button>

 		</form>		
 		</div>

 	  	</div>
 	  <!-- 	<div id="response">
 	  		
 	  	</div> -->
 	  </div>
 	  	<div id="response">
 	  		
 	  	</div>
 </main>
 
 <!-- for uploading the profile information -->
 <script type="text/javascript">
 	$(function(){ 
 		$(document).on("submit",".changePassword", function(event){
 			event.preventDefault();
 			// alert("work ing");
 			$.ajax({
 				type: "POST",
 				url: "../Include/changePassword.php",
 				data:$(this).serialize(),
 				success: function(response){
 				// alert(response);
 				//when old password input is empty.
 				if(response == "empty"){
 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Enter Your existing password to change your password.</p>");
 					$("#response .alert").slideDown("slow"); 
 					$("#response").css('color', 'red');
 					$("#password").css('border-color','red');

 				 }
 				 //when the entered old password doesn't match.
 				 if(response == "incorrect"){
 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Incorrect password.</p>");
 					$("#response .alert").slideDown("slow"); 
 					$("#response").css('color', 'red');
 					$("#password").css('border-color','red');
 				 }

 				 // when any one of confirm password or new password input is empty
 				 if(response == "new empty"){
 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Please fill both of the below input to change your password.</p>");
 					$("#response .alert").slideDown("slow"); 
 					$("#response").css('color', 'red');
 					$("#password").css('border-color','green');

 				 }
 				 //when new password is invalid
 				  if(response == "invalid"){
 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Must contain at least one number and one uppercase and lowercase letter.</p>");
 					$("#response .alert").slideDown("slow"); 
 					$("#response").css('color', 'red');
 					$("#password").css('border-color','green');
 					$("#newPassword").css('border-color','red');
 					$("#confirmPassword").css('border-color','none');

 				 }
 				 //when old password matches with new password.
 				 if(response == "same"){
 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Your new password is same as your old password. So, chose new.</p>");
 					$("#response .alert").slideDown("slow"); 
 					$("#response").css('color', 'red');
 					$("#password").css('border-color','red');
 					$("#newPassword").css('border-color','red');
 				 }
 				 //when confirm password doesn't math with new password.
 				 if(response == "not same"){
 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Confirmed password doesn't matches new password.</p>");
 					$("#response .alert").slideDown("slow"); 
 					$("#response").css('color', 'red');
 					$("#password").css('border-color','green');
 					$("#newPassword").css('border-color','red');
 					$("#confirmPassword").css('border-color','red');
 				 }
 				 //when password is successfully changed.
 				if(response == "success"){
 					$("#response").html("<div class='alert alert-success' style='Display: none'>Password Changed.</div>");
 					$("#response .alert").slideDown("slow");
 					$("#password").css('border-color','green');
 					$("#newPassword").css('border-color','green');
 					$("#confirmPassword").css('border-color','green');
 					window.location.href = "../HTML/userLayout.php?user=userLogouts";
 				}

 				}
 			});
 		});
 	});

 </script>

<footer class="bg-secondary">
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
<!-- for searching -->
 
 </body>
 </html>
 		<?php 
 	}
 	else
 	{
 		header('Refresh: 1; url =../Layouts/index.php');
 	}
 	?>		
 

 