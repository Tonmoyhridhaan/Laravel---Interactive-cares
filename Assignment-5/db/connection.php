<?php

    $con = mysqli_connect("localhost","root","","interactivecares_assignment-5");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
?>