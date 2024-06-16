<?php
include("../Main/database1.php");
include("../Main/databaseTable.php");
session_start();
if (isset($_POST['deactivateAccount'])) {
 		$sql = "UPDATE users
				SET activation = 0
				WHERE user_id = :id";
		$result = [
			'id'		=> $_SESSION['id']
		];
		$statement = $pdo->prepare($sql);
		if ($statement->execute($result)) {
		echo "Account_Deactivated";
 		header('Refresh: 1; url =../HTML/userLayout.php?user=userLogouts');
		}

 }

  
 if (isset($_POST['deleteAccount'])) {
 		$id = $_SESSION['id'];
 		// first deleteing all the user comments
 		$sql = "DELETE FROM  comments
				WHERE commenter = '$id'";
		
		$statement = $pdo->prepare($sql);
			if ($statement->execute()) {
				
				// second deleting all the user connections.
			$sql = "DELETE FROM  tbl_follow
					WHERE receiver_id = '$id'";


			

			$statement = $pdo->prepare($sql);
				if ($statement->execute()) {

			
					// third deleting all the user post
						$sql = "DELETE FROM  post
								WHERE user_Id = '$id'";
						
						$statement = $pdo->prepare($sql);
						if ($statement->execute()) {
						// deleting directory
						$user = $pdo->query("SELECT * FROM users WHERE user_id = '$id'")->fetch();
						$lower ='../Datas/'.$user['emailAddress'];//for profile folder deletion.
						$lower2 ='../Datas/'.$user['emailAddress'];//for files folder deletion.
						$lower3 ='../Datas/'.$user['emailAddress'].'/';//for main folder deletion.
						if (!is_dir($lower)) {
						        throw new InvalidArgumentException("$lower must be a directory");
						    }

					    if (!is_dir($lower2)) {
					        throw new InvalidArgumentException("$lower must be a directory");
					    }
					   
					    if (substr($lower, strlen($lower) - 1, 1) != '/') {
					       
					        $lower .= '/profile/';
					    }

					    if (substr($lower2, strlen($lower2) - 1, 1) != '/') {
					       
					        $lower2 .= '/files/';
					    }
					    //now deleting profile
					    $folders = glob($lower . '*', GLOB_MARK);
					    foreach ($folders as $folder) {
					        if (is_dir($folder)) {
					            self::deleteDir($folder);
					        } else {
					            unlink($folder);
					        }
					    }
					    //now deleting files.
					   $folders2 = glob($lower2 . '*', GLOB_MARK);
					    foreach ($folders2 as $folder2) {
					        if (is_dir($folder2)) {
					            self::deleteDir($folder2);
					        } else {
					            unlink($folder2);
					        }
					    }
						    rmdir($lower);//delete sub folder profile.
						    rmdir($lower2);//delete sub-folder files.
						    rmdir($lower3);//delete main folder.
							// echo 'deleted ';

							// last deleting users accounts
							$sql = "DELETE FROM  users
								WHERE user_id = '$id'";
							
							$statement = $pdo->prepare($sql);
							if ($statement->execute()) {

								echo "Account_Deleted";
								header('Refresh: 1; url =../HTML/userLayout.php?user=userLogouts');
							}
						}
				
				}
			
	 		
			}

 }
 else{


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
 <main id="accountsSeting" >
 	<div class="container bg-secondary" style="width: 100%; display: flex;flex-direction: row;">
 	<div id="sidebar" style="width: 30%;">
 		<br><br>
 		<ul style="list-style: none">
 			<li><a id="edit" class="btn btn-dark" href="editProfile.php">Edit Profile</a></li><br>
 			<li><a id="change" class="btn btn-dark" href="security.php">Security</a></li><br>
 			<li><a id="accounts" class="btn btn-dark" href="#">Accounts</a></li>
 		</ul>
 	</div>
 	<div id="mainbar" style="background-color: lightgrey; padding: 2%; width: 70%; border-top-right-radius: 10%;">
 		

 	<?php  
 	$id = $_SESSION['id'];
 	$user = $pdo->query("SELECT * FROM users WHERE user_id = '$id'")->fetch();
 		?>
 		<div class="container" style="">

 		<h1>Account Setting</h1> 			
 		<div>
 			<form class="goForm" action="" method="POST">
 				<label>Password:</label>
 				<input type="Password" class="form-control" name="password" id="password" placeholder="Your existing password.">
 				<br>

 				<button type="submit" id="goButton" class="btn btn-info">Go for it</button>
 				<p>When you enter your password and click the "Go for it" button then below buttons will be active to go.</p>
 				<br><br>

 				<div class="dropdown-divider"></div>
 				<div class="dropdown-divider"></div>
 			</form>
 			<div>
 				<button type="submit" disabled="true" class="btn btn-light" id="deactivate" name="deactivate">Deactivate Account</button>
 				<button type="submit" disabled="true" id="delete" class="btn btn-light" name="delete">Delete Account</button>
 				</div>
 		</div>
 		</div>

 	  	</div>
 	  </div>
 	  	<div id="responseAccountError">
 	  	</div>
 </main>

 <div id="deactivate_user" style="">
 	<div id="deactivate_user_content" style="">
 		 <form action="" class="deactivated" method="POST" >
 		 	<?php
 		 		$uid = $_SESSION['id']; 
			$query = "
			SELECT * FROM users
			WHERE user_Id = '$uid'
			";
			$statement = $pdo->prepare($query);
			$statement->execute();
			$result = $statement->fetch();
			echo '<p>Hello <b>'.$result['firstname'].' '.$result['lastname'].'</b>, Are you sure want to deactivate your account. After deactivating your account your data`s will not be lost but your account and post will be hidden from the system. you can reactivate your when you re-login to the system again. Thank you for being here. See you soon.</p>'; 
 		 	 ?>
 		 	<button type="submit" class="btn btn-info" name="deactivateAccount">Deactivate</button>
 		 	<div class="btn btn-light" id="cancelDeactive">Cancel</div>
 		 </form>
 	</div>
 </div>
 <script type="text/javascript">
 	document.getElementById('deactivate').addEventListener('click', function(){
	document.querySelector('#deactivate_user').style.display='flex';
 	});
 	document.querySelector('#cancelDeactive').addEventListener('click', function(){
	document.querySelector('#deactivate_user').style.display='none';
 	});
 </script>


 <div id="delete_user" style="">
 	<div id="delete_user_content" style="">
 		 <form action="" class="deleted" method="POST" >
 		 	<?php
 		 	$uid = $_SESSION['id']; 
			$query = "
			SELECT * FROM users
			WHERE user_Id = '$uid'
			";
			$statement = $pdo->prepare($query);
			$statement->execute();
			$result = $statement->fetch();
			echo '<p>Hello <b>'.$result['firstname'].' '.$result['lastname'].'</b>, Are you sure want to delete your account. After deleting your account your data`s will also be lost and your account and post will be deleted from the system. you can`t reactivate your account again. Once, you clicked delete. There is no turning back.</p>'; 
 		 	 ?>
 		 	<button type="submit" class="btn btn-info" name="deleteAccount">Delete</button>
 		 	<div class="btn btn-light" id="cancelDelete">Cancel</div>
 		 </form>
 	</div>
 </div>
 <script type="text/javascript">
 	document.getElementById('delete').addEventListener('click', function(){
	document.querySelector('#delete_user').style.display='flex';
 	});
 	document.querySelector('#cancelDelete').addEventListener('click', function(){
	document.querySelector('#delete_user').style.display='none';
 	});
 </script>




 <script type="text/javascript">
 	$(function(){ 
 		$(document).on("submit",".goForm", function(event){
 			event.preventDefault();
 			// alert('working');
 			$.ajax({
 				type: "POST",
 				url: "../Include/checkPassword.php",
 				data:$(this).serialize(),
 				success: function(responseAccountError){
 					// alert(responseAccountError);
 					if(responseAccountError == "empty"){
 					$("#responseAccountError").html("<p class='alert alert-warning' style='Display: none'>**Enter Your existing password to change your password.</p>");
 					$("#responseAccountError .alert").slideDown("slow"); 
 					$("#responseAccountError").css('color', 'red');
 					$("#password").css('border-color','red');

 				 }
 				 //when the entered old password doesn't match.
 				 if(responseAccountError == "incorrect"){
 					$("#responseAccountError").html("<p class='alert alert-warning' style='Display: none'>**Incorrect password.</p>");
 					$("#responseAccountError .alert").slideDown("slow"); 
 					$("#responseAccountError").css('color', 'red');
 					$("#password").css('border-color','red');
 				 }
					//when the entered old password does match.
 				 if(responseAccountError == "correct"){
 					$("#responseAccountError").html("<p class='alert alert-success' style='Display: none'>**Correct password.</p>");
 					$("#responseAccountError .alert").slideDown("slow"); 
 					$("#responseAccountError").css('color', 'green');
 					$("#password").css('border-color','green');
 					$("#password").attr("disabled", true);
 					$("#goButton").attr("disabled", true);
 					$("#password").attr("disabled", true);
 					$('#deactivate').attr("disabled", false);
 					$('#delete').attr("disabled", false);
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
 }
 	?>		
 

 