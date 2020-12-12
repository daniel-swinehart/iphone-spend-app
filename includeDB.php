
<?php
   function connectDB() {
      global $mysqli;
         //connect to server and select database;
      $mysqli = new mysqli("localhost", "danielma_daniel", "TRoop12719871990!!", "danielma_personal_expenses");
      if ($mysqli->connect_errno) {
         echo "Failed to connect to MySQL: " . $mysqli->connect_error;
         exit();
      }
   }
?>