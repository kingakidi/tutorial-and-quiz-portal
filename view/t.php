<div class="m-5 mt-2 p-3 pt-2">


<?php
   
    
    $tQuery = $conn->query("SELECT * FROM content WHERE id=$id");

    if (!$tQuery) {
        die(error("Failed Unable to get course details ".$conn->error));
    }else {
        if ($tQuery->num_rows > 0) {
            $row = $tQuery->fetch_assoc();
            extract($row);

            // GET COURSE 
            $gCTQuery = $conn->query("SELECT * FROM course WHERE id = $course_id");
            if (!$gCTQuery) {
              die("UNABLE TO GET COURSE TITLE ".$conn->error);
            }else{
              $course_title =  strtoupper($gCTQuery->fetch_assoc()['course_name']);
            }
            
            // ENDO OF GET COURSE 

            // GET TITLE 
            $gCTQuery = $conn->query("SELECT * FROM topics WHERE id = $topic_id");
            if (!$gCTQuery) {
            die("UNABLE TO GET TOPICS TITLE ".$conn->error);
            }else{
            $topic_title =  strtoupper($gCTQuery->fetch_assoc()['topic_title']);
            }

            // END OF GET TITLE 
            echo "<h3>" . $course_title ."</h3>
            <h5>" . $topic_title ."</h5>
            <p class='text-grey'>
               $tutorial_content
            </p>
            <div class='stats' id='stat'>
        
            </div>
            ";

                // CHECK IF QUIZ EXIST FOR THIS TOPIC  
                $qCQuery = $conn->query("SELECT * FROM quiz WHERE topics_id = $topic_id");
                if (!$qCQuery) {
                    die(error("UNABLE TO VERIFY QUIZ ".$conn->error));
                }else{

                    
                    // CHECK FOR NUM 
                    if ($qCQuery->num_rows > 0) {
                    extract($qCQuery->fetch_assoc());
                    
                    $qNQuery = $conn->query("SELECT * FROM user_answer WHERE quiz_id = $topic_id AND user_id = $userid");
                    if (!$qNQuery) {
                        die("FAILED TO VERIFY QUIZ");
                    }else{
                        $numQuiz = $qNQuery->num_rows;
                        if ($numQuiz > 0) {
                            echo "<div class='text-center'>
                                <a href='takequiz.php?q=$topic_id' class='btn btn-success'>View Result</a>
                            </div>";
                        }else{
                            echo "<div class='text-center'>
                            <a href='takequiz.php?q=$topic_id' class='btn btn-success'>Take Quiz</a>
                        </div>";

                        }
                    }
                    // CHECK IF USER HAS ALREADY TAKE THIS QUIZ 
                    //     echo "<div class='text-center'>
                    //     <a href='takequiz.php?q=$topic_id' class='btn btn-success'>Take Quiz</a>
                    // </div>";
                    }
                }
        }else{
            echo error("TUTORIAL NOT AVAILABLE ON THE SYSTEM ");
        }
    }
    ?>
    </div>