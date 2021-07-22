<?php 
    include "./control/conn.php";
    $_SESSION['usertype'] = NULL;
    session_unset();
    session_destroy();
    header("Location: ./index.php");