<nav class="navbar navbar-light bg-info">
      <a href="./index.php" class="navbar-brand text-white">ONLINE TUTORIAL & QUIZ </a>
      <div class="form-inline">
      
        <?php
            if (isset($_SESSION['usertype']) AND $_SESSION['usertype'] ==='admin') {
              echo '<a href="./dashboard.php" class="btn btn-success m-1">Dashboard</a>';
            }

        ?>
        
        <?php
          if (isset($_SESSION['usertype'])) {
            
            echo '<a class="btn btn btn-success m-1" href="./logout.php">Logout</a>';
          }else{
            echo '<a href="./login.php" class="btn btn-success m-1">Login</a>
            <a href="./register.php" class="btn btn-success m-1">Register</a>';
          }
        ?>
        
      </div>
</nav>