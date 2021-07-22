<?php

 $tQuery = $conn->query("SELECT * FROM topics");
 if (!$tQuery) {
   die(error("UNABLE TO LOAD COURSES AT THE MOMENT ".$conn->error));
 }
 // FETCH THE TOPICS IN TWOS 
 $numRows = mysqli_num_rows($tQuery);

 $a =0;
 while ($a <= $numRows) {
   // FETCH NEXT TWO 
   $fNQuery = $conn->query("SELECT * FROM topics JOIN content WHERE topics.id = content.topic_id ORDER BY topics.id DESC LIMIT $a, 2 ");
   if (!$fNQuery) {
     die("UNABLE TO GET TUTORIALS ".$conn->error);
   }else{
     echo "<div class='row m-2'>";
     while ($row = $fNQuery->fetch_assoc()) {
       extract($row);
      echo "<div class='col-sm'>
         <div class='card'>
           <div class='card-header'>" . getCourseTitle($course_id) ."</div>
           <div class='card-body'>
             <h5 class='card-title'>" .  getTopicTitle($topic_id) ."</h5>
             <p class='card-text'>".
             limit_text($tutorial_content, 200)
             ."</p>
             <a href='./index.php?t=$id' class='btn btn-info'>READ MORE</a>
           </div>
         </div>
       </div>";
   
     }
     echo "</div>";
    
   }
   
   // if ($a == 0) {
   //   $a =+3;
   // }else{
     $a += 2;
   // }

   
 }