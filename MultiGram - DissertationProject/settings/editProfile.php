<?php
 $pdo= new PDO("mysql:host=localhost; dbname=dissertation; charset=utf8mb4", "root", "");
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
 			//for searching other user in system.
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
 	
 <main id="editProfile" >
 	<div class="container bg-secondary" style="display: flex;flex-direction: row;">
 	<!-- this div is for sidebar which will provide link to other settings -->
 	<div id="sidebar" style="width: 30%;">
 		<br><br>
 		<ul style="list-style: none">
 			<li><a id="edit" class="btn btn-dark" href="#">Edit Profile</a></li><br>
 			<li><a id="change" class="btn btn-dark" href="security.php">Security</a></li><br>
 			<li><a id="accounts" class="btn btn-dark" href="accounts.php">Accounts</a></li>
 		</ul>
 	</div>
 	<div id="mainbar" style="background-color: lightgrey; padding: 2%;width: 70%; border-top-right-radius: 10%;">
 		

 	<?php  
 	$id = $_SESSION['id'];
 	$user = $pdo->query("SELECT * FROM users WHERE user_id = '$id'")->fetch();
 		?>
 		<div class="container" style="">
 		<!-- form to edit profile -->
 		<h1>Edit your profile</h1> 			
 		<form action="" method="POST" class="editForm" >
 			<input type="hidden" name="id" value="<?php echo $user['firstname'] ?>">
 			<!-- for editing firstname -->
 			<label>Firstname:</label>
 			<input type="text" class="form-control" name="firstname" value="<?php echo $user['firstname'] ?>"><br>


 			<!-- for editing lastname -->
 			<label>Lastname:</label>
 			<input type="text" class="form-control" name="lastname" value="<?php echo $user['lastname'] ?>"><br>

 			<!-- for editing username -->
			<label>Username:</label>
 			<input type="text" class="form-control" name="username" value="<?php echo $user['username'] ?>"><br>

 			<!-- for editing birthday -->
 			<label>Birthday</label>
			<input class="form-control" id="birthday" type="date" name="date_of_birth" min="1960"  autocomplete ="off" value="<?php echo $user['date_of_birth'] ?>">
			<br>

			<!-- for editing contact-no -->
 			<label>Contact_no:</label>
 			<input type="text"  class="form-control" name="contact" value="<?php echo $user['contactNo'] ?>"><br>

 			<!-- for editing gender -->
 			<label>Gender:</label>
 			<select class="form-control" name="gender" style="width:40%">
 				<option value="<?php echo $user['gender'] ?>"><?php echo $user['gender'] ?></option>
 				<option value="Male">Male</option>
 				<option value="Female">Female</option>
 			</select>
 			<br>

 			<button type="submit" class="btn btn-light" name="editProfile">Save</button>
 		</form>

 		</div>

 	  	</div>
 	  </div>
 	  	<div id="responseProfileError">
 	  		
 	  	</div>
 </main>
 
 <!-- for uploading the profile information -->
 <script type="text/javascript">
 	$(function(){ 
 		$(document).on("submit",".editForm", function(event){
 			event.preventDefault();
 			// alert("work ing");
 			$.ajax({
 				type: "POST",
 				url: "../Include/update.php",
 				data:$(this).serialize(),
 				success: function(responseProfileError){
 				// alert(responseProfileError);

 				if(responseProfileError == "empty"){
 					$("#responseProfileError").html("<p class='alert alert-warning' style='Display: none'>**You must fill all input except username and contact no.</p>");
 					$("#responseProfileError .alert").slideDown("slow"); 
 					$("#responseProfileError").css('color', 'red');
 				 }
 				 //check if name is valid or not.
 				 if(responseProfileError == "name"){
					$("#responseProfileError").html("<div class='alert alert-warning' style='Display: none'>**Invalid first/ lastname.</div>");
					$("#responseProfileError .alert").slideDown("slow");
					$("#responseProfileError").css('color', 'red');
 				}
 				//check if username is valid or not.
 				if(responseProfileError == "username"){
					$("#responseProfileError").html("<div class='alert alert-warning' style='Display: none'>**Invalid Username.</div>");
					$("#responseProfileError .alert").slideDown("slow");
					$("#responseProfileError").css('color', 'red');
 				}

 				//check if username is already taken or not.
 				if(responseProfileError == "user taken"){
					$("#responseProfileError").html("<div class='alert alert-warning' style='Display: none'>**Username Already taken.</div>");
					$("#responseProfileError .alert").slideDown("slow");
					$("#responseProfileError").css('color', 'red');
 				}

 				
 				//check if email address is taken or not
 				if(responseProfileError == "taken"){
					$("#responseProfileError").html("<div class='alert alert-warning' style='Display: none'>**Email address already taken.</div>");
					$("#responseProfileError .alert").slideDown("slow");
					$("#responseProfileError").css('color', 'red');
 				}
 				
 				if(responseProfileError == "success"){
 					$("#responseProfileError").html("<div class='alert alert-success' style='Display: none'>Update Successful.</div>");
 					$("#responseProfileError .alert").slideDown("slow");
 					// window.location.href = "../settings/editProfile.php";
 				}
 				}
 			});
 		});
 	});

 </script>

<footer class="bg bg-secondary">
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>

 
 </body>
 </html>
 		<?php 
 	// }
 }
 	else
 	{
 		header('Refresh: 1; url =../Layouts/index.php');
 	}
 	?>		
 

 