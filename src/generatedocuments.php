<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
//for timer
if(!hasPermission('system_settings')){
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
<body class="relative" >
    <div class="flex h-screen w-screen overflow-auto">
        <!-- Sidebar -->
        <div class="flex-none w-20 h-full shadow-2xl">
            <!--Nav-->
            <div id="mainNav" class="flex flex-col place-content-start h-full w-full bg-c duration-500 ease-in-out">
                <div class="h-full flex flex-col ">
                    <div class="place-content-center h-full grow-0 space-y-14 ">
                        <div>
                            <a href="dashboard.php">
                                <button onmouseover="toggleDisplay('dashboard_title', true)" onmouseleave="toggleDisplay('dashboard_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/dashboard.png ">
                                    <span id="dashboard_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Dashboard</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="residentpage.php">
                                <button onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/res_info.png ">
                                    <span id="res_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Resident Information</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="generatedocuments.php">
                                <button  onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/gen_doc.png">
                                    <span id="doc_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Generate Documents</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="printhistory.php">
                                <button onmouseover="toggleDisplay('print_history', true)" onmouseleave="toggleDisplay('print_history', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/reports.png">
                                    <span id="print_history" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Print History</span>
                                </button>
                            </a>
                        </div>
                        <div>
                            <?php
                            if (hasPermission('system_settings')){
                            ?>
                            <a href="accountmanagement.php">
                                <button  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full ">
                                    <img class="size-10 hover:animate-wiggle" src="../img/setting.png"  >
                                    <span id="set_title" class="absolute ml-64 z-10 shadow-3xl text-sm p-2 rounded-lg bg-c min-w-40 hidden">Account Settings</span>
                                </button>
                            </a>
                            <?php 
                            } else {
                            ?>
                            <button disabled  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
                                <img  class="size-10 hover:animate-wiggle" src="../img/setting.png" >
                                <span id="set_title" class="absolute z-10 hover:scale-110 text-sm bg-c hidden">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/x.png">
                                </span>
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Account and Logout -->
                    <div class="place-content-center space-x-4 h-2/5 w-full grow">
                        <!-- Account -->
                        <div>
                            <button onmouseover="toggleDisplay('account', true)" onmouseleave="toggleDisplay('account', false)" class="flex place-content-center w-full">
                                <img  class="size-10 hover:animate-wiggle" src="../img/account.png">
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
                            <button class="flex place-self-center">
                                <?php
                                    $userId = $_SESSION['users'];
                                    $query = 'SELECT * FROM users WHERE id = :id';  // Query with a condition to select the logged-in user
                                    $stmt = $dbh->prepare($query);
                                    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);  // Bind the user ID parameter
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($result) {
                                        echo $result['email'];
                                    }   else {
                                        echo "No such user found.";
                                    }
                                ?>
                            </button>
                        </div>
                        <a href="backend/logout.php">
                            <img src="../img/logout.png" class="place-self-center size-12 hover:scale-125 transition duration-500" alt="">
                            <p class="flex place-self-center">Logout</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main -->
        <div class="w-full h-screen"> 
            <!-- Header -->
            <div class="h-22 w-full grid gap-x-10 grow grid-cols-2 shadow-md px-8 py-2 bg-white">
                <div class="text-3xl">
                    <b>Barangay Buna Cerca</b><br>
                    <div class="flex items-center">
                        <p class="text-[20px] italic">Generate Documents</p>
                        <?php if(!hasPermission('system_settings')) : ?>
                            <p class="text-[16px] italic transform translate-y-[0.5px] translate-x-4" id="timer">Session expires in: </p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="flex justify-end items-center space-x-4">
                    <div class="justify-items-end">
                        <b>Philippine Standard Time: </b><br>
                        <p class="italic" id="liveClock"></p>
                    </div>
                </div>
            </div>
            <!-- Body -->
            <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../img/bunacerca-bg.png'); filter: blur(5px); z-index: -1;"></div>
            <div class="grid content-center h-[90%] bg-cover bg-center bg-fixed z-10" >
                <div class=" place-items-center">
                    <p class="font-bold text-white text-5xl mb-4">Select a Document</p>
                    <p class="border-t-4 border-c w-1/5 rounded-sm mb-20"></p>
                </div>
                <div class="grid grid-cols-3  place-self-center gap-x-28 z-20 text-lg">
                    <!-- Barangay Clearance -->
                    <div>
                        <div class="border-2 border-sg rounded-t-xl bg-c h-48 w-64 flex justify-center items-center">
                            <div>
                                <button class="cursor-default">
                                <img class='place-self-center size-14' src='../img/dashboard.png'>
                                    Barangay Clearance
                                </button>
                            </div>
                        </div>
                        <a href="documents/brgyclearance.php">
                            <div class="border-x-2 border-b-2 border-sg rounded-b-xl h-12 w-64 flex justify-center items-center bg-sg hover:text-white active:bg-sg transition duration-700 cursor-pointer ">
                                <button>
                                    Generate
                                </button>
                            </div>
                        </a>
                    </div>
                    <!-- Certificate of Residency -->
                    <div>
                        <div class="border-2 border-sg rounded-t-xl bg-c h-48 w-64  flex justify-center items-center">
                            <div>
                                <button class="cursor-default">
                                <img class='place-self-center size-14' src='../img/dashboard.png'>
                                    Cerificate of Residency
                                </button>
                            </div>
                        </div>
                        <a href="documents/certresidency.php">
                            <div class="border-x-2 border-b-2  border-sg rounded-b-xl h-12 w-64 flex justify-center items-center bg-sg hover:text-white active:bg-sg transition duration-700 cursor-pointer ">
                                <button>
                                    Generate
                                </button>
                            </div>
                        </a>
                    </div>
                    <!-- Certificate of Indigency -->
                    <div>
                        <div class="border-2 border-sg rounded-t-xl bg-c h-48 w-64  flex justify-center items-center">
                            <div>
                                <button class="cursor-default">
                                <img class='place-self-center size-14' src='../img/dashboard.png'>
                                   Certificate of Indigency
                                </button>
                            </div>
                        </div>
                        <a href="documents/certindigency.php">
                            <div class="border-x-2 border-b-2 border-sg rounded-b-xl h-12 w-64 flex justify-center items-center bg-sg hover:text-white active:bg-sg transition duration-700 cursor-pointer ">
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
