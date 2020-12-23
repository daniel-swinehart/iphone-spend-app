<?php
   session_start();
   if(!isset($_SESSION['user_id'])){
      header('Location: login.php');
      exit;
   } else {
      ob_start();
      include 'includeDB.php';
      //SQL create new record in database to reset funds levels to hard-coded levels.
      $create_new_sql = $connection->prepare("INSERT INTO categories (grocery, education, transportation, utilities, apartment_rent, clothing, recreation, vacation, savings, medical, house_help, hospitality, charitable, tithe) VALUES (400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400)");
      $create_new_sql->execute();

      //Close connection to database
      $create_new_sql = NULL;

      header("Location: displayFunds.php");
      exit;
   }
?>