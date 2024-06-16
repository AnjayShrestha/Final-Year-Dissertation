<?php 

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dissertation';
$pdo= new PDO("mysql:host=localhost; dbname=dissertation; charset=utf8mb4", "root", "");
require('../Main/databaseTable.php');
$connect = mysqli_connect($host, $username, $password, $dbname);
session_start();
// echo 'hello';

if(!isset($_SESSION['id'])){
 header('Refresh: 1; url =../Layouts/index.php');
 }
 
 else
 {

	if(isset($_POST["password"])){
	$password = $_POST["password"];
	}

	if(empty($password)){
		echo "empty";
	}
	else
	{
		$id = $_SESSION['id'];
		$sql = "SELECT * FROM users WHERE user_id = '$id' AND activation=1";
		$result = mysqli_query($connect, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck>0){	
			if($row=mysqli_fetch_assoc($result)){
				$check = password_verify($password, $row['password']);

				if($check)
				{
					echo 'correct';
				}
				else{
					echo 'incorrect';
				}
	}

 }
}
}