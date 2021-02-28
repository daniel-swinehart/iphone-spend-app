<?php
   session_start();
   if(!isset($_SESSION['user_id'])){
      header('Location: login.php');
      exit;
   } else {
      ob_start();
      include 'includeDB.php';
      $date = date('Y-m-d H:i:s'); 
      $current_category_record = $_POST['reset-button'];
      

      //Collect CATEGORIES table current remaining fund levels
      $query_categories = $connection->prepare("SELECT * FROM categories WHERE id= :current_record");
      $query_categories->bindParam(":current_record", $current_category_record, PDO::PARAM_STR);
      $query_categories->execute(); 
      //Fetch results
      $category_info = $query_categories->fetch(PDO::FETCH_ASSOC);
      
      //Collect ROLLOVER table current fund levels
      $query_rollover = $connection->prepare("SELECT * FROM rollover ORDER BY id DESC LIMIT 1");
      $query_rollover->execute();
      //Fetch results
      $rollover_info = $query_rollover->fetch(PDO::FETCH_ASSOC);
      //Add remaining funds to exsisting rollover amounts for new rollover
      $roll_grocery = $rollover_info['grocery'] + $category_info['grocery'];
      $roll_education = $rollover_info['education'] + $category_info['education'];
      $roll_transportation = $rollover_info['transportation'] + $category_info['transportation'];
      $roll_utilities = $rollover_info['utilities'] + $category_info['utilities'];
      $roll_apartment = $rollover_info['apartment_rent'] + $category_info['apartment_rent'];
      $roll_clothing = $rollover_info['clothing'] + $category_info['clothing'];
      $roll_recreation = $rollover_info['recreation'] + $category_info['recreation'];
      $roll_vacation = $rollover_info['vacation'] + $category_info['vacation'];
      $roll_savings = $rollover_info['savings'] + $category_info['savings'];
      $roll_medical = $rollover_info['medical'] + $category_info['medical'];
      $roll_house_help = $rollover_info['house_help'] + $category_info['house_help'];
      $roll_hospitality = $rollover_info['hospitality'] + $category_info['hospitality'];
      $roll_charitable = $rollover_info['charitable'] + $category_info['charitable'];
      $roll_tithe = $rollover_info['tithe'] + $category_info['tithe'];

      //SQL to update ROLLOVER table totals into new record
      $create_new_rollover_record = $connection->prepare("INSERT INTO rollover (grocery, education, transportation, utilities, apartment_rent, clothing, recreation, vacation, savings, medical, house_help, hospitality, charitable, tithe, time_stamp) VALUES (:new_grocery, :new_education, :new_transportation, :new_utilities, :new_apartment_rent, :new_clothing, :new_recreation, :new_vacation, :new_savings, :new_medical, :new_house_help, :new_hospitality, :new_charitable, :new_tithe, :new_time_stamp)");
      $create_new_rollover_record->bindParam(":new_grocery", $roll_grocery, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_education", $roll_education, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_transportation", $roll_transportation, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_utilities", $roll_utilities, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_apartment_rent", $roll_apartment, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_clothing", $roll_clothing, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_recreation", $roll_recreation, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_vacation", $roll_vacation, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_savings", $roll_savings, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_medical", $roll_medical, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_house_help", $roll_house_help, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_hospitality", $roll_hospitality, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_charitable", $roll_charitable, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_tithe", $roll_tithe, PDO::PARAM_STR);
      $create_new_rollover_record->bindParam(":new_time_stamp", $date, PDO::PARAM_STR);
      $create_new_rollover_record->execute();

      /*SQL create new record in database to reset funds levels to hard-coded levels and reset timestamp for month*/
      $create_new_categories_record = $connection->prepare("INSERT INTO categories (grocery, education, transportation, utilities, apartment_rent, clothing, recreation, vacation, savings, medical, house_help, hospitality, charitable, tithe, time_stamp) VALUES (3588, 4058, 1298, 1256, 4750, 897, 1794, 1794, 2243, 448, 1520, 717, 448, 2691, :current_date)");
      $create_new_categories_record->bindParam(":current_date", $date, PDO::PARAM_STR);
      $create_new_categories_record->execute();

      //Close connection to database
      $query_categories = NULL;
      $query_rollover = NULL;
      $create_new_rollover_record = NULL;
      $create_new_categories_record = NULL;

      header("Location: displayFunds.php");
      exit;
   }
?>