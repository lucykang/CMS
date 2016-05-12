<?php
ob_start();
require_once('auth.php');

//set the page title
$title = 'User Information Updated';

//show header on the page
require_once('header.php');

//store the form inputs in the variables
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$user_id = $_POST['user_id'];

$ok = true; // this variable indicates whether the forms are filled or not.

//for parameter in the email link
$headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";

try{
    //connect to the db
    require('db.php');

    //if there was a user_id from the query, update the information in the db.
    if (!empty($user_id)) {        
    $sql = "UPDATE users SET username = :username, password = :password, first_name = :first_name, last_name = :last_name WHERE user_id = :user_id";
    }
    
    //if there was no user_id, register as a new user.
    else { 
        //input validation
        if (empty($username)){
            echo 'Username is required <br/>';
            $ok = false;
        }
        if (empty($password)){
            echo 'Password is required <br />';
            $ok = false;
        }
        if ($password != $confirm){
            echo 'Passwords must match <br />';
            $ok = false;
        }
        if (empty($first_name)){
            echo 'First Name is required <br />';
            $ok = false;
        }
        if (empty($last_name)){
            echo 'Last name is required <br />';
            $ok = false;
        }
        
        //if the username has been entered, check if there's a same username (email) in the db.
        $sql = "SELECT * FROM users WHERE username = :username";

        //execute sql query to find the same username
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
        $cmd->execute();
        $result = $cmd->fetchAll();

        //if found, redirect the user to the user list page.
        if (count($result) >= 1) {
?>
            <div class="alert alert-info" role="alert">
            <p>The username already exists. You will be redirected to the registration page in 5 seconds.</p>
            </div>
<?php
            $ok = false;

            //load the user admin page
            header('refresh:5; url=register.php');

            exit;
        }
        if ($ok){
            //hash the password
            $password = hash('sha512', $password);

            //set up the SQL $ add the values given from the parameters
            $sql = "INSERT INTO users (username, password, first_name, last_name) VALUES (:username, :password, :first_name, :last_name)";
        }
    }
    
    $cmd = $conn->prepare($sql);
    
    //add user_id parameter if we are updating
    if (!empty($user_id)) {
        $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    }
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
    $cmd->bindParam(':first_name', $first_name, PDO::PARAM_STR, 50);
    $cmd->bindParam(':last_name', $last_name, PDO::PARAM_STR, 50);

    //execute
    $cmd->execute();

    //disconnect
    $conn = null;
}
catch (exception $e){
    mail('200294841@student.georgianc.on.ca', 'Save User Error', $e);
    header('location:error.php');
}

//send a confirmation email to the user who was registered as an new admin.
if(!empty($user_id)) {
    mail($email, 'Registration Confirmation', 'This email is to confirm that you are registered as an admin user. If you would like to edit your information, please log in through this <a href="http://gc200294841.computerstudi.es/php/assn2/login.php">link</a> and update from the user list. Have a good day!',$headers);
}

//show confirmation message in the screen
echo "<h2>User information added and updated.</h2><br />";
//provide link to go back to the form to add more admin users.
echo 'Click <a href="register.php">here</a> to add or edit more admin users on the list.';

require_once('footer.php');
ob_flush();
?>