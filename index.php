<?php
  include "./view/home_header.php";
  include "./view/home_navbar.php";
 

 
?>

    <main class="m-3 p-3">
      <?php
        if (isset($_GET['t'])) {
          $id = $_GET['t'];
          include "./view/t.php";
       }else{
         include "./view/home.php";
       }
        

      ?>
      
      
    </main>
  </body>
</html>
