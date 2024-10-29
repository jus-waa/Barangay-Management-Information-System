<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
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
</head>
<body class="relative bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <!-- Header -->
    <div class="grid grid-cols-2 items-center">
        <div class="flex flex-row items-start">
            <!-- Nav -->
            <div id="mainNav" onmouseover="hoverNav()" onmouseleave="leaveNav()" class="flex flex-col mr-16 rounded-b-full h-14 w-16 hover:h-44 bg-lg duration-500 ease-in-out">
                <a href="generatedocuments.php">
                    <button id="gen_doc" onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="flex w-20 mt-1 rounded-b-full">
                        <img class="place-self-center size-10 ml-3 mb-2" src="../img/gen_doc.svg">
                        <span id="doc_title" class="hidden ml-8 z-10 p-2 border-4 border-dg rounded-full bg-lg min-w-52">Generate Documents</span>
                    </button>
                </a>
                <a href="residentpage.php">
                        <button id="res_info"  onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                            <img  class="place-self-center size-8 ml-4 mb-4 mt-2" src="../img/res_info.svg">
                            <span id="res_title" class="hidden ml-8 z-10 p-2 border-4 border-dg rounded-full bg-lg min-w-52">Resident Information</span>
                        </button>
                    </a>
                <?php
                    if (hasPermission('system_settings')){
                    ?>
                    <a href="accountmanagement.php">
                        <button id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                            <img  class="place-self-center size-8 ml-4 mb-4" src="../img/setting.svg" >
                            <span id="set_title" class="hidden ml-8 z-10 p-2 border-4 border-dg rounded-full bg-lg min-w-52">System Settings</span>
                        </button>
                    </a>
                    <?php 
                    } else {
                    ?>
                    <button disabled id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                        <img  class="place-self-center size-8 ml-4 mb-4 mt-2" src="../img/setting.svg" >
                        <span id="set_title" class="hidden ml-8 z-10 p-2 border-4 border-gray-600 rounded-full bg-gray-500 text-gray-600 min-w-52">System Settings</span>
                    </button>
                    <?php
                    }
                ?>
            </div>

            <!-- Left section: Title (Generate Documents) -->
            <div class="bg-lg w-3/5 p-4 pr-8 pl-8 mt-8 rounded-lg place-self-center">
                <h1 class="text-5xl font-bold mb-2 text-center">Generate<br>Documents</h1>
                <div class="bg-dg w-full h-10 rounded-lg"></div>
            </div>
        </div>

        <!-- Right section: List of Records -->
        <div class="relative inline-block w-2/4 place-self-center ml-56">
            <div class="bg-lg h-12 rounded-lg flex items-center justify-center p-8">
                <h1 class="text-2xl font-bold text-center">Select a document</h1>
            </div>
            <div class="bg-dg w-3/4 h-6 rounded-lg absolute right-0 top-14 -z-10"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mt-40"> <!-- Add margin-top for spacing -->
        <div class="w-full p-10 rounded-lg flex justify-center space-x-14 bg-lg">
            <div class="document-button flex flex-col items-center w-40 cursor-pointer">
                <img width="50" height="50" src="../img/clearance.svg" alt="clearance" />
                <span class="mt-2 text-sm bg-dg px-10 py-2 rounded-md text-center">Barangay <br>Clearance</span>
            </div>
            <div class="document-button flex flex-col items-center w-40 cursor-pointer">
                <img width="50" height="50" src="../img/indigency.svg" alt="indigency" />
                <span class="mt-2 text-sm bg-dg px-10 py-2 rounded-md text-center">Certificate of<br>Indigency</span>
            </div>
            <div class="document-button flex flex-col items-center w-40 cursor-pointer">
                <img width="50" height="50" src="../img/residency.svg" alt="residency" />
                <span class="mt-2 text-sm bg-dg px-10 py-2 rounded-md text-center">Certificate of<br>Residency</span>
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
