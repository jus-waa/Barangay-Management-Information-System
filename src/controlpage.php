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
    <script src="../script.js" defer></script>
</head>
<body  class="absolute inset-0 h-full w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <div class="bg-white grid grid-rows-2/5 grid-cols-1 rounded-xl w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="text-5xl place-self-center w-full pt-12 col-span-3 rounded-xl mb-16" >
            <h1 class="bg-pg p-6 text-center font-bold shadow-xl " >Barangay Management System</h1>
        </div>
        <div class="grid rounded-xl grid ml-96 st:ml-0 border-2"  >
            <div class="border-2">Generate documents</div>
            <div class="border-2">View records</div>
            <div class="border-2">Account information</div>
        </div>    
    </div>
    <div x-data="{ open: false }">
    <button @click="open = true">Expand</button>
 
    <span x-show="open">
        Content...
    </span>
</div>
</body>
</html>