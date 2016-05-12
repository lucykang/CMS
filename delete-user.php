<?php ob_start(); 
require_once('auth.php');

$title = 'Delete User';

require_once('header.php');

//check the url for an id value & store in a variable
$user_id = base64_decode($_GET['user_id']);

try{
    //connect
    require('db.php');

    //set up the SQL DELETE command
    $sql = "DELETE FROM users WHERE user_id = :user_id";

    //execute the deletion
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();

    //disconnect
    $conn = null;
}
catch (exception $e){
    mail('200294841@student.georgianc.on.ca', 'Delete User Error', $e);
    header('location:error.php');
}
//redirect to delete confirmation page
header('location:delete-confirmation.php');

require_once('footer.php');
ob_flush(); ?>
