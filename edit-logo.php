<?php ob_start();
require_once('auth.php');

$title = 'Add/Edit Logo';

require_once('header.php');

?>
<div class="container-fluid">
    <form method="post" action="save-logo.php" enctype="multipart/form-data" />
    <div>
        <label for="logo">Upload Your Logo: </label>
        <input type="file" name="logo" />
    </div>
    <div>
        <input type="submit" class="btn btn-primary" value="Upload" />
    </div>
</div>
<?php
require_once('footer.php');
ob_flush();
?>
