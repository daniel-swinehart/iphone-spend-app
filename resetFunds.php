<?php
ob_Start();
include 'includeDB.php';
connectDB();

//SQL create new record in database to reset funds levels to hard-coded levels.
$create_new_sql = "INSERT INTO categories (grocery, education, transportation, utilities, apartment_rent, clothing, recreation, vacation, savings, medical, house_help, hospitality, charitable, tithe) VALUES (400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400, 400)";
mysqli_query($mysqli, $create_new_sql) or die(mysqli_error($mysqli));

//Close connection to MySQL
mysqli_close($mysqli);

header("Location: displayFunds.php");
exit;
?>