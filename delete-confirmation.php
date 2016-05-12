<?php
ob_start();
require_once('auth.php');

$title = 'User Deleted Successfully.';
require_once('header.php');
?>
<div class="alert alert-info" role="alert">
<p>The user was deleted successfully. Redirecting you to the user list in 5 second.</p>
</div>
<?php
//redirect the user after 5 seconds.
header('refresh:5; url=users.php');

require_once('footer.php');
ob_flush();
?>