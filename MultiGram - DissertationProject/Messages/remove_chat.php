<?php 
// remove_chat.php


include("../Main/database.php");
//for removing the infromation from database chat_message.
if(isset($_POST["chat_message_id"]))
{
$query = "
UPDATE chat_message
SET status = '2'
WHERE chat_message_id = '".$_POST["chat_message_id"]."'
";

$statement = $pdo->prepare($query);

$statement->execute();


}

 ?>