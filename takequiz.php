<?php
  include "./view/home_header.php";
  include "./view/home_navbar.php";
 
    if (!$_SESSION['usertype']) {
       header("Location: ./login.php");
    }

      
?>

    <main class="m-3 p-3">
      <?php
        
        if (isset($_GET['q'])) {
            $id = clean($_GET['q']);
        $userid = $_SESSION['user_id'];
        echo "<script>
        globalThis.quizId = $id;
        </script>";
            echo " <div class='quiz-container'>";
            // CHECK IF USER HAS ALREADY TAKE THIS QUIZ, SHOW HIM RESULT 
            $uQCQuery = $conn->query("SELECT * FROM user_answer WHERE quiz_id = $id AND user_id = $userid");
            if (!$uQCQuery) {
                die("UNABLE TO VERIFY QUIZ STATUS ");
            }else{
                // echo $uQCQuery->num_rows;
                if ($uQCQuery->num_rows < 1) {
                    //   GET ALL THE QUIZ QUESTIONS 
                    $qCQuery = $conn->query("SELECT * FROM quiz WHERE topics_id = $id ");

                    if (!$qCQuery) {
                        die(error("UNABLE TO VERIFY QUIZ ".$conn->error));
                    }else{
                        // CHECK FOR NUM 
                        if ($qCQuery->num_rows > 0) {
                            $qNumRows = $qCQuery->num_rows;
                            // echo $qNumRows;
                            $sn=1;
                            echo "
                            <form action='' class='quiz-form' id='quiz-form'> ";
                            while ($row = $qCQuery->fetch_assoc()) {
                            extract($row);
                                $question_id = $id;
                                echo "<div class='quiz-question'>
                                <div class='form-group'>
                                    <label for='question' class='text-info font-weight-bold'>Question $sn of $qNumRows </label> 
                                    <strong> $question </strong>
                                    <hr>
                                </div>
                                ";

                                // GET THE OPTIONS OF THIS QUESTIONS 
                                
                                $qOptionQuery = $conn->query("SELECT * FROM quiz_options WHERE question_id = $question_id");
                                if (!$qOptionQuery) {
                                    die(error("Unable to verify options "));
                                }else{
                                    while ($rowOptions = $qOptionQuery->fetch_assoc()) {
                                        // echo "<pre>";
                                        //     print_r($rowOptions);
                                        // echo "</pre>";
                                        $optionText  = $rowOptions['option_text'];
                                        $optionValue = $rowOptions['option_value'];
                                        $optionId = $rowOptions['id'];
                                        echo " <div class='form-group'>
                                            <label class='d-inline' for='option-$optionId'> $optionText </label>
                                            <input type='radio' data-question='$question_id' class='d-inline options' value='$optionText' name='option-$id' id='option-$optionId'> <span class='d-inline'> $optionValue </span>
                                        </div>";
                                    }
                                }
                            //     echo '<hr> <div class="form-group d-flex justify-content-between">
                            //     <div class="text-left"> <button class="btn btn-success"> Previous </button></div>
                            //     <div class="text-right"><button class="btn btn-success mr-auto">Next</button></div>
                            // </div>';
                                echo "</div>";
                                $sn++;
                            }
                            echo "<div class='text-center m-2' id='show-status'></div>
                                    <div class='form-group text-right pt-3'>
                                        <button class='btn btn-info' type='submit' id='btn-quiz-form'> Submit Quiz </button>
                                    </div>
                                </form>         
                            ";
                        }
                    }
                }else{
                    // SHOW QUIZ RESULT 
                    $qRQuery = $conn->query("SELECT * FROM user_answer WHERE quiz_id = $id AND user_id = $userid");
                    if (!$qRQuery) {
                        die(error("UNABLE TO VERIFY YOUR SCORE"));
                    }else{
                        // GET QUIZ NUM 
                        // echo $id;
                        
                        $topicTitle =  strtoupper(getTopicTitle($id));
                        $qNQuery = $conn->query("SELECT * FROM quiz WHERE topics_id = $id");
                        if (!$qNQuery) {
                            die("FAILED TO VERIFY QUIZ");
                        }else{
                            $numQuiz = $qNQuery->num_rows;
                        }
                            $totalScore = 0;
                            $number_of_answer_question = $qRQuery->num_rows;
                        while ($row = $qRQuery->fetch_assoc()) {
                           extract($row); 
                           $totalScore += $score;

                        }

                       $pScore = ceil(($totalScore / $numQuiz)*100) ."%";
                        echo "<div class='score-container'>
                            <div class='score p-5'>
                                <p class='font-weight-bold topic-title'> $topicTitle </p>
                            <strong> <p>   Score:    $pScore </p> </strong>
                            </div>
                        </div>";
                    }

                }

            } 
           
          echo "</div>";
         
       }else{
         header("Location: ./index.php");
       }
        

      ?>
      
    </main>

    <script src="./js/jquery.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/takequiz.js"></script>
  </body>
</html>
