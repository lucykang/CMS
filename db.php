<?php
    //connect
    $conn = new PDO('mysql:host=sql.computerstudi.es;dbname=database', 'username', 'password');

    //enable PDO debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
