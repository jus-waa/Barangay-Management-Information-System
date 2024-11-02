<?php
session_start();
include("backend/connection.php");
$stmt = $dbh->prepare("SELECT * FROM `users`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
</head>
<body class="relative">
    <!-- Header -->
    <div class="absolute w-full h-full">
        <div class="grid grid-cols-2 items-center -z-20">
            <div class="flex flex-row items-start">
                <!--Nav-->
                <div id="mainNav" onmouseover="hoverNav()" onmouseleave="leaveNav()" class="flex flex-col mr-16 rounded-b-full h-14 w-16 bg-c duration-500 ease-in-out">
                    <a href="accountmanagement.php">
                        <button id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="w-20 mt-2 rounded-b-full flex">
                            <img  class="place-self-center size-8 ml-4 mb-4" src="../img/setting.svg" >
                            <span id="set_title" class="hidden ml-8 z-10 p-2 border-4 border-sg rounded-full bg-c min-w-52">System Settings</span>
                        </button>
                    </a>
                    <a href="generatedocuments.php">
                        <button id="gen_doc" onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="w-20 opacity-0 mt-1 rounded-b-full flex">
                            <img  class="place-self-center size-10 ml-3 mb-2 mt-1" src="../img/gen_doc.svg">
                            <span id="doc_title" class="hidden ml-8 z-10 p-2 border-4 border-sg rounded-full bg-c min-w-52">Generate Documents</span>
                        </button>
                    </a>
                    <a href="residentpage.php">
                        <button id="res_info"  onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                            <img  class="place-self-center size-8 ml-4 mb-4 mt-2" src="../img/res_info.svg">
                            <span id="res_title" class="hidden ml-8 z-10 p-2 border-4 border-sg rounded-full bg-c min-w-52">Resident Information</span>
                        </button>
                    </a>
            </div>

                <!-- Title Section -->
                <div class="bg-c w-3/5 p-4 px-8 mt-6 rounded-lg place-self-center">
                    <h1 class="text-5xl font-bold mb-2 text-center">
                        Account<br>Management
                    </h1>
                    <div class="bg-sg w-full h-10 rounded-lg"></div>
                </div>
            </div>

            <!-- Accounts List -->
            <div class="relative inline-block w-2/4 place-self-center ml-24 ll:ml-56 -z-20">
                <div class="bg-c h-12 rounded-lg flex items-center justify-center p-8">
                    <h1 class="text-2xl font-bold text-center">List of accounts</h1>
                </div>
                <div class="bg-sg w-3/4 h-6 rounded-lg absolute right-0 top-14 -z-10"></div>
            </div>
        </div>

        <!-- Regular Section -->
        <div class="flex justify-between items-end mx-32 mt-16">
            <div class="bg-c text-black py-2 px-14 rounded-xl font-bold text-3xl min-w-[200px] text-center">Regular</div>
            <a href="signuppage.php"><button class="bg-c text-black py-1 px-3 hover:bg-sg focus:outline-none rounded-sm focus:ring-4 ring-dg">Add Record</button></a>
        </div>

        <!-- Regular Account Table -->
        <div class="w-screen overflow-hidden mt-4">
            <div class="border-2 border-c rounded-lg mx-32">
                <!--Regular-->
                <div id="tb1" class="overflow-auto no-scrollbar ">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse">
                        <colgroup>
                            <col class="w-[100px]">
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class="bg-c sticky top-0 ">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="w-12">ID</th>
                                <th class="">Username</th>
                                <th class="w-56">Email</th>
                                <th class="w-72">Password</th>
                                <th class="w-72">Verify Password</th>
                                <th class="w-32">Contact Information</th>
                                <th class="">Date Created</th>
                                <th class="">Date Updated</th>
                                <th class="w-36">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                            if ($row['role_id'] == 2) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class=" border-y-2 border-c w-12">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
                                    <?=$row['username']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center overflow-auto w-56" >
                                    <?=$row['email']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-start overflow-auto w-64">
                                    <?=$row['password']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-start overflow-auto w-64">
                                    <?=$row['password_re']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center overflow-auto w-32">
                                    <?=$row['contact_info']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
                                    <?=$row['created_at']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
                                    <?=$row['updated_at']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c w-36">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="updateaccount.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <div class=" h-6 rounded-b-sm border-2 border-c bg-c"></div>
            </div>
        </div>

        <!-- Admin Section -->
        <div class="flex justify-between items-end mx-32 mt-16">
            <div class="bg-c text-black py-2 px-16 rounded-xl font-bold text-3xl min-w-[200px] text-center">Admin</div>
            <!-- <a href="signuppage.php"><button class="bg-c text-black py-1 px-3 hover:bg-sg focus:outline-none rounded-sm focus:ring-4 ring-dg">Add Record</button></a> -->
        </div>

        <!-- Admin Table -->
        <div class="w-screen overflow-hidden mt-4">
            <div class="border-2 border-c rounded-lg mx-32">
                <!--Regular-->
                <div id="tb1" class="overflow-auto no-scrollbar ">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse">
                        <colgroup>
                            <col class="w-[100px]">
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class="bg-c sticky top-0 ">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="w-12">ID</th>
                                <th class="">Username</th>
                                <th class="w-56">Email</th>
                                <th class="w-72">Password</th>
                                <th class="w-72">Verify Password</th>
                                <th class="w-32">Contact Information</th>
                                <th class="">Date Created</th>
                                <th class="">Date Updated</th>
                                <th class="w-36">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                            if ($row['role_id'] == 1) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class=" border-y-2 border-c w-12">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
                                    <?=$row['username']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center overflow-auto w-56" >
                                    <?=$row['email']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-start overflow-auto w-64">
                                    <?=$row['password']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-start overflow-auto w-64">
                                    <?=$row['password_re']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center overflow-auto w-32">
                                    <?=$row['contact_info']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
                                    <?=$row['created_at']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
                                    <?=$row['updated_at']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c w-36">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="updateaccount.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <div class=" h-6 rounded-b-sm border-2 border-c bg-c"></div>
            </div>
        </div>
    </div>
    <!--Confirm Deletion-->
    <div class="fixed z-50 hidden" id="confirmDeletion">
        <div class="border-4 w-screen h-screen flex justify-center items-center">
            <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
            <div class="relative grid grid-cols-1 grid-rows-2 h-72 w-96 overflow-auto rounded-md bg-white z-10">
                <div class="grid justify-center">
                    <div class="text-3xl font-bold place-self-center mt-12">Confirm Deletion</div>
                    <div class="mb-24 mt-4">Are you sure you want to delete this record?</div>
                </div>
                <div class="flex justify-center space-x-4 mt-6">
                    <a id="deleteLink" href="#">
                        <button class="bg-sg rounded-md w-32 h-12">
                            Yes, Delete  
                        </button>
                    </a>
                    <button class="bg-sg rounded-md w-32 h-12" onclick="cancelConfirmation()">No</button>
                </div>
            </div>
        </div>
    </div>
<script>
    //hover on nav 
    function hoverNav() {
        let generate = document.getElementById("gen_doc");
        let resident = document.getElementById("res_info");
        let mainNav = document.getElementById("mainNav");
        mainNav.style.height = "11rem";
        generate.style.opacity = "1";
        resident.style.opacity = "1";
    }
    function leaveNav() {
        let generate = document.getElementById("gen_doc");
        let resident = document.getElementById("res_info");
        let mainNav = document.getElementById("mainNav");

        mainNav.style.height = "3.5rem";
        generate.style.opacity = "0";
        resident.style.opacity = "0";
    }
    function confirmDeletion(id) {
        document.getElementById("confirmDeletion").classList.remove("hidden");
        document.getElementById("deleteLink").href =' backend/delete_account.php?id=' + id;
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
