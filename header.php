<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- favicon -->
        <link rel="icon" type="image/png" href="pics/favicon.png" />
        
        <!-- <link rel="icon" href="favicon.ico"> -->
        <title><?php echo $title; ?></title>
        
        <!-- Latest compiled and minified CSS -->     
        <link rel="stylesheet" href="bootstrap-3.3.5/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap-3.3.5/dist/css/bootstrap-theme.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="bootstrap-3.3.5/docs/examples/jumbotron/jumbotron.css">
        <link rel="stylesheet" href="bootstrap-3.3.5/docs/examples/sticky-footer/sticky-footer.css">
        
        <!-- custom CSS -->
        <link rel="stylesheet" href="css/custom.css">
        
    </head>
    <body>
<?php
//connect to the db
require('db.php');

//set up the sql query to call the logo that was updated most lately
$sql = "SELECT * FROM logos ORDER BY 1 DESC LIMIT 1";
$cmd = $conn->prepare($sql);
$cmd->execute();
$result = $cmd->fetchAll();

foreach($result as $row){
    $logo = $row['logo'];
}

//disconnect
$conn = null;
?>
        <!-- NAVIGATION BAR -->
        <nav class="nav navbar-inverse navbar-fixed-top" role="navigation">
            <!-- div class="container" -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="default.php">
                    <!-- if there is logo, bring the file from the directory -->
                    <img src="<?php if(!empty($logo)){?>image/<?echo $logo;} else{echo "LUCY KANG";} ?>" alt="Logo" width="200" height="50"/>
                    </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav"> 
<?php
                    //if the user is authenticated, show the admin priviliged navigation
                    session_start();

                    if(!empty($_SESSION['user_id'])) {
?>
                    <li><a href="users.php">Show User List</a></li>
                    <li><a href="register.php">Add New Admin</a></li>
                    <li><a href="edit-page.php">Edit Website</a></li>
                    <li><a href="logout.php">Log Out</a></li>
<?php
                    }
                    //if the user is not authenticated, then show the guest navigation
                    else {
                        try{
                            //connect to the db
                            require('db.php');

                            //setup the query to call page from pages table in db
                            $sql = "SELECT * FROM pages";

                            $cmd = $conn->prepare($sql);
                            $cmd->execute();
                            $result = $cmd->fetchAll();

                            //count the result
                            $count = count($result);

                            //if there is a result (if there is a page in pages table in db)
                            if($count>0){
                                //echo its title on the navigation
                                foreach($result as $row){
                                    echo '<li><a href="default.php?page_id=' . $row['page_id'] . '">' . $row['page_title'] . '</a></li>';
                                }
                            }

                            //disconnect
                            $conn = null;
                        }
                        catch(exception $e){
                            //email ourselves the error details
                            mail('200294841@student.georgianc.on.ca', 'Header Navigation Error', $e);
                            header('location:error.php');
                        }
?>
                        <li><a href="login.php">Log In as Admin</a></li>
<?php
    }
?>
                    </ul>
                </div>
                
            <!--/div-->  
        </nav>