<?php

include("backend/connection.php");
include("backend/pagination.php");
require("backend/helper.php");
//for timer
if(hasPermission('system_settings')){
    include("backend/session_timer.php");
} 
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
    <script src="clock.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="relative"> 
    <div class="flex h-screen w-screen overflow-auto">
        <!-- Sidebar -->
        <div class="flex-none w-14 std:w-20 h-full shadow-2xl">
            <!--Nav-->
            <div id="mainNav" class="flex flex-col place-content-start h-full w-full bg-c duration-500 ease-in-out">
                <div class="h-full flex flex-col ">
                    <!-- Menu -->
                    <div class="flex flex-col justify-between place-content-center h-full grow-0">
                        <div class="m-3 mt-5 std:mt-4">
                            <img src="../img/buna_cerca.png" alt="">
                        </div>
                        <div class="place-content-center my-16 std:my-20 space-y-10 std:space-y-14 ">
                            <div>
                                <a href="dashboard.php">
                                    <button id="dashboard"  onmouseover="toggleDisplay('dashboard_title', true)" onmouseleave="toggleDisplay('dashboard_title', false)" class="flex place-content-center w-full">
                                        <img  class="size-8 std:size-10 hover:animate-wiggle"  src="../img/dashboard.png ">
                                        <span id="dashboard_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Dashboard</span>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <a href="residentpage.php">
                                    <button id="res_info"  onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="flex place-content-center w-full">
                                        <img  class="size-8 std:size-10 hover:animate-wiggle"  src="../img/res_info.png ">
                                        <span id="res_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Resident Information</span>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <a href="generatedocuments.php">
                                    <button id="gen_doc" onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="flex place-content-center w-full">
                                        <img  class="size-8 std:size-10 hover:animate-wiggle"  src="../img/gen_doc.png">
                                        <span id="doc_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Generate Documents</span>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <a href="printhistory.php">
                                    <button onmouseover="toggleDisplay('print_history', true)" onmouseleave="toggleDisplay('print_history', false)" class="flex place-content-center w-full">
                                        <img  class="size-8 std:size-10 hover:animate-wiggle"  src="../img/reports.png">
                                        <span id="print_history" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Print History</span>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <?php
                                if (hasPermission('system_settings')){
                                ?>
                                <a href="accountmanagement.php">
                                    <button id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full ">
                                        <img class="size-8 std:size-10 hover:animate-wiggle"  src="../img/setting.png"  >
                                        <span id="set_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Account Settings</span>
                                    </button>
                                </a>
                                <?php 
                                } else {
                                ?>
                                <button disabled id="setting" onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-8 std:size-10 hover:animate-wiggle"  src="../img/setting.png" >
                                    <span id="set_title" class="absolute z-10 hover:scale-110 text-sm bg-c hidden">
                                        <img  class="size-10 hover:animate-wiggle" src="../img/x.png">
                                    </span>
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Account and Logout -->
                    <div class="flex flex-col justify-center space-y-4 h-2/5 w-full grow text-xs std:text-base">
                        <!-- Account -->
                        <div>
                            <button onmouseover="toggleDisplay('account', true)" onmouseleave="toggleDisplay('account', false)" class="flex place-content-center w-full">
                                <img class="size-8 std:size-10 hover:animate-wiggle"  src="../img/account.png">
                                <span id="account" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">
                                    <?php
                                        $userId = $_SESSION['users'];
                                        $query = 'SELECT * FROM users WHERE id = :id';  // Query with a condition to select the logged-in user
                                        $stmt = $dbh->prepare($query);
                                        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);  // Bind the user ID parameter
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        if ($result) {
                                            echo $result['username'];
                                        }   else {
                                            echo "No such user found.";
                                        }
                                    ?>
                                </span>
                            </button>
                            <button class="flex place-self-center text-left">
                                <?php
                                    $userId = $_SESSION['users'];
                                    $query = 'SELECT * FROM users WHERE id = :id';  // Query with a condition to select the logged-in user
                                    $stmt = $dbh->prepare($query);
                                    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);  // Bind the user ID parameter
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($result) {
                                        $email = $result['email'];
                                        //break every 10 let
                                        $formatEmail = wordwrap($email, 10, "<br/>", true);
                                        echo $formatEmail;
                                    }   else {
                                        echo "No such user found.";
                                    }
                                ?>
                            </button>
                        </div>
                        <!-- Logout -->
                        <div class="flex place-content-center w-full">
                            <a href="backend/logout.php">
                                <img src="../img/logout.png"  class="place-self-center size-10 std:size-12 std:hover:scale-125 transition duration-500" alt="">
                                <p class="flex place-self-center">Logout</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main -->
        <div class="flex flex-col w-screen h-screen">
            <!-- Header -->
            <div class="grid grid-cols-2 items-center shadow-md px-8 py-2 std:py-2 bg-white">
                <div class="text-xl std:text-3xl ">
                    <b>Barangay Buna Cerca</b>
                    <br>
                    <div class="flex items-center">
                        <p class="text-[16px] std:text-[20px] italic">Resident Information</p>
                        <?php if(hasPermission('system_settings')) : ?>
                            <p class="text-[12px] std:text-[16px] italic transform translate-y-0 std:translate-y-[0.5px] translate-x-4" id="timer">Session expires in: </p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="justify-items-end text-sm std:text-base">
                    <b>Philippine Standard Time: </b><br>
                    <p class="italic" id="liveClock"></p>
                </div>
            </div>
            <!-- Body -->
            <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../img/bunacerca-bg.png'); filter: blur(5px); z-index: -1;"></div>
            <div class="flex flex-col h-full grow">
                <!-- Note -->
                <div id="uploadMsg" class="h-14 my-2 mx-4 std:my-4 std:mx-8 text-white ">
                    <?php
                    //displays message
                    if(isset($_GET['msg'])) {
                        $msg = $_GET['msg'];
                        echo '
                            <div id="notif-del" class="grid grid-cols-2 items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100">
                                <p>'. $msg .'</p>
                                <img src="../img/notif-del.png" alt="X" class="justify-self-end cursor-pointer" onclick="notifDel();">
                            </div>
                            ';
                    } else {
                        echo '
                            <div class="grid grid-cols-2 items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-0">
                                <p></p>
                            </div>
                            ';
                    }
                    ?>
                </div>
                <!-- Options -->
                <div class="grid grid-cols-[auto_1fr] items-center mr-4 std:mr-0">
                    <!-- Categories -->
                    <div class="ml-8 text-black ">
                        <ul class="flex justify-start items-center space-x-4 ">
                            <li onclick="showCategory('tb1','option1')"><button id="option1" class="border-b-4 border-sg py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Personal Information</button></li>
                            <li onclick="showCategory('tb2','option2')"><button id="option2" class="border-b-4 border-c  py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Birth Details</button></li>
                            <li onclick="showCategory('tb3','option3')"><button id="option3" class="border-b-4 border-c  py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Contact Information</button></li>
                            <li onclick="showCategory('tb4','option4')"><button id="option4" class="border-b-4 border-c  py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Address Details</button></li>
                            <li onclick="showCategory('tb5','option5')"><button id="option5" class="border-b-4 border-c  py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Citizenship and Civil Status</button></li>
                            <li onclick="showCategory('tb6','option6')"><button id="option6" class="border-b-4 border-c  py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Residency and Occupation</button></li>
                            <li onclick="showCategory('tb7','option7')"><button id="option7" class="border-b-4 border-c  py-3.5 std:py-1 px-3 hover:border-sg rounded-sm text-sm std:text-base">Health</button></li>
                        </ul>
                    </div>
                    <!-- Search -->
                    <div class="flex justify-start std:justify-end items-center space-x-2 std:space-x-4 mr-4 std:mr-6">
                        <div class="relative">
                            <form method="GET" class="flex justify-end items-center">
                                <input name="search" id="search" type="text" placeholder="Search..." value="<?=$search?>" class="border border-gray-300 rounded-md p-2 w-60 h-8 focus:outline-none focus:ring-2 ring-sg  z-10  transform translate-x-8" >
                                <button type="submit" id="searchBtn" class=" bg-white  rounded-md p-2 focus:outline-none focus:ring-2 ring-sg h-7 flex items-center justify-center z-20">
                                    <img class="w-4" src="../img/search.svg" alt="Search Icon"/>
                                </button>
                            </form>
                        </div>
                        <?php 
                        if(hasPermission('system_settings')) {
                        ?>
                            <!-- Add Record -->
                            <div>
                                <a href="backend/add.php"><button class="rounded-md border-c bg-c py-1.5 std:py-1 std:px-3 w-20 std:w-full place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300 text-sm std:text-base">Add Record</button></a>
                            </div>
                            <!--Bulk Import-->
                            <div>
                                <form id="formUpload"  class="flex items-center">
                                    <div>
                                        <button id="btnUpload" name="btnUpload" type="submit" class="rounded-md py-1.5 std:py-1 std:px-3 w-20 std:w-full text-sm std:text-base bg-gray-400 text-gray-600 focus:outline-none" disabled>Bulk Import</button>
                                    </div>
                                    <label for="file_input">
                                        <img id="file_output" class="mr-8 std:mr-0 size-8 cursor-pointer hover:animate-wiggle" src="../img/document.png">
                                        <input type="file" id="file_input" name="file" accept="csv/*" class="hidden"></input>
                                    </label>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- Tables -->
                <?php if ($searchResult) { ?>
                <div class=" mt-4 w-full ">
                    <div class="border-2 border-c rounded-lg mx-8 bg-white">
                        <!--Personal Information Table -->
                        <div id="tb1" class=" ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col>
                                        <col>
                                        <col>
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class="bg-c sticky top-0 font-bold text-sm std:text-base">
                                        <tr class="uppercase">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 std:py-4 min-w-20">ID</th>
                                            <th class="py-2 std:py-4">First Name</th>
                                            <th class="py-2 std:py-4">Middle Name</th>
                                            <th class="py-2 std:py-4">Last Name</th>
                                            <th class="py-2 std:py-4">Suffix</th>
                                            <th class="py-2 std:py-4">Gender</th>
                                            <th class="py-2 std:py-4">Age</th>
                            
                                            <th class="min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white">
                                    <?php 
                                    $male = 0;
                                    $female = 0;
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100 text-sm std:text-base text-center">
                                        <td class=" border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center  min-w-20">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
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
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center items-center">
                                                <a href="backend/edit.php?id=<?= $row['id']?>">
                                                    <button class="w-6 mr-1 cursor-pointer flex justify-center items-center" name="id" id="editBtn"> 
                                                    <img src="../img/edit.svg" alt="edit"/>
                                                    </button>
                                                </a>
                                                <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                                    <img name="delete" src="../img/trash.svg" alt="delete"/>
                                                </button>
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Birth Details Table -->
                        <div  id="tb2" class="hidden ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse ">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[300px] std:w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[300px]">
                                        <col class="w-[300px]">
                                        <col class="w-[250px]">
                                        <col class="w-[250px]">
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class=" bg-c sticky top-0 text-sm font-bold std:text-base">
                                        <tr class="uppercase ">
                                            <!--Basic Information + Action-->
                                            <th class="py-1 std:py-4">ID</th>
                                            <th class="py-1 std:py-4 text-sg">Full Name</th>                            
                                            <th class="py-1 std:py-4">Date of Birth</th>
                                            <th class="text-xs std:text-base">Place of Birth Municipality/City</th>
                                            <th>Place of Birth Province</th>
                                            <th class="py-1 std:py-4">Father's Name</th>                            
                                            <th class="py-1 std:py-4 text-xs std:text-base">Mother's Maiden Name</th>
                                            <th class="py-1 std:py-4 min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white">
                                    <?php 
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10;
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100 text-sm std:text-base text-center">
                                        <td class="border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center min-w-20">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c text-sg py-2 std:py-2">
                                            <div class="flex justify-center ">
                                                <?=$row['first_name']?>
                                                <?=$row['middle_name']?>
                                                <?=$row['last_name']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center" >
                                                <?=$row['birth_date']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center">
                                                <?=$row['birthplace_municipality_city']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center">
                                                <?=$row['birthplace_province']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center">
                                                <?=$row['father_name']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center">
                                                <?=$row['mother_maiden_name']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center items-center">
                                                <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                                    <a href="backend/edit.php?id=<?= $row['id']?>">
                                                        <img src="../img/edit.svg" alt="edit"/>
                                                    </a>
                                                </button>
                                                <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                                    <img name="delete" src="../img/trash.svg" alt="delete"/>
                                                </button>
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Contact Information Table -->
                        <div id="tb3" class="hidden ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[300px] std:w-[200px]">
                                        <col class="w-[600px]">
                                        <col class="w-[600px]">
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class=" bg-c sticky top-0 text-sm std:text-base">
                                        <tr class="uppercase ">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 std:py-4 min-w-20">ID</th>
                                            <th class="py-2 std:py-4  text-sg">Full Name</th>                            
                                            <th class="py-2 std:py-4">Contact Information</th>
                                            <th class="py-2 std:py-4">Email Address</th>
                                            <th class="py-2 std:py-4 min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white">
                                    <?php 
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100 text-sm std:text-base text-center">
                                        <td class="border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c text-sg py-2 std:py-2">
                                            <div class="flex justify-center ">
                                                <?=$row['first_name']?>
                                                <?=$row['middle_name']?>
                                                <?=$row['last_name']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center" >
                                                <?=$row['contact_num']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center">
                                                <?=$row['email_address']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-2">
                                            <div class="flex justify-center items-center">
                                                <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                                    <a href="backend/edit.php?id=<?= $row['id']?>">
                                                        <img src="../img/edit.svg" alt="edit"/>
                                                    </a>
                                                </button>
                                                <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                                    <img name="delete" src="../img/trash.svg" alt="delete"/>
                                                </button>
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Address Table -->
                        <div id="tb4" class="hidden ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse ">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[300px] std:w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[300px] std:w-[200px]">
                                        <col class="w-[100px]">
                                        <col class="hidden std:block w-[200px]">
                                        <col class="w-[250px]">
                                        <col class="w-[150px]">
                                        <col class="w-[150px]">
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class=" bg-c sticky text-sm std:text-base top-0">
                                        <tr class="uppercase">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 std:py-4 min-w-20 ">ID</th>
                                            <th class="py-2 std:py-4 text-sg">Full Name</th>                            
                                            <th class="py-2 std:py-4">House Number</th>
                                            <th class="py-2 std:py-4">Street Name</th>
                                            <th class="py-2 std:py-4">Purok</th>
                                            <th class="py-2 std:py-4 ">Barangay Name</th>
                                            <th class="py-2 std:py-4">Municipality/City</th>                            
                                            <th class="py-2 std:py-4">Province</th>
                                            <th class="py-2 std:py-4">Zip Code</th>
                                            <th class="py-2 std:py-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white">
                                    <?php 
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100 text-sm std:text-base text-center">
                                        <td class="border-y-2 border-c py-1 std:py-4">
                                            <div class="flex justify-center">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c text-sg">
                                            <div class="flex justify-center py-2">
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
                                            <div class="flex justify-center">
                                                <?=$row['purok']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2 std:py-4">
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
                                        <td class="border-y-2 border-c py-1 std:py-2 ">
                                            <div class="flex justify-center items-center">
                                                <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                                    <a href="backend/edit.php?id=<?= $row['id']?>">
                                                        <img src="../img/edit.svg" class="size-5 std:size-10" alt="edit"/>
                                                    </a>
                                                </button>
                                                <button  class="w-6 ml-2 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                                    <img name="delete" src="../img/trash.svg" class="size-5 std:size-10" alt="delete"/>
                                                </button>
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" class="size-5 std:size-6" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>         
                        <!--Civil Status & Citizenship Table -->
                        <div id="tb5" class="hidden ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse ">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col >
                                        <col >
                                        <col >
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class=" bg-c sticky text-sm std:text-base top-0">
                                        <tr class="uppercase ">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 std:py-4 min-w-20">ID</th>
                                            <th class="py-2 std:py-4  text-sg">Full Name</th>                            
                                            <th class="py-2 std:py-4">Civil Status</th>
                                            <th class="py-2 std:py-4">Citizenship</th>
                                            <th class="py-2 std:py-4">Ethnicity</th>
                                            <th class="py-2 std:py-4 min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white">
                                    <?php 
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100 text-sm std:text-base text-center">
                                        <td class="border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
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
                                                <?=ucwords($row['civil_status'])?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['citizenship']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['ethnicity']?>
                                            </div>
                                        </td>
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
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Residentcy & Occupation Table -->
                        <div id="tb6" class="hidden ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse ">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[500px]">
                                        <col class="w-[250px]">
                                        <col>
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class=" bg-c sticky text-sm std:text-base top-0">
                                        <tr class="uppercase ">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 std:py-4 min-w-20">ID</th>
                                            <th class="py-2 std:py-4  text-sg">Full Name</th>                            
                                            <th class="py-2 std:py-4">Occupation</th>
                                            <th class="py-2 std:py-4">Type Of Residency</th>
                                            <th class="py-2 std:py-4">Status</th>
                                            <th class="py-2 std:py-4 min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 text-sm std:text-base bg-white">
                                    <?php 
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100  text-center">
                                        <td class="border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
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
                                                <?=ucwords($row['residency_type'])?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center" >
                                                <?php
                                                if (strtolower($row['status']) === 'active') {
                                                    ?>
                                                    <div class="flex items-center mr-1">
                                                        <img src="../img/active.png" class="size-2 std:size-4 flex items-center" alt="">
                                                    </div>
                                                <?=ucwords($row['status'])?>
                                                <?php 
                                                } else if (strtolower($row['status']) === 'inactive') {
                                                    ?>
                                                    <div class="flex items-center mr-1">
                                                        <img src="../img/inactive.png" class="size-2 std:size-4 flex items-center" alt="">
                                                    </div>
                                                    <?=ucwords($row['status'])?>
                                                <?php } ?>
                                            </div>
                                        </td>
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
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Health Table -->
                        <div id="tb7" class="hidden ">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse ">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[300px] std:w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[150px]">
                                        <col class="w-[300px]">
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class=" bg-c sticky text-sm std:text-base top-0">
                                        <tr class="uppercase ">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 min-w-20">ID</th>
                                            <th class="py-2  text-sg">Full Name</th>                            
                                            <th class="py-2 text-xs std:text-base">Height<br><p class="text-xs hidden std:block">(cm)</p></th>
                                            <th class="py-2 text-xs std:text-base">Weight<br><p class="text-xs hidden std:block">(kg)</p></th>
                                            <th class="py-2">Eye Color</th>
                                            <th class="py-2">Blood Type</th>
                                            <th class="py-2">Religion</th>
                                            <th class="py-2 min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 text-sm std:text-base bg-white">
                                    <?php 
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($searchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100 text-sm std:text-base text-center ">
                                        <td class="border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
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
                                                <?=$row['height']?> cm
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center" >
                                                <?=$row['weight']?> KG
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center" >
                                                <?=$row['eye_color']?>
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
                                                <button class="w-6 ml-3 cursor-pointer" onclick="viewDetails(event, '<?= $row['id'] ?>')">
                                                    <img name="view_details" src="../img/view.png" alt="delete"/>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Page Links -->
                        <div class=" h-12 rounded-b-sm bg-c">
                            <?php
                                //display first and prev
                                echo "<div class='place-self-end pt-3 p-2'>";
                                if ($page > 1) {
                                    echo "<a href='residentpage.php?page=1&search=$search' class='px-4 py-2 text-sm  text-white bg-sg rounded-l-lg hover:opacity-80'>&laquo; First</a>";
                                    echo "<a href='residentpage.php?page=" . ($page - 1) . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>&lt; Previous</a>"; // Previous page link
                                } else {
                                    echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200 rounded-l-lg'>&laquo; First</span>";
                                    echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200'>&lt; Previous</span>";
                                }
                                //display range of page link
                                for ($i = max(1, $page - 5); $i <= min($total_pages, $page + 5); $i++) {
                                    if ($i == $page) {
                                        echo "<span class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</span>";
                                    } else {
                                        echo "<a href='residentpage.php?page=" . $i . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</a>";
                                    }
                                }
                                // Display next and last
                                if ($page < $total_pages) {
                                   echo "<a href='residentpage.php?page=" . ($page + 1) . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>Next &gt;</a>"; // Next page link
                                   echo "<a href='residentpage.php?page=$total_pages&search=$search' class='px-4 py-2 text-sm  text-white bg-sg rounded-r-lg hover:opacity-80'>Last &raquo;</a>"; // Last page link
                                } else {
                                   echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200'>Next &gt;</span>";
                                   echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200 rounded-r-lg'>Last &raquo;</span>";
                                }
                                echo "</div>";
                            ?>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
                <!-- No records -->
                <div class="overflow-hidden mt-4 w-full ">
                    <div class="border-2 border-c rounded-lg mx-8 bg-white">
                        <!--Personal Information Table -->
                        <div class="">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                    </colgroup>
                                    <thead class="bg-c sticky top-0 text-sm std:text-base">
                                        <tr class="uppercase ">
                                            <!--Basic Information + Action-->
                                            <th class="py-2 std:py-4 min-w-20">ID</th>
                                            <th class="py-2 std:py-4">First Name</th>
                                            <th class="py-2 std:py-4">Middle Name</th>
                                            <th class="py-2 std:py-4">Last Name</th>
                                            <th class="py-2 std:py-4">Suffix</th>
                                            <th class="py-2 std:py-4">Gender</th>
                                            <th class="py-2 std:py-4">Age</th>
                                            <th class="min-w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white h-[55vh] std:h-[60vh] text-sm std:text-base">
                                    <tr class=" text-center">
                                        <td class=" border-y-2 border-c py-2 std:py-4">
                                            <div class="flex justify-center  min-w-20">
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center" >
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                No records found
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                            </div>
                                        </td>
                                        <?php
                                        if (hasPermission('system_settings')){
                                        ?>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center items-center">
                                            </div>
                                        </td>
                                        <?php
                                        } else {
                                        ?>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center items-center">
                                            </div>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class=" h-12 rounded-b-sm bg-c">
                            <?php
                                //display first and prev
                                echo "<div class='place-self-end pt-3 p-2'>";
                                if ($page > 1) {
                                    echo "<a href='residentpage.php?page=1&search=$search' class='px-4 py-2 text-sm  text-white bg-sg rounded-l-lg hover:opacity-80'>&laquo; First</a>";
                                    echo "<a href='residentpage.php?page=" . ($page - 1) . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>&lt; Previous</a>"; // Previous page link
                                } else {
                                    echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200 rounded-l-lg'>&laquo; First</span>";
                                    echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200'>&lt; Previous</span>";
                                }
                                //display range of page link
                                for ($i = max(1, $page - 5); $i <= min($total_pages, $page + 5); $i++) {
                                    if ($i == $page) {
                                        echo "<span class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</span>";
                                    } else {
                                        echo "<a href='residentpage.php?page=" . $i . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</a>";
                                    }
                                }
                                // Display next and last
                                if ($page < $total_pages) {
                                   echo "<a href='residentpage.php?page=" . ($page + 1) . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>Next &gt;</a>"; // Next page link
                                   echo "<a href='residentpage.php?page=$total_pages&search=$search' class='px-4 py-2 text-sm  text-white bg-sg rounded-r-lg hover:opacity-80'>Last &raquo;</a>"; // Last page link
                                } else {
                                   echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200'>Next &gt;</span>";
                                   echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200 rounded-r-lg'>Last &raquo;</span>";
                                }
                                echo "</div>";
                            ?>
                        </div>
                    </div>
                </div>
                <?php }  ?>
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
                                Delete  
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
                <div class="absolute bg-black opacity-50 w-screen h-screen grid cursor-pointer" onclick="cancelView()"></div> <!-- Background overlay -->
                <div class="relative flex flex-col h-screen overflow-auto rounded-l-xl bg-white z-10 " style="width:60vh">
                    <div class="flex ml-4">
                        <button onclick="cancelView()" class="flex items-center ">
                            <div class="flex items-center pr-2 py-4 rounded-md cursor-pointer ">
                                <img src="../img/back.png" class="size-4" alt="select from records">
                            </div>
                            <p class="flex justify-start w-48 px-2">Back</p>
                        </button>
                    </div>
                    <div id="viewDetailsContent" class="pl-20 items-center ">
                    <!-- Details from viewDetails.php will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Loading Message -->
        <div class="fixed z-50 " id="msgUpload">
        
        </div>
    </div>
<script>
    //remove notif
    function notifDel(){
        document.getElementById("notif-del").style.opacity = "0";
    }
    //confirm deletion
    function confirmDeletion(id) {
        document.getElementById("confirmDeletion").classList.remove("hidden");
        document.getElementById("deleteLink").href =' backend/delete.php?id=' + id;
    }
    function cancelConfirmation() {
        document.getElementById("confirmDeletion").classList.add("hidden");
    }
    //view details
    function viewDetails(event, id) {
        event.preventDefault(); // Prevent page reload

        // AJAX to fetch the details without refreshing the page
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'backend/viewDetails.php?id=' + id, true); // Make sure viewDetails.php accepts the ID in the query string
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Insert the response (HTML) into the modal
                document.getElementById("viewDetailsContent").innerHTML = xhr.responseText;
                document.getElementById("viewDetails").classList.remove("hidden");
            }
        };
        xhr.send();
    }
    function cancelView() {
        document.getElementById("viewDetails").classList.add("hidden");
    }
    //toggle display
    function toggleDisplay(elementID, show) {
        const element = document.getElementById(elementID);
        element.style.display = show ? "block" : "none";
    }

    // show category
    function showCategory(categoryID, option){
        const tables = ["tb1", "tb2", "tb3", "tb4", "tb5", "tb6", "tb7"];
        // Hide all tables except the selected one
        tables.forEach(id => {
            document.getElementById(id).classList.toggle("hidden", id !== categoryID);
        });

        const options = ["option1", "option2", "option3", "option4", "option5", "option6", "option7"];

        // toggle active
        options.forEach(border => {
            const button = document.getElementById(border);
            button.classList.toggle("border-sg", option === border);
            button.classList.toggle("border-c", option !== border);
        });

        // store the selected categ and opt in localStorage
        localStorage.setItem('selectedCategory', categoryID);
        localStorage.setItem('selectedOption', option);
    }
    // load the previously selected categ and page on page load
    function loadCategory() {
        const selectedCategory = localStorage.getItem('selectedCategory');
        const selectedOption = localStorage.getItem('selectedOption');
        if (selectedCategory) {
            showCategory(selectedCategory, selectedOption);
        }
    }
    // Call the loadCategory function on page load to restore the previous state
    window.onload = loadCategory;
    
