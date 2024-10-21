<?php
session_start();

 //db connection
include("connection.php");


        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        //prepared stmt to avoid sql inject
        $query = 'SELECT * FROM users WHERE users.email = :e AND users.password = :p';
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(":e" => $email, ":p" => $pass));

        $users = $stmt->fetch();

        $user_exist = false;

        if (is_array($users) || is_object($users)) {
            foreach($users as $user){
                $upass = $user['pass'];
                if(password_verify($password, $upass)) {
                    $user_exist = true;
                    $_SESSION['users'] = $users;
                    break;
                }
            }
        }
        if($user_exist) header ('location: signup.php');
        else $error_msg = 'Incorrect username or password';
        /*
        //check if user exists
        if($stmt->rowCount() > 0){
            //fetch user data
            $_SESSION['login_msg'] = "User Exists.";    
            //redirect to this location
            header('location: ../signuppage.php');
        } else {
            //return to page
            $_SESSION['login_msg'] = "User does not exists.";
            header('location: loginpage.php');
        }   
        */
?>
