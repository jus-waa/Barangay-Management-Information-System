<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
//for timer
if(hasPermission('system_settings')){
    include("backend/session_timer.php");
} 
include("backend/dashboardreport.php");
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
    <script src="../node_modules/chart.js/dist/chart.umd.js"></script>
    <script src="../script.js"></script>
    <script src="clock.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="relative">
    <div class="flex h-screen w-screen overflow-auto">
        <!-- Sidebar -->
        <div class="flex-none w-20 h-full shadow-2xl">
            <!--Nav-->
            <div id="mainNav" class="flex flex-col place-content-start h-full w-full bg-c duration-500 ease-in-out">
                <div class="h-full flex flex-col ">
                    <!-- Menu -->
                    <div class="flex flex-col justify-between place-content-center h-full grow-0">
                        <div class="m-3 mt-4">
                            <img src="../img/buna_cerca.png" alt="">
                        </div>
                        <div class="place-content-center my-20 space-y-14 ">
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
                                <button disabled id="setting" onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
                                    <img  class="size-10 hover:animate-wiggle" src="../img/setting.png" >
                                    <span id="set_title" class="absolute z-10 hover:scale-110 text-sm bg-c hidden">
                                        <img  class="size-10 hover:animate-wiggle" src="../img/x.png">
                                    </span>
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Account and Logout -->
                    <div class="flex flex-col justify-center space-y-4 h-2/5 w-full grow">
                        <!-- Account -->
                        <div>
                            <button  onmouseover="toggleDisplay('account', true)" onmouseleave="toggleDisplay('account', false)" class="flex place-content-center w-full">
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
                                <img src="../img/logout.png" class="place-self-center size-12 hover:scale-125 transition duration-500" alt="">
                                <p class="flex place-self-center">Logout</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main -->
        <div class="flex flex-col w-full h-screen overflow-hidden"> 
            <!-- Header -->
            <div class="grid grid-cols-2 items-center shadow-md px-8 py-2 stl:py-2 bg-white">
                <div class="text-xl stl:text-3xl ">
                    <b>Barangay Buna Cerca</b>
                    <br>
                    <div class="flex items-center">
                        <p class="text-[20px] italic">Dashboard</p>
                        <?php if(hasPermission('system_settings')) : ?>
                            <p class="text-[16px] italic transform translate-y-[0.5px] translate-x-4" id="timer">Session expires in: </p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="justify-items-end">
                    <b>Philippine Standard Time: </b><br>
                    <p class="italic" id="liveClock"></p>
                </div>
            </div>
            <!-- Body -->
            <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../img/bunacerca-bg.png'); filter: blur(5px); z-index: -1;"></div>
            <!-- Outer Box -->
            <div class="flex-1 grid grid-cols-[auto_30rem] gap-x-4 p-2 stl:p-4">
                <div class="grid grid-rows-[11rem_auto] stl:grid-rows-[13rem_auto] gap-y-4 rounded-xl">
                    <!-- First Upper Box -->
                    <div class="grid grid-rows-[5rem_auto] h-32 stl:h-52 w-full bg-sg border-2 border-sg rounded-xl text-white">
                       <div class="flex items-center justify-between p-6 drop-shadow-md mt-2">
                            <h1 class="text-4xl font-bold ">
                                Population Overview
                            </h1>
                            <div>
                                <a href="documents/print/dashboard_print.php" class="flex px-6 p-1 rounded-xl border-2 border-sg bg-c place-self-center hover:border-c hover:bg-c hover:text-white transition duration-300" target="_blank"> 
                                    <img src="../img/printer.png" class="size-12" alt="">
                                    <button class="text-black">
                                        Print Dashboard
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="grid grid-cols-[18rem_18rem_18rem_auto] rounded-xl">
                            <div class="flex justify-center items-center space-x-4 rounded-l-xl">
                                <div class="flex items-center justify-center bg-c rounded-xl h-20 w-20 hover:border-c hover:animate-wiggle hover:scale-125"> 
                                    <img src="../img/total-res.png" alt="">
                                </div>
                                <div class="flex items-center justify-center flex-col mb-[18px]"> 
                                    <p>Total Household</p>
                                    <p class="text-4xl font-bold"><?= $totalHouseHold ?></p>
                                </div>
                            </div>
                            <div class="flex justify-center items-center space-x-4">
                                <div class="flex items-center justify-center bg-c rounded-xl h-20 w-20 hover:border-c hover:animate-wiggle hover:scale-125"> 
                                    <img src="../img/total-household.png" alt="">
                                </div>
                                <div class="flex items-center justify-center flex-col mb-[18px]"> 
                                    <p>Total Residents</p>
                                    <p class="text-4xl font-bold"><?= $totalRes ?></p>
                                </div>
                            </div>
                            <div class="flex justify-center items-center space-x-4">
                                <div class="flex items-center justify-center bg-c rounded-xl h-20 w-20 hover:border-c hover:animate-wiggle hover:scale-125"> 
                                    <img src="../img/active-res.png" alt="">
                                </div>
                                <div class="flex items-center justify-center flex-col"> 
                                    <p>Active Residents</p>
                                    <p class="text-4xl font-bold"><?= $active ?></p>
                                    <p class="text-sm">out of <?= $totalRes?></p>
                                </div>
                            </div>
                            <div class="flex justify-center items-center space-x-4 rounded-r-xl">
                                <div class="flex items-center justify-center bg-c rounded-xl h-20 w-20 hover:border-c hover:animate-wiggle hover:scale-125"> 
                                    <img src="../img/res-type.png" alt="">
                                </div>
                                <div class="flex items-center justify-center flex-col mb-[8px]"> 
                                    <p>Resident Type</p>
                                    <div class="flex text-center space-x-4">
                                        <div>
                                            <p class="text-2xl font-bold"><?= $permanent ?></p>
                                            <p class="text-sm">Permanent</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-bold"><?= $temporary ?></p>
                                            <p class="text-sm">Temporary</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-bold"><?= $student ?></p>
                                            <p class="text-sm">Student</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Weekly Report -->
                    <div class="grid grid-cols-[75.5%_23.5%] gap-4 border-2 h-full w-full border-sg rounded-xl bg-white p-6">
                        <div class="grid gap-y-4">
                            <div class="flex justify-between items-center w-full drop-shadow-xl">
                                <h1 class="text-4xl font-bold">Document Issuance Data</h1>
                                <h1 class="flex space-x-2 text-gray-500">
                                    <p>This Week</p> 
                                    <img src="../img/arrow-down.png" alt="">
                                </h1>
                            </div>
                            <div class="w-full justify-items-center border-2 rounded-xl border-sg">
                                <canvas id="weeklyReportChart"></canvas>
                            </div>
                        </div>
                        <div class="grid grid-rows-4 gap-y-4">
                            <div class="flex flex-col items-center justify-center bg-[#D9D9D9] rounded-xl">
                                <div class="text-2xl font-bold"><?=$totalDocs?></div>
                                <p class="text-sm">Total documents issued</p>
                            </div>
                            <div class="flex flex-col items-center justify-center bg-[#D9D9D9] rounded-xl">
                                <div class="text-2xl font-bold"><?=$brgyclr?></div>
                                <p class="text-sm">Barangay Clearance</p>
                            </div>
                            <div class="flex flex-col items-center justify-center bg-[#D9D9D9] rounded-xl">
                                <div class="text-2xl font-bold"><?=$certIndigency?></div>
                                <p class="text-sm">Certificate of Indigency</p>
                            </div>
                            <div class="flex flex-col items-center justify-center bg-[#D9D9D9]  rounded-xl">
                                <div class="text-2xl font-bold"><?=$certResidency?></div>
                                <p class="text-sm">Certificate of Residency</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Demographics -->
                <div class="flex flex-col items-center space-y-4  border-2 border-sg rounded-xl bg-white p-6">
                    <h1 class="text-4xl font-bold">
                        Community Metrics
                    </h1>
                    <!-- Age Brackets Chart-->
                    <div class="h-1/2 w-full">
                        <canvas id="ageGroupChart"></canvas>
                    </div>
                    <div class="w-full grow">
                        <div class="grid grid-rows-3 gap-y-4 h-full w-full ">
                            <!-- Gender Breakdown -->
                            <div class="grid grid-cols-2 gap-x-2 rounded-xl text-white">
                                <div class="flex items-center rounded-xl bg-black pr-4">
                                    <img src="../img/male.png" alt="">
                                    <div class="flex flex-col items-center justify-start grow">
                                        <h1 class="text-sm">Male Population</h1>
                                        <p class="text-4xl font-bold"><?=$male?></p>
                                    </div>
                                </div>
                                <div class="flex items-center rounded-xl bg-black pr-2">
                                    <img src="../img/female.png" alt="">
                                    <div class="flex flex-col items-center justify-start grow">
                                        <h1 class="text-sm">Female Population</h1>
                                        <p class="text-4xl font-bold"><?=$female?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Civil Status Breakdown-->
                            <div class="grid grid-rows-[auto_1fr] rounded-xl bg-[#D9D9D9]">
                                <div class="text-sm font-bold px-3 pt-2">
                                    Civil Status
                                </div>
                                <div class="flex justify-between px-4">
                                    <div class="place-items-center text-2xl p-2">
                                        <h1 class="font-bold "><?= $single ?></h1>
                                        <p class="text-xs">SINGLE</p>
                                    </div>
                                    <div class="place-items-center text-2xl p-2">
                                        <h1 class="font-bold "><?= $married ?></h1>
                                        <p class="text-xs">MARRIED</p>
                                    </div>
                                    <div class="place-items-center text-2xl p-2">
                                        <h1 class="font-bold "><?= $divorced ?></h1>
                                        <p class="text-xs">DIVORCED</p>
                                    </div>
                                    <div class="place-items-center text-2xl p-2">
                                        <h1 class="font-bold "><?= $separated ?></h1>
                                        <p class="text-xs">SEPARATED</p>
                                    </div>
                                    <div class="place-items-center text-2xl p-2">
                                        <h1 class="font-bold "><?= $widowed ?></h1>
                                        <p class="text-xs">WIDOWED</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Blood Type -->
                            <div class="grid grid-rows-[auto_1fr] rounded-xl bg-black">
                                <div class="text-sm font-bold px-3 pt-2 text-white">
                                    Blood Type
                                </div>
                                <div class="flex justify-between px-4 ">
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $a_plus ?></h1>
                                        <p class="text-xs text-white">A+</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $a_minus ?></h1>
                                        <p class="text-xs text-white">A-</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $b_plus ?></h1>
                                        <p class="text-xs text-white">B+</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $b_minus ?></h1>
                                        <p class="text-xs text-white">B-</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $ab_plus ?></h1>
                                        <p class="text-xs text-white">AB+</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $ab_minus ?></h1>
                                        <p class="text-xs text-white">AB-</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $o_plus ?></h1>
                                        <p class="text-xs text-white">O+</p>
                                    </div>
                                    <div class="place-items-center text-lg p-2">
                                        <h1 class="font-bold text-pg hover:text-c cursor-default transition duration-700"><?= $o_minus ?></h1>
                                        <p class="text-xs text-white">O-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    // Confirm Delete
    function confirmDeletion(id) {
        document.getElementById("confirmDeletion").classList.remove("hidden");
        document.getElementById("deleteLink").href =' backend/delete.php?id=' + id;
    }
    function cancelConfirmation() {
        document.getElementById("confirmDeletion").classList.add("hidden");
    }
    // Toggle display
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
<script>
    const ageGroupCtx = document.getElementById("ageGroupChart").getContext("2d");
    
    const infant = <?php echo $infantJSON; ?>;
    const toddler = <?php echo $toddlerJSON; ?>;
    const child = <?php echo $childJSON; ?>;
    const teenager = <?php echo $teenagerJSON; ?>;
    const youngAdult = <?php echo $youngAdultJSON; ?>;
    const middleAgedAdult = <?php echo $middleAgedAdultJSON; ?>;
    const seniorAdult = <?php echo $seniorAdultJSON; ?>;
    const totalRes = <?php echo $totalResJSON; ?>;

    const config4 = {
        type: 'bar',
        data: {
            labels: ["Infant", "Toddler", "Child", "Teenager/Adolescent", "Young Adult", "Middle-Aged Adult", "Senior/Older Adult"],
            datasets: [{
                label: "Age Group Distribution",
                data: [infant, toddler, child, teenager, youngAdult, middleAgedAdult, seniorAdult], // Values
                backgroundColor: [
                    'rgba(175, 225, 175, 0.5)',
                    'rgba(175, 225, 175, 0.5)',
                    'rgba(175, 225, 175, 0.5)',
                    'rgba(175, 225, 175, 0.5)',
                    'rgba(175, 225, 175, 0.5)',
                    'rgba(175, 225, 175, 0.5)'
                ],
                borderColor: [
                    'rgba(175, 225, 175, 1)',
                    'rgba(175, 225, 175, 1)',
                    'rgba(175, 225, 175, 1)',
                    'rgba(175, 225, 175, 1)',
                    'rgba(175, 225, 175, 1)',
                    'rgba(175, 225, 175, 1)'
                ],
                borderWidth: 1,
                barThickness: 40 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: false, 
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: totalRes,
                    ticks: {
                        stepSize: totalRes/10,
                    }
                }
            }
        }
    };
    const ageGroupChart = new Chart(ageGroupCtx, config4);
</script>
<script>
    // Weekly Report
    const weeklyReportctx = document.getElementById("weeklyReportChart").getContext("2d");
    const totalDocs = <?php echo $totalDocsJson; ?>;
    const weeklyData = <?php echo json_encode($documentCounts); ?>;

    const config3 = {
      type: 'line', 
      data: {
        labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // X-axis labels
        datasets: [{
          label: 'Documents Issued Weekly', 
          data: weeklyData, 
          borderColor: 'rgba(175, 225, 175, 1)', 
          backgroundColor: 'rgba(175, 225, 175, 0.5)', 
          borderWidth: 2, 
          fill: true, 
          tension: 0.1 
        }]
      },
      options: {
        responsive: true, // Makes the chart responsive
        plugins: {
          legend: {
            display: true, // Show legend
            position: 'top' // Legend position
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Days in a Week', // X-axis title
              fontStyle: 'bold'
            }
          },
          y: {
            title: {
              display: true,
              text: 'Number of Documents Issued' // Y-axis title
            },
            beginAtZero: true, // Start Y-axis at zero\
            min: 0,
            max: totalDocs,
            stepSize: 2,
          }
        }
      }
    };

    const weeklyChart = new Chart(weeklyReportctx, config3);
</script>
</body>
</html>
