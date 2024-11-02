<?php
    session_start();
    //require login first
    if (!isset($_SESSION['users'])) {
        header('location: login.php');
        exit();
    }
    
    //$_SESSION['table'] = 'users';
    //$users = $_SESSION['users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js"></script>
</head>
<body class="h-screen w-full bg-[#f0f0f0] p-6 flex items-center justify-center">
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
                    <form action="backend/signup.php" method="POST" >
                        <div class="grid grid-rows-3 grid-cols-2 justify-self-center">
                            <div class="mr-2">
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="email" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Email Address</label>
                            </div>
                            <div class="relative mb-4">
                                <input type="password" id="password" name="password" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1  pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl ">Password</label>
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <img src="../img/eye-close.png" alt="Show password" class="h-3 w-4 mr-3 text-gray-600" id="eyeClosed">
                                    <img src="../img/eye-open.png" alt="Hide password"  class="h-2.5 w-4 mr-3 text-gray-600 hidden" id="eyeOpen">
                                </button>
                                </div>
                            <div>
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="username" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Username</label>
                            </div>
                            <div class="relative mb-4">
                                <input type="password" id="passwordRe" name="password_re" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1  pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-c pl-1 text-left rounded-2xl ">Re-type Password</label>
                                <button type="button" id="togglePasswordRe" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <img src="../img/eye-close.png" alt="Show password" class="h-3 w-4 mr-3 text-gray-600" id="eyeClosedRe">
                                    <img src="../img/eye-open.png" alt="Hide password"  class="h-2.5 w-4 mr-3 text-gray-600 hidden" id="eyeOpenRe">
                                </button>
                            </div>
                            <div>
                                <input autocomplete="off" type="number" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="contact_info" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Contact Information</label>
                            </div>
                            <div class="grid grid-cols-2 grid-rows-1 mr-2">
                                <div class="">
                                    <input type="radio" name="role_id" value="1"></input>
                                    <label class="text-sg">Admin</label><br>
                                    <input type="radio" name="role_id" value="2"></input>
                                    <label class="text-sg">Regular</label>
                                </div>                               
                                <div>
                                    <button class="rounded-md  w-full bg-pg p-2 text-l col-span-2 mb-4">Create Account</button><br>
                                </div>
                            </div>
                        </div>
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
