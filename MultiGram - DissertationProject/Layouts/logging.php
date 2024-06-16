<?php 
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dissertation';

$connect = mysqli_connect($host, $username, $password, $dbname);
$pdo= new PDO("mysql:host=localhost; dbname=dissertation; charset=utf8mb4", "root", "");

if(isset($_SESSION['id'])){
 header('Refresh: 1; url =../HTML/userLayout.php');
 }

else{

	if(isset($_POST["emails"])){
	$email = $_POST["emails"];
	}

	if(isset($_POST["pwd"])){
		$password = $_POST["pwd"];
	}
	if(empty($email)||empty($password)){
		echo "empty";
	}
	else{
	
	$sql = "SELECT * FROM users WHERE (username='$email' OR emailAddress='$email') AND (activation = 1 AND verified = 1)";
	$result = mysqli_query($connect, $sql);
	$resultCheck = mysqli_num_rows($result);
	
	if($resultCheck>0){
		if($row=mysqli_fetch_assoc($result)){
			
			$check = password_verify($password, $row['password']);
			if($check){
				$_SESSION['loggedin'] = $row['emailAddress'];
				$_SESSION['id'] 	= $row['user_id'];
				$_SESSION['last_login '] = $row['last_login'];
				
				echo "success";
				$pdo= new PDO("mysql:host=localhost; dbname=dissertation; charset=utf8mb4", "root", "");
				$sub_query=	"
			 	INSERT INTO login_details (user_id) 
				 VALUES ('".$_SESSION['id']."')
				 ";
				 $statement = $pdo->prepare($sub_query);
				 $statement->execute();
				 $_SESSION['login_details_id'] = $pdo->lastInsertId();
				}
			
			else
			{
				echo "error";
			}
		}
	}
	else{
	$sql = "SELECT * FROM users WHERE (username='$email' OR emailAddress='$email') AND (activation = 0)";
	$result = mysqli_query($connect, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck>0){
		if ($row=mysqli_fetch_assoc($result)) {
			$check = password_verify($password, $row['password']);
			if($check){
			$_SESSION['reAlive'] = $row['user_id'];
			echo 'deactivated';
		}
		else{
			echo "error";
		}
		}
		
	}
	else{
		echo 'nouser';
	}

	}

	}

}   


