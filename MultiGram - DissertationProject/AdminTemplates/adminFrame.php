<?php
$pdo = new PDO('mysql:dbname=Dissertation;host=127.0.0.1', 'root', ''); 
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<link rel="stylesheet" type="text/css" href="../Styles/Style.css">
 	<title>
 	</title>
 </head>
 <body>
 
 <header class="userHeader">
 	<div class="LS">
		 	<div class="logo">
		 		<a href="adminsLayout.php"><b>MultiGram</b></a>
		 	</div>

		 	<div class="srch">
				<form class="searchForm" action="POST" >
					<input class="searchALl" type="search" name="srh" placeholder="Search..." required="">
					<input class="searchBtn" type="submit" name="srhBtn" value="search">
				</form>
			</div>
	</div>
 </header>
 <nav class="nav">
 	<ul>
 		<li><a href="userLayout.php?user=userIndex"><b>Home</b></a></li>
 		<li>|</li>
 		<li><a href=""><b>Username</b></a></li>
 		<li>|</li>
 		<li><a href=""><b>Messages</b></a></li>
 		<li>|</li>
 		<li><a href=""><b>Notification</b></a></li>
 		<li>|</li>
 		<li><a href=""><b>More</b></a></li>

 	</ul>
 </nav>
 <main class="admin">
 	<nav class="mininav">
 		<ul>
			<li><a href=""><b>All</b></a></li>
 			<li>|</li>
			<li><a href=""><b>Photos</b></a></li>
 			<li>|</li>
			<li><a href=""><b>Vidoes</b></a></li>
 		</ul>
 	</nav>
<?php echo $content; ?>		
 </main>

<footer>
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 
 </body>
 </html>