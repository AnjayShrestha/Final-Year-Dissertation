
<?php
$pdo = new PDO('mysql:dbname=dissertation;host=127.0.0.1', 'root', ''); 
session_start();

 if(isset($_SESSION['reAlive'])){
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
 <main class="reActive" style=" margin-top: 5%; margin-left: 30%; margin-right: 30%;">
 		
	 	<div class="container" style="background: grey; padding:7%; border-radius: 2%;">
	 		

		<form action="" class="reLogin" method="POST">
				<?php 
				$id = $_SESSION['reAlive'];
 				$user = $pdo->query("SELECT * FROM users WHERE user_id = '$id'")->fetch();
				
 				$post = $pdo->query("SELECT * FROM post WHERE user_Id = '$id' AND postType = 'Profile Picture' ORDER BY post_Id DESC")->fetch();
				 
				 echo $post['textPost'];
				 ?>

				<?php echo '<p style="color: white">Welcome back <b>'.$user['firstname'].' '.$user['lastname'].'</b> Your account was deacativated by you or by the system. Now, enter your password and click "Activate" to activate you account again</p>' ?>
				<br>

				<input type="password" class="form-control" id="password" name="password" placeholder="Password" >
				<br>

				<input class="btn btn-dark" id="logBtn" type="submit" name="login"  value="Activate">		
			</form>	
	 	</div>

 	<div id="response"></div>
 </main>
<script type="text/javascript">
 	$(function(){ 
 		$(document).on("submit",".reLogin", function(event){
 			event.preventDefault();
 			// alert("work ing");
 			$.ajax({
 				type: "POST",
 				url: "activate.php",
 				data:$(this).serialize(),
 				success: function(response){
 				// alert(response);
	 				if(response == "empty"){
	 					$("#response").html("<p class='alert alert-warning' style='Display: none'>**Please enter your password.</p>");
	 					$("#response .alert").slideDown("slow"); 
	 					$("#response").css('color', 'red');
	 					$("#password").css('border-color', 'red');
	 				 }
	 				if(response == "success"){
	 					$("#response").html("<div class='alert alert-success' style='Display: none'>Login Successful.</div>");
	 					$("#response .alert").slideDown("slow");
	 					$("#response").css('color', 'green');
	 					window.location.href = "../HTML/userLayout.php";
	 				}
	 				if(response == "error"){
						$("#response").html("<div class='alert alert-warning' style='Display: none'>**Password incorrect.</div>");
						$("#response .alert").slideDown("slow");
						$("#response").css('color', 'red');
						$("#password").css('border-color', 'red');
	 				}
	 				
	 				if(response == "no"){
	 					$("#response").html("<div class='alert alert-warning' style='Display: none'>**Account is not deacativated.</div>");
	 					$("#response .alert").slideDown("slow");
	 					$("#response").css('color', 'red');
	 					window.location.href = "index.php";
	 				}
 				}
 			});
 		});
 	});

 </script>
<footer>
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 
 </body>
 </html>

<?php
 	
 	}
	
	
 		else
 		{
 		header('Refresh: 1; url =index.php');		
 	}
 	?>		
 

 