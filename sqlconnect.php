
<?php
   $mysqli = new mysqli("danielmaroc.com", "daniel", "8DcyhJ!&;0MY", "expense_tracker");
   if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
?>