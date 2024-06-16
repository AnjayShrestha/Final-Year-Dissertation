<?php 
// get_users.php

include('../Main/database.php');


$sql = "
	SELECT * FROM users WHERE firstname like '%".$_post['name']."%'";

$array = $pdo->query($sql);

foreach ($array as $key) {
?>

	<div id="user"><img src="" id="pic /"><span><?php echo $key['firstname'].' '.$key['lastname'] ?></span>

	</div>

<?php 
}

 ?>