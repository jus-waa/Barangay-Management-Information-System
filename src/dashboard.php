<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
//require login first
if (!isset($_SESSION['users'])) {
    header('location: login.php');
    exit();
}

//for resident info
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from resident info
$i = 0;
$male = 0;
$female = 0;
$active = 0;
$inactive = 0;
foreach ($result as $row) {
    // for total residents
    $i++;
    // for no. of male and female
    if ($row['gender'] == 'Male') {
        $male++;
    } else if ($row['gender'] == 'Female') {
        $female++;
    }
    // for active residents
    if ($row['status'] == 'Active') {
        $active++;
    } else if ($row['status'] == 'Inactive') {
        $inactive++;
    }
}
$maleJSON = json_encode($male); // convert into JSON
$femaleJSON = json_encode($female);

//for print history
$stmt = $dbh->prepare("SELECT * FROM `print_history`");
$stmt->execute();
$result_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from print history
$n = 0; //total number of printed docs
$brgyclr = 0;
foreach ($result_history as $rows) {
    $n++;
    //for no of brgy clearance
    if($rows['document_type'] === 'Barangay Clearance') {
        $brgyclr++;
    }
}
$brgyclrJSON = json_encode($brgyclr); // convert into JSON

// Get the current date
$currentDate = date('Y-m-d');
    
// Get the start of the week (Sunday) and end of the week (Saturday)
$startOfWeek = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
$endOfWeek = date('Y-m-d', strtotime('next saturday', strtotime($currentDate)));

// Prepare the SQL query to fetch document counts by day of the week
$sql = "SELECT DAYOFWEEK(print_date) AS day_of_week, COUNT(*) AS documents_count
        FROM print_history
        WHERE print_date BETWEEN :startOfWeek AND :endOfWeek
        GROUP BY day_of_week";

// Prepare the statement
$stmt = $dbh->prepare($sql);

// Bind parameters
$stmt->bindParam(':startOfWeek', $startOfWeek);
$stmt->bindParam(':endOfWeek', $endOfWeek);

// Execute the statement
$stmt->execute();

// Initialize an array for storing document counts for each day
$documentCounts = array_fill(0, 7, 0); // Default 0 for each day

// Fetch the results and update the document counts array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dayIndex = $row['day_of_week'] - 1; // MySQL DAYOFWEEK() returns 1 for Sunday, 7 for Saturday
    $documentCounts[$dayIndex] = $row['documents_count'];
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
        <div class="flex flex-col w-full h-screen overflow-hidden"> 
            <!-- Header -->
            <div class="shadow-md px-20 py-2 stl:px-32 stl:py-6">
                <div class="text-xl stl:text-3xl">
                    Dashboard
                </div>
            </div>
            <!-- Body -->
            <div class="flex-1 grid grid-cols-[auto_30rem] p-2 stl:p-8 overflow-hidden">
                <div class="grid grid-rows-[11rem_auto] stl:grid-rows-[13rem_auto]">
                    <!-- Data -->
                    <div class="h-32 grid grid-cols-4 mt-4 stl:mt-0 stl:h-52 pb-0 stl:pb-8 w-full stl:w-full space-x-2 stl:space-x-8">
                        <!-- Total Residents -->
                        <div class="border-2 border-sg rounded-xl">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/total_res.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-base flex items-center">Total Residents</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center">
                                <p class="text-lg stl:text-2xl"><?php echo $i; ?><br></p>
                                <p class="text-[10px] stl:text-base py-2 stl:block">Total number of registered residents</p>
                            </div>
                        </div>          
                        <!-- Total Documents -->
                        <div class="border-2 border-sg rounded-xl">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/indigency.svg" class="size-6 p-1 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-base flex items-center">Total Documents</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center">
                                <p class="text-lg stl:text-2xl"><?php echo $n; ?><br></p>
                                <p class="text-[10px] stl:text-base py-2 stl:block">Total number of documents issued</p>
                            </div>
                        </div>
                        <!-- Active Residents Population -->
                        <div class="border-2 border-sg rounded-xl">
                            <div class="flex p-2 stl:p-4 border-b-2 border-sg bg-c rounded-t-xl">
                                <img src="../img/status.png" class="size-6 p-0.5 bg-white rounded-md mr-2" alt="">
                                <p class="text-xs stl:text-base flex items-center">Active Residents</p>
                            </div>
                            <div class="h-3/5 flex flex-col justify-center items-center text-center">
                                <p class="text-lg stl:text-2xl"><?php echo $active; ?> out of <?php echo $i; ?><br></p>
                                <p class="text-[10px] stl:text-base py-2 stl:block">Total number of active residents</p>
                            </div>
                        </div>
                    </div>
                    <!-- Weekly Report -->
                    <div class="border-2 h-full w-full border-sg rounded-xl p-4 stl:p-8">
                        <div class="w-auto h-full stl:w-full stl:h-[33rem] justify-items-center border-2 rounded-xl border-sg">
                            <canvas id="weeklyReportChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Pie Charts -->
                <div class="grid grid-rows-2 h-full w-full pl-8 gap-y-8 overflow-hidden">
                    <div class="border-2 border-sg rounded-xl">
                        <div class="h-full w-full flex justify-center p-4">
                            <canvas id="genderChart" class="max-w-full"></canvas>
                        </div>
                    </div>
                    <div class="border-2 border-sg rounded-xl">
                        <div class="h-full w-full flex justify-center p-4">
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
