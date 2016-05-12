<?php ob_start();
require_once('auth.php');

//set the page title
$title = 'Users List';

require_once('header.php');

try{
    //connect to db
    require('db.php');

    //set up an SQL query
    $sql = "SELECT * FROM users;";

    //execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $result = $cmd->fetchAll();

    //start the table and add the headings BEFORE our loop (only once)
    echo '<table class="table table-striped"><thead><th>User ID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Edit</th><th>Delete</th></thead><tbody>';

    //loop through the query result where $result is the dataset & $row is 1 record
    foreach($result as $row) {
        //display - create a new row and 3 columns for each record
        echo '<tr><td>' . $row['user_id'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['first_name'] . '</td>
            <td>' . $row['last_name'] . '</td>
            <td><a href="register.php?user_id=' . base64_encode($row['user_id']) . '">Edit</a></td>
            <td><a href="delete-user.php?user_id=' . base64_encode($row['user_id']) . '" 
            onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a></td></tr>';
    }

    //close table body and the table itself
    echo '</tbody></table>';

    //disconnect
    $conn = null;
}
catch (exception $e){
    //email ourselves the error details
    mail('200294841@student.georgianc.on.ca', 'User List Error', $e);
    header('location:error.php');
}

require_once('footer.php');
ob_flush();
?>
