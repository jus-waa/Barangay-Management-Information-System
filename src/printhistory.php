<?php
include("backend/connection.php");
include("backend/pagination.php");
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
    <script src="clock.js"></script>
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
        <div class="flex flex-col w-screen h-screen">
            <!-- Header -->
            <div class="h-22 w-full grid gap-x-10 grow grid-cols-2 shadow-md px-8 py-2 bg-white">
                <div class="text-3xl">
                    <b>Barangay Buna Cerca</b><br>
                    <div class="flex items-center">
                        <p class="text-[20px] italic">Transaction History</p>
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
                <div class="flex flex-col h-full grow mt-[5.5rem]">
                    <!-- Options -->
                    <div class="grid grid-cols-2 mx-8 ">
                    <!-- Categories -->
                    <div class="flex justify-start items-center">
                        <p class="border-b-4 border-sg text-black py-1 px-3 hover:border-sg rounded-sm">
                            History of Documents Issued
                        </p>
                    </div>
                    <!-- Search -->
                    <div class="relative">
                        <form method="GET" class="flex justify-end items-center">
                            <input name="search" id="search" type="text" placeholder="Search..." value="<?=$search?>" class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none focus:ring-2 ring-sg h-8 z-10  transform translate-x-8" >
                            <button type="submit" id="searchBtn" class=" bg-white  rounded-md p-2 focus:outline-none focus:ring-2 ring-sg h-7 flex items-center justify-center z-20">
                                <img class="w-4" src="../img/search.svg" alt="Search Icon"/>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Tables -->
                <?php if ($printSearchResult) { ?>
                <div class="overflow-hidden mt-4 w-full">
                    <div class="border-2 border-c rounded-lg mx-8 bg-white">
                        <!--No Records Table -->
                        <div class="h[67vh]">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col>
                                    </colgroup>
                                    <thead class="bg-c sticky top-0 ">
                                        <tr class="uppercase">
                                            <!--Basic Information + Action-->
                                            <th class="py-4 min-w-20">ID</th>
                                            <th class="py-4">First Name</th>
                                            <th class="py-4">Age</th>
                                            <th class="py-4">Document Type</th>
                                            <th class="py-4">Control Number</th>
                                            <th class="py-4">CTC Number</th>
                                            <th class="py-4">Issued By</th>
                                            <th class="min-w-20">Purpose</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white">
                                    <?php 
                                    $male = 0;
                                    $female = 0;
                                    $i = 1; //auto numbering
                                    $j = 10 * $page - 10; // adjust depending on page
                                    foreach ($printSearchResult as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100  text-center">
                                        <td class=" border-y-2 border-c py-4">
                                            <div class="flex justify-center  min-w-20">
                                                <?php echo $page > 1 ? $i + $j : $i; ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center" >
                                                <?=$row['age']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['document_type']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['control_number']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['ctc_number']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['issued_by']?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-c py-2">
                                            <div class="flex justify-center">
                                                <?=$row['purpose']?>
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
                                    echo "<a href='printhistory.php?page=1&search=$search' class='px-4 py-2  text-sm  text-white bg-sg rounded-l-lg hover:opacity-80'>&laquo; First</a>";
                                    echo "<a href='printhistory.php?page=" . ($page - 1) . "&search=$search' class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>&lt; Previous</a>"; // Previous page link
                                } else {
                                    echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200 rounded-l-lg'>&laquo; First</span>";
                                    echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200'>&lt; Previous</span>";
                                }
                                //display range of page link
                                for ($i = max(1, $page - 5); $i <= min($print_total_pages, $page + 5); $i++) {
                                    if ($i == $page) {
                                        echo "<span class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</span>";
                                    } else {
                                        echo "<a href='printhistory.php?page=" . $i . "&search=$search' class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</a>";
                                    }
                                }
                                // Display next and last
                                if ($page < $print_total_pages) {
                                   echo "<a href='printhistory.php?page=" . ($page + 1) . "&search=$search' class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>Next &gt;</a>"; // Next page link
                                   echo "<a href='printhistory.php?page=$print_total_pages&search=$search' class='px-4 py-2  text-sm  text-white bg-sg rounded-r-lg hover:opacity-80'>Last &raquo;</a>"; // Last page link
                                } else {
                                   echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200'>Next &gt;</span>";
                                   echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200 rounded-r-lg'>Last &raquo;</span>";
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
                        <!--No Records Table -->
                        <div class="h[67vh]">
                            <div class="rounded-t-sm pt-2 bg-c ">
                                <table id="residentTable" class="w-full border-collapse">
                                    <colgroup>
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[100px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col class="w-[200px]">
                                        <col>
                                    </colgroup>
                                    <thead class="bg-c sticky top-0 ">
                                        <tr class="uppercase">
                                            <!--Basic Information + Action-->
                                            <th class="py-4 min-w-20">ID</th>
                                            <th class="py-4">First Name</th>
                                            <th class="py-4">Age</th>
                                            <th class="py-4">Document Type</th>
                                            <th class="py-4">Control Number</th>
                                            <th class="py-4">CTC Number</th>
                                            <th class="py-4">Issued By</th>
                                            <th class="min-w-20">Purpose</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" text-gray-600 bg-white h-[60vh]">
                                    <tr class=" text-center">
                                        <td class=" border-y-2 border-c py-4">
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
                                    echo "<a href='residentpage.php?page=1&search=$search' class='px-4 py-2  text-sm  text-white bg-sg rounded-l-lg hover:opacity-80'>&laquo; First</a>";
                                    echo "<a href='residentpage.php?page=" . ($page - 1) . "&search=$search' class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>&lt; Previous</a>"; // Previous page link
                                } else {
                                    echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200 rounded-l-lg'>&laquo; First</span>";
                                    echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200'>&lt; Previous</span>";
                                }
                                //display range of page link
                                for ($i = max(1, $page - 5); $i <= min($total_pages, $page + 5); $i++) {
                                    if ($i == $page) {
                                        echo "<span class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</span>";
                                    } else {
                                        echo "<a href='residentpage.php?page=" . $i . "&search=$search' class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</a>";
                                    }
                                }
                                // Display next and last
                                if ($page < $total_pages) {
                                   echo "<a href='residentpage.php?page=" . ($page + 1) . "&search=$search' class='px-4 py-2  text-sm  text-white bg-sg hover:opacity-80'>Next &gt;</a>"; // Next page link
                                   echo "<a href='residentpage.php?page=$total_pages&search=$search' class='px-4 py-2  text-sm  text-white bg-sg rounded-r-lg hover:opacity-80'>Last &raquo;</a>"; // Last page link
                                } else {
                                   echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200'>Next &gt;</span>";
                                   echo "<span class='px-4 py-2  text-sm  text-gray-400 bg-gray-200 rounded-r-lg'>Last &raquo;</span>";
                                }
                                echo "</div>";
                            ?>
                        </div>
                    </div>
                </div>
                <?php }  ?>
                <!-- Confirm Print -->
                <div class="fixed z-50 hidden" id="confirmDeletion">
                    <div class="border-4 w-screen h-screen flex justify-center items-center">
                        <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                        <div class="relative grid grid-cols-1 grid-rows-2 h-72 w-96 overflow-auto rounded-md bg-white z-10">
                            <div class="grid justify-center">
                                <div class="text-3xl font-bold place-self-center mt-12">Confirm Print?</div>
                                <div class="mb-24 mt-4">Are you sure you want to delete this record?</div>
                            </div>
                            <div class="flex justify-center space-x-4 mt-6">
                                <a id="" href="#">
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
        </div>
    </div>
<script>
    //remove notif
    function notifDel(){
        document.getElementById("notif-del").style.opacity = "0";
    }
    function confirmDeletion(id) {
        document.getElementById("confirmDeletion").classList.remove("hidden");
        //document.getElementById("deleteLink").href =' backend/delete.php?id=' + id;
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
