<?php ob_start();
require_once('auth.php');

$title = "Save Page";

require_once('header.php');

//store the form inputs in the variables
$page_title = $_POST['page_title'];
$contents = $_POST['contents'];
$page_id = $_POST['page_id'];
$ok = true;

//input validation (only check the title. contents don't have to have value to start)
if(empty($page_title)){
?>
    <div class="alert alert-info" role="alert">
    <p>Page title is required. <br /></p>
</div> 
<?php
    $ok = false;
}
//if the page_title had value, do the following
if($ok){
    try{
        //connect to the db
        require('db.php');
        
        //setup the SQL command
        //if there was page_id, update the data in db
        if(!empty($page_id)){
            $sql = "UPDATE pages SET page_title = :page_title, contents = :contents WHERE page_id = :page_id";   
        }
        //if there was no page_id, then insert new data in db
        else {
            $sql = "INSERT INTO pages (page_title, contents) VALUES (:page_title, :contents)";   
        }
        
        //create a command object to fill the parameter values
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':page_title', $page_title, PDO::PARAM_STR, 15);
        $cmd->bindParam(':contents', $contents, PDO::PARAM_STR);
        
        //add page_id parameter if we are updating
        if(!empty($page_id)){
            $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);   
        }
        $cmd->execute();
        
        //disconnect
        $conn = null;
    }catch (exception $e){
            mail('200294841@student.georgianc.on.ca', 'Save Page Error', $e);
            header('location:error.php');
    }    
}
//redirect to the edit page
header('location:edit-page.php');

require_once('footer.php');
ob_flush();
?>