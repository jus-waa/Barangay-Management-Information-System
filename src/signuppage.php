<?php
    session_start();
    //require login first
    if (!isset($_SESSION['users'])) {
        header('location: login.php');
        exit();
    }
    include('backend/connection.php');
    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $pass_re = $_POST['password_re'];
        $contact_info = $_POST['contact_info'];
        $role_id = $_POST['role_id'];

        if($pass != $pass_re) {
            $_SESSION['pass_recheck'] = "Password do not match.";
            header('location: signuppage.php');
            exit();
        }

        $query = "SELECT * FROM roles WHERE id = :role_id";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(":role_id" => $role_id));
        $role = $stmt->fetch(PDO::FETCH_ASSOC); 

        if (!$role) {
            $_SESSION['empty_info'] = "Please fill in required information.";
            header('location: signuppage.php');
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
            header('location: signuppage.php');
        } else  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_format'] = "Invalid email format";
            header('location: signuppage.php');
        } else if($email == $result['email']) { //check for email duplicates
            $_SESSION['email_dup'] = "Email already in use.";
            header('location: signuppage.php');
            exit();
        } 
        //check for password strength
        if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $pass)) {
            $_SESSION['pass_min'] = "Password too weak.";
            header('location: signuppage.php');
            exit();
        } else {
            try {
                $insert_data = "INSERT INTO `users`(`username`, `email`, `password`, `password_re`, `contact_info`, `created_at`, `updated_at`, `role_id`) VALUES ('$username','$email','$encrypted','$encrypted_re','$contact_info',now(),now(),'$role_id')";
                $dbh->exec($insert_data);
                $response = $username . 'has been successfully added to the system.';
            } catch (PDOException $e) {
                $response = $e->getMessage();
            }
            if($role_id === '1') {
                header('location: accountmanagement.php?msg= Admin account has been created.');
            } else {
                header('location: accountmanagement.php?msg= Regular account has been created.');
            }
            exit();
        } 
    } else if (isset($_POST['cancel'])) {
        header('location: accountmanagement.php?msg= The operation has been terminated.');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-full p-6 flex items-center justify-center">
    <!-- Main Content Area -->
    <div class="flex flex-col h-4/5 w-4/5 bg-white shadow-2xl rounded-xl overflow-hidden">
        <div class="flex flex-grow">
            <!-- Left Side (Information Section) -->
            <div class="bg-sg rounded-l-md w-2/5 text-white flex flex-col justify-center items-center"> 
                <div class="mx-12">
                    <h1 class="text-5xl font-bold mb-2 text-center">iBarangay</h1>
                    <h3 class="text-c text-2xl mt-1 mb-16 text-center">Management Information System</h3>
                    <p class="text-c text-justify p-6">A user-friendly website designed to simplify barangay management of resident data, incident reports, projects, and documents, enhancing productivity and service to the community.</p> <!-- Changed font to Questrial -->
                </div>
            </div>

            <!-- Right Side (Create Account Form) -->
            <div class="bg-c w-3/5 flex flex-col justify-center"> 
                <div class="grid rounded-xl bg-c">
                    <div class="grid grid-rows-1 grid-cols-2 mb-4 justify-self-center mr-4">
                        <div class="grid grid-rows-1">
                            <div class="h-16">
                                <div class="">
                                    <p class="text-3xl font-bold">Create Account</p>
                                    <p class="mb-4">Get started with an account.</p>
                                </div>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs"><b>NOTE:</b><br>The password must be at least 8 characters long and <br>include at least one uppercase letter, one lowercase <br> letter, one digit, and one special character. </p>
                        </div>
                    </div>
                    <form action="signuppage.php" method="POST" id="account_form" >
                        <div class="grid grid-rows-3 grid-cols-2 justify-self-center">
                            <div class="mr-2">
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="email" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl ">Email Address</label>
                            </div>
                            <div class="relative mb-4">
                                <input type="password" id="password" name="password" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl ">Password</label>
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <img src="../img/eye-close.png" alt="Show password" class="h-3 w-4 mr-3 text-gray-600" id="eyeClosed">
                                    <img src="../img/eye-open.png" alt="Hide password"  class="h-2.5 w-4 mr-3 text-gray-600 hidden" id="eyeOpen">
                                </button>
                                </div>
                            <div>
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="username" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl ">Username</label>
                            </div>
                            <div class="relative mb-4">
                                <input type="password" id="passwordRe" name="password_re" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1  pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl ">Re-type Password</label>
                                <button type="button" id="togglePasswordRe" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <img src="../img/eye-close.png" alt="Show password" class="h-3 w-4 mr-3 text-gray-600" id="eyeClosedRe">
                                    <img src="../img/eye-open.png" alt="Hide password"  class="h-2.5 w-4 mr-3 text-gray-600 hidden" id="eyeOpenRe">
                                </button>
                            </div>
                            <div>
                                <input id="contact-num" name="contact_info" type="text" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl">Contact Number</label>
                            </div>
                            <div class="flex gap-x-2 mr-2 mb-4">
                                <div class="border-2  border-sg flex justify-center items-center h-11 w-full rounded-md ">
                                    <input type="radio" class="hidden peer" name="role_id" value="1" id="admin" onclick="adminColor()"></input>
                                    <label for="admin" class="w-4 h-4 flex justify-center items-center rounded-full border-2 border-sg cursor-pointer">
                                        <div class="w-2.5 h-2.5 bg-c transition duration-50 rounded-full cursor-pointer"  id="colorButtonAdmin"></div>
                                    </label>
                                    <label for="admin" class="text-sg ml-2">Admin</label>
                                </div>
                                <div class="border-2  border-sg flex justify-center items-center h-11 w-full rounded-md ">
                                    <input type="radio" class="hidden peer" name="role_id" value="2" id="regular" onclick="regularColor()"></input>
                                    <label for="regular" class="w-4 h-4 flex justify-center items-center rounded-full border-2 border-sg cursor-pointer">
                                        <div class="w-2.5 h-2.5 bg-c transition duration-50 rounded-full cursor-pointer"  id="colorButtonRegular"></div>
                                    </label>
                                    <label for="regular" class="text-sg ml-2">Regular</label>
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-500 text-sm">Format: 0999 999 9999</span><br>
                                <span id="contact-error" class="text-red-500 text-sm hidden">Must be 11 digits</span>
                            </div>
                            <div class="flex gap-x-3">
                                <button id="update_account" name="signup" onclick="accountMsg()" class="rounded-md w-[8.6rem] border-2  p-2 place-self-center border-sg bg-sg hover:text-white transition duration-300">Create</button>
                                <button id="cancel-button" name="cancel" class="rounded-md w-[8.6rem] border-2 p-2 place-self-center border-red-500 bg-red-500  hover:text-white transition duration-700">Cancel</button>
                            </div>
                        </div>
                        <?php 
                        if (isset($_SESSION['response'])) {
                            $response_message = $_SESSION['response'];
                            ?>
                            <div class="text-xs grid mt-2" style="color: green;">
                                <p class="place-self-center responseMessage__success">
                                    <?= $response_message ?>
                                </p>
                            </div>
                            <?php
                            unset($_SESSION['response']);
                        }
                        //displays messages
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
    function adminColor(){
        const colorButton1 = document.getElementById('colorButtonAdmin');
        const colorButton2 = document.getElementById('colorButtonRegular');

        colorButton1.classList.add('bg-sg');
        colorButton1.classList.remove('bg-c');

        colorButton2.classList.remove('bg-sg');
        colorButton2.classList.add('bg-c');
    }
    function regularColor(){
        const colorButton1 = document.getElementById('colorButtonAdmin');
        const colorButton2 = document.getElementById('colorButtonRegular');

        colorButton2.classList.add('bg-sg');
        colorButton2.classList.remove('bg-c');

        colorButton1.classList.remove('bg-sg');
        colorButton1.classList.add('bg-c');
  
    }
    </script>
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

    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("account_form");
    const contactNumberInput = document.getElementById("contact-num");
    const contactNumber = document.getElementById("contact-num").value;
    const contactError = document.getElementById("contact-error");
    const cancelButton = document.getElementById("cancel-button"); // Assume the Cancel button has this ID

    form.addEventListener("submit", (event) => {
            let isValid = true;
            let firstInvalidElement = null;

            // Check Contact Number
            if (!/^\d{4} \d{3} \d{4}$/.test(contactNumberInput.value.trim())) {
                isValid = false;
                event.preventDefault();
                contactError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || contactNumberInput;
            } else {
                contactError.classList.add("hidden");
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
                firstInvalidElement.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        });
        // Cancel Button: Redirect to another page
        cancelButton.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent default button behavior
            // Redirect to another page (replace 'your-page-url' with the actual URL)
            window.location.href = "accountmanagement.php"; 
        });
    });
    </script>
</body>
</html>
