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
else{

	if(isset($_POST["password"])){
	$password = $_POST["password"];
	}

	if(isset($_POST["newPassword"])){
	$newPassword = $_POST["newPassword"];
	}

	if(isset($_POST["confirmPassword"])){
	$confirmPassword = $_POST["confirmPassword"];
	}

	
	if(empty($password)){
		echo "empty";
	}
	else{
		
		$id = $_SESSION['id'];
		$sql = "SELECT * FROM users WHERE user_id = '$id' AND activation=1";
		$result = mysqli_query($connect, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck>0){	
			if($row=mysqli_fetch_assoc($result)){
				$check = password_verify($password, $row['password']);

				if($check){
					if ($password == $newPassword) {
						echo 'same';
					}
					else{
					// echo 'correct';
					if (empty($newPassword) || empty($confirmPassword)) {
						echo 'new empty';
					}
					
					else{
						if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $newPassword)) 
						{
							echo 'invalid';
						}
						else
						{
							if ($newPassword != $confirmPassword) {
								echo 'not same';
							}
							else{ 
								$sql = "UPDATE users
										SET password = :password
										WHERE user_id = :id";
								$result = [
									'password' 	=> password_hash($_POST['newPassword'], PASSWORD_DEFAULT),
									'id'		=> $_SESSION['id']
								];
								$statement = $pdo->prepare($sql);
								if ($statement->execute($result)) {
									echo 'success';
								}
								
							}
						}
					}
				  }
				}
				else{
					echo 'incorrect';
				}
			}
		}
	}
}
				


