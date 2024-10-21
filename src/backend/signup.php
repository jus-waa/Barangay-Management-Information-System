<?php
    session_start();

    include('connection.php');

    $tb_name = $_SESSION['users'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass_re = $_POST['password_re'];
    $contact_info = $_POST['contact_info'];

    $options = ['cost' => 13];
    $encrypted = password_hash($pass, PASSWORD_BCRYPT, $options);
    $encrypted_re = password_hash($pass_re, PASSWORD_BCRYPT, $options);

    //check for empty email
    if (empty($username) || empty($email) || empty($pass) || empty($pass_re) || empty($contact_info)) {
        $_SESSION['empty_info'] = "Please fill in required information.";
        header('location: ../signuppage.php');
    } 
    //validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_format'] = "Invalid email format";
            header('location: ../signuppage.php');
    } 
    //check if user email already exists
    $query = "SELECT * FROM users WHERE email = :e";
    $stmt = $dbh->prepare($query);
    $stmt->execute(array(":e" => $email));
    if($stmt->rowCount() > 0){
        $_SESSION['email_info'] = "Email has already been used.";
        header('location: ../signuppage.php');
    } else {
        try {
            $insert_data = "INSERT INTO `users`(`username`, `email`, `password`, `password_re`, `contact_info`, `created_at`, `updated_at`) VALUES ('$username','$email','$encrypted','$encrypted_re','$contact_info',now(),now())";
            $dbh->exec($insert_data);

            $response = [
                'success' => true,
                'message' => $username . ' successfully added to the system.'
            ];
             

        } catch (PDOException $e) {
            $response = [
                'success' => true,
                'message' => $e->getMessage()
            ];
        }
        $_SESSION['response'] = $response;
        header('location: ../signuppage.php');
    }
?>