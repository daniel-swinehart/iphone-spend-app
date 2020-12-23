<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit;
    } else {
      include 'includeDB.php';

      //Collect expense categories and current remaining fund levels
      $query = $connection->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT 1");
      $query->execute(); 

      //Arrange fund level data into table for display
      $category_info = $query->fetch(PDO::FETCH_ASSOC);
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

      //Add to table display
      $display_block = <<<END_OF_TEXT
      <table class='fund-levels'>
         <thead>
            <th colspan='2'>Current Fund Levels (MAD)</th>
         </thead>
         <tbody>
            <tr class='table-rows'>
               <td class='table-column-category'>Groceries</td>
               <td class='table-column-amount'>$cat_grocery</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Charitable</td>
               <td class='table-column-amount'>$cat_charitable</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Transportation</td>
               <td class='table-column-amount'>$cat_transportation</td>
            </tr>
            <tr class='table-rows'>
               <td class='table-column-category'>Education</td>
               <td class='table-column-amount'>$cat_education</td>
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
               <td class='table-column-category'>House Help</td>
               <td class='table-column-amount'>$cat_house_help</td>
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
            <tr class='table-rows-last'>
               <td class='table-column-category-last'>Tithe</td>
               <td class='table-column-amount-last'>$cat_tithe</td>
            </tr>
         </tbody>
      </table>

      END_OF_TEXT;

      //Close connection to MySQL
      $connection = NULL;
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
      <div class='page'>
         <header class='header'>
            <div class='page-logo'><img src='#'/></div>
         </header>

         <h1>Monthly Fund Tracker</h1>

         <form action='updateFunds.php' method='post' class='spend-form'>
            <div class='form-row'>
               <label for='expense-type'>Expense Type:
                  <select id='expense-type' name='expense-type'>
                     <option value='grocery'>Grocery</option>
                     <option value='charitable'>Charitable</option>
                     <option value='transportation'>Transportation</option>
                     <option value='education'>Education</option>
                     <option value='clothing'>Clothing</option>
                     <option value='hospitality'>Hospitality</option>
                     <option value='medical'>Medical</option>
                     <option value='house_help'>House Help</option>
                     <option value='utilities'>Utilities</option>
                     <option value='apartment_rent'>Apartment Rent</option>
                     <option value='recreation'>Recreation</option>
                     <option value='vacation'>Vacation</option>
                     <option value='savings'>Savings</option>
                     <option value='tithe'>Tithe</option>  
                  </select>
               </label>  
            </div>
            <div class='form-row'>
               <label for='expense-amount'>Amount(MAD):
                  <input id='expense-amount' name='expense-amount' type='number'/>
               </label>
            </div>
            <div class='form-row'>
               <button type='submit' id='update-button' name='update-button' value='<?php echo $cat_id; ?>'>Submit</button>
            </div>   
         </form>

         <?php echo $display_block; ?>
         <details class='report-reset'>
            <summary>Reset Fund Levels</summary>
            <form action='resetFunds.php' method='post'  class='reset-spend-form'>
               <div class='form-row'>
                  <button type='submit' name='reset-button'>Reset Funds</button>
               </div>
            </form>
         </details>
      </div>
   </body>
</html>