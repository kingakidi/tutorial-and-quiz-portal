<?php
    include "./view/home_header.php";
    include "./view/home_navbar.php";
    if (isset($_SESSION['usertype'])) {
        
        header("Location: ./dashboard.php");
    }  
?>
    <div class="form-container">
        <form class="register-form" id="register-form">
            <h5 class="text-info text-center">Register Account</h5>
            <hr>
            <div class="form-group">
                <label for="fullname">Enter Fullname</label>
                <input type="text" class="form-control" id="fullname" placeholder="Enter your fullname">
            </div>
            <div class="form-group">
                <label for="email">Enter Email Address</label>
                <input type="email" class="form-control" placeholder="Enter your email address" id="email">
            </div>
            <div class="form-group">
                <label for="phone">Enter Phone number</label>
                <input type="number" name="phone" id="phone" class="form-control" placeholder="Enter Phone number">
            </div>
            <div class="form-group">
                <label for="password">Enter Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
            </div>
            <div class="show-status text-center m-2" id="show-status"></div>
            <div><a href="./login.php"> Click here to login</a></div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-info" id="btn-register">Register</button>
            </div>
        </form>
    </div>
    <script src="./js/jquery.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/register.js"></script>
</body>
</html>