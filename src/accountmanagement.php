<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
//for timer
if(hasPermission('system_settings')){
    include("backend/session_timer.php");
} 
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
    <link rel="icon" type="image/x-icon" href="../img/buna_cerca.png">
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
                                        $resultz = $stmt->fetch(PDO::FETCH_ASSOC);
                                        if ($resultz) {
                                            echo $resultz['username'];
                                        }   else {
                                            echo "No such user found.";
                                        }
                                    ?>
                                </span>
                            </button>
                            <button class="flex place-self-center text-left ">
                                <?php
                                    $userId = $_SESSION['users'];
                                    $query = 'SELECT * FROM users WHERE id = :id';  // Query with a condition to select the logged-in user
                                    $stmt = $dbh->prepare($query);
                                    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);  // Bind the user ID parameter
                                    $stmt->execute();
                                    $resultz = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($resultz) {
                                        $email = $resultz['email'];
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
                                <p class="flex place-self-center text-xs std:text-base">Logout</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main -->
        <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../img/bunacerca-bg.png'); filter: blur(5px); z-index: -1;"></div>
        <div class="flex flex-col w-screen h-screen">
            <!-- Header -->
            <div class="grid grid-cols-2 items-center shadow-md px-8 py-2 std:py-2 bg-white">
                <div class="text-xl std:text-3xl ">
                    <b>Barangay Buna Cerca</b>
                    <br>
                    <div class="flex items-center">
                        <p class="text-[16px] std:text-[20px] italic">Account management</p>
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
            <!-- List of Accounts -->
            <div class="flex flex-col h-full grow">
                <!-- Note -->
                <div class="h-14 my-6 mx-4 std:my-4 std:mx-8 text-white">
                <?php
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
                <!-- Regular Section -->
                <div class="flex justify-between items-end mx-8 mt-4">
                    <div class="bg-c text-black py-2 px-14 rounded-xl font-bold text-xl std:text-3xl std:min-w-[200px] text-center">Regular</div>
                    <a href="signuppage.php"><button class="bg-c text-black py-1 px-3 duration-500 hover:bg-sg focus:outline-none rounded-md text-sm std:text-base">Add Record</button></a>
                </div>
                <!-- Regular Account Table -->
                <div class="overflow-hidden w-full  mt-4">
                    <div class="border-2 border-c rounded-lg mx-8">
                    <!--Regular-->
                    <div id="tb1" class="overflow-auto no-scrollbar h-[21vh] std:h-[25vh]">
                        <div class="rounded-t-sm pt-2 bg-c ">
                            <table id="residentTable" class="w-full border-collapse">
                        <colgroup>
                            <col class="w-[100px]">
                            <col class="w-[100px]">
                            <col class="w-[200px]">
                            <col class="w-[200px]">
                            <col class="w-[400px]">
                            <col class="w-[200px]">
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class="bg-c sticky top-0 text-sm std:text-base">
                            <tr class="uppercase">
                                <!--Basic Information + Action-->
                                <th class="w-12 py-2 std:py-4">ID</th>
                                <th class="">Name</th>
                                <th class="w-56">Username</th>
                                <th class="w-32">Contact Information</th>
                                <th class="">Date Created</th>
                                <th class="">Date Updated</th>
                                <th class="w-36">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" text-gray-600 bg-white ">
                        <?php 
                        $i = 1; //auto numbering
                        foreach ($result as $row) {
                            if ($row['role_id'] == 2) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <td class=" border-y-2 border-c w-12 py-4">
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
                                <div class="flex justify-center" >
                                    <?=$row['email']?>
                                </div>
                            </td>
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
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
                    <div class=" h-6 rounded-b-sm border-2 border-c bg-c">
                        </div>
                </div>
                <!-- Admin Section -->
                <div class="flex justify-between items-end mx-8 mt-10">
                    <div class="bg-c text-black py-2 px-12 std:px-16 rounded-xl font-bold text-xl std:text-3xl min-w-[200px] text-center">Admin</div>
                    <!-- <a href="signuppage.php"><button class="bg-c text-black py-1 px-3 hover:bg-sg focus:outline-none rounded-sm focus:ring-4 ring-dg">Add Record</button></a> -->
                </div>
                <!-- Admin Table -->
                <div class="w-full overflow-hidden mt-4">
                    <div class="border-2 border-c rounded-lg mx-8">
                        <!-- Admin -->
                        <div id="tb1" class="overflow-auto no-scrollbar h-[21vh] std:h-[25vh]">
                        <div class="rounded-t-sm pt-2 bg-c ">
                            <table id="residentTable" class="w-full border-collapse ">
                        <colgroup>
                        <col class="w-[100px]">
                            <col class="w-[100px]">
                            <col class="w-[200px]">
                            <col class="w-[200px]">
                            <col class="w-[400px]">
                            <col class="w-[200px]">
                            <col class="w-[200px]">
                        </colgroup>
                        <thead class="bg-c sticky top-0 text-sm std:text-base">
                            <tr class="uppercase ">
                                <!--Basic Information + Action-->
                                <th class="w-12 py-2 std:py-4">ID</th>
                                <th class="">Name</th>
                                <th class="w-56">Username</th>
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
                            <td class=" border-y-2 border-c w-12 py-4">
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
                                <div class="flex justify-center">
                                    <?=$row['email']?>
                                </div>
                            </td>
                            
                            <td class="border-y-2 border-c ">
                                <div class="flex justify-center">
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
                        <div class=" h-6 rounded-b-sm border-2 border-c bg-c">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Confirm Deletion-->
        <div class="fixed inset-0 z-50 hidden" id="confirmDeletion">
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
    </div>
<script>
    //remove notif
    function notifDel(){
        document.getElementById("notif-del").style.opacity = "0";
    }
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
</body>
</html>
