<?php
    session_start();
    
    //require login first
    if (!isset($_SESSION['users'])) {
        header('location: login.php');
        exit();
    }

    include('backend/connection.php');
    $id = $_GET["id"];
    if(isset($_POST['update_account'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $pass_re = $_POST['password_re'];
        $contact_info = $_POST['contact_info'];

        if($pass != $pass_re) {
            $_SESSION['pass_recheck'] = "Password do not match.";
        }

        $options = ['cost' => 13];
        $encrypted = password_hash($pass, PASSWORD_BCRYPT, $options);
        $encrypted_re = password_hash($pass_re, PASSWORD_BCRYPT, $options);

        $query = 'SELECT * FROM users WHERE users.email = :e';
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(":e" => $email));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //check if empty, check for email validation, then email duplicates
        if (empty($username) || empty($email) || empty($pass) || empty($pass_re) || empty($contact_info)) {
            $_SESSION['empty_info'] = "Please fill in required information.";
        } else  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_format'] = "Invalid email format";
        }
        //check for password strength
        if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $pass)) {
            $_SESSION['pass_min'] = "Password too weak.";
        } else {
            try {
                $update_data = "UPDATE `users` SET `username`='$username', `email`='$email', `password`='$encrypted', `password_re`='$encrypted_re', `contact_info`='$contact_info',`updated_at`=now() WHERE `id`='$id'";
                $dbh->exec($update_data);
                $response =  $username . ' successfully updated to the system.';
            } catch (PDOException $e) {
                $response = $e->getMessage();
            }
            $_SESSION['response'] = $response;
            header('location: accountmanagement.php?msg=' . $response);
        } 
    } else if (isset($_POST['cancel'])) {
        header('location: accountmanagement.php?msg= operation cancelled.');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management Sytem</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js"></script>
</head>
<body class="absolute inset-0 h-full w-full bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <div class="grid grid-rows-2/5 grid-cols-1 rounded-xl w-full  bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="text-5xl place-self-center w-full pt-12 col-span-3 rounded-xl mb-16" >
            <h1 class=" bg-pg p-6 text-center font-bold shadow-xl ">iBarangay: Management Information System</h1>
        </div>
        <div class="rounded-xl grid st:ml-0"  >
            <div class="bg-pg rounded-xl grid place-self-center shadow-2xl st:ml-0">
                <div class="grid rounded-xl bg-c m-10 p-14">
                    <div class="grid grid-rows-1 grid-cols-2 mb-4 ">
                        <div>
                            <p class="text-3xl font-bold">Update Account</p>
                            <p>Edit account.</p>
                        </div>
                        <div class="flex place-content-center">
                            <p class="text-xs"><b>NOTE:</b><br>The password must be at least 8 characters long and <br>include at least one uppercase letter, one lowercase <br> letter, one digit, and one special character. </p>
                        </div>
                    </div>
                    <?php 
                    $query = "SELECT * FROM `users` WHERE `id` = :id";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute(['id' => $_GET['id']]);
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form method="POST" >
                        <div class="grid grid-rows-3 grid-cols-2 ">
                            <div class="">
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" value="<?php echo $row['email'] ?>" name="email" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Email Address</label>
                            </div>
                            <div x-data="{showPassword : false}">
                                <input :type="showPassword ? 'text' : 'password'" autocomplete="off" type="password" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c ml-2"  name="password"  placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-4 peer-focus:scale-75 peer-focus:translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Password</label>
                                <div>
                                    <img :src="showPassword ? '../img/eye-open.png' : '../img/eye-close.png'" @click="showPassword = !showPassword" alt="show/hide password" class="absolute transform -translate-y-13.5 cursor-pointer"  style="cursor:pointer; z-index:99; cursor:pointer; margin-left:16rem; width: 1rem; margin-top: 1.6rem; cursor:pointer;">
                                </div>
                            </div>
                            <div>
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" value="<?php echo $row['username'] ?>" name="username" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Username</label>
                            </div>
                            <div x-data="{showPassword : false}">
                                <input :type="showPassword ? 'text' : 'password'"  autocomplete="off" type="password" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c ml-2"  name="password_re" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-4 peer-focus:scale-75 peer-focus:translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Re-type Password</label>
                                <div>
                                    <img :src="showPassword ? '../img/eye-open.png' : '../img/eye-close.png'" @click="showPassword = !showPassword" alt="show/hide password" class="absolute transform -translate-y-13.5 cursor-pointer"  style="cursor:pointer; z-index:99; cursor:pointer; margin-left:16rem; width: 1rem; margin-top: 1.6rem; cursor:pointer;">
                                </div>
                            </div>
                            <div>
                                <input autocomplete="off" type="number" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" value="<?php echo $row['contact_info'] ?>" name="contact_info" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Contact Information</label>
                            </div>
                            
                            <div class="grid grid-cols-2 grid-rows-1 place-self-center ml-1">
                                <div></div>                               
                                <div>
                                    <button name="update_account" class="rounded-md bg-pg w-full p-2 px-4 text-l col-span-2 mb-4">Update Account</button><br>
                                </div>
                            </div>
                         </div>
                         <?php } ?>
                         <?php //displays messanges
                            $messages = [
                                'response' => ['message' => 'response', 'class' => 'responseMessage__success', 'color' => 'green'],
                                'empty_info' => ['message' => 'empty_info', 'class' => 'responseMessage__error', 'color' => 'red'],
                                'email_format' => ['message' => 'email_format', 'class' => 'responseMessage__error', 'color' => 'red'],
                                'email_info' => ['message' => 'email_info', 'class' => 'responseMessage__error', 'color' => 'red'],
                                'email_dup' => ['message' => 'email_dup', 'class' => 'responseMessage__error', 'color' => 'red'],
                                'pass_recheck' => ['message' => 'pass_recheck', 'class' => 'responseMessage__error', 'color' => 'red'],
                                'pass_min' => ['message' => 'pass_min', 'class' => 'responseMessage__error', 'color' => 'red'],
                                'role_num' => ['message' => 'role_num', 'class' => 'responseMessage__error', 'color' => 'red']
                            ];

                            foreach ($messages as $key => $message) {
                                if (isset($_SESSION[$key])) {
                                    $response_message = $_SESSION[$key];
                            ?>
                                <div class="text-xs grid mt-2" style="color: <?= $message['color'] ?>">
                                    <p class="place-self-center <?= $message['class'] ?>">
                                        <?= $response_message ?>
                                    </p>
                                </div>
                            <?php unset($_SESSION[$key]);}}?>
                     </form>
                </div>
            </div>
        </div>    
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye icons
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });

        const togglePasswordRe = document.getElementById('togglePasswordRe');
        const passwordRe = document.getElementById('passwordRe');
        const eyeOpenRe = document.getElementById('eyeOpenRe');
        const eyeClosedRe = document.getElementById('eyeClosedRe');

        togglePasswordRe.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordRe.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordRe.setAttribute('type', type);

            // Toggle the eye icons
            eyeOpenRe.classList.toggle('hidden');
            eyeClosedRe.classList.toggle('hidden');
        });
    </script>
</body>
</html>
