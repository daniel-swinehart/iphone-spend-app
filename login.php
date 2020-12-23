<?php
    session_start();
    ob_start();
    include('includeDB.php');
    if (isset($_POST['login'])) {
        $username = $_POST['user-name'];
        $password = $_POST['user-password'];
        $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<p class="error">Username password combination is wrong!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                echo '<p class="success">Congratulations, you are logged in!</p>';
                header("Location: displayFunds.php");
                exit;
            } else {
                echo '<p class="error">Username password combination is wrong!</p>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang='en'>
   <head>
      <meta name='robots' content='noindex'/>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
      <title>User Login</title>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,900;1,900&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
      <link rel='stylesheet' href='temp_style.css'/>
      <link rel='apple-touch-icon' type='image/png' href='http://www.danielmaroc.com/images/apple-touch-icon.png'/>
   </head>
   <body>
      <form method='post' action='' name='signup-form'>
         <div class='form-row'>
            <label for='input-username'>Username
               <input id='input-username' name='user-name' type='text' required/>
            </label>
         </div>
         <div class='form-row'>
            <label for='input-password'>Password
               <input id='input-password' name='user-password' type='password' required/>
            </label>
         </div>
         <button type='submit' name='login' value='login'>Login</button>
      </form>
   </body>
</html>