<?php
    session_start();

    include('connection.php');
    $id = $_GET["id"];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass_re = $_POST['password_re'];
    $contact_info = $_POST['contact_info'];
    $role_id = $_POST['role_id'];

    if($pass != $pass_re) {
        $_SESSION['pass_recheck'] = "Password do not match.";
        header('location: ../accountmanagement.php');
        exit();
    }

    $options = ['cost' => 13];
    $encrypted = password_hash($pass, PASSWORD_BCRYPT, $options);
    $encrypted_re = password_hash($pass_re, PASSWORD_BCRYPT, $options);

    $query = 'SELECT * FROM users WHERE users.email = :e';
    $stmt = $dbh->prepare($query);
    $stmt->execute(array(":e" => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    
    //check if empty, check for email validation, then email duplicates
    if (empty($username) || empty($email) || empty($pass) || empty($pass_re) || empty($contact_info) || empty($role_id)) {
        $_SESSION['empty_info'] = "Please fill in required information.";
        header('location: ../accountmanagement.php');
    } else  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_format'] = "Invalid email format";
        header('location: ../accountmanagement.php');
    } else if($email == $result['email']) { //check for email duplicates
        $_SESSION['email_dup'] = "Email already in use.";
        header('location: ../accountmanagement.php');
        exit();
    } 
    //check for                         password strength
    if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $pass)) {
        $_SESSION['pass_min'] = "Password too weak.";
        header('location: ../accountmanagement.php');
        exit();
    } else {
        try {
            $update_data = "UPDATE `users` SET `username`=$username, `email`=$email, `password`=$encrypted, `password_re`=$encrypted_re, `contact_info`=$contact_info,`updated_at`=now() WHERE `id`=$id";
            $dbh->exec($update_data);
            
            $response =  $username . ' successfully added to the system.';
             

        } catch (PDOException $e) {
            $response = $e->getMessage();
        }
        $_SESSION['response'] = $response;
        header('location: ../accountmanagement.php');
    } 
?>