</script>
<script>
    // Display Session TImer
    var remainingTime = <?php echo $remaining_time; ?>;
        // If remaining time exists in sessionStorage, use it, otherwise, set it
        if (sessionStorage.getItem('remainingTime') === null) {
            sessionStorage.setItem('remainingTime', remainingTime);
        } else {
            sessionStorage.setItem('remainingTime', remainingTime);
        }
        // Update the timer display every second
    function updateTimer() {
        var remainingTime = parseInt(sessionStorage.getItem('remainingTime'), 10);
        // Calculate minutes and seconds
        var minutes = Math.floor(remainingTime / 60);
        var seconds = remainingTime % 60;
        // Update the timer display
        document.getElementById('timer').innerHTML = "Session expires in: " + minutes + "m " + seconds + "s";
        // Decrease remaining time and store it in sessionStorage
        if (remainingTime <= 0) {
            window.location.href = 'backend/logout.php';
        } else {
            remainingTime--;
            sessionStorage.setItem('remainingTime', remainingTime);
        }
    }
    // Call updateTimer every second
    setInterval(updateTimer, 1000);

</script>
<script>
    // bulk import
    const fileInput = document.querySelector("#file_input");
    const fileOutput = document.querySelector("#file_output");
    const notifMsg = 
    `
    <div id="notif-del" class="grid grid-cols-2 items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100">
        <p>Unsupported file type. Please upload a CSV file.</p>
        <img src="../img/notif-del.png" alt="X" class="justify-self-end cursor-pointer" onclick="notifDel();">
    </div>
    `;
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
            document.querySelector("#uploadMsg").innerHTML = notifMsg;
        } 
        fileReader.readAsDataURL(file);
    };
    $('#formUpload').on('submit', function(e) {
    e.preventDefault();
        let form = $(this);
        let csv = new FormData(form[0]);
        $('#msgUpload').html(
            `<div class="fixed z-50">
                <div class="border-4 w-screen h-screen flex justify-center items-center">
                    <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                    <div class="relative flex items-center justify-center h-72 w-96 overflow-auto rounded-md bg-white z-10">
                        <center><img src="../img/loader.gif"/> <br>Uploading Data. Please wait...</center>
                    </div>
                </div>
            </div>
            `);

// To make sure the loader shows up, remove the "hidden" class
$('#msgUpload').removeClass('hidden');
        $('#btnUpload').hide();

        $.ajax({
            url: "backend/upload.php",
            type: 'POST',
            contentType: false,
            processData: false,
            data: csv,
            success: function(data) {
                $('#msgUpload').html('');  // Clear the loading message
                $('#btnUpload').show();
                console.log(data); // Debugging: Check what is being returned
                $('#uploadMsg').html(data); // Ensure data is valid HTML or text
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                $('#uploadMsg').html('<p style="color: red;">An error occurred while uploading. Please try again.</p>');
            }
        });
    });

</script>
</body>
</html>