<?php
session_start();
include("backend/connection.php");
include("backend/helper.php");
//require login first
if (!isset($_SESSION['users'])) {
    header('location: login.php');
    exit();
}
// fetch data
$stmt = $dbh->prepare("SELECT * FROM `print_history`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="w-full h-screen"> 
            <!-- Header -->
            <div class="grid gap-x-10 grid-cols-2 shadow-md px-32 py-6 mb-20 ">
                <div class="text-3xl">
                    Print History
                </div>
            </div>
            <!-- Options -->
            <div class="flex justify-between items-center">
                <!-- Categories -->
                <div class="ml-32">
                    <p class="border-b-4 border-sg text-black py-1 px-3 hover:border-sg rounded-sm">
                        History of Documents Issued
                    </p>
                    
                </div>
            </div>
            <!-- Tables -->
            <div class="overflow-hidden mt-4 w-full">
                <div class="border-2 border-c rounded-lg mx-32">
                    <!-- Report Page Table -->
                    <div id="tb1" class="overflow-auto no-scrollbar" style="height: 67vh;">
                        <div class="rounded-t-sm pt-2 bg-[#AFE1AF]">
                            <table id="residentTable" class="w-full border-collapse">
                                <colgroup>
                                    <col class="w-[100px]">
                                    <col class="w-[200px]">
                                    <col class="w-[200px]">
                                    <col class="w-[200px]">
                                    <col class="w-[200px]">
                                    <col class="w-[200px]">
                                    <col class="w-[100px]">
                                    <col>
                                </colgroup>
                                <thead class="bg-c sticky top-0 ">
                                    <tr class="uppercase ">
                                        <th class="py-4 min-w-20">ID</th>
                                        <th class="py-4">Resident Name</th>
                                        <th class="py-4">Type of Document</th>
                                        <th class="py-4">Date of Printing</th>
                                        <th class="py-4">Control Number</th>
                                        <th class="py-4">Issued By</th>
                                        <th class="py-4">Status</th>
                                        <th class="py-4">Purpose</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 bg-white">
                                    <?php 
                                    $i = 1; // auto numbering
                                    foreach ($result as $row) {
                                    ?>
                                    <tr class="hover:bg-gray-100  text-center">
                                        <td class="border-y-2 border-[#AFE1AF] py-4"> 
                                            <div class="flex justify-center min-w-20">
                                                <?= $i ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2"> 
                                            <div class="flex justify-center">
                                                <?= $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2"> 
                                            <div class="flex justify-center">
                                                <?= $row['document_type'] ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2">
                                            <div class="flex justify-center">
                                                <?= $row['print_date'] ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2"> 
                                            <div class="flex justify-center">
                                                <?= $row['control_number'] ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2"> 
                                            <div class="flex justify-center">
                                                <?= $row['issued_by'] ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2"> 
                                            <div class="flex justify-center">
                                                <?= $row['status'] ?>
                                            </div>
                                        </td>
                                        <td class="border-y-2 border-[#AFE1AF] py-2"> 
                                            <div class="flex justify-center">
                                                <?= $row['purpose'] ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class=" h-6 rounded-b-sm border-2 border-c bg-c"></div>
                </div>
            </div>
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
<script>
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
</body>
</html>
