<div class="popup-page" id="popup-page">
        
        <div class="popup-content" id="popup-content">
            
        <div class="popup-close form-group text-right" >
                <button id="popup-close" class="btn btn-danger">Close</button>
            </div>
            <div class="show-popup-content" id="show-popup-content">
               
            </div>
           
              
        </div>
    </div>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="./js/jquery.js"></script>
    <script src="./js/ckeditor/ckeditor.js"></script>
    <script src="./js/functions.js"></script>
   
    <?php
                if (isset($_GET['p'])) {
                    $page = $_GET['p'].".js";
                    echo "<script src='./js/$page'></script>";
                }
            ?>
            
  </body>
  
</html>