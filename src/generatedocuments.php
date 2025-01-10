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
                            <a href="approvalqueue.php">
                                <button onmouseover="toggleDisplay('approval_q', true)" onmouseleave="toggleDisplay('approval_q', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/reports.png">
                                    <span id="approval_q" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Approval Queue</span>
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
                    Generate Documents
                </div>
            </div>
            <div class="grid content-center h-5/6">
                <div class=" place-items-center">
                    <p class="font-bold">Select a Document</p>
                    <p class="border-t-4 border-c w-40 text-white rounded-sm">.</p>
                </div>
                <div class="grid grid-cols-3  place-self-center gap-x-10">
                    <!-- Barangay Clearance -->
                    <div>
                        <div class="border-2 border-sg rounded-t-xl bg-c h-32 w-48 flex justify-center items-center">
                            <div>
                                <button class="cursor-default">
                                <img class='place-self-center size-14' src='../img/dashboard.png'>
                                    Barangay Clearance
                                </button>
                            </div>
                        </div>
                        <a href="documents/brgyclearance.php">
                            <div class="border-x-2 border-b-2 border-sg rounded-b-xl h-12 w-48 flex justify-center items-center bg-sg hover:text-white active:bg-sg transition duration-700 cursor-pointer ">
                                <button>
                                    Generate
                                </button>
                            </div>
                        </a>
                    </div>
                    <!-- Certificate of Residency -->
                    <div>
                        <div class="border-2 border-sg rounded-t-xl bg-c h-32 w-48 flex justify-center items-center">
                            <div>
                                <button class="cursor-default">
                                <img class='place-self-center size-14' src='../img/dashboard.png'>
                                    Cerificate of Residency
                                </button>
                            </div>
                        </div>
                        <a href="documents/certresidency.php">
                            <div class="border-x-2 border-b-2 border-sg rounded-b-xl h-12 w-48 flex justify-center items-center bg-sg hover:text-white active:bg-sg transition duration-700 cursor-pointer ">
                                <button>
                                    Generate
                                </button>
                            </div>
                        </a>
                    </div>
                    <!-- Dashboard -->
                    <div>
                        <div class="border-2 border-sg rounded-t-xl bg-c h-32 w-48 flex justify-center items-center">
                            <div>
                                <button class="cursor-default">
                                <img class='place-self-center size-14' src='../img/dashboard.png'>
                                   Certificate of Indigency
                                </button>
                            </div>
                        </div>
                        <a href="documents/certindigency.php">
                            <div class="border-x-2 border-b-2 border-sg rounded-b-xl h-12 w-48 flex justify-center items-center bg-sg hover:text-white active:bg-sg transition duration-700 cursor-pointer ">
                                <button>
                                    Generate
                                </button>
                            </div>
                        </a>
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
