<?php
session_start();

 //db connection
$conn = new mysqli('localhost', 'root', '', 'db_mis');

if (isset($_POST['login'])){
    //check for empty values
    if(empty(trim($_POST['pass'])) && empty(trim($_POST['email']))){
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        $options = ['cost' => 13];
        $hash = password_hash($pass, PASSWORD_BCRYPT, $options); 
        
        $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$hash')");

        
        /*
        //prepared stmt to avoid sql inject
        $query = 'SELECT * FROM users WHERE users.email = :e AND users.password = :p';
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(":e" => $email, ":p" => $hash));   
        
        
        if ($stmt->rowCount() == 1) {
            echo "found one user";
            $stmt->fetch();
            $_SESSION['users'] = $stmt->fetch();
        }
        
        //check if user exists
        if($stmt->rowCount() > 0){
            //fetch user data
            $_SESSION['users'] = $stmt->fetch();
            $_SESSION['login_msg'] = "User Exists.";    
            //redirect to this location
            header('location: ../signup.php');
        } else {
            //return to page
            $_SESSION['login_msg'] = "User does not exists.";
            header('location: ../loginpage.php');
        }   
        $pdo = null;

    */
    } else $error_msg = "Incorrect email or password.";
}
 //password hash

 //$sql = "UPDATE users SET password = $hash WHERE email = $email";   
 //password verify
 //$data = $stmt->fetch();
 //if (password_verify($pass, $data['pass'])) {
 //   echo "Password verified";
 //} else echo "Invalid password"; 
?>
