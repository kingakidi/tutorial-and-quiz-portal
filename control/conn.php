<?php   
    $conn = mysqli_connect("localhost", "root", "", "tutorial");
    if (!$conn) {
        die("Unable to establish connection ");
    }
    session_start();
    ob_start();