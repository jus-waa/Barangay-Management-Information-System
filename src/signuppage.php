<?php
    session_start();
    //if(!isset($_SESSION['users'])) header('location: login.php');
    //$_SESSION['table'] = 'users';
    //$users = $_SESSION['users'];
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
    <div class="bg-white grid grid-rows-2/5 grid-cols-1 rounded-xl w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="text-5xl place-self-center w-full pt-12 col-span-3 rounded-xl mb-16" >
            <h1 class="text-red-500 bg-pg p-6 text-center font-bold shadow-xl " >Barangay Management System</h1>
        </div>
        <div class="rounded-xl grid ml-96 st:ml-0"  >
            <div class="bg-pg rounded-xl grid place-self-center shadow-2xl st:ml-0">
                <div class="grid rounded-xl bg-c m-10 mb-0 p-14 shadow-lg">
                    <div class="grid grid-rows-1 grid-cols-2 mb-4">
                        <div>
                            <p class="text-3xl font-bold break-after-auto">Create Account</p>
                            <p>Get started with an account.</p>
                        </div>
                        <div class="flex place-content-center">
                            <p class="text-xs pl-28"><b>NOTE:</b><br>The password must be at least 8 characters long and <br>include at least one uppercase letter, one lowercase <br> letter, one digit, and one special character. </p>
                        </div>
                        
                    </div>
                    <form action="backend/signup.php" method="POST" >
                        <div class="grid grid-rows-3 grid-cols-2 ">
                            <!--1,4,2,5,3 -->
                            
                            <div>
                                <input autocomplete="off" type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="email" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Email Address</label>
                            </div>
                            <div>
                                <input autocomplete="off" type="password" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c ml-2 " name="password"  placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-4 peer-focus:scale-75 peer-focus:translate-x-2 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Password</label>
                            </div>
                            <div>
                                <input autocomplete="off" type="numer" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="username" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">  Username</label>
                            </div>
                            <div>
                                <input autocomplete="off" type="password" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c ml-2" name="password_re" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-4 peer-focus:scale-75 peer-focus:translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Re-type Password</label>
                            </div>
                            <div>
                                <input autocomplete="off" type="number" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="contact_info" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Contact Information</label>
                            </div>
                            
                            <div class="grid grid-cols-2 grid-rows-1 place-self-center">
                                <div>
                                    <input autocomplete="off" type="text" maxlength="1" size="2" class="block bg-transparent border-2 border-sg text-m p-2 py-1.5 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" name="role_id" placeholder=" "/> 
                                    <label class="absolute text-sg pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-1 peer-focus:scale-75 peer-focus:-translate-x-1.5 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Role ID</label>
                                </div>                               
                                <div>
                                    <button class="rounded-md bg-pg w-full p-2 pl-4 pr-4 text-l col-span-2">Create Account</button><br>
                                    <a href="#" class="underline text-blue-700 text-s">Forgot Password?</a>
                                </div>
                            </div>
                         </div>

                        <!--displays response msg-->
                        <?php if(isset($_SESSION['response'])) { 
                                $response_message = $_SESSION['response']['message']; 
                                $success_message = $_SESSION['response']['success'];    
                            ?> 
                                <div class="text-xs grid mt-2" style="color: red">
                                    <p class="place-self-center <?= $success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                                       <?= $response_message ?>
                                    </p>
                                </div>
                            <?php unset($_SESSION['response']); } ?>
                        <!--display login message if email is emptyor not-->
                        <?php 
                            if(isset($_SESSION['empty_info'])) {
                        ?>
                            <div class="text-xs grid mt-2" style="color: red">
                                <p class="place-self-center">
                                    <?= $_SESSION['empty_info']?>
                                </p>
                            </div>
                        <?php unset($_SESSION['empty_info']); }?>
                                
                        <!--display if email format is incorrect -->
                        <?php 
                            if(isset($_SESSION['email_format'])) {
                        ?>
                            <div class="text-xs grid mt-2" style="color: red">
                                <p class="place-self-center">
                                    <?= $_SESSION['email_format']?>
                                </p>
                            </div>
                        <?php unset($_SESSION['email_format']); }?>

                        <!--display if email info already exist-->
                        <?php 
                            if(isset($_SESSION['email_info'])) {
                        ?>
                            <div class="text-xs grid mt-2" style="color: red">
                                <p class="place-self-center">
                                    <?= $_SESSION['email_info']?>
                                </p>
                            </div>
                        <?php unset($_SESSION['email_info']); }?>
                        <!--display message about email dup-->
                        <?php 
                            if(isset($_SESSION['email_dup'])) {
                        ?>
                        <div class="text-xs grid mt-2" style="color: red">
                            <p class="place-self-center">
                                <?= $_SESSION['email_dup']?>
                            </p>
                        </div>
                        <?php unset($_SESSION['email_dup']); }?>
                        <!--display message about password recheck-->
                        <?php 
                            if(isset($_SESSION['pass_recheck'])) {
                        ?>
                        <div class="text-xs grid mt-2" style="color: red">
                            <p class="place-self-center">
                                <?= $_SESSION['pass_recheck']?>
                            </p>
                        </div>
                        <?php unset($_SESSION['pass_recheck']); }?>
                        <!--display message about password recheck-->
                        <?php 
                            if(isset($_SESSION['pass_min'])) {
                        ?>
                        <div class="text-xs grid mt-2" style="color: red">
                            <p class="place-self-center">
                                <?= $_SESSION['pass_min']?>
                            </p>
                        </div>
                        <?php unset($_SESSION['pass_min']); }?>
                        <!--display message about role number-->
                        <?php 
                            if(isset($_SESSION['role_num'])) {
                        ?>
                        <div class="text-xs grid mt-2" style="color: red">
                            <p class="place-self-center">
                                <?= $_SESSION['role_num']?>
                            </p>
                        </div>
                        <?php unset($_SESSION['role_num']); }?>
                     </form>
                </div>
                <p class="text-center rounded-xl mb-28 mt-4 text-s md:mb-12">Already have an account? <a href="loginpage.php" class="underline text-blue-700">Sign In</a></p>
            </div>
        </div>    
         
    </div>
</body>
</html>
