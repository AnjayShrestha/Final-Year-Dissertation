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
	if(isset($_POST["firstname"])){
	$firstname = $_POST["firstname"];
	}

	if(isset($_POST["lastname"])){
	$lastname = $_POST["lastname"];
	}

	if(isset($_POST["username"])){
	$username = $_POST["username"];
	}

	if(isset($_POST["contact"])){
		$contact= $_POST["contact"];
	}

	if(isset($_POST["date_of_birth"])){
		$date_of_birth= $_POST["date_of_birth"];
	}


	if(isset($_POST["gender"])){
		$gender= $_POST["gender"];
	}
	if(empty($firstname)||empty($lastname)||empty($date_of_birth)||empty($gender)){
		echo "empty";
	}
		
	else{
			//check if any name input are valid
		if (!preg_match("/^[A-Z][a-zA-Z -]+$/", $firstname) || !preg_match("/^[A-Z][a-zA-Z -]+$/", $lastname)) 
			{
				echo 'name';
			}
		else{

			if(!empty($username)){		
					 if (!preg_match("/^[A-Z][a-zA-Z0-9 -]+$/", $username)) 
					 {
			 		echo 'username';
			 		 }
					 else
					 {
					 	$id = $_SESSION['id'];
						$sql ="SELECT * FROM users WHERE user_id != '$id' AND username='$username'";
									$result = mysqli_query($connect, $sql);
									$resultCheck = mysqli_num_rows($result);
								if ($resultCheck > 0) {
									echo 'user taken';							
			 						}
		 						else{
						// check valid email.
																
												$stmt = $pdo->prepare('UPDATE users
														SET activation = "1",
														firstname = :firstname,
												 	    lastname = :lastname,
												 	    username = :username,
												 	    contactNo = :contact_no,
										 			    gender = :gender,
											 	    	date_of_birth = :date_of_birth
														WHERE user_id = :id;
												');//update given data in profile table.
												$result = [
													'id' => $_SESSION['id'],
													'firstname'		=> $_POST['firstname'],
													'lastname' 		=> $_POST['lastname'],
													'username'		=> $_POST['username'],
													'contact_no' 	=> $_POST['contact'],
													'gender' 		=> $_POST['gender'],
													'date_of_birth' => $_POST['date_of_birth']
												];
											$stmt->execute($result);//execute the table.
												echo 'success';
										
										}
									}
								}
			
					else{
											
									$stmt = $pdo->prepare('UPDATE users
											SET activation = "1",
											firstname = :firstname,
									 	    lastname = :lastname,
									 	    contactNo = :contact_no,
							 			    gender = :gender,
								 	    	date_of_birth = :date_of_birth
											   WHERE user_id = :id;
									');//update given data in cars table.
									$result = [
										'id' => $_SESSION['id'],
										'firstname'		=> $_POST['firstname'],
										'lastname' 		=> $_POST['lastname'],
										'contact_no' 	=> $_POST['contact'],
										'gender' 		=> $_POST['gender'],
										'date_of_birth' => $_POST['date_of_birth']
									];
								$stmt->execute($result);//execute the table.
									echo 'success';
							
							}
						}
					}
				}
	

