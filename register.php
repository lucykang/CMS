<?php 
ob_start();
require_once('auth.php');
//make the site private so that only admin could register new user.
//require_once('auth.php');

$title = 'User Registration';

//call html header from header.php
require_once('header.php');
try{
    //check if we have an user ID in the querystring
    if (!empty($_GET['user_id'])) {

	//decode the id from the string and store in a variable
	$user_id = base64_decode($_GET['user_id']);
    
    //connect to the db
    require('db.php');
   
    //select all the data for the selected user from the users table
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
   
    //store each value from the database into a variable
    foreach ($result as $row) {
        $username = $row['username'];
        $password = $row['password'];
    	$first_name = $row['first_name'];
    	$last_name = $row['last_name'];
    }
   
    //disconnect
	$conn = null;
    }
}
    catch (exception $e){
        mail('200294841@student.georgianc.on.ca', 'Registration Page Error', $e);
        header('location:error.php');
    }
?>
<div class="container">
    <form method="post" action="save-admin.php" class="form form-horizontal">
        <h4> Please fill all fields provided </h4>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
        
        <div class="form-group">
            <label for="username" class="col-sm-2">Username: </label>
            <input name="username" type="email" required value="<?php echo $username; ?>" placeholder="user@email.com" />
        </div>
        
        <div class="form-group">
            <label for="password" class="col-sm-2">Password: </label>
            <input type="password" name="password" required />
        </div>
        
        <div class="form-group">
            <label for="confirm" class="col-sm-2">Confirm Password: </label>
            <input type="password" name="confirm" required />
        </div>
        
        <div class="form-group">
            <label for="first_name" class="col-sm-2">First Name: </label>
            <input name="first_name" required value="<?php echo $first_name; ?>" />
        </div>
        
        <div class="form-group">
            <label for="last_name" class="col-sm-2">Last Name: </label>
            <input name="last_name" required value="<?php echo $last_name; ?>" />
        </div>
        
        <div class="col-sm-offset-2">
            <input type="submit" value="Register" class="btn btn-primary" />
        </div>
    </form>
</div>
<?php
require_once('footer.php');
ob_flush();
?>