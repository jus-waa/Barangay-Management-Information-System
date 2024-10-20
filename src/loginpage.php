<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management Sytem</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\style.css">
    <script src="\Main Project\Barangay-Management-System\tailwind.config.js"></script>
</head>
<body  class="absolute inset-0 h-full w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
<div class="bg-white grid grid-rows-2/5 grid-cols-3 rounded-xl w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="text-5xl place-self-center w-full pt-12 col-span-3 rounded-xl mb-16" >
            <h1 class="bg-pg p-6 text-center font-bold shadow-xl ">Barangay Management System</h1>
        </div>

        <div class="rounded-xl grid ml-20 mb-24 place-self-center w-64 2xl:w-96 text-xs hidden st:block 2xl:text-base 2xl:block" >
            <div class="place-self-center rounded-xl">
                <div class="rounded-xl bg-pg grid pt-8 pb-8 p-4 mt-4 shadow-xl">
                    <p class="rounded-xl bg-c p-4 text-center">Barangay Poblacion II is popularly known as Riverside because it is bounded by the Tibagan River on the southwest portion. It was established in 1982 when Poblacion was divided into four barangays. The Barangay is primarily classified as urban with a total land area of 74 hectares and is bounded on the north by Barangay Poblacion III, on the south by Barangay Banaba Cerca, on the east by Barangay Poblacion I and on the west by Tibagan River.</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl grid ml-96 st:ml-0"  >
            <div class="bg-pg rounded-xl grid place-self-center shadow-2xl st:ml-0">
                <div class="grid rounded-xl bg-c m-10 mb-0 p-14 shadow-lg">
                    <div class="grid grid-rows-2">
                        <p class="text-3xl font-bold break-after-auto">Sign In</p>
                        <p>Access your account.</p>
                    </div>
                    <form action="" method="POST">
                        <div>
                            <input name="email" type="text" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                            <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Email Address</label>
                        </div>
                        <div>
                            <input name="pass" type="password" autocomplete="off" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c mt-2" placeholder=" "/> 
                            <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Password</label>
                        </div>

                        <!--displays error msg-->
                        <?php if (!empty($error_msg)) { ?> 
                        <div>
                            <p><? $error_msg ?></p>
                        </div>
                        <?php } ?>
                        <!--display login message if user exists or not-->
                        <?php 
                            if(isset($_SESSION['login_msg'])) {
                        ?>
                        <div class="text-xs grid mt-2" style="color: red">
                            <p class="place-self-center">
                                <?= $_SESSION['login_msg']?>
                            </p>
                        </div>
                        <?php unset($_SESSION['login_msg']); }?>

                        <button class="relative rounded-md bg-pg w-2/5 p-2 mt-2 text-l mt-4" name="login">Sign In</button><br>
                        <a href="#" class="underline text-blue-700">Forgot Password?</a>
                     </form>
                </div>
                <p class="text-center rounded-xl mb-28 mt-4 text-s md:mb-12">Don't have an account? <a href="#" class="underline text-blue-700">Create your account </a></p>
            </div>
        </div>

        <div class="rounded-xl grid place-self-center w-96 2xl:w-auto text-xs hidden st:block 2xl:text-base 2xl: block">
            <div class="rounded-xl grid ">
                <div class="ml-64 mr-12 place-self-center rounded-xl md:ml-12 md:mb-16">
                    <div class="rounded-xl bg-pg grid pt-8 pb-8 p-4 mt-4 mb-4 shadow-xl ">
                        <p class="rounded-xl bg-c place-self-center max-w-96 p-4 text-center">A user-friendly website that helps barangays manage resident information, incident reports, projects, and documents easily. It simplifies day-to-day tasks, making operations more efficient and improving service for the community.</p>
                    </div>
                    <div class="flex justify-center items-center space-x-8">
                        <img src="\Main Project\Barangay-Management-System\img\bit_builders.png" alt="bitbuilders-logo" class="size-12 rounded-full border-2 border-pg">
                        <p class="text-center bg-pg rounded-lg p-2">by Bit Builders</p>
                    </div>
                </div>
            </div>
        </div>     
    </div>
</body>
</html>