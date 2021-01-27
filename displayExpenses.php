<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit;
    } else {
        ob_start();
        include 'includeDB.php';
        //Query EXPENSE table for relevant expenses
        $query_expenses = $connection->prepare("SELECT * FROM expenses WHERE category = :cat_result AND time_stamp > :time_result");
        $query_expenses->bindParam(":cat_result", $_GET['category'], PDO::PARAM_STR);
        $query_expenses->bindParam("time_result", $_GET['time'], PDO::PARAM_STR);
        $query_expenses->execute();
    }
?>
<!DOCTYPE html>
<html lang='en'>
   <head>
      <meta name='robots' content='noindex'/>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
      <title>Expense Details</title>
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
            
            <table class='expense-list'>
                <thead>
                    <th colspan='4'>Category Expense Details (MAD)</th>
                </thead>
                <tbody>
                    <?php
                        while($row = $query_expenses->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr class='table-rows'>";
                            echo "<td class='table-column-expense'>". $row['category'] ."</td>";
                            echo "<td class='table-column-description'>". $row['expense_description'] ."</td>";
                            echo "<td class='table-column-time'>". $row['time_stamp'] ."</td>";
                            echo "<td class='table-column-cost'>" . $row['amount'] ."</td>";  
                            echo "</tr>";
                        }    
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
