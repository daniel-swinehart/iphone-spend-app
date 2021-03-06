<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit;
    } else {
      include 'includeDB.php';

      //Collect expense categories and current remaining fund levels
      $query_categories = $connection->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT 1");
      $query_categories->execute(); 

      //Arrange fund level data into table for display
      $category_info = $query_categories->fetch(PDO::FETCH_BOTH);
      $cat_id = $category_info['id'];
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
      $cat_tithe = $category_info['tithe'];
      $cat_start_total = $category_info['start_total']; 
      $cat_time = $category_info['time_stamp'];

      //Calculate current total for display
      $cat_total = $cat_grocery + $cat_education + $cat_transportation + $cat_utilities + $cat_apartment + $cat_clothing + $cat_recreation + $cat_vacation + $cat_savings + $cat_medical + $cat_house_help + $cat_hospitality + $cat_charitable + $cat_tithe;

      //Add to table display
      $display_block_current_funds = <<<END_OF_TEXT
      <table class='fund-levels'>
         <thead>
            <th colspan='2'>Current Fund Levels (MAD)</th>
         </thead>
         <tbody>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=grocery&time=$cat_time'>Groceries</a></td>
               <td class='table-column-amount'>$cat_grocery</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=charitable&time=$cat_time'>Charitable</a></td>
               <td class='table-column-amount'>$cat_charitable</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=transportation&time=$cat_time'>Transportation</a></td>
               <td class='table-column-amount'>$cat_transportation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=education&time=$cat_time'>Education</a></td>
               <td class='table-column-amount'>$cat_education</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=hospitality&time=$cat_time'>Hospitality</a></td>
               <td class='table-column-amount'>$cat_hospitality</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=clothing&time=$cat_time'>Clothing</a></td>
               <td class='table-column-amount'>$cat_clothing</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=medical&time=$cat_time'>Medical</a></td>
               <td class='table-column-amount'>$cat_medical</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=recreation&time=$cat_time'>Recreation</a></td>
               <td class='table-column-amount'>$cat_recreation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=house_help&time=$cat_time'>House Help</a></td>
               <td class='table-column-amount'>$cat_house_help</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=savings&time=$cat_time'>Savings</a></td>
               <td class='table-column-amount'>$cat_savings</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=vacation&time=$cat_time'>Vacation</a></td>
               <td class='table-column-amount'>$cat_vacation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=utilities&time=$cat_time'>Utilities</a></td>
               <td class='table-column-amount'>$cat_utilities</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'><a href='displayExpenses.php?category=apartment_rent&time=$cat_time'>Apartment Rent</a></td>
               <td class='table-column-amount'>$cat_apartment</td>
            </tr>
            <tr class='table-rows-last'>
               <td class='table-column-category-last'><a href='displayExpenses.php?category=tithe&time=$cat_time'>Tithe</a></td>
               <td class='table-column-amount-last'>$cat_tithe</td>
            </tr>
         </tbody>
      </table>

      END_OF_TEXT;

      $display_block_current_funds_total = <<<END_OF_TEXT
      <table class='fund-levels'>
         <thead>
            <th colspan='2'>Fund Totals (MAD)</th>
         </thead>
         <tbody>
            <tr class='table-rows'>
               <td class='table-column-amount-last'>Beginning Total: $cat_start_total</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-amount-last'>Remaining Total: $cat_total</td>
            </tr>
         </tbody>
      </table>

      END_OF_TEXT;

      //Collect rollover fund levels
      $query_rollover = $connection->prepare("SELECT * FROM rollover ORDER BY id DESC LIMIT 1");
      $query_rollover->execute(); 

      //Arrange fund level data into table for display
      $rollover_info = $query_rollover->fetch(PDO::FETCH_ASSOC);
      $roll_grocery = $rollover_info['grocery'];
      $roll_education = $rollover_info['education'];
      $roll_transportation = $rollover_info['transportation'];
      $roll_utilities = $rollover_info['utilities'];
      $roll_apartment = $rollover_info['apartment_rent'];
      $roll_clothing = $rollover_info['clothing'];
      $roll_recreation = $rollover_info['recreation'];
      $roll_vacation = $rollover_info['vacation'];
      $roll_savings = $rollover_info['savings'];
      $roll_medical = $rollover_info['medical'];
      $roll_house_help = $rollover_info['house_help'];
      $roll_hospitality = $rollover_info['hospitality'];
      $roll_charitable = $rollover_info['charitable'];
      $roll_tithe = $rollover_info['tithe'];
      
      //Calculate total rollover amount
      $roll_total = $roll_grocery + $roll_education + $roll_transportation + $roll_utilities + $roll_apartment + $roll_clothing + $roll_recreation + $roll_vacation + $roll_savings + $roll_medical + $roll_house_help + $roll_hospitality + $roll_charitable + $roll_tithe; 
      

      //Add to display ROLLOVER fund table
      $display_block_rollover_funds = <<<END_OF_TEXT
      <table class='fund-levels'>
         <thead>
            <th colspan='2'>Rollover Fund Levels (MAD)</th>
         </thead>
         <tbody>
            <tr class='table-rows'>
               <td class='table-column-category'>Groceries</td>
               <td class='table-column-amount'>$roll_grocery</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Charitable</td>
               <td class='table-column-amount'>$roll_charitable</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Transportation</td>
               <td class='table-column-amount'>$roll_transportation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Education</td>
               <td class='table-column-amount'>$roll_education</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Hospitality</td>
               <td class='table-column-amount'>$roll_hospitality</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Clothing</td>
               <td class='table-column-amount'>$roll_clothing</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Medical</td>
               <td class='table-column-amount'>$roll_medical</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Recreation</td>
               <td class='table-column-amount'>$roll_recreation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>House Help</td>
               <td class='table-column-amount'>$roll_house_help</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Savings</td>
               <td class='table-column-amount'>$roll_savings</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Vacation</td>
               <td class='table-column-amount'>$roll_vacation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Utilities</td>
               <td class='table-column-amount'>$roll_utilities</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Apartment Rent</td>
               <td class='table-column-amount'>$roll_apartment</td>
            </tr>
            <tr class='table-rows-last'>
               <td class='table-column-category-last'>Tithe</td>
               <td class='table-column-amount-last'>$roll_tithe</td>
            </tr>
         </tbody>
      </table>

      END_OF_TEXT;
      
      $display_block_rollover_funds_total = <<<END_OF_TEXT
      <table class='fund-levels'>
         <thead>
            <th colspan='2'>Rollover Total (MAD)</th>
         </thead>
         <tbody>
            <tr class='table-rows'>
               <td class='table-column-amount-last'>$roll_total</td>
            </tr>
         </tbody>
      </table>
      
      END_OF_TEXT; 
      
      //Close database connections
      $query_categories = NULL;
      $query_rollover = NULL;
    } 
