<?php 
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dissertation';

$connect = mysqli_connect($host, $username, $password, $dbname);

if (isset($_GET['vKey'])) 
{
	// process verification.
	$vKey = $_GET['vKey'];
	// $resultSet = $connect->query();
	$sql = "SELECT verified, verify_key  FROM users WHERE verified = 0 AND verify_key = '$vKey' LIMIT 1";
	$result = mysqli_query($connect, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {

		$update = $connect->query("UPDATE users SET verified = 1 WHERE verify_key = '$vKey' LIMIT 1");

		if ($update) {
			echo "you account has been verified. You may now login";
			echo "<a href='index.php' class='btn btn-secondary'>Go to Login page</a>";
		}
		else{
			echo $connect->error;
		}
	}
	else{
		echo "This account is invalid or already verified";
		echo "<a href='index.php' class='btn btn-secondary'>Go to Login page</a>";
	}
}

else
{
	die("Something went wrong");
}

 ?>

