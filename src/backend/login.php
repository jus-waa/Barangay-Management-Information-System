<?php
session_start();

 //db connection
include('connection.php');

 if (isset($_POST['login'])){
     $email = $_POST['email'];
     $pass = $_POST['pass'];

     //prepared stmt to avoid sql inject
     $query = 'SELECT * FROM users WHERE users.email = :e AND users.password = :p';
     $stmt = $dbh->prepare($query);
     $stmt->execute(array(":e" => $email, ":p" => $pass));

     //check if user exists
     if($stmt->rowCount() > 0){
         //fetch user data
         $_SESSON['users'] = $stmt->fetch();
         $_SESSION['login_msg'] = "User Exists.";

         //redirect to this location
         header('location: ../loginpage.php');
     } else {
         //return to page
         $_SESSION['login_msg'] = "User does not exists.";
         header('location: ../loginpage.php');
     }

     $pdo = null;
 }
?>