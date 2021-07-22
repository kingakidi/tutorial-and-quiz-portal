<div class="cateogry">
    <p class="text-center text-success font-italic font-weight-bold"> 
        *Use below buttons to view courses, add course, and add topics to registered courses
    </p>
    <div class="item" id="item">
    
        <div class="item-link-container" id="item-link-container">
        
                <a href="?p=course" class="btn btn-info" id="category">COURSES</a>
        
        
                <a class="btn btn-info" name="p-link" id="add-category">ADD COURSE</a>
    
        
        
                <a class="btn btn-info" name="p-link" id="sub-category">ADD TOPIC</a>
        
            
            
            
        </div>
        <div class="show-item mt-3" id="show-item">
                <?php 
                    $categoryQuery = $conn->query("SELECT * FROM course");
                    if (!$categoryQuery) {
                        die("FAILED ");
                    }else{
                        echo '
                        <h5 class="text-center text-info">LIST OF REGISTERED COURSES</h5>
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>NAME</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                        ';
                        $sn = 1;
                        while ($row = mysqli_fetch_assoc($categoryQuery)) {
                            $id = $row['id'];
                            $cName = ucwords($row['course_name']);
                            echo "<tr>
                                    <td>$sn </td>
                                    <td>$cName </td>
                                    <td><button class='btn btn-info' id='$id' name='edit-category'>Edit</button>
                                </td>
                                </tr>
                            ";
                            $sn++;
                        }
                    }
                ?>
        </div>
    </div>


        </tbody>
    </table>


          </div>