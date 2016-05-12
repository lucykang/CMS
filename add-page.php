<?php ob_start(); 
require_once('auth.php');

$title = 'Add/Edit Page';
require_once('header.php');

<!-- if there was page_id, it will show the previous data from the database to edit-->
try{
    //check if there's page ID in the querystring
    if(isset($_GET['page_id'])){
        //if yes, store in the variable
        $page_id = $_GET['page_id'];
        
        //connect
        require('db.php');
        
        //select the data from the database
        $sql = "SELECT * FROM pages WHERE page_id = :page_id";
        
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $cmd->execute();
        $result = $cmd->fetchAll();
        
        //store each value from the db into the variables
        foreach($result as $row){
            $page_title = $row['page_title'];
            $contents = $row['contents'];
        }
        
        //disconnect
        $conn = null;
    }
}catch (exception $e){
    mail('200294841@student.georgianc.on.ca', 'Add/Edit Page Error', $e);
    header('location:error.php');
}
?>

<div class="container">
    <h5>Please fill the fields to create a new page or edit the page</h5>
    <form method="post" action="save-page.php" class="form-horizontal">

        <div class="form-group">
            <label for="page_title" class="col-sm-2">Page Title: </label>
            <input name="page_title" placeholder="Up to 15 character" required value="<?php echo $page_title; ?>"/>
        </div>

        <div class="form-group">
            <label for="contents" class="col-sm-2">Contents: </label>
            <textarea name="contents" cols="100" rows="10" class="field-large"><?php echo $contents; ?></textarea>
        </div>

            <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
        <div class="col-sm-offset-2">
            <input type="submit" value="Save" class="btn btn-primary" />
        </div>
    </form>
</div>
<?php
require_once('footer.php');  
ob_flush();
?>