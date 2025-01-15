<?php
    session_start();
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
<body class="relative">
    <!-- Main Content Area -->
    <div class="flex h-screen">
        <!-- Left Side (Sign In Form) -->
        <div class="w-3/5 flex justify-center items-center"> 
        <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../img/bunacerca-bg.png'); filter: blur(3px); z-index: -1;"></div>
                <form action="backend/login.php" method="POST" class="grid border-1 border-black px-12 py-20 rounded-xl backdrop-blur-sm bg-white/80"> 
                    <div class="place-self-center">
                        <div class="grid grid-rows-2 place-content-center">
                            <p class="text-3xl font-bold place-self-center">Sign In</p>
                            <p>Login to access your account.</p>
                        </div>
                        <!--Email-->
                        <div class="mt-8 mb-6 ">
                            <input name="email" type="text" autocomplete="off" class="block bg-transparent w-72 border-1 text-m p-2 peer rounded-md outline-none ring-2 ring-c focus:ring-sg" placeholder=" "/> 
                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-[3.8rem] z-10  bg-white/5 pl-1 text-left rounded-2xl "><p class="opacity-100">Email Address</p></label>
                        </div>
                        <!--Password-->
                        <div class="relative mb-4">
                            <input type="password" id="password" name="pass" autocomplete="off" class="block bg-transparent w-72 border-1 text-m p-2 peer rounded-md outline-none ring-2 ring-c mt-2 focus:ring-sg" placeholder=" "/> 
                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1  pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-[3.8rem] z-10 bg-white/5 pl-1 text-left rounded-2xl ">Password</label>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <img src="../img/eye-close.png" alt="Show password" class="h-3 w-4 mr-3 text-gray-600" id="eyeClosed">
                                <img src="../img/eye-open.png" alt="Hide password"  class="h-2.5 w-4 mr-3 text-gray-600 hidden" id="eyeOpen">
                            </button>
                        </div>
                        <!--Displays error msg-->
                        <?php if (!empty($error_msg)) { ?> 
                            <div>
                                <p><? $error_msg ?></p>
                            </div>
                        <?php } ?>
                        <!--Display login message if user exists or not-->
                        <?php 
                            if(isset($_SESSION['login_msg'])) {
                        ?>
                            <div class="text-xs grid mt-2" style="color: red">
                                <p class="place-self-center">
                                    <?= $_SESSION['login_msg']?>
                                </p>
                            </div>
                        <?php unset($_SESSION['login_msg']); }?>
                        <div class="">
                            <button class="rounded-md w-72 p-2 mt-4 place-self-center bg-sg transition duration-700 text-white hover:text-black">Sign In</button><br>
                        </div>
                    </div>
                </form>
        </div>

        <!-- Right Side (Information Section) -->
        <div class="bg-sg rounded-l-md w-2/5  p-20 text-white flex flex-col justify-center items-center"> <!-- Increased padding -->
            <img src="../img/coat.png" alt="" class="h-20 w-20 object-contain">
            <h1 class="text-5xl font-bold mb-2 text-center">Barangay Buna Cerca</h1>
            <h3 class="text-c text-2xl mt-1 mb-16 text-center">iBarangay: Management Information System</h3>
            <p class="text-c text-justify p-6">A user-friendly website designed to simplify barangay management of resident data, incident reports, projects, and documents, enhancing productivity and service to the community.</p> <!-- Changed font to Questrial -->
        </div>
    </div>

    <!-- Footer Section -->
    <div class="absolute bottom-4 left-4 flex items-center">
        <img src="../img/bit_builders.png" alt="bitbuilders-logo" class="size-8 rounded-full border-2 border-c">
        <span class="ml-3 text-white">
            By Bit Builders
        </span>
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
    </script>
</body>
</html>
