
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
 <main style="margin-left: 25%; margin-right: 25%; margin-top: 3%;">
 			
 		<div id="login">
 			<a href="index.php" class="btn btn-secondary">Go to Login page</a>
 		</div>		
 		<div align="center" class="alert alert-secondary" id="thank">
 			<p>Thank you.We have sent a verification email to the adddress you provided. please verify yourself.</p>
 			<img src="../Icons/msg.png" width="20%">
 		</div>

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
 

 