<?php ob_start();

$title = "Welcome";

require_once('header.php');

$page_id = $_GET['page_id'];

//if page_id exists, present the page.
if(!empty($page_id)){
    try{
    //connect to the db
    require('db.php');
    
    //set up the query to bring the contents
    $sql = "SELECT * FROM pages WHERE page_id = :page_id";
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
    
    //loop through the results and store the value in the variables
    foreach($result as $row){
        $page_title = $row['page_title'];
        $contents = $row['contents'];
    }
?>
<!-- the actual contents start here -->
    <div class="container">
<?php
    //present the value on the page
    echo '<h1>' . $page_title . '</h1>';
    echo '<p>' . $contents . '</p>';
?>
    </div>
<?php
        
    //drop the connection
    $conn = null;
    }
    catch (exception $e){
        mail('200294841@student.georgianc.on.ca', 'Save Athlete Error', $e);
        header('location:error.php');
    }
}

//if the page_id doesn't exist, show the following page
else{
?>
        <h2 class="text-center">"  Hello stranger !  "</h2>
        <p class="text-center">I made this website to organize my projects I have created since the day 1 in Computer Programmer course in Georgian College.<br/>This is responsive website with content management system built in PHP, HTML5, CSS3, Bootstrap and MySQL to connect to my database.</p>
        <p class="text-center">Can't wait to see this website upgraded over time! </p>
    
    <!-- Carousel presenting the portfolio images and it rotates in 3 second interval -->
    <div id="carousel-example-generic" class="carousel" data-ride="carousel" data-interval="3000" data-pause="hover">
            <ol class="carousel-indicators">
              <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
              <li data-target="#carousel-example-generic" data-slide-to="1"></li>
              <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <!-- this will be the first image to be displayed-->
                <div class="item active">
                    <img src="pics/canon-site.png" alt="Canon Site" class="img-responsive">
                    <div class = "carousel-caption">
                        <h3>Responsive Website</h3>  
                    </div>
                </div>
                <div class="item">
                    <img src="pics/nav_assignment.png" alt="Nav Assignment" class="img-responsive">
                    <div class = "carousel-caption">
                        <h3>Navigation with nested unordered list and pseudo class</h3>  
                    </div>
                </div>
                <div class="item">
                    <img src="pics/movie_site.png" alt="Movie Site" class="img-responsive">
                    <div class = "carousel-caption">
                        <h3>Movie Site using CSS</h3>  
                    </div>
                </div>
            </div>
            <!-- carousel left & right button -->
            <a class="carousel-control left" href="#carousel-example-generic" data-slide="prev">
              <span class="icon-prev"></span>
            </a>
            <a class="carousel-control right" href="#carousel-example-generic" data-slide="next">
              <span class="icon-next"></span>
            </a>
    </div>
<?php 
}
require_once('footer.php');
ob_flush();
?>