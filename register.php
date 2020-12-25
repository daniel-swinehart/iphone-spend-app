<?php
   session_start();
   if(!isset($_SESSION['user_id'])){
      header('Location: login.php');
      exit;
   } else {
      include 'includeDB.php';
      if (isset($_POST['register'])) {
         $username = $_POST['user-name'];
         $email = $_POST['user-email'];
         $password = $_POST['user-password'];
         $password_hash = password_hash($password, PASSWORD_BCRYPT);
         $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
         $query->bindParam(":email", $email, PDO::PARAM_STR);
         $query->execute();
         if ($query->rowCount() > 0) {
            echo '<p class="error">The email address is already registered!</p>';
         }
         if ($query->rowCount() == 0) {
            $query = $connection->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
            $query->bindParam(":username", $username, PDO::PARAM_STR);
            $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
               echo '<p class="success">Your registration was successful!</p>';
               header("Location: login.php");
               exit;
            } else {
               echo '<p class="error">Something went wrong!</p>';
            }
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
      <title>Register</title>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,900;1,900&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
      <link rel='stylesheet' href='styles.css'/>
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
            <label for='input-email'>Email
               <input id='input-email' name='user-email' type='email' required/>
            </label>
         </div>
         <div class='form-row'>
            <label for='input-password'>Password
               <input id='input-password' name='user-password' type='password' required/>
            </label>
         </div>
         <button type='submit' name='register' value='register'>Register</button>
      </form>
   </body>
</html>