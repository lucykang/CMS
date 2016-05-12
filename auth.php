<?php
    //auth check
    //this code will make the site from public to private.
    session_start();
    if(!isset($_SESSION['user_id'])){ //if(empty($_SESSION['user_id'])){
        header('Location:login.php');   
    //stop the page
    exit();
}
?>