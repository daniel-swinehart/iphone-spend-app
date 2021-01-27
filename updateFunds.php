<?php
   session_start();
   if(!isset($_SESSION['user_id'])){
      header('Location: login.php');
      exit;
   } else {
      ob_start();
      include 'includeDB.php';
      //Check for the required fields from 'spend-form' on displayFunds.php
      if ((!$_POST['expense-type']) || (!$_POST['expense-amount']) || (!$_POST['expense-description'])) {
         header("Location: displayFunds.php");
         exit;
      } else {
         //Assign variable values for input into the database
         $expense_type = $_POST['expense-type'];
         $expense_amount = $_POST['expense-amount'];
         $expense_description = $_POST['expense-description'];
         /*Assign current CATEGORY table record id to variable and assign current date_time*/
         $current_record = $_POST['update-button'];
         $date = date('Y-m-d H:i:s'); 
         //Create and issue query to find category value to update
         $current_amount_query = $connection->prepare("SELECT $expense_type FROM categories WHERE id= :record"); 
         $current_amount_query->bindParam(":record", $current_record, PDO::PARAM_INT);
         $current_amount_query->execute();
         $result_row = $current_amount_query->fetchAll(PDO::FETCH_ASSOC);
         $current_amount = ($result_row[0][$expense_type]);
         //Convert expense amount and current amount to int for calculations
         $int_expense_amount = (int)$expense_amount;
         $int_current_amount = (int)$current_amount;
         //Subtract new expense amount from current expense
         $int_current_amount -= $int_expense_amount;
         //Update new category value into database
         $update_amount = $connection->prepare("UPDATE categories SET $expense_type = :amount WHERE id= :record");
         $update_amount->bindParam(":amount", $int_current_amount, PDO::PARAM_INT);
         $update_amount->bindParam(":record", $current_record, PDO::PARAM_INT);
         $update_amount->execute();

         //Add new expense to EXPENSE table in database
         $create_new_expense_sql = $connection->prepare("INSERT INTO expenses (category, expense_description, amount, time_stamp) VALUES (:expense_cat, :expense_desc, :expense_amount, :expense_time)");
         $create_new_expense_sql->bindParam(":expense_cat", $expense_type, PDO::PARAM_STR);
         $create_new_expense_sql->bindParam(":expense_desc", $expense_description, PDO::PARAM_STR);
         $create_new_expense_sql->bindParam(":expense_amount", $expense_amount, PDO::PARAM_STR);
         $create_new_expense_sql->bindParam(":expense_time", $date, PDO::PARAM_STR);
         $create_new_expense_sql->execute();

         //Close connection to database
         $current_amount_query = NULL;
         $update_amount = NULL;
         $create_new_expense_sql = NULL;

         header("Location: displayFunds.php");
         exit;
      }
   }
?>