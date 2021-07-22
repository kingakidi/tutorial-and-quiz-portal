<div class="container">
    <p class="text-center text-success font-italic font-weight-bold">*Use this form to create new quiz questions on respective course and topics: Note Quiz created here will apear at the bottom of each topics </p>
    <form action="" class="set-quiz" id="set-quiz">
    <h5 class="text-center text-info">ADD QUIZ FORM</h5>
    <hr>
    <div class="form-group">
                <label for="course" class="text-info fw-bold">Select course <span class="text-danger fw-bold"><sup>*</sup></span></label>
                <select name="" id="course" class="form-control" required>
                    <option value="" selected disabled>Select Course</option>
                    <?php
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
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="topic">Select Topic <span class="text-danger fw-bold"><sup>*</sup></span></label>
                <select name="topic" id="topic" class="form-control">
                    <option value=""  disabled selected>Select Course First</option>
                   
                </select>
            </div>
            <div class="form-group">
                <label for="question-type" class="text-info fw-bold">Select Question Type</label>
                <select name="" id="question-type" class="form-control">
                    <option value="" selected disabled>Select Question Type</option>
                    <option value="essay">Essay (Option A-D)</option>
                    <option value="truthy">True / False</option>
                    <option value="yesno">Yes / NO</option>
                </select>
            </div>
            <div class="form-group">
                    <label for="question-editor" class="text-info fw-bold">Enter Question</label>
                    <textarea name="" id="question" cols="30" rows="3" class="form-control" placeholder="Enter Question"></textarea>
                </div>
            <div class="show-questions" id="show-question">

                    <p class="text-info text-center font-weight-bold">Select  Question Type First</p>
            </div>
    </form>
</div>