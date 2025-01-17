<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
//for timer
if(!hasPermission('system_settings')){
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
                            <button disabled id="setting" onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="flex place-content-center w-full">
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
        <div class="flex flex-col w-full h-screen overflow-hidden"> 
            <!-- Header -->
            <div class="grid grid-cols-2 items-center shadow-md px-8 py-2 stl:py-2 bg-white">
                <div class="text-xl stl:text-3xl ">
                    <b>Barangay Buna Cerca</b>
                    <br>
                    <div class="flex items-center">
                        <p class="text-[20px] italic">Dashboard</p>
                        <?php if(!hasPermission('system_settings')) : ?>
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
            <div class="flex-1 grid grid-cols-[auto_30rem] p-2 stl:p-8 overflow-hidden ">
                <div class="grid grid-rows-[11rem_auto] stl:grid-rows-[13rem_auto]">
                    <!-- Data -->
                    <div class="grid grid-cols-4 mt-4 stl:mt-0 h-32 stl:h-52 pb-0 stl:pb-4 w-full space-x-2 stl:space-x-8">
                        <!-- Total Residents -->
                        <div class="border-2 border-sg rounded-xl bg-white">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/total_res.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-sm flex items-center">Total Households</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center ">
                                <p class="text-lg stl:text-xl"><?php echo $totalHouseHold; ?><br></p>
                                <p class="text-[10px] stl:text-sm py-2">Total number of Households</p>
                            </div>
                        </div> 
                        <!-- Total Residents -->
                        <div class="border-2 border-sg rounded-xl bg-white">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/total_res.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-sm flex items-center">Total Residents</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center">
                                <p class="text-lg stl:text-xl"><?php echo $i; ?><br></p>
                                <p class="text-[10px] stl:text-sm py-2">Total number of registered residents</p>
                            </div>
                        </div> 
                        <!-- Active Residents Population -->
                        <div class="border-2 border-sg rounded-xl bg-white">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/status.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-sm flex items-center">Active Residents</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center">
                                <p class="text-lg stl:text-xl"><?php echo $active; ?> out of <?php echo $i; ?><br></p>
                                <p class="text-[10px] stl:text-sm py-2">Total number of active residents</p>
                            </div>
                        </div>
                        <!-- Total Documents -->
                        <div class="border-2 border-sg rounded-xl bg-white">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/indigency.svg" class="size-6 p-1 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-sm flex items-center">Total Documents</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center ">
                                <p class="text-lg stl:text-xl"><?php echo $n; ?><br></p>
                                <p class="text-[10px] stl:text-sm py-2 ">Total number of documents issued</p>
                            </div>
                        </div>
                    </div>
                    <!-- Weekly Report -->
                    <div class="border-2 h-full w-full border-sg rounded-xl p-4 stl:p-8 bg-white">
                        <div class="w-auto h-full stl:w-full stl:h-[33rem] justify-items-center border-2 rounded-xl border-sg">
                            <canvas id="weeklyReportChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Pie Charts -->
                <div class="grid grid-rows-[44px_auto_auto] h-full w-full pl-4 gap-y-4 overflow-hidden ">
                    <div class="place-self-center w-full">
                        <a href="documents/print/dashboard_print.php" target="_blank"> 
                            <button class="rounded-md w-full border-2 border-sg bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">
                            Print Report
                            </button>
                        </a>
                    </div>
                    <div class="border-2 border-sg rounded-xl flex justify-center bg-white">
                        <div class=" w-80 h-80 p-4">
                            <canvas id="genderChart" class="max-w-full"></canvas>
                        </div>
                    </div>
                    <div class="border-2 border-sg rounded-xl flex justify-center bg-white ">
                        <div class="w-80 h-80 p-4">
                            <canvas id="documentChart" class="max-w-full"></canvas>
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
    // Gender Chart
    const genderctx = document.getElementById("genderChart").getContext("2d");
    const male = <?php echo $maleJSON; ?> // use the converted JSON in this script
    const female = <?php echo $femaleJSON; ?>
    // Data config
    const config1 = {
        type: 'pie',
        data: {
        labels: ["Female", "Male"],
            datasets: [{
                label: "Gender Breakdown",
                data: [female, male], //Values
                backgroundColor: [
                'rgba(0, 0, 0, 0)',
                'rgba(175, 225, 175, 1)',
            ],
            borderColor: [
                'rgba(76, 147, 76, 1)',
                'rgba(76, 147, 76, 1)',
            ],
            borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Gender Breakdown'
                }
            }
        }
    };
    const genderChart = new Chart(genderctx, config1);
</script>
<script>
    // Document Chart
    const documentctx = document.getElementById("documentChart").getContext("2d");
    const brgyclr = <?php echo $brgyclrJSON; ?> // use the converted JSON in this script
    // Data config
    const config2 = {
        type: 'pie',
        data: {
        labels: ["Barangay Clearance", "Certificate of Indigency", "Certificate of Residency"],
            datasets: [{
                label: "Documents Issued Breakdown",
                data: [brgyclr, male, female], //Values
                backgroundColor: [
                'rgba(0, 0, 0, 0)',
                'rgba(175, 225, 175, 1)',
                'rgba(76, 147, 76, 1)',
            ],
            borderColor: [
              'rgba(76, 147, 76, 1)',
              'rgba(76, 147, 76, 1)',
              'rgba(76, 147, 76, 1)',
            ],
            borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Documents Issued Breakdown'
                }
            }
        }
    };
    const documentChart = new Chart(documentctx, config2);
</script>
<script>
    // Weekly Report
    const weeklyReportctx = document.getElementById("weeklyReportChart").getContext("2d");

    // Pass PHP data to JavaScript
    const weeklyData = <?php echo json_encode($documentCounts); ?>;

    const config3 = {
      type: 'line', // Chart type
      data: {
        labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // X-axis labels
        datasets: [{
          label: 'Documents Issued Weekly', // Dataset label
          data: weeklyData, // Data points from PHP
          borderColor: 'rgba(175, 225, 175, 1)', // Line color
          backgroundColor: 'rgba(175, 225, 175, 0.5)', // Fill under the line
          borderWidth: 2, // Line width
          fill: true, // Fill the area under the line
          tension: 0.1 // Smooth curve (0.1 for a slight curve, 0 for straight lines)
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
            max: 20,
            stepSize: 2,
          }
        }
      }
    };

    const weeklyChart = new Chart(weeklyReportctx, config3);
</script>
</body>
</html>
