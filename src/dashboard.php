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
                <div class="h-full flex flex-col ">
                    <div class="place-content-center h-full grow-0 space-y-14 ">
                        <div>
                            <a href="dashboard.php">
                                <button id="dashboard"  onmouseover="toggleDisplay('dashboard_title', true)" onmouseleave="toggleDisplay('dashboard_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/dashboard.png ">
                                    <span id="dashboard_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Dashboard</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="residentpage.php">
                                <button id="res_info"  onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/res_info.png ">
                                    <span id="res_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Resident Information</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="generatedocuments.php">
                                <button id="gen_doc" onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/gen_doc.png">
                                    <span id="doc_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Generate Documents</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <a href="accountmanagement.php">
                                <button id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full ">
                                    <img class="size-10 hover:animate-wiggle" src="../img/setting.png"  >
                                    <span id="set_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Account Settings</span>
                                </button>
                            </a>
                            <?php 
                            } else {
                            ?>
                            <button disabled id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
                                <img  class="size-10 hover:animate-wiggle" src="../img/setting.png" >
                                <span id="set_title" class="absolute z-10 hover:scale-110 text-sm bg-c hidden">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/x.png">
                                </span>
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="place-content-center h-2/5 w-full grow">
                        <a href="backend/logout.php">
                            <img src="../img/logout.png" class="place-self-center size-12 hover:scale-125 transition duration-500" alt="">
                            <button class="flex place-self-center">Logout</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main -->
        <div class="w-full h-screen"> 
            <!-- Header -->
            <div class="shadow-md px-32 py-6">
                <div class="text-3xl">
                    Dashboard
                </div>
            </div>
            <div class="h-[90%] grid grid-cols-[auto_30rem]">
                <div class="grid grid-rows-[13rem_auto] mb-4">
                    <!-- Data -->
                    <div class="h-52 grid grid-cols-4 my-4 mx-2 ">
                        <!-- Total Residents -->
                        <div class="rounded-xl bg-c m-4">
                            <div class="flex m-6 ">
                                <img src="../img/total_res.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p>Total Residents</p>
                            </div>
                            <div class="w-auto flex flex-col items-center place-self-center text-center">
                                <p class="text-xl">2132<br></p>
                                <p class="text-xs py-4">Current number of registered residents</p>                                                           
                            </div>
                        </div>          
                        <!-- Total Documents -->
                        <div class="rounded-xl bg-c m-4">
                            <div class="flex m-6">
                                <img src="../img/indigency.svg" class="size-6 p-1 bg-white rounded-md mr-2" alt="">
                                <p>Total Documents Issued</p>
                            </div>
                            <div class="w-auto flex flex-col items-center place-self-center text-center">
                                <p class="text-xl">232<br></p>
                                <p class="text-xs py-4">Current number of documents issued</p>                                                           
                            </div>
                        </div>
                        <!-- Acitve Residents Population -->
                        <div class="rounded-xl bg-c m-4">
                            <div class="flex m-6">
                                <img src="../img/status.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p>Active Residents</p>
                            </div>
                            <div class="w-auto flex flex-col items-center place-self-center text-center">
                                <p class="text-xl">1 out of 200<br></p>
                                <p class="text-xs py-4">Current number of active residents</p>                                                           
                            </div>
                        </div>
                    </div>
                    <!-- Weekly Report -->
                    <div class="border-2 rounded-xl ml-6 mr-3 mt-6">
                        <p class="m-4">Weekly Report</p>
                    </div>
                </div>
                <div class="grid grid-rows-2 mt-4 mr-2">
                    <div class="border-2 mx-4 mt-4 mb-2 rounded-xl">
                        <p class="m-4">Residents (Gender)</p>
                    </div>
                    <div class="border-2 m-4  rounded-xl">
                        <p class="m-4">Documents (Type)</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
<script>
   
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
