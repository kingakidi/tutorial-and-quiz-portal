<?php 
  include "./view/header.php";
  include "./view/navbar.php";''
  ?>
      <main class="m-3 dasboard-main">
          <div class="dasboard-main-container">
         
            <?php
                if (isset($_GET['p'])) {
                    $page = $_GET['p'].".php";
                    include "./view/$page";
                }else{
                    echo '<div class="text-center text-success font-weight-bold m-5 h5">
                            Welcome to TUTORIAL PORTAL ADMIN  Section, Kindly user above buttons, to navigate to respective sections
                          </div>';
                }
            ?>
                 
          </div>
      </main>
<?php 
  include "./view/footer.php";
  ?>