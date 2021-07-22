<div class="cateogry">
    <p class="text-center text-success font-italic font-weight-bold"> 
        *Use below buttons to manage users details and activities
    </p>
    <div class="item" id="item">
    
        <div class="item-link-container" id="item-link-container">
        
                <a href="?p=stats" class="btn btn-info">USERS</a>
                <a class="btn btn-info" name="p-link" id="questions">QUESTIONS</a>
                <a class="btn btn-info" name="p-link" id="quiz-list">QUIZ LIST</a>
                <a class="btn btn-info" name="p-link" id="quiz-scores">QUIZ SCORES</a>
                <a class="btn btn-info" name="p-link" id="logs">LOG</a>
            
        </div>
        <div class="show-item mt-3" id="show-item">
        <?php
        
            // GET ALL REGISTERED USERS 
            $uQuery = mysqli_query($conn, "SELECT * FROM register");
            if (!$uQuery) {
                die("FAILED TO FETCH USERS ".mysqli_error($conn));
            }else if(mysqli_num_rows($uQuery) > 0){
                echo '
                    <table class="table table-bordered table-responsive container">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>FULLNAME</th>
                            <th>EMAIL ADDRESS</th>
                            <th>PHONE </th>
                            <th>TYPE</th>
                            <th>STATUS</th>
                            <th>USER TOOLS</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                $sn = 1;
                while ($row = mysqli_fetch_assoc($uQuery)) {
                    $id = $row['id'];
                    // $username = $row['username'];
                    $fullname = ucwords($row['fullname']);
                    $email = $row['email'];
                    $phone = $row['phone'];
                    // $gender = ucwords($row['gender']);
                    $type = strtoupper($row['usertype']);
                    $status = ucwords($row['status']);
                    $date = $row['date'];
                    
                    echo "
                    <tr>
                        <td>$sn </td> 
                        <td>$fullname</td>
                        <td>$email</td>
                        <td>$phone </td>
                        <td>$type</td>
                        <td>$status</td>
                     
                        <td>
                            <div class='form-group'>
                                <select name='user-tools' id='$id' class='user-tools'>
                                    <option value='' disabled selected>Select Action</option>
                                    <option value='role'>Change Role</option>
                                    <option value='toggleActivation'>Toggle Activation</option>
                                    <option value='chart'>View Chart</option>
                                    <option value='log'>Logs</option>
                                    <option value='changeEmail'> Change Email </option>
                                </select>
                            </div>
                        </td>
                   </tr>
                    
                    ";
                    $sn++;
                }
                echo ' </tbody>
                </table>';
            }else{
                echo "<span class='text-primary'>NO REGISTER ACCOUNT ON THIS SYSTEM</span>";
            }
        ?>
    </div>
    </div>
<div>