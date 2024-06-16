<?php 
// check.php
    $connect = mysqli_connect("localhost", "root", "", "dissertation");
	 if(isset($_POST["email_address"]))
	 {
		$query = "SELECT * FROM  users WHERE emailAddress  = '".$_POST["email_address"]."'";//query to get user email.
			$result = mysqli_query($connect, $query);
			echo mysqli_num_rows($result);
		}
 ?>