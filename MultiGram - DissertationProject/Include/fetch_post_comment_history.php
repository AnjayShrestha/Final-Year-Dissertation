
<?php 
// fetch_post_comment_history.php

include('../Main/database.php');

session_start();

echo fetch_post_comment_history($_SESSION['id'], $_POST['to_post_id'], $pdo);


 ?>