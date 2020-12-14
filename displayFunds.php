<?php
   include 'includeDB.php';
   connectDB();

   //Collect expense categories and current remaining fund levels
   $get_catFunds_sql = "SELECT * FROM categories ORDER BY id DESC";

   $get_catFunds_results = mysqli_query($mysqli, $get_catFunds_sql) or die      (mysqli_error($mysqli));

   //Arrange fund level data into table for display
   $category_info = mysqli_fetch_array($get_catFunds_results);
   $cat_grocery = $category_info['grocery'];
   $cat_education = $category_info['education'];
   $cat_transportation = $category_info['transportation'];
   $cat_utilities = $category_info['utilities'];
   $cat_apartment = $category_info['apartment_rent'];
   $cat_clothing = $category_info['clothing'];
   $cat_recreation = $category_info['recreation'];
   $cat_vacation = $category_info['vacation'];
   $cat_savings = $category_info['savings'];
   $cat_medical = $category_info['medical'];
   $cat_house_help = $category_info['house_help'];
   $cat_hospitality = $category_info['hospitality'];
   $cat_charitable = $category_info['charitable'];

   //Add to table display
   $display_block = <<<END_OF_TEXT
   <table class='fund_levels'>
   <tr class='table-rows'>
      <td class='table-column-category'>Groceries</td>
      <td class='table-column-amount'>$cat_grocery</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Transportation</td>
      <td class='table-column-amount'>$cat_transportation</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Charitable</td>
      <td class='table-column-amount'>$cat_charitable</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Education</td>
      <td class='table-column-amount'>$cat_education</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>House Help</td>
      <td class='table-column-amount'>$cat_house_help</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Hospitality</td>
      <td class='table-column-amount'>$cat_hospitality</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Clothing</td>
      <td class='table-column-amount'>$cat_clothing</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Medical</td>
      <td class='table-column-amount'>$cat_medical</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Recreation</td>
      <td class='table-column-amount'>$cat_recreation</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Savings</td>
      <td class='table-column-amount'>$cat_savings</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Vacation</td>
      <td class='table-column-amount'>$cat_vacation</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Utilities</td>
      <td class='table-column-amount'>$cat_utilities</td>
   </tr>
   <tr class='table-rows'>
      <td class='table-column-category'>Apartment Rent</td>
      <td class='table-column-amount'>$cat_apartment</td>
   </tr>
   </table>

   END_OF_TEXT;

   //Free results from sql query
   mysqli_free_result($get_catFunds_results);

   //Close connection to MySQL
   mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang='en'>
   <head>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
      <title>Expense Tracker</title>
      <link rel='stylesheet' href='styles.css'/>
      <link rel='shortcut icon' type='image/png' href='favicon.png'/>
   </head>

   <body>
      <div class='page'>
         <header class='header'>
            <div class='page-logo'><img src='#'/></div>
         </header>

         <h1>Expense Tracker</h1>

         <form action='updateFunds.php' method='post' class='spend-form'>
            <div class='form-row'>
               <label for='expense-type'>Expense Type</label>
               <select id='expense-type' name='expense-type'>
                  <option value='grocery'>Grocery</option>
                  <option value='education'>Education</option>
                  <option value='transportation'>Transportation</option>
                  <potion value='utilities'>Utilities</option>
                  <option value='apartment_rent'>Apartment Rent</option>
                  <option value='clothing'>Clothing</option>
                  <option value='recreation'>Recreation</option>
                  <option value='vacation'>Vacation</option>
                  <option value='savings'>Savings</option>
                  <option value='medical'>Medical</option>
                  <option value='house_help'>House Help</option>
                  <option value='hospitality'>Hospitality</option>
                  <option value='charitable'>Charitable</option>
               </select>
            </div>
            <div class='form-row'>
               <label for='expense-amount'>Amount</label>
               <input id='expense-amount' name='expense-amount' type='text'/>
            </div>
            <div class='form-row'>
               <button type='submit'>Submit</button>
            </div>   
         </form>

         <h2>Expense Report</h2>
         <?php echo $display_block; ?>
      </div>
   </body>
</html>