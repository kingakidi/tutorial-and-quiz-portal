<?php 
    include "./functions.php";
    $userid = 1;
    // CREATE ADD CATEGORY FORM 
    if (isset($_POST['addCategoryForm'])) {
       echo '
            <div class="add-category" id="add-category">
            <form class="category-form" id="category-form">
                <h5 class="text-center text-info">ADD COURSE FORM</h5>
                <div class="form-group">
                    <input type="text" placeholder="COURSE TITLE" class="form-control" autocomplete="off" id="category-name">
                </div>
                <div class="form-group text-center" id="category-error"></div>
                <div class="text-right">
                    <button type="submit" class="btn btn-info btn-category" id="btn-category">Submit</button>
                </div>
            </form>
            </div>
            ';
    }

    // CREATE SUB CATEGORY FORM 
    if (isset($_POST['subCategoryForm'])) {
       echo '
        <div class="add-category" id="add-category">
        <form class="sub-category-form" id="sub-category-form">
            <h5 class="text-center text-info">ADD TOPIC</h5>
            <div class="form-group">
                <select name="category-name" id="category-name" class="form-control">
                    <option value="" disabled selected>Select Course</option>
        ';

            // BRINGS THE COURSES 
            $cQuery = mysqli_query($conn, "SELECT * FROM course");
            if (!$cQuery) {
                die("CATEGORY FAILED");
            }
            while ($row = mysqli_fetch_assoc($cQuery)) {
               
                $id = $row['id'];
                $cName = strtoupper($row['course_name']);
                echo "<option value='$id'>$cName</option>";
            }
            
            echo '
                    </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Topic" id="sub-category-name">
                    </div>
                    <div class="form-group text-center" id="sub-category-error"></div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info btn-category" id="btn-sub-category">Submit</button>
                    </div>
                </form>
                </div>
            ';
    }

    // CATEGORY EDIT FORM 
    if (isset($_POST['editCategoryForm'])) {
        $id = $_POST['id'];
          //   GET THE CATEGORY 
          $gQuery = mysqli_query($conn, "SELECT * FROM course WHERE id=$id");
  
          if (!$gQuery) {
              die("FAILED TO GET COURSE");
          }else{
              $row = mysqli_fetch_assoc($gQuery);
              $cName =ucwords($row['course_name']);
          }
        
          echo "<form class='edit-category-form' id='edit-category-form'>
          <div class='form-group'>
              
              <input type='text' class='form-control' id='catName' value='$cName' required>
          </div>
          <div class='form-group text-center' id='edit-category-error'></div>
          <div class='form-group text-right'>
              <button type='submit'  class='btn btn-info' id='btn-edit-category'>Update</button>
          </div>
      </form>";
      }

    //   GET TOPICS 
    if (isset($_POST['getTopics'])) {
        $courseId = clean($_POST['courseId']);
        echo $courseId;
        
        // CLEAN AND SEND FOR TOPICS 
        $tQuery = $conn->query("SELECT * FROM topics WHERE course_id = $courseId");
        if (!$tQuery) {
            die(error("FAILED TO VERIFY TOPICS").$conn->error);
            
        }else{
            if (mysqli_num_rows($tQuery)< 1) {
                echo "<option selected disabled> NO TOPIC REGISTER FOR THIS COURSE </option>";
            }else{
                echo "<option selected disabled> SELECT TOPIC </option>";
                while ($row = mysqli_fetch_assoc($tQuery)) {
                    $title = ucwords($row['topic_title']);
                    $id = $row['id'];
                    echo "<option value='$id'> $title </option>";
                }
            }
        }
        
    }
    
    // QUESTION TYPE 
    if (isset($_POST['quizOpitonType'])) {
         extract($_POST);
         $qType = clean($quizOpitonType);
         if ($qType === "truthy") {
            echo ' <input type="text" id="type" value="truthy" hidden disabled>
            <div class="form-group">
                <label for="right-answer">SELECT THE CORRECT ANSWER</label>
                <select name="" id="right-answer" class="form-control">
                    <option value="" selected disabled>Select the correct answer</option>
                    <option value="1">TRUE</option>
                    <option value="2">FALSE</option>
                </select>
            </div>
            <div class="show-status text-center" id="show-status">
                
            </div>
            <div class="form-group text-right">
                <button type="submit" id="btn-submit" class="btn btn-info">Submit</button>
            </div>';
         }else if($qType === "essay"){
            echo ' <input type="text" id="type" value="essay" hidden disabled>
                <div class="form-group">
                    <label for="option" class="text-info fw-bold">OPTION A</label>
                    <textarea  id="option1" cols="30" rows="3" class="form-control question-options" placeholder="Enter Option A"></textarea>
                </div>
                <div class="form-group">
                    <label for="option2" class="text-info fw-bold">OPTION B</label>
                    <textarea  id="option2" cols="30" rows="3" class="form-control question-options" placeholder="Enter Option B"></textarea>
                </div>
                <div class="form-group">
                    <label for="option3" class="text-info fw-bold">OPTION C</label>
                    <textarea  id="option3" cols="30" rows="3" class="form-control question-options" placeholder="Enter Option C"></textarea>
                </div>
                <div class="form-group">
                    <label for="option4" class="text-info fw-bold">OPTION D</label>
                    <textarea  id="option4" cols="30" rows="3" class="form-control question-options" placeholder="Enter Option D"></textarea>
                </div>
                <div class="form-group">
                    <label for="option-2">SELECT THE CORRECT OPTION</label>
                    <select name="" id="right-answer" class="form-control">
                        <option value="" selected disabled>Select the correct option</option>
                        <option value="1">Option A</option>
                        <option value="2">Option B</option>
                        <option value="3">Option C</option>
                        <option value="4">Option D</option>
                    </select>
                </div>
                <div class="show-status text-center" id="show-status">
                
                </div>
                <div class="form-group text-right">
                    <button type="submit" id="btn-submit" class="btn btn-info">Submit</button>
                </div>';
         }else if($qType === "yesno"){
            echo ' <input type="text" id="type" value="yesno" hidden disabled>
            <div class="form-group">
                <label for="right-answer">SELECT THE CORRECT ANSWER</label>
                <select name="" id="right-answer" class="form-control">
                    <option value="" selected disabled>Select the correct answer</option>
                    <option value="1">YES</option>
                    <option value="2">NO</option>
                </select>
            </div>
            <div class="show-status text-center" id="show-status">
                
            </div>
            <div class="form-group text-right">
                <button type="submit" id="btn-submit" class="btn btn-info">Submit</button>
            </div>';
         }
     
     }

    //  ROLE FORM 
    if (isset($_POST['changeRoleForm'])) {
        extract($_POST);
        $user_id = clean($id);
        $email = userEmail($user_id);
        
      ?>
        <form action="" class="change-role" id="change-role">
            <div class="form-group">
                
                <label for="user-email">User Email</label>
                <input type="email" value="<?php echo $email ?>" class="form-control" id="user-email" disabled>
            </div>
            <?php 
            echo '
            <div class="form-group">
                <label for="role">Selct Roled</label>
                <select name="role" id="role" class="form-control">
                    <option value="" selected disabeld>Select Role</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password"> Enter password</label>
                <input type="password" class="form-control" placeholder="Enter your password " id="password">
            </div>
            <div class="show-role-status form-group text-center" id="show-role-status"></div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-info" id="btn-role-submit">Confirm</button>
            </div>
        </form>';
    }
    if (isset($_POST['toggleActivation'])) {
        extract($_POST);
        $user_id = clean($id);
        $email = userEmail($user_id);
        
      ?>
        <form action="" class="toggle-activation" id="toggle-activation">
            <div class="form-group">
                
                <label for="user-email">User Email</label>
                <input type="email" value="<?php echo $email ?>" class="form-control" id="user-email" disabled>
            </div>
            <?php 
            echo '
            <div class="form-group">
                <label for="role">Selct Activation</label>
                <select name="role" id="toggle-action" class="form-control">
                    <option value="" selected disabeld>Select Activation</option>
                    <option value="activated">Activate</option>
                    <option value="deactivate">Deactivate</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password"> Enter password</label>
                <input type="password" class="form-control" placeholder="Enter your password " id="password">
            </div>
            <div class="show-role-status form-group text-center" id="show-role-status"></div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-info" id="btn-activation-submit">Confirm </button>
            </div>
        </form>';
    }


    // GET ALL QUESTIONS 
    if (isset($_POST['getAllQuestion'])) {
       $qQuery  = $conn->query("SELECT * FROM `quiz` LEFT JOIN course on quiz.course_id = course.id JOIN topics ON quiz.topics_id = topics.id");
       if (!$qQuery) {
           die(error("Unable to get questions "));
       }else{
           if ($qQuery->num_rows > 0) {
               $sn=1;
               echo '<table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>S/N </th>
                        <th>COURSE</th>
                        <th>TOPIC</th>
                        <th>QUESTION</th>
                        <th>TYPE</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>';
                while ($row = $qQuery->fetch_assoc()) {
                    //     echo "<pre>";
                    //    print_r($row);
                    //    echo "</pre>";
                    extract($row);
                    $course_name = strtoupper($course_name);
                    $topic_title = strtoupper($topic_title);
                    echo " <tr>
                    <td>$sn</td>
                    <td>$course_name</td>
                    <td>$topic_title</td>
                    <td>$question</td>
                    <td>$question_type</td>
                    <td>$date</td>
                    
                </tr>";
                    $sn++;
                }
                echo "   </tbody>
                </table>";
           }else{
               echo info("NO QUIZ ON THE PORTAL YES");
           }
       }
    }

    // GET ALL SCORES 

    if (isset($_POST['getAllScores'])) {
       
        $sUQuery = $conn->query("SELECT DISTINCT user_id FROM user_answer");
        if (!$sUQuery) {
            die(error("FAILED TO VERIFY QUIZ TAKERS"));
        }else{
            echo '<table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>FULLNAME</th>
                    <th>EMAIL</th>
                    <th>QUIZ </th>
                    <th>SCORE</th>
                </tr>
            </thead>';
            $sn = 1;

            while ($row = $sUQuery->fetch_assoc()) {
                //    print_r($row);
                $user_id =  $row['user_id'];
                $user_email = userEmail($user_id);
                $user_fullname = ucwords(userFullname($user_id));

                $uQQuery = $conn->query("SELECT quiz_id, SUM(score) FROM user_answer WHERE user_id = $user_id");

                if (!$uQQuery) {
                    die(error("UNABLET TO GET QUIZ DETAILS ".$conn->error));
                }else{
                    
                    $row = $uQQuery->fetch_assoc();
                    $score = $row['SUM(score)'];
                    $quiz_id = $row['quiz_id'];
                    $quiz_title = strtoupper(getQuizTitle($quiz_id));
                    // GET THE TOTAL QUESTION ON THE QUIZ 
                    $qNQuery = $conn->query("SELECT * FROM quiz WHERE topics_id = $quiz_id");
                        if (!$qNQuery) {
                            die("FAILED TO VERIFY QUIZ");
                        }else{
                            $numQuiz = $qNQuery->num_rows;
                        }
                    // END OF QUIZ NUM 
                    $pScore = ceil(($score / $numQuiz)*100) ."%";
                    echo "<tr>
                            <td>$sn</td>
                            <td>$user_email</td>
                            <td>$user_fullname</td>
                            <td>$quiz_title</td>
                            <td>$pScore</td>
                        </tr>";
                     
                    
                }
                $sn++;
            }
            echo "<tbody>
                </tbody>
            </table>";
        }
    }
?>
