<?php 
// get_users.php

include('../Main/database.php');
session_start();
$id = $_SESSION['id'];
if (empty($_POST['name'])) {
	
}
else
{

$sql = "
	SELECT * FROM users WHERE (firstname like '%".$_POST['name']."%' OR lastname like '%".$_POST['name']."%')
	AND (user_id != '$id' AND activation = 1 AND verified = 1) LIMIT 2" ;

$array = $pdo->query($sql);

foreach ($array as $key) {
?>

	<div id="users">
		<span><?php echo '<a class="dropdown-item bg-secondary" href="../profile/otherUsersProfile.php?id='.$key['user_id'].'"><div class="btn btn-secondary" style="display: flex; flex-direction: row;"><div style="width: 10%;"> '.get_profile_picture($pdo, $key['user_id']).' </div><div><b><h5> '.$key['firstname'].' '.$key['lastname'].' </h5></b></div></div></a>'; ?></span>

	</div>

<?php 
}

}
 ?>