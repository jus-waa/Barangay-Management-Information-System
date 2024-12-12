<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
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
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative">
    <div class="flex h-screen w-screen overflow-auto">
        <!-- Sidebar -->
        <div class="flex-none w-20 h-full shadow-2xl">
            <!--Nav-->
            <div id="mainNav" class="flex flex-col place-content-start h-full w-full bg-c duration-500 ease-in-out">
                <div class="mt-24 flex flex-col space-y-6">
                    <a href="residentpage.php">
                        <button id="res_info"  onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="flex place-content-center w-full">
                            <img  class="size-10 my-2" src="../img/res_info.svg">
                            <span id="res_title" class="absolute ml-76 z-10 p-2 border-4 border-sg rounded-full bg-c min-w-52 hidden">Resident Information</span>
                        </button>
                    </a>
                    <a href="generatedocuments.php">
                        <button id="gen_doc" onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="flex place-content-center w-full">
                            <img  class="size-13 my-1" src="../img/gen_doc.svg">
                            <span id="doc_title" class="absolute ml-76 z-10 p-2 border-4 border-sg rounded-full bg-c min-w-52 hidden">Generate Documents</span>
                        </button>
                    </a>
                    <?php
                    if (hasPermission('system_settings')){
                    ?>
                    <a href="accountmanagement.php">
                        <button id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
                            <img  class="size-10 my-2" src="../img/setting.svg" >
                            <span id="set_title" class="absolute ml-76 z-10 p-2 border-4 border-sg rounded-full bg-c min-w-52 hidden">System Settings</span>
                        </button>
                    </a>
                    <?php 
                    } else {
                    ?>
                    <button disabled id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
                        <img  class="size-10 my-2" src="../img/setting.svg" >
                        <span id="set_title" class="absolute ml-76 z-10 p-2 border-4 border-gray-600 rounded-full bg-gray-500 text-gray-600 min-w-52 hidden ">System Settings</span>
                    </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Main -->
        <div class="w-full h-screen"> 
            <!-- Header -->
            <div class="shadow-md px-32 h-20 py-6">
                <div class="text-3xl">
                    Generate Documents
                </div>
            </div>
            <div class="grid content-center h-5/6">
                <div class="flex justify-center space-x-14 bg-c w-full p-10 shadow-md">
                    <div class="document-button flex flex-col items-center w-40 ">
                        <img width="50" height="50" src="../img/clearance.svg" alt="clearance" />
                        <a href="brgyclearance.php" class="mt-2 text-sm bg-sg px-10 py-2 rounded-md text-center cursor-pointer">
                            Barangay <br> Clearance
                        </a>
                    </div>
                    <div class="document-button flex flex-col items-center w-40 cursor-pointer">
                        <img width="50" height="50" src="../img/indigency.svg" alt="indigency" />
                        <span class="mt-2 text-sm bg-sg px-10 py-2 rounded-md text-center">Certificate of<br>Indigency</span>
                    </div>
                    <div class="document-button flex flex-col items-center w-40 cursor-pointer">
                        <img width="50" height="50" src="../img/residency.svg" alt="residency" />
                        <span class="mt-2 text-sm bg-sg px-10 py-2 rounded-md text-center">Certificate of<br>Residency</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
<script>
   //hover on nav 
    function hoverNav() {
        let setting = document.getElementById("setting");
        let resident = document.getElementById("res_info");
        let mainNav = document.getElementById("mainNav");
        mainNav.style.height = "11rem";
        setting.style.opacity = "1";
        resident.style.opacity = "1";
    }
    function leaveNav() {
        let setting = document.getElementById("setting");
        let resident = document.getElementById("res_info");
        let mainNav = document.getElementById("mainNav");
    
        mainNav.style.height = "3.5rem";
        setting.style.opacity = "0";
        resident.style.opacity = "0";
    }
    function confirmDeletion(id) {
        document.getElementById("confirmDeletion").classList.remove("hidden");
        document.getElementById("deleteLink").href =' backend/delete.php?id=' + id;
    }
    function cancelConfirmation() {
        document.getElementById("confirmDeletion").classList.add("hidden");
    }
    //toggle display
    function toggleDisplay(elementID, show) {
        const element = document.getElementById(elementID);
        element.style.display = show ? "block" : "none";
    }
</script>
</body>
</html>
