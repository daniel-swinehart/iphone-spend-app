<?php
include 'includeDB.php';
connectDB();

//Check for the required fields from 'spend-form' on displayFunds.php
if ((!$_POST['expense-type']) || (!$_POST['expense-amount'])) {
   header("Location: http://www.danielmaroc.com/displayFunds.php");
   exit;
}

//Create safe values for input into the database
$clean_expense_type = mysqli_real_escape_string($mysqli, $_POST['expense-type']);
$clean_expense_amount = mysqli_real_escape_string($mysqli, $_POST['expense-amount']);

//Convert cleaned expense amount to int for calculations
$int_expense_amount = (int)$clean_expense_amount;

//Create and issue query to find category value to update
$retrieve_current_amount_sql = "SELECT $clean_expense_type FROM categories WHERE id = 1";
$retrieve_current_amount_res = mysqli_query($mysqli,        $retrieve_current_amount_sql) or die(mysqli_error($mysqli));
$current_row = mysqli_fetch_array($retrieve_current_amount_res);
$current_amount = $current_row[$clean_expense_type];

//Subtract new expense amount from current expense
$current_amount -= $int_expense_amount;

//Update new category value into database
$update_category_amount_sql = "UPDATE categories SET $clean_expense_type= $current_amount WHERE id = 1";
mysqli_query($mysqli, $update_category_amount_sql) or die(mysqli_error($mysqli));

//Close connection to MySQL
mysqli_close($mysqli);

header("Location: http://www.danielmaroc.com/displayFunds.php");
exit;
?>