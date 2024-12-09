<?php
session_start();

 //db connection
include("connection.php");
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        //select data and a prepared stmt to avoid sql inject
        $query = 'SELECT * FROM users WHERE users.email = :e'; // AND users.password = :p
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(":e" => $email));//, ":p" => $pass
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //check if user exists
        if(password_verify($pass, $result['password'])){
            //fetch user data
            $_SESSION['users'] = $result['id'];
            $_SESSION['role_id'] = $result['role_id'];
            $_SESSION['login_msg'] = "User Exists.";    
            //redirect to this location
            header('location: ../controlpage.php');
            exit();
        } else if (empty($email) || empty($pass)){
            //return to page
            $_SESSION['login_msg'] = "Empty credentials!";
            header('location: ../loginpage.php');
            exit();
        }   else {
            //return to page
            $_SESSION['login_msg'] = "Invalid credentials!";
            header('location: ../loginpage.php');
            exit();
        }   
?>