<?php
    session_start();

    include('connection.php');

    $tb_name = $_SESSION['users'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass_re = $_POST['password_re'];
    $contact_info = $_POST['contact_info'];
    $role_id = $_POST['role_id'];

    if($pass != $pass_re) {
        $_SESSION['pass_recheck'] = "Password do not match.";
        header('location: ../signuppage.php');
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
        header('location: ../signuppage.php');
    } else  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_format'] = "Invalid email format";
        header('location: ../signuppage.php');
    } else if($email == $result['email']) { //check for email duplicates
        $_SESSION['email_dup'] = "Email already in use.";
        header('location: ../signuppage.php');
        exit();
    } 
    //check for password strength
    if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $pass)) {
        $_SESSION['pass_min'] = "Password too weak.";
        header('location: ../signuppage.php');
        exit();
    } 
    //check for role number
    if ($role_id != 1 || $role_id != 2) {
        $SESSION['role_num'] = "Please enter a valid role number.";
        header('location: ../signuppage.php');
        exit();
    } else {
        try {
            $insert_data = "INSERT INTO `users`(`username`, `email`, `password`, `password_re`, `contact_info`, `created_at`, `updated_at`, `role_id`) VALUES ('$username','$email','$encrypted','$encrypted_re','$contact_info',now(),now(),'$role_id')";
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