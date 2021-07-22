<div class="container">
    <div class="tutorial-container">
        <p class="text-center text-success font-italic font-weight-bold">*Use this form to create new tutorial content: <br> Note: The content will automatically appear on the home page of this portal </p>
        <form class="tutorial-form" id="tutorial-form">
            <h5 class="text-center text-info">ADD TUTORIAL FORM</h5>
            <hr>
            <div class="form-group">
                <label for="course">Select course <span class="text-danger fw-bold"><sup>*</sup></span></label>
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
                    <option value="" selected disabled>Select Course First</option>
                   
                </select>

            </div>
            <!-- <div class="form-group">
                <label for="sub-topic">Enter Sub Topic (Opitional) </label>
                <input type="text" placeholder="Enter Sub Topic (optional)" id="sub-topic" class="form-control">
            </div> -->
            <div class="form-group">
                <label for="content">Enter Tutorial Content <span class="text-danger fw-bold"><sup>*</sup></span></label>
                <textarea name="" id="editor" cols="30" rows="10" class="form-control" placeholder="Enter Tutorial Content" required></textarea>
            </div>
            <div class="form-group show-status text-center" id="show-status"></div>
            <div class="form-group text-right">
                <button class="btn btn-info" type="submit">Upload</button>
            </div>
        </form>
    </div>
</div>