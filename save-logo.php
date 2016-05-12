<?php ob_start(); 
require_once('auth.php');

$title = 'Save Logo';

require_once('header.php');

//store inputs into variables
$logo = $_FILES['logo']['name'];
$tmp_name = $_FILES['logo']['tmp_name'];
$type = $_FILES['logo']['type'];

$ok = true;

//if the logo variable is not empty, do the following
if(!empty($logo)){   
    //check the type of the image
    //if the file is image, then save it in the directory.
    if($type == "image/jpeg" || $type == "image/png"){
        
        session_start();
        
        //move to the "image" directory
        move_uploaded_file($tmp_name, "image/$logo");
        
        /* the following code can be used to save the file in set dimension.
        
        //check the width and height of the logo image
        $imageSize = getimagesize($tmp_name);
        $width = $imageSize[0];
        $height = $imageSize[1];

        //default size of the logo that would fit the webpage
        $default_width = 200;
        $default_height = 50;
        
        
        //check the logo dimension
        //if it's landscape picture
        if($width > $height){
            //picture will fit to the default width so find the new height value.
            $new_height = round($height / $width * $default_width);
            
            //resample the image
            $tmp_after = imagecreatetruecolor($default_width, $new_height);
            imagecopyresampled($tmp_after, $logo, 0, 0, 0, 0, $default_width, $new_height, $width, $height);
            
            //output
            imagejpeg($tmp_after, "image/$logo", 100);
        }
        else{ //when the picture is square or portrait
            //picture will fit to the default height so find the new width value.
            $new_width = round($width / $height * $default_height);
            
            //resample the image
            $tmp_after = imagecreatetruecolor($new_width, $default_height);
            imagecopyresampled($tmp_after, $logo, 0, 0, 0, 0, $new_width, $default_height, $width, $height);
            
            //output
            imagejpeg($tmp_after, "image/$logo", 100);
        }*/
    }
    //if the file was not image file, show the message and don't save it.
    else{
?>
        <div class="alert alert-info" role="alert">
        <p>This file type cannot be uploaded. Please upload .jpeg or .png file only.</p>
        </div>
<?php
        //set the ok variable false.
        $ok = false;
//redirect the user to the edit logo page after 5 seconds.
header('refresh:5; url=edit-logo.php');
    }
}

//if the file was image file, do the following
if($ok){
    try{
        //connect to the db
        require('db.php');
        
        //set up the query to save the image in db
        $sql = "INSERT INTO logos (logo) VALUES (:logo)";

        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':logo', $logo, PDO::PARAM_STR, 100);
        $cmd->execute();
        
        //disconnect
        $conn = null;
    }
    catch(exception $e){
        mail('200294841@student.georgianc.on.ca', 'Save Logo Error', $e);
        header('location:error.php');
    }
}
//redirect to updated default page
header('location:default.php');

require_once('footer.php');
ob_flush(); 
?>