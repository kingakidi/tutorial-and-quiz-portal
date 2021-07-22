<?php
    include "./conn.php";
    
    function clean($var)
    {
        global $conn;
        return trim(strtolower(mysqli_escape_string($conn, $var)));
    }
    
    function success($x) {
        return "<span class='text-success'>$x</span>";
    }
    function info($x) {
        return "<span class='text-info'>$x</span>";
    }
    function error($x) {
        return "<span class='text-danger'>$x</span>";
    }
    
    function userEmail($id){
        global $conn; 
        
        $uEQuery = $conn->query("SELECT * FROM register WHERE id = $id");
        if (!$uEQuery) {
            die(error("UNABLE TO VERIFY EMAIL "));
        }else{
            $email = $uEQuery->fetch_assoc()['email'];
            return $email;
        }
    }

    function getUserPassword($id){
        global $conn; 
        $uPQuery = $conn->query("SELECT * FROM register WHERE id = '$id'");
        if (!$uPQuery) {
            die(error("UNABLE TO VALIDATE YOUR PASSWORD "));
        }else{
            $password = $uPQuery->fetch_assoc()['password'];
            return $password;
        }
    }