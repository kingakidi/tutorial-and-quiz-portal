<?php
    include "./view/home_header.php";
    include "./view/home_navbar.php";
    if (isset($_SESSION['usertype'])) {
        
        header("Location: ./index.php");
    }  
?>


    <div class=" form-container">
        <form class="login-form" id="login-form">
            <h5 class="text-center text-info">Login </h5>
                <hr>
            <div class="form-group">
                <label for="username">Enter Email or Phone Number</label>
                <input type="text" class="form-control" placeholder="Enter Email or Phone Number" id="username">
            </div>
            <div class="form-group">
                <label for="password">Enter Password</label>
                <input type="password" placeholder="Enter password" class="form-control" id="password">
            </div>
            <div class="show-status text-center" id="show-status"></div>
            <div><a href="./register.php"> Click here to register </a> </div>
            <div class="form-group text-right">
                <button class="btn btn-info" type="submit" id="btn-login"> Login </button>
            </div>
        </form>
    </div>
    <script src="./js/jquery.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/login.js"></script>
</body>
</html>