<?php ob_start();
require_once('auth.php');

$title = "Delete Page";

require_once('header.php');

$page_id = $_GET['page_id'];

try{
    //connect to the db
    require('db.php');
    
    //setup delete data command
    $sql = "DELETE FROM pages WHERE page_id = :page_id";
    
    //execute the command
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
    $cmd->execute();
    
    //drop the connection
    $conn = null;
}catch (exception $e){
    mail('200294841@student.georgianc.on.ca', 'Delete Page Error', $e);
    header('location:error.php'); 
}

//redirect to the updated edit-page.php
header('location:edit-page.php');

require_once('footer.php');

ob_flush();
?>