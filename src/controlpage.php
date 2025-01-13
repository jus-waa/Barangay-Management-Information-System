<?php
    session_start();
    require 'backend/connection.php';
    require 'backend/helper.php';
    //require login first
    if (!isset($_SESSION['users'])) {
        header('location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management Sytem</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body  class="relative">
    <div class="flex flex-col rounded-xl w-full h-screen">
        <div class="text-5xl h-64 pt-12 col-span-3 ">
            <h1 class="border-4 border-c bg-c hover:bg-sg hover:border-sg transition duration-700 p-6 text-center shadow-xl font-family "><b>iBarangay</b>: Management Information System</h1>
        </div>
        <div class="flex flex-col justify-center h-full">
            <div class=" place-items-center">
                <p class="font-bold">Select an Action</p>
                <p class="border-t-4 border-c w-32 text-white rounded-sm">.</p>
            </div>
            <div class="grid grid-rows-2 gap-10 place-self-center mb-32">
                <div class="grid grid-cols-3 gap-x-10">
                    <!-- Dashboard -->
                    <div class="bg-c rounded-2xl grid">
                        <div class="border-2 border-c rounded-xl  hover:bg-sg active:bg-sg transition duration-700 cursor-pointer">
                            <?php
                                if (hasPermission('data_analytics')) {
                                    echo "
                                    <a href='dashboard.php'>
                                        <button class=' h-full py-8 px-14'>
                                        <img class='place-self-center size-14' src='../img/dashboard.png'>
                                            Dashboard
                                        </button>
                                    </a>";
                                }
                            ?>
                        </div>
                    </div>
                    <!-- Resident Info -->
                    <div class="bg-c rounded-2xl grid ">
                        <div class="border-2 border-c rounded-xl  hover:bg-sg active:bg-sg transition duration-700 cursor-pointer ">
                            <?php
                                if (hasPermission('resident_info')) {
                                    echo "
                                    <a href='residentpage.php'>
                                        <button class='h-full py-8 px-14'>
                                        <img class='place-self-center size-12' src='../img/res_info.png'>
                                            Resident<br>Information
                                        </button>
                                    </a>";
                                }
                            ?>
                        </div>
                    </div>
                    <!-- Generate Documents -->
                    <div class="bg-c rounded-2xl grid">
                        <div class="border-2 border-c rounded-xl  hover:bg-sg active:bg-sg transition duration-700 cursor-pointer ">
                            <?php
                                if (hasPermission('generate_doc')) {
                                    echo "
                                    <a href='generatedocuments.php'>
                                        <button class=' h-full py-8 px-14'>
                                        <img class='place-self-center size-12' src='../img/gen_doc.png'>
                                            Generate<br>Documents
                                        </button>
                                    </a>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="flex justify-around">
                    <div class="grid grid-cols-2 gap-x-10">
                        <!-- Print History -->
                        <div class="bg-c rounded-2xl grid">
                            <div class="border-2 border-c rounded-xl  hover:bg-sg active:bg-sg transition duration-700 cursor-pointer ">
                                <?php
                                    if (hasPermission('print_history')) {
                                        echo "
                                        <a href='printhistory.php'>
                                            <button class=' h-full py-8 px-14'>
                                            <img class='place-self-center size-12' src='../img/gen_doc.png'>
                                                Print History
                                            </button>
                                        </a>";
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Account Settings -->
                        <div class="bg-c rounded-2xl grid">
                            <div class="border-2 border-c rounded-xl  hover:bg-sg active:bg-sg transition duration-700 cursor-pointer ">
                            <?php if(hasPermission('system_settings')){ 
                                    echo "
                                    <a href='accountmanagement.php'>
                                        <button class='h-full py-8 px-10'>
                                        <img class='place-self-center size-12' src='../img/setting.png'>
                                        Account Settings
                                        </button>
                                    </a>";
                                } else { ?>
                            </div>
                        </div>  
                        <div class="bg-gray-300 rounded-2xl grid">
                            <div class="border-2 border-gray-200 rounded-xl  hover:bg-gray-400 active:bg-sg transition duration-700 pointer-events-none ">
                                <?php 
                                    echo "
                                    <a href=''>
                                        <button class='h-full py-8 px-10'>
                                        <img class='place-self-center size-12' src='../img/setting.png'>
                                            Inaccessible
                                        </button>
                                    </a>";
                                ?>
                            </div>
                        </div>  
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>