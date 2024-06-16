
<?php
$pdo = new PDO('mysql:dbname=dissertation;host=127.0.0.1', 'root', ''); 
session_start();

 if(isset($_SESSION['id'])){
 	header('Refresh: 1; url =../HTML/userLayout.php');		
 	}
	
	
 		else
 		{
 			
 		?>

 <!DOCTYPE html>
 <html>
 <head>
 	<!-- <link rel="stylesheet" type="text/css" href="../Styles/bootstrap.css"> -->
 	<link rel="stylesheet" type="text/css" href="../Styles/Style.css">
 	<!-- bootstrap property -->
 	<link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="../Bootstrap/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="../Bootstrap/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="../Bootstrap/bootstrap.min.js"></script>
 	<title>
 	</title>
 </head>
 <body>
 
 <header>
 	<div class="logo">
 		<a href="Index.php"><b>MultiGram</b></a>
 	</div>
 </header>
 <nav>
 	
 </nav>
 <main class="index">
 			
 		<div class="text">
 			<p>Welcome to multigram. Where you can share your stories through pictures and videos with your friend and family.</p>
 		</div>
 		
	 	<div class="login">
	 		

		<form action="" class="LoginForm" method="POST">
				<label>Email Address/ Username:</label>
				<input type="text" class="form-control" id="email" name="emails" placeholder="Email Address/Username" >
				<br>
				<label>Password:</label>
				<input type="password" class="form-control" id="password" name="pwd" placeholder="Password" >
				<br>

				<input class="btn btn-dark" id="logBtn" type="submit" name="login"  value="Login">

				
				
				

				<label>Create new account clicking below</label><br>
				<a href="signup.php">Create a New Account</a>

			</form>
			<div id="responseLoginError"></div>	
	 	</div>
 	<script type="text/javascript">
 	$(function(){ 
 		$(document).on("submit",".LoginForm", function(event){
 			event.preventDefault();
 			// alert("work ing");
 			$.ajax({
 				type: "POST",
 				url: "logging.php",
 				data:$(this).serialize(),
 				success: function(responseLoginError){
 				// alert(responseLoginError);
 				// if any input is empty.
	 				if(responseLoginError == "empty"){
	 					$("#responseLoginError").html("<p class='alert alert-warning' style='Display: none'>**Please enter your email address and password.</p>");
	 					$("#responseLoginError .alert").slideDown("slow"); 
	 					$("#responseLoginError").css('color', 'red');
	 				 }
	 				 // when login to the system was success
	 				if(responseLoginError == "success"){
	 					$("#responseLoginError").html("<div class='alert alert-success' style='Display: none'>Login Successful.</div>");
	 					$("#responseLoginError .alert").slideDown("slow");
	 					$("#responseLoginError").css('color', 'green');
	 					window.location.href = "../HTML/userLayout.php";

	 				}
	 				// when password is incorrect
	 				if(responseLoginError == "error"){
						$("#responseLoginError").html("<div class='alert alert-warning' style='Display: none'>**Password incorrect.</div>");
						$("#responseLoginError .alert").slideDown("slow");
						$("#responseLoginError").css('color', 'red');
	 				}
	 				// when the user is deactivated from the system.
	 				if(responseLoginError == "deactivated"){
	 					$("#responseLoginError").html("<div class='alert alert-warning' style='Display: none'>**Your account is Deactivated.<br></div>");
	 					$("#responseLoginError .alert").slideDown("slow");
	 					$("#responseLoginError").css('color', 'red');
	 					window.location.href = "userReactivated.php";
	 				}
	 				// wher the entered username or email addres is not entered
	 				if(responseLoginError == "nouser"){
	 					$("#responseLoginError").html("<div class='alert alert-warning' style='Display: none'>**Email/ username is not registered/ verified.</div>");
	 					$("#responseLoginError .alert").slideDown("slow");
	 					$("#responseLoginError").css('color', 'red');
	 				}

	 				
 				}
 			});
 		});
 	});

 </script>
 </main>

<footer>
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 
 </body>
 </html>

<?php
 	}
 	?>		
 

 