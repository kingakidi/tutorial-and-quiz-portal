<?php 
  include "./control/conn.php";
  function clean($var){
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

   function limit_text($text, $len) {
        if (strlen($text) < $len) {
            return $text;
        }
        $text_words = explode(' ', $text);
        $out = "";


        foreach ($text_words as $word) {
            if ((strlen($word) > $len) && $out == null) {

                return substr($word, 0, $len) . "...";
            }
            if ((strlen($out) + strlen($word)) > $len) {
                return $out . "...";
            }
            $out.=" " . $word;
        }
        return $out;
    }
    

  //  GET COURSE TITLE 
  function getCourseTitle($id){
    global $conn; 
    $gCTQuery = $conn->query("SELECT * FROM course WHERE id = $id");
    if (!$gCTQuery) {
      die("UNABLE TO GET COURSE TITLE ".$conn->error);
    }else{
      return strtoupper($gCTQuery->fetch_assoc()['course_name']);
    }
  }
  //  GET TOPICS TITLE 
  function getTopicTitle($id){
      global $conn; 
      $gCTQuery = $conn->query("SELECT * FROM topics WHERE id = $id");
      if (!$gCTQuery) {
      die("UNABLE TO GET TOPICS TITLE ".$conn->error);
      }else{
      return ucwords($gCTQuery->fetch_assoc()['topic_title']);
      }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WELCOME TO ONLINE TUTORIAL & QUIZ PORTAL</title>
    <link rel="stylesheet" href="./vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="./vendor/index.css">
  </head>
  <body>
    