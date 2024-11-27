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
    <div class="grid grid-rows-2/5 grid-cols-1 rounded-xl w-full">
        <div class="text-5xl place-self-center w-full pt-12 col-span-3 rounded-xl mb-16" >
            <h1 class="bg-sg p-6 text-center font-bold shadow-xl ">iBarangay: Management Information System</h1>
        </div>
        <div class="mt-16 xl:mt-48">
            <div class="flex gap-32 place-self-center">
                <div class="bg-c rounded-2xl grid ">
                <img class="place-self-center h-28 size-20" src="../img/gen_doc.svg" alt="">
                    <div class="bg-sg rounded-xl text-xl hover:bg-sg active:bg-sg focus:outline-none focus:ring-4 focus:ring-c">
                        <?php
                            if (hasPermission('generate_doc')) {
                                echo "<a href='generatedocuments.php'><button class='p-2 px-14'>Generate a<br> Document</button></a>";
                            }
                        ?>
                    </div>
                </div>
                <div class="bg-c rounded-2xl grid ">
                <img class="place-self-center h-28 size-16" src="../img/res_info.svg" alt="">
                    <div class="bg-sg rounded-xl text-xl hover:bg-sg active:bg-sg focus:outline-none focus:ring-4 focus:ring-c">
                        <?php
                            if (hasPermission('resident_info')) {
                                echo "<a href='residentpage.php'><button class='p-2 px-14'>Resident<br>Information</button></a>";
                            }
                        ?>
                    </div>
                </div>
                <?php  
                if(hasPermission('system_settings')){
                ?>
                <div class="bg-c rounded-xl grid">
                <?php
                } else {
                ?>
                <div class="bg-gray-400 rounded-xl grid">
                <?php
                }
                ?>
                <img class="place-self-center h-28 size-16" src="../img/setting.svg" alt="">
                    <div class="bg-sg rounded-2xl text-xl hover:bg-sg active:bg-sg focus:outline-none focus:ring-4 focus:ring-c">
                        <?php
                            if (hasPermission('system_settings')) {
                                echo "<a href='accountmanagement.php'><button class='p-2 px-18'>System<br>Settings</button></a>";
                            } else {
                                echo "<button class = 'p-5.5 px-12 bg-gray-500 text-gray-600 rounded-xl pointer-events-none'>Inaccessible</button>";
                            }
                        ?>
                    </div>
                </div>
            </div>  
        </div>
          
    </div>
</body>
</html>