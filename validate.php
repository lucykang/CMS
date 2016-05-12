<?php ob_start(); 
require_once('header.php');

//store user inputs and hash 
$username = $_POST['username'];
$password = hash('sha512', $_POST['password']);

try{
    //connect to the db
    require('db.php');

    //query the database
    $sql = "SELECT user_id FROM users WHERE username = :username AND password = :password";

    //execute the query
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
    $cmd->execute();
    $result = $cmd->fetchAll();

    //check how many users matched the username hashed password
    if (count($result) >= 1) {
        echo 'Logged in Successfully.';

        //store the user identity before they leave this page	
        foreach  ($result as $row) {
            //access the existing session
            session_start();

            //store the user_id in the session object
            $_SESSION['user_id'] = $row['user_id'];

            //load the user admin page
            header('Location:users.php');
        }
    }
    //if the user was not found in the database, show message.
    else {
?>
<div class="alert alert-info" role="alert">
    <p>Oops! Your Username or Password is invalid. Please try again or contact our support team.</p>
</div>
<?php
    }
    //disconnect
    $conn = null;
}
catch (exception $e){
    mail('200294841@student.georgianc.on.ca', 'Validate Error', $e);
    header('location:error.php');
}

require_once('footer.php');
ob_flush(); 
?>