?>

<!DOCTYPE html>
<html lang='en'>
   <head>
      <meta name='robots' content='noindex'/>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
      <title>Expense Tracker</title>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,900;1,900&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
      <link rel='stylesheet' href='styles.css'/>
      <link rel='apple-touch-icon' type='image/png' href='http://www.danielmaroc.com/images/apple-touch-icon.png'/>
   </head>

   <body>
      <header class='header'>
         <div class="navbar">
            <a href="#home">Home</a>
            <a href="#reports">Reports</a>
            <a href="#reset">Reset</a>
         </div>
      </header>
      <div class='page'>
         <h1>Monthly Fund Tracker</h1>

         <form action='updateFunds.php' method='post' class='spend-form'>
            <div class='form-row'>
               <label for='expense-type'>Expense Type:
                  <select id='expense-type' name='expense-type'>
                     <option value='grocery'>Grocery</option>
                     <option value='charitable'>Charitable</option>
                     <option value='transportation'>Transportation</option>
                     <option value='education'>Education</option>
                     <option value='hospitality'>Hospitality</option>
                     <option value='clothing'>Clothing</option>
                     <option value='medical'>Medical</option>
                     <option value='recreation'>Recreation</option>
                     <option value='house_help'>House Help</option>
                     <option value='savings'>Savings</option>
                     <option value='vacation'>Vacation</option>
                     <option value='utilities'>Utilities</option>
                     <option value='apartment_rent'>Apartment Rent</option>
                     <option value='tithe'>Tithe</option>  
                  </select>
               </label>  
            </div>
            <div class='form-row'>
                  <label for='expense-description'>Expense Description:
                     <input id='expense-description' name='expense-description' type='text' required/>
                  </label>
            </div>
            <div class='form-row'>
               <label for='expense-amount'>Amount(MAD):
                  <input id='expense-amount' name='expense-amount' type='number' required/>
               </label>
            </div>
            <div class='form-row'>
               <button type='submit' id='update-button' name='update-button' value='<?php echo $cat_id; ?>'>Submit</button>
            </div>   
         </form>

         <?php echo $display_block_current_funds; ?>
         <?php echo $display_block_current_funds_total; ?>
         <details class='report-rollover'>
            <summary>Current Fund Rollover Amounts</summary>
               <div class='form-row'>
                  <?php echo $display_block_rollover_funds; ?>
               </div>
               <div class='form-row'>
                  <?php echo $display_block_rollover_funds_total; ?>
               </div>
         </details>
         <details class='report-reset'>
            <summary>Reset Fund Levels</summary>
            <form action='resetFunds.php' method='post'  class='reset-spend-form'>
               <div class='form-row'>
                  <button class='reset-button' type='submit' id='reset-button' name='reset-button' value='<?php echo $cat_id; ?>'>Reset Funds</button>
               </div>
             </form>
         </details>      
      </div>
   </body>
</html>