<?php
session_start();
include("backend/connection.php");
require("backend/helper.php");

$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative"> <!--bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]-->
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
                            <img class="size-10 my-2" src="../img/setting.svg"  >
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
        <div class="grow w-4/5 h-full">
            <!-- Header -->
            <div class="grid gap-x-10 grid-cols-2 shadow-md h-20 px-32 py-6 mb-20 ">
                <div class="text-3xl">
                    Resident Page
                </div>
                <!-- Search, Add New Button, Bulk Import -->
                <div class="flex justify-end items-center space-x-4">
                    <!-- Search -->
                    <div class="relative">
                        <form method="post">
                            <input name="search" id="search" type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none focus:ring-2 ring-sg h-8" >
                            <button id="searchBtn" class="rounded-md absolute right-0 top-1/2 transform -translate-y-1/2 bg-white border border-l-0 border-gray-300 p-2 h-full flex items-center justify-center pointer-events-none">
                                <img class="w-4 h-4" src="../img/search.svg" alt="Search Icon"/>
                            </button>
                        </form>
                    </div>
                    <?php 
                    if(hasPermission('system_settings')) {
                    ?>
                        <!-- Add Record -->
                        <div>
                            <a href="backend/add.php"><button class="bg-c text-black py-1 px-3 duration-500 hover:bg-sg focus:outline-none rounded-sm">Add Record</button></a>
                        </div>
                        <!--Bulk Import-->
                        <div>
                            <form id="formUpload"  class="flex items-center">
                                <div>
                                    <button id="btnUpload" name="btnUpload" class="py-1 px-3 bg-gray-400 text-gray-600 focus:outline-none rounded-sm" disabled>Bulk Import</button>
                                </div>
                                <label for="file_input">
                                    <img id="file_output" class="size-10 cursor-pointer hover:animate-wiggle" src="../img/gen_doc.svg">
                                    <input type="file" id="file_input" name="file" accept="csv/*" class="hidden"></input>
                                </label>
                            </form>
                            <div id="msgUpload"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Options -->
            <div class="flex justify-between items-center">
                <!-- Categories -->
                <div class="ml-32">
                    <ul class="flex justify-start items-center space-x-4 ">
                        <li onclick="showCategory('tb1','option1')"><button id="option1" class="border-b-4 border-sg text-black py-1 px-3 hover:border-sg rounded-sm">Personal Information</button></li>
                        <li onclick="showCategory('tb2','option2')"><button id="option2" class="border-b-4 border-c text-black py-1 px-3 hover:border-sg rounded-sm">Birth Details</button></li>
                        <li onclick="showCategory('tb3','option3')"><button id="option3" class="border-b-4 border-c text-black py-1 px-3 hover:border-sg rounded-sm">Contact Information</button></li>
                        <li onclick="showCategory('tb4','option4')"><button id="option4" class="border-b-4 border-c text-black py-1 px-3 hover:border-sg rounded-sm">Address Details</button></li>
                        <li onclick="showCategory('tb5','option5')"><button id="option5" class="border-b-4 border-c text-black py-1 px-3 hover:border-sg rounded-sm">Citizenship and Civil Status</button></li>
                        <li onclick="showCategory('tb6','option6')"><button id="option6" class="border-b-4 border-c text-black py-1 px-3 hover:border-sg rounded-sm">Residency and Occupation</button></li>
                        <li onclick="showCategory('tb7','option7')"><button id="option7" class="border-b-4 border-c text-black py-1 px-3 hover:border-sg rounded-sm">Health</button></li>
                    </ul>
                        
                </div>
                        
            </div>
            <!-- Tables -->
            <div class="overflow-hidden mt-4 w-full">
                <div class="border-2 border-c rounded-lg mx-32">
                <!--Personal Information Table -->
                <div id="tb1" class="overflow-auto no-scrollbar"  style="height: 67vh;">
                    <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse">
                        <colgroup>
                            <col class="w-[200px]">
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
                                <th class="py-4 min-w-20">ID</th>
                                <th class="py-4">First Name</th>
                                <th class="py-4">Middle Name</th>
                                <th class="py-4">Last Name</th>
                                <th class="py-4">Suffix</th>
                                <th class="py-4">Gender</th>
                                <th class="py-4">Age</th>

                                <th class="min-w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class=" border-y-2 border-c py-4">
                                <div class="flex justify-center  min-w-20">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['first_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['middle_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['suffix']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['gender']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['age']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <a href="backend/edit.php?id=<?= $row['id']?>">
                                        <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                            <img src="../img/edit.svg" alt="edit"/>
                                            </button>
                                    </a>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <!--Birth Details Table -->
                <div  id="tb2" class="overflow-auto no-scrollbar hidden" style="height: 67vh;">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse ">
                        <colgroup>
                            <col class="w-[200px]">
                            <col>
                            <col>
                            <col>
                            <col>
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class=" bg-c sticky top-0">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="py-4 min-w-20">ID</th>
                                <th class="py-4 text-sg">Full Name</th>                            
                                <th class="py-4">Date of Birth</th>
                                <th class="py-4">Place of Birth Municipality/City</th>
                                <th class="py-4">Place of Birth Province</th>
                                <th class="py-4 min-w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border-y-2 border-c py-4">
                                <div class="flex justify-center min-w-20">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c text-sg">
                                <div class="flex justify-center ">
                                    <?=$row['first_name']?>
                                    <?=$row['middle_name']?>
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['birth_date']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['birthplace_municipality_city']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['birthplace_province']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="backend/edit.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <!--Contact Information Table -->
                <div id="tb3" class="overflow-auto no-scrollbar hidden" style="height: 67vh;">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse">
                        <colgroup>
                            <col class="w-[200px]">
                            <col >
                            <col >
                            <col >
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class=" bg-c sticky top-0">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="py-4 min-w-20">ID</th>
                                <th class="py-4  text-sg">Full Name</th>                            
                                <th class="py-4">Contact Information</th>
                                <th class="py-4">Email Address</th>
                                <th class="py-4 min-w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border-y-2 border-c py-4">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c text-sg">
                                <div class="flex justify-center ">
                                    <?=$row['first_name']?>
                                    <?=$row['middle_name']?>
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['contact_num']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['email_address']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="backend/edit.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <!--Address Table -->
                <div id="tb4" class="overflow-auto no-scrollbar hidden" style="height: 67vh;">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse ">
                        <colgroup>
                            <col class="w-[200px]">
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class=" bg-c sticky top-0">
                            <tr class="uppercase">
                                <!--Basic Information + Action-->
                                <th class="py-4 min-w-20 ">ID</th>
                                <th class="py-4  text-sg">Full Name</th>                            
                                <th class="py-4">House Number</th>
                                <th class="py-4">Street Name</th>
                                <th class="py-4">Barangay Name</th>
                                <th class="py-4">Municipality/City</th>                            
                                <th class="py-4">Province</th>
                                <th class="py-4">Zip Code</th>
                                <th class="py-4 min-w-24">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border-y-2 border-c py-4">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c text-sg">
                                <div class="flex justify-center ">
                                    <?=$row['first_name']?>
                                    <?=$row['middle_name']?>
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['house_num']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['street_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['barangay_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['municipality_city']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['province']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['zip_code']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="backend/edit.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                </div>         
                <!--Civil Status & Citizenship Table -->
                <div id="tb5" class="overflow-auto no-scrollbar hidden" style="height: 67vh;">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse ">
                        <colgroup>
                            <col class="w-[200px]">
                            <col >
                            <col >
                            <col >
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class=" bg-c sticky top-0">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="py-4 min-w-20">ID</th>
                                <th class="py-4  text-sg">Full Name</th>                            
                                <th class="py-4">Civil Status</th>
                                <th class="py-4">Citizenship</th>

                                <th class="py-4 min-w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border-y-2 border-c py-4">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c text-sg">
                                <div class="flex justify-center">
                                    <?=$row['first_name']?>
                                    <?=$row['middle_name']?>
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['civil_status']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['citizenship']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="backend/edit.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <!--Residentcy & Occupation Table -->
                <div id="tb6" class="overflow-auto no-scrollbar hidden" style="height: 67vh;">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse ">
                        <colgroup>
                            <col class="w-[200px]">
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class=" bg-c sticky top-0">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="py-4 min-w-20">ID</th>
                                <th class="py-4  text-sg">Full Name</th>                            
                                <th class="py-4">Occupation</th>
                                <th class="py-4">Type Of Residency</th>
                                <th class="py-4">Start Date of Residency</th>
                                <th class="py-4">End Date of Residency</th>
                                <th class="py-4 min-w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border-y-2 border-c py-4">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c text-sg">
                                <div class="flex justify-center">
                                    <?=$row['first_name']?>
                                    <?=$row['middle_name']?>
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['occupation']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['residency_type']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['start_residency']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['end_residency']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="backend/edit.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <!--Health Table -->
                <div id="tb7" class="overflow-auto no-scrollbar hidden" style="height: 67vh;">
                <div class="rounded-t-sm pt-2 bg-c ">
                    <table id="residentTable" class="w-full border-collapse ">
                        <colgroup>
                            <col class="w-[200px]">
                            <col >
                            <col >
                            <col >
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class=" bg-c sticky top-0">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="py-4 min-w-20">ID</th>
                                <th class="py-4  text-sg">Full Name</th>                            
                                <th class="py-4">Blood Type</th>
                                <th class="py-4">Religion</th>
                                <th class="py-4 min-w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border-y-2 border-c py-4">
                                <div class="flex justify-center">
                                    <?= $i ?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c text-sg">
                                <div class="flex justify-center">
                                    <?=$row['first_name']?>
                                    <?=$row['middle_name']?>
                                    <?=$row['last_name']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center" >
                                    <?=$row['blood_type']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center">
                                    <?=$row['religion']?>
                                </div>
                            </td>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                        <a href="backend/edit.php?id=<?= $row['id']?>">
                                            <img src="../img/edit.svg" alt="edit"/>
                                        </a>
                                    </button>
                                    <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                        <img name="delete" src="../img/trash.svg" alt="delete"/>
                                    </button>
                                    <button  class="w-6 ml-3 cursor-pointer" onclick="window.location.href='backend/viewDetails.php?id=<?= $row['id'] ?>'">
                                        <img name="view_details" src="../img/view.png" alt="delete"/>
                                    </button>
                                </div>
                            </td>
                            <?php
                            } else {
                            ?>
                            <td class="border-y-2 border-c py-2">
                                <div class="flex justify-center items-center">
                                    <button disabled class="w-6 mr-1"> 
                                        <img src="../img/lock.png" alt="edit"/>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <div class=" h-6 rounded-b-sm border-2 border-c bg-c"></div>
                </div>
            </div>
        </div>
        <!--Delete Confirmation -->
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
        <!-- View Details -->
        <div class="fixed z-50 hidden" id="viewDetails">
            <div class="border-4 w-screen h-screen flex justify-end items-center">
                <div class="absolute bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                <div class="relative grid h-screen overflow-auto rounded-l-xl bg-white z-10" style="width:60vh">
                    <div class="pl-6 pt-2 flex items-center">
                        <button onclick="cancelView()"><img src="../img/back.png" class="size-4"></button>
                    </div>
                    <div class="px-8" style="height:90vh;">
                        <?php 
                        $query = "SELECT * FROM `resident_info` WHERE `id` = :id";
                        $stmt = $dbh->prepare($query);
                        $stmt->execute(['id' => $_GET['id']]);
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="grid gap-2 text-gray-400 ">
                            <!--Personal Info Summary -->
                            <div class="grid-cols-2">
                                <p class="text-xl">Personal Information</p>
                                <!-- First Name -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>First Name</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['first_name']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Middle Name -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Middle Name</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['middle_name']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Last Name</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['last_name']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Suffix -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Suffix</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['suffix']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Gender -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Gender</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['gender']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Age -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Age</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['age']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Birth Details -->
                            <div class="grid-cols-2">
                            <p class="text-xl">Birth Details</p>
                                <!-- Birth Date-->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Date of Birth</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['birth_date']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Birthplace Municipality City -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Birthplace Municipality City</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['birthplace_municipality_city']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Birthplace Province -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Birthplace Province</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['birthplace_province']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Contact Number -->
                            <div class="grid-cols-2">
                            <p class="text-xl">Contact Number</p>
                                <!-- Birthplace Province -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Contact Number</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['contact_num']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Email Address -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Email Address</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['email_address']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Address Details -->
                            <div class="grid-cols-2">
                            <p class="text-xl">Address Details</p>
                                <!-- Birthplace Province -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>House Number</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['house_num']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Email Address -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Street Name</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['street_name']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Barnangay Name -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Barangay Name</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['barangay_name']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Municipality/City -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Municipality/City</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['municipality_city']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Province -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Province</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['province']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Zip Code -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Zip Code</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['zip_code']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Citizenship and Civil Status -->
                            <div class="grid-cols-2">
                            <p class="text-xl">Citizenship and Civil Status</p>
                                <!-- Civil Status -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Civil Status</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['civil_status']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Citizenship -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Citizenship</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['citizenship']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Residency and Occupation -->
                            <div class="grid-cols-2">
                            <p class="text-xl">Residency and Occupation</p>
                                <!-- Occupation -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Occupation</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['occupation']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Type of Residency -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Type of Residency</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['residency_type']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Start of Residency -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Start of Residency</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['start_residency']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End of Residency -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Start of Residency</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['end_residency']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Health -->
                            <div class="grid-cols-2">
                            <p class="text-xl">Residency and Occupation</p>
                                <!-- Bloodtype -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Blood Type</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['blood_type']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Religion -->
                                <div class="flex">
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li>Blood Type</li>
                                        </ul>
                                    </div>
                                    <div class="w-6/12 ">
                                        <ul class="ml-6"> 
                                            <li><?=$row['religion']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    //confirm deletion
    function confirmDeletion(id) {
        document.getElementById("confirmDeletion").classList.remove("hidden");
        document.getElementById("deleteLink").href =' backend/delete.php?id=' + id;
    }
    function cancelConfirmation() {
        document.getElementById("confirmDeletion").classList.add("hidden");
    }

    //veiw details
    function viewDetails() {
        document.getElementById("viewDetails").classList.remove("hidden");
        
    }
    window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('showModal') && urlParams.get('showModal') === '1') {
        viewDetails();

        window.history.replaceState({}, document.title, window.location.pathname);
        }
    };
    function cancelView() {
        document.getElementById("viewDetails").classList.add("hidden");
    }

    //toggle display
    function toggleDisplay(elementID, show) {
        const element = document.getElementById(elementID);
        element.style.display = show ? "block" : "none";
    }
    function showCategory(categoryID, option){
        const tables = ["tb1", "tb2", "tb3", "tb4", "tb5", "tb6", "tb7"];
        tables.forEach(id => {
            document.getElementById(id).classList.toggle("hidden", id !== categoryID);
        });
        const options = ["option1", "option2", "option3", "option4", "option5", "option6", "option7"];
        options.forEach(border => {
            const button = document.getElementById(border);
            button.classList.toggle("border-sg", option === border);
            button.classList.toggle("border-c", option !== border);
        });
    }
</script>
<script>
    //search funcitonality
    $(document).ready(function() {
        $('#search').keyup(function(event) {
            search_table($(this).val());
        });
        function search_table(value) {
            $('#residentTable tbody tr').each(function(){
                let found = 'false';
                $(this).each(function(){
                    if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0){
                        found = 'true';
                    }
                });
                if(found=='true'){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
</script>
<script>
    const fileInput = document.querySelector("#file_input");
    const fileOutput = document.querySelector("#file_output");

    let file = "";

    fileInput.addEventListener("change", function(){
        file = this.files[0];
        displayFile();
    });
    //change the display file to csv icon
    const displayFile = () => {
        let fileReader = new FileReader();
        let fileType = file.type;
        if (fileType === "text/csv"){
            fileReader.onload=()=>{
                let fileAddress = fileReader.result;
                fileOutput.src=fileAddress;
                fileOutput.src="../img/prevcsv.png";
                document.querySelector("#btnUpload").removeAttribute("disabled");
                document.querySelector("#btnUpload").classList.remove("bg-gray-400");
                document.querySelector("#btnUpload").classList.add("bg-c");
                document.querySelector("#btnUpload").classList.add("hover:bg-sg");
                document.querySelector("#btnUpload").classList.remove("text-gray-600");
            };
        } else {
            fileOutput.src="../img/lock.png";
            document.querySelector("#btnUpload").setAttribute("disabled", "true"); 
            document.querySelector("#btnUpload").classList.add("w-26");
            document.querySelector("#btnUpload").classList.add("h-8");
            document.querySelector("#btnUpload").classList.remove("px-3");
            document.querySelector("#btnUpload").textContent = "That's not csv.";
            document.querySelector("#btnUpload").classList.add("bg-gray-400");
            document.querySelector("#btnUpload").classList.add("text-sm");
            document.querySelector("#btnUpload").classList.remove("bg-c");
            document.querySelector("#btnUpload").classList.remove("hover:bg-sg");
            document.querySelector("#btnUpload").classList.add("text-gray-600");
        } 
        fileReader.readAsDataURL(file);
    };
    //upload csv file
    $(function (){
        $('#formUpload').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let csv = new FormData(form[0]);
            $('.msgUpload').show(2).html('<center><img src=../img/loader.gif width=60px/> <br>Uploading Data. Please wait...</center>');
            $('.btnUpload').hide(2);
            $.ajax({
                url: "backend/upload.php",
                type: 'POST',
                contentType: false,
                processData: false,
                data: csv,
                success: function(data) {
                    console.log(data);
                    $('#msgUpload').html(data);
                    $('#btnUpload').hide(2);
                }
            }); 
        });
    });
</script>
</body>
</html>