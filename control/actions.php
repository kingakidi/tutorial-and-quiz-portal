<?php
    include "./functions.php";
    if (isset($_SESSION['user_id'])) {
       $userid = $_SESSION['user_id'];
    }
    // REGISTER USER 
    if (isset($_POST['registerAccount'])) {
        extract($_POST);
        $fullname = clean($fullname);
        $email = clean($email);
        $phone = clean($phone);
        $password = mysqli_escape_string($conn, $password);

        // CHECK FOR EMPTY 
        if (!empty($fullname) && !empty($email) && !empty($phone) && !empty($password)) {
             // CHECK IF EMAIL OR PHONE NUMBER ALREADY EXIST 
             $cRQuery = $conn->query("SELECT * FROM register WHERE email = '$email' OR phone = '$phone'");
             if (!$cRQuery) {
                 die("Unable to verify account status ");
             }else{
                 if (mysqli_num_rows($cRQuery) > 0) {
                    echo error("Account of same details already exist");
                 }else{
                    // SEND DATA TO DB
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $ruQuery = $conn->query("INSERT INTO `register`(`fullname`, `email`, `phone`, `password`) VALUES ('$fullname', '$email', '$phone', '$password')");
                    if (!$ruQuery) {
                        die("Unable to register account");
                    }else{
                        echo success("Account Registered Successfully");
                    }
                 }
             }
        }else{
            echo error("All fields required");
            exit();
        }
       

        
    }

    // LOGIN USER 
    if (isset($_POST['loginUser'])) {
       extract($_POST);
       $username = clean($username);
       $password = mysqli_escape_string($conn, $password);
        
        // CHECK FOR EMPTY FIELDS 
        if (!empty($username) && !empty($password)) {
            // CHECK FOR USER EXISTENCE 
            $cUQuery = $conn->query("SELECT * FROM register WHERE email = '$username' OR register.phone = '$username' LIMIT 1"); 
            if (!$cUQuery) {
                die(error("Unable to Verify User Account"));
            }else{

                if (mysqli_num_rows($cUQuery) < 1) {
                    echo error("Invalid Username");
                }else{
                       
                    // COMPARE PASSWORD 
                    $row = mysqli_fetch_assoc($cUQuery);
                    $db_status = $row['status'];
                    $db_password = $row['password'];
                    
                    if ($db_status !== 'approved') {
                        echo error("ACCOUNT DISABLED CONTACT ADMIN FOR SUPPORT");
                    }else{
                        if (password_verify($password, $db_password)) {
                            echo success("Login Successfully");  
                            $userid = $row['id'];
                            $usertype = $row['usertype'];
                            // SET SESSION 
                            $_SESSION['user_id'] = $userid;
                            $_SESSION['usertype'] = $usertype;
                        }else{
                            echo error("Invalid Password");
                        }
                    }
                    
                }
            }
        }else{
            echo error("All fields required");
        }


    }

    // ADD CATEGORY 
    if (isset($_POST['AddCategory'])) {
        $cName = clean($_POST['cName']);
        if (!empty($cName)) {
            // CHECK IF CATEGORY DOES NOT EXIST IN DB
            $cCQuery = mysqli_query($conn, "SELECT * FROM `course` WHERE course_name='$cName'");
            if (!$cCQuery) {
                die(error("COURSE FAILS"));
            }else if(mysqli_num_rows($cCQuery) > 0){
                echo error("COURSE ALREADY EXIST");
            }else{
                // SEND VALUE TO DB
                $aCQuery = mysqli_query($conn, "INSERT INTO `course`( `course_name`, `user_id`) VALUES ('$cName', $userid)");
                if (!$aCQuery) {
                    die("COURSE FAILED");
                }else{
                    echo success("COURSE ADDED SUCCESSFULLY");
                }
            }
        }
    }

    // ADD SUB CATEGORY 
    if (isset($_POST['addSubCategory'])) {
        $cName = clean($_POST['cName']);
        $sCName = clean($_POST['sCName']);
        
        // CHECK FOR EMPTY FIELDS
        if (empty($cName) || empty($sCName)) {
            echo error("ALL FIELDS(s) REQUIRED");
        }else{
             // CHECK IF SUB CATEGORY ALREADY EXIST ON THE USING CATEGORY ID 
             $sCQuery = mysqli_query($conn, "SELECT * FROM topics WHERE topic_title='$sCName' AND course_id=$cName");
             if (!$sCQuery) {
                 die(error("TOPIC CHECK FAILED ").$conn->error);
             }else{
                 if (mysqli_num_rows($sCQuery) > 0) {
                    echo error("TOPIC ALREADY EXIST FOR THIS CATEGORY");
                 }else{
                      // SEND TO SUB CATEGORY IF NULL 
                     
                      $sSCQuery = mysqli_query($conn, "INSERT INTO `topics`(`course_id`, `topic_title`, `user_id`) VALUES ($cName, '$sCName', $userid)");
                      if (!$sSCQuery) {
                          die(error("FAILED TO UPLOAD TOPIC"));
                      }else{
                          echo success("TOPIC ADDED SUCCESSFULLY");
                      }
                 }
             }
        }
       
       

    }
    // SUB CATEGORY QUERY 
    if (isset($_POST['subCategoryList'])) {
       $catId = $_POST['subCategoryList'];

       $sBQuery = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id=$catId");
       
       if (!$sBQuery) {
           die("SUB CATEGORY FAILED ");
       }else if(mysqli_num_rows($sBQuery) > 0){
        echo "<option value='' selected disabled>SELECT SUB CATEGORY </option>";
            while ($row = mysqli_fetch_assoc($sBQuery)) {
                $sCName = strtoupper($row['sub_category_name']);
                $sCId = $row['id'];
                echo "<option value='$sCId'>$sCName</option>";
            }
       }else{
        echo "<option value='' selected disabled>NO SUB CATEGORY </option>";
       }
       
    }
     // UPDATE CATEGORY FORM 
    if (isset($_POST["categoryUpdate"])) {
        $cName = $_POST['cName'];
        $id = $_POST['cId'];
        
        // CHECK FOR EMPTY FIELDS 
        if(!empty($cName)){
        
            // CHECK FOR AVAILABILITY IN DB
            $checkCatQuery = mysqli_query($conn, "SELECT * FROM course WHERE course_name = '$cName'");
            if (!$checkCatQuery) {
                die(error("FAILED TO VERIFY COURSE"));
            }else if(mysqli_num_rows($checkCatQuery) < 1){
                // SEND UPDATE QUERY 
                $uCQuery = mysqli_query($conn, "UPDATE course SET course_name='$cName' WHERE id=$id");
                if (!$uCQuery) {
                    die(error("UNABLE TO UPDATE COURSE"));
                }else{
                    echo success("COURSE UPDATED SUCCESSFULLY");
                }
            }else{
                echo error("COURSE ALREADY EXIST");
            }
        }else{
            echo error("ALL FIELDS REQUIRED");
        }
        
    }

    // ADDING TUTORIAL CONTENT
    if (isset($_POST['registerTutorial'])) {

       extract($_POST);
       $newContent = html_entity_decode(filter_var($content, FILTER_SANITIZE_STRING));
       $course = clean($course);
       $topic = clean($topic);
       $content = clean($content);
       $subTopic = clean($subTopic);
        echo $subTopic;
        //    CHECK FOR EMPTY FIELDS  
        if (!empty($course) AND !empty($topic) AND !empty($content)) {
            // STRIP AND CHECK CONTENT FIELDS 
            $cContentQuery = $conn->query("SELECT * FROM `content` WHERE course_id = $course AND topic_id = $topic");

            if (!$cContentQuery) {
                die("UNABLE TO VERIFY CONTENT");
            }else{
                if (mysqli_num_rows($cContentQuery) > 0) {
                    echo error("Tutorial of same topic and sub topic already exist");
                    exit();
                }else{
                    // INSERT THE CONTENT 
                    $iContentQuery = $conn->query("INSERT INTO `content`(`course_id`, `topic_id`, `user_id`, `tutorial_content` ) VALUES ($course, $topic,  $userid, '$content')");
                    
                    if (!$iContentQuery) {
                        die(error("UNABLE TO SUBMIT TUTORIAL CONTENT ".$conn->error));
                    }else{
                        echo success("Tutorial Added Successfully");
                    }
                }
            }
            
        }else{
            echo error("All * fields required");
        }
       

        
        

    }
    
    // REGISTER ESSAY QUESTION 
    if (isset($_POST['sendEssayQuesiton'])) {
        //   EXTRACT AND CLEAN 
        extract($_POST);
        $course = clean($course);
        $topic = clean($topic);
        $qtype = clean($qType);
        $question = clean($question);
        $rightAnswer = clean($rightAnswer);
        $option1 = clean($option1);
        $option2 = clean($option2);
        $option3 = clean($option3);
        $option4 = clean($option4);

        // CHECK FOR EMPTY FIELDS 
        if (!empty($course) AND !empty($topic) AND !empty($qtype) AND !empty($question) AND !empty($rightAnswer) AND !empty($option1) AND !empty($option2)) {
           $rightOption = ""."option".$rightAnswer;
           if (trim($$rightOption) !== "") {
            //    CHECK IF QUESTION ALREADY EXIST AT SAME COURSE AND TOPIC 
            $qCQuery = $conn->query("SELECT * FROM quiz WHERE course_id = $course AND topics_id = $topic AND question = '$question'");
            if (!$qCQuery) {
                die(error("Unable to verify queston status".$conn->error));
            }else{
                if (mysqli_num_rows($qCQuery) > 0) {
                   echo error("This quesiton already exist on this course and topic");
                }else{
                    // SEND QUESTION TO DB 
                    // THE SEND OPTIONS 
                    $iQQuery = $conn->query("INSERT INTO `quiz`(`course_id`, `topics_id`, `question`, `right_answer`, `userid`) VALUES ($course, $topic, '$question', $rightAnswer, $userid)");

                    if (!$iQQuery) {
                        die(error("Unable to Add Quiz "));
                    }else{
                        // GET THE LAST ID AND INSERT OPTIONS USING LOOP 
                        $question_id = $conn->insert_id;
                        
                        $optionArray = [$option1, $option2, $option3, $option4];
                        $options = ['A', 'B', 'C', 'D'];
                        $count = 0;
                        foreach ($optionArray as $value) {
                           if (!empty($value)) {
                                //   INSERT IT INTO THE DB 
                                $option = $options[$count];
                                $optionQuery = $conn->query("INSERT INTO `quiz_options`(`question_id`, `option_text`, `option_value`) VALUES ($question_id, '$option', '$value')");
                                if (!$optionQuery) {
                                    die(error("Failed to add options"));
                                }
                           }
                           $count++;
                        }
                        echo success("QUIZ ADDED SUCCESSFULLY");

                    }
                }
            }
           }else{
               echo error("Right Option Can't be empty");
           }

        }else{
            echo error("All * field required");
        }

        
    }

    // REGISTER YESNO QUESTION 
    if (isset($_POST['sendYesnoQuestion'])) {
        extract($_POST);
        $rightAnswer = clean($userAnswer);
        $question = clean($question);
        $course = clean($course);
        $topic = clean($topic);
        $qtype = clean($qType);
       
        // print_r($_POST);
        $qCQuery = $conn->query("SELECT * FROM quiz WHERE course_id = $course AND topics_id = $topic AND question = '$question'");
        if (!$qCQuery) {
            die(error("Unable to verify queston status".$conn->error));
        }else{
            if (mysqli_num_rows($qCQuery) > 0) {
               echo error("This quesiton already exist on this course and topic");
            }else{
                // SEND QUESTION TO DB 
                // THE SEND OPTIONS 
                $iQQuery = $conn->query("INSERT INTO `quiz`(`course_id`, `topics_id`, `question`, `right_answer`, `userid`, question_type) VALUES ($course, $topic, '$question', $rightAnswer, $userid, '$qtype')");

                if (!$iQQuery) {
                    die(error("Unable to Add Quiz "));
                }else{
                    // GET THE LAST ID AND INSERT OPTIONS USING LOOP 
                    $question_id = $conn->insert_id;
                    
                    $optionArray = ["YES", "NO"];
                    $options = ['A', 'B'];
                    $count = 0;
                    foreach ($optionArray as $value) {
                       if (!empty($value)) {
                            //   INSERT IT INTO THE DB 
                            $option = $options[$count];
                            $optionQuery = $conn->query("INSERT INTO `quiz_options`(`question_id`, `option_text`, `option_value`) VALUES ($question_id, '$option', '$value')");
                            if (!$optionQuery) {
                                die(error("Failed to add options"));
                            }
                       }
                       $count++;
                    }
                    echo success("QUIZ ADDED SUCCESSFULLY");

                }
            }
        }
    }


    // REGISTER TRUTHY QUESTION 
    
    if (isset($_POST['sendTruthyQuestion'])) {
        extract($_POST);
        $rightAnswer = clean($userAnswer);
        $question = clean($question);
        $course = clean($course);
        $topic = clean($topic);
        $qtype = clean($qType);
       
        print_r($_POST);
        $qCQuery = $conn->query("SELECT * FROM quiz WHERE course_id = $course AND topics_id = $topic AND question = '$question'");
        if (!$qCQuery) {
            die(error("Unable to verify queston status".$conn->error));
        }else{
            if (mysqli_num_rows($qCQuery) > 0) {
               echo error("This quesiton already exist on this course and topic");
            }else{
                // SEND QUESTION TO DB 
                // THE SEND OPTIONS 
                $iQQuery = $conn->query("INSERT INTO `quiz`(`course_id`, `topics_id`, `question`, `right_answer`, `userid`, question_type) VALUES ($course, $topic, '$question', $rightAnswer, $userid, '$qtype')");

                if (!$iQQuery) {
                    die(error("Unable to Add Quiz "));
                }else{
                    // GET THE LAST ID AND INSERT OPTIONS USING LOOP 
                    $question_id = $conn->insert_id;
                    
                    $optionArray = ["TRUE", "FALSE"];
                    $options = ['A', 'B'];
                    $count = 0;
                    foreach ($optionArray as $value) {
                       if (!empty($value)) {
                            //   INSERT IT INTO THE DB 
                            $option = $options[$count];
                            $optionQuery = $conn->query("INSERT INTO `quiz_options`(`question_id`, `option_text`, `option_value`) VALUES ($question_id, '$option', '$value')");
                            if (!$optionQuery) {
                                die(error("Failed to add options"));
                            }
                       }
                       $count++;
                    }
                    echo success("QUIZ ADDED SUCCESSFULLY");

                }
            }
        }
    }
   
    // SUBMIT QUIZ 
    if (isset($_POST['submitQuiz'])) {
        extract($_POST);
        $quizId = clean($quizId);
        $userAnswers = json_decode($userAnswers, true);
        $optionsAZ = ["A", "B", "C", "D", "E"];

        // CHECK FOR EMPTY FIELDS 
        if (!empty($quizId) AND !empty($userAnswers)) {
           // CHECK IF USER HAS ALREADY TAKEN THIS QUIZ 

           $uQCQuery = $conn->query("SELECT * FROM user_answer WHERE quiz_id = $quizId AND user_id = $userid");
           if (!$uQCQuery) {
               die("UNABLE TO VERIFY QUIZ STATUS ");
           }else{
               if ($uQCQuery->num_rows < 1) {
                foreach ($userAnswers as $value) {
            
                    $qNo =  clean($value['qNo']);
                    $user_answer = clean($value['answer']);
        
                    // GET THE ANSWER FROM DB AND COMPARE, SEND SCORE TO DB 
                    $cAQuery = $conn->query("SELECT * FROM quiz WHERE id=$qNo");
                    if (!$cAQuery) {
                        die(("Unable to verify quiz"));
                    }else{
                    
                            $row = ($cAQuery->fetch_assoc());
                            $db_rightAnswer = (int)$row['right_answer'];
                            // convert it to a-d 
                            $db_rightAnswer = strtolower($optionsAZ[$db_rightAnswer - 1]); 
                            // echo $db_rightAnswer, $user_answer . "<br>";
        
                            if ($db_rightAnswer === $user_answer) {
                               $mark = 1; 
                            }else{
                                $mark = 0;
                            }
                          
        
                            // SEND RESULT TO DB 
                            $mUQuery = $conn->query("INSERT INTO `user_answer`(`user_id`, `quiz_id`, `question_id`, `right_answer`, `user_answer`, `score`)
                             VALUES ($userid, $quizId, $qNo, '$db_rightAnswer', '$user_answer', $mark)");
                             if (!$mUQuery) {
                                 die("Unable to submit quiz at the moment ");
                                 exit();
                             }
                        
                    }
        
        
                }
                echo success("QUIZ SUBMITTED SUCCESSFULLY");
               }else{
                   echo "You have already taken this quiz";
               }
           }
        }else{
            echo "Answer at least one question";
        }
        

       
    }

    
    // CHANGE USER ROLES
    if (isset($_POST['changeUserRole'])) {
        // print_r($_POST);
        extract($_POST);
          // CLEAN
        $email = clean($email); 
        $password = clean($password);
        $role = clean($role);
       
        // CHECK FOR EMPTY 
        if (!empty($email) AND !empty($password) AND !empty($role)) {
             // CHECK FOR PASSWORD VALIDATION 
             $loginUserPassword = getUserPassword($_SESSION['user_id']);
            if (password_verify($password, $loginUserPassword)) {
                       
                // CHANGE THE ROLE 
                $uRQuery = $conn->query("UPDATE register SET usertype = '$role' WHERE email = '$email'");
                if (!$uRQuery) {
                   die(error("Unable to change user role at the moment")); 
                }else{
                    echo success("Role change Succcessfully");
                }
            }else{
                echo error("Invalid Password");
            }

        }else{
            echo error("All field required ");
        }
    
    }