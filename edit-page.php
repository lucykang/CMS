<?php ob_start();
require_once('auth.php');

//set the page title
$title = 'Edit Your Page';

require_once('header.php');

try{
    //connect to db
    require('db.php');

    //set up an SQL query
    $sql = "SELECT * FROM pages";
    
    //execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $result = $cmd->fetchAll();
    
?>
<!-- button to add/edit logo -->
<div class="button-right">
    <a href="edit-logo.php" class="btn btn-primary" role="button">Add/Edit Logo</a>
</div>
<!-- button to add page -->
<div class="button-right">
    <a href="add-page.php" class="btn btn-primary" role="button">Add New Page</a>
</div>
<? 
    //start the table and add the headings BEFORE our loop (only once)
    echo '<table class="table table-striped"><thead>
    <th>Page ID</th><th>Page Name</th><th>Edit</th><th>Delete</th></thead><tbody>';

    //loop through the query result where $result is the dataset & $row is 1 record
    foreach($result as $row) {
        //display - create a new row and 3 columns for each record
        echo '<tr><td>' . $row['page_id'] . '</td>
            <td>' . $row['page_title'] . '</td>
            <td><a href="add-page.php?page_id=' . $row['page_id'] . '">Edit</a></td>
            <td><a href="delete-page.php?page_id=' . $row['page_id'] . '" 
            onclick="return confirm(\'Are you sure you want to delete this page?\');">Delete</a></td></tr>';
    }

    //close table body and the table itself
    echo '</tbody></table>';

    //disconnect
    $conn = null;
}
catch (exception $e){
    //email ourselves the error details
    mail('200294841@student.georgianc.on.ca', 'Edit Page Error', $e);
    header('location:error.php');
}
?>

<?php
require_once('footer.php');
ob_flush();
?>
