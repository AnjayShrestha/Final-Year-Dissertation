<?php 
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dissertation';

$connect = mysqli_connect($host, $username, $password, $dbname);

if(isset($_SESSION['id'])){
 header('Refresh: 1; url =../HTML/userLayout.php');
 }

else{
	if(isset($_POST["password"])){
		$password = $_POST["password"];
	}
	if(empty($password)){
		echo "empty";
	}
	else{
	$id = $_SESSION['reAlive'];
	$sql = "SELECT * FROM users WHERE user_id = '$id' AND activation = 0";
	$result = mysqli_query($connect, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck>0) {
		if ($row=mysqli_fetch_assoc($result)) {
			$check = password_verify($password, $row['password']);
			if($check){
			$_SESSION['loggedin'] = $row['emailAddress'];
				$_SESSION['id'] 	= $row['user_id'];
				$pdo= new PDO("mysql:host=localhost; dbname=dissertation; charset=utf8mb4", "root", "");
				$sql = "UPDATE users
						SET activation = 1
						WHERE user_id = :id";
				$result = [
					'id'	=> $_SESSION['reAlive']
				];
				$statement = $pdo->prepare($sql);
				if ($statement->execute($result)) {
				echo "success";
		 		header('Refresh: 1; url =../HTML/userLayout.php?user=userLogouts');
				}
				
				
				$sub_query=	"
			 	INSERT INTO login_details (user_id) 
				 VALUES ('".$_SESSION['id']."')
				 ";
				 $statement = $pdo->prepare($sub_query);
				 $statement->execute();
				 $_SESSION['login_details_id'] = $pdo->lastInsertId();
		}
		else{
			echo "error";
			}
		}
	}
	else{
		echo 'no';
	}

	}

	}
    // $connect = mysqli_connect("localhost", "root", "", "dissertation");


