<?php
session_start();
include("../backend/connection.php");
require("../backend/helper.php");
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//require login first
if (!isset($_SESSION['users'])) {
    header('location: login.php');
    exit();
}

// add to printhistory
if (isset($_POST['confirm'])) {
    try{
        $first_name = $_POST['first_name']; 
        $middle_name =  $_POST['middle_name']; 
        $last_name =  $_POST['last_name'];
        $document_type = 'Barangay Clearance';
        $print_date = $_POST['print_date'];
        $control_number = $_POST['control_number'];
        $issued_by = $_POST['issued_by'];
        $status = $_POST['status'];
        $purpose = $_POST['purpose'];
       
        $query = "INSERT INTO `print_history`(`resident_name`, `document_type`, `print_date`, `control_number`, `issued_by`, `status`, `purpose`) VALUES (:resident_name, :document_type, :print_date, :control_number, :issued_by, :status, :purpose)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':document_type', $document_type, PDO::PARAM_STR);
        $stmt->bindParam(':print_date', $print_date, PDO::PARAM_STR);
        $stmt->bindParam(':control_number', $control_number, PDO::PARAM_STR);
        $stmt->bindParam(':issued_by', $issued_by, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
        $stmt->execute();

        // Get ID of selected record
        $lastInsertId = $dbh->lastInsertId();

        if ($stmt) {
            echo "<script>alert('Data successfully inserted into print_history.');</script>";
            header("Location: print/brgyclearance_print.php?id=" . $lastInsertId);
            exit;
            } else {
            echo "<script>alert('Failed to insert data: " . $e->getMessage() . "');</script>";
            echo "<script>window.location.href = 'brgyclearance.php';</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['cancel'])){
    header("location: brgyclearance.php?msg= operation cancelled.");
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../../script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body class="relative h-screen w-full bg-cover bg-center bg-fixed">
    <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../../img/indang.webp'); filter: blur(2px); z-index: -1;"></div>
    <div class="flex justify-center place-items-center flex-col h-full relative z-10">
        <!-- Main Content -->
        <div class="w-4/5 p-6 mt-4 bg-white rounded-lg">
            <!-- Back and Select from records button -->
            <div class="grid grid-cols-2 items-center">
                <!-- Back Button -->
                <div class="grid justify-items-start pl-2">
                    <div class="flex">
                        <div>
                            <a href="../generatedocuments.php" class="flex items-center p-2 rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700""><img src="../../img/back.png" class="size-4" alt="select from records"></a>
                        </div>
                        <p class="flex justify-start items-center w-48 p-2 text-gray-400 ">Back</p>
                    </div>
                </div>
                <!-- Select from records -->
                <div class="grid justify-items-end ">
                    <div class="flex">
                        <p class="flex justify-end w-48 p-2 text-gray-400 ">Select from Records</p>
                        <div >
                            <button class="rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700" onclick="selectRecords()"><img src="../../img/residency.svg" class="size-10 p-2" alt="select from records"></button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="personal_info">
                <?php 
                $id = isset($_GET['id']) ? $_GET['id'] : 0;
                $recordLoaded = false;

                if($id) {
                    $query = "SELECT * FROM `resident_info` WHERE `id` = :id";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute(['id' => $id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        $recordLoaded = true;
                    } else {
                        $row = [];
                    }
                }
                
                $defaultValues = [
                    'first_name' => '',
                    'middle_name' => '',
                    'last_name' => '',
                    'suffix' => '',
                    'house_num' => '',
                    'street_name' => '',
                    'barangay_name' => '',
                    'municipality_city' => '',
                    'zip_code' => '',
                ];
                ?>
                <!-- Two-column Grid -->
                <div class="grid grid-cols-2 gap-20">
                    <!-- First Column: Personal Information and Purpose -->
                    <div>
                        <!-- Personal Information -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-xl font-bold mb-4">Personal Information</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                                    <div>
                                        <input id="first-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['first_name'] : $defaultValues['first_name']?>" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">First Name</label>
                                        <span id="first-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <div class="relative">
                                        <input id="middle-name" name="middle_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['middle_name'] : $defaultValues['middle_name']?>" placeholder=" "/> 
                                        <label id="middle-name-label" class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Middle Name</label>
                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <span class="flex-grow"></span>
                                            <input type="checkbox" id="no-middle-name" class="mr-2 border-gray-400" />
                                            <label for="no-middle-name" class="text-sm text-gray-500 mr-4">No Middle Name</label>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="last-name" name="last_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['last_name'] : $defaultValues['last_name']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Last Name</label>
                                            <span id="last-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                        </div>
                                        <div for="suffix" class="flex flex-col flex-grow">
                                            <?php
                                            $suffixOptions = ["", "Jr.", "Sr.", "II", "III", "IV", "V", "PhD", "MD", "Esq."];
                                            ?>
                                            <select id="suffix" name="suffix" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                                <?php foreach ($suffixOptions as $suffix): ?>
                                                    <option value="<?= $suffix ?>" 
                                                        <?= ($recordLoaded ? $row['suffix'] : $defaultValues['suffix']) == $suffix ? "selected" : "" ?>>
                                                        <?= $suffix == "" ? "Select Suffix" : $suffix?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Control Number and Date of Issuance -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-xl font-bold mb-4">Control Number & Date of Issuance</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                                    <div>
                                        <input id="control-number" name="control_number" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Control Number</label>
                                        <span id="control-number-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <div class="relative">
                                        <input id="date-of-issuance" name="print_date" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <span id="date-of-issuance-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Second Column: Address, Control Number, and Date of Issuance -->
                    <div>
                        <!-- Address Details -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-xl font-bold mb-4">Address Details</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                                    <div>
                                        <input id="house-number" name="house_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['house_num'] : $defaultValues['house_num']?>" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">House Number</label>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="street-name" name="street_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['street_name'] : $defaultValues['street_name']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Street Name</label>
                                        </div>
                                        <div class="flex-grow">
                                            <input id="barangay-name" name="barangay_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['barangay_name'] : $defaultValues['barangay_name']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Barangay Name</label>
                                        </div>
                                    </div>
                                    <div for="suffix" class="flex flex-col flex-grow">
                                        <select name="status" class="text-black border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                            <option class="bg-white text-gray-500" value="">Status</option>
                                            <option class="bg-white" value="Pending">Pending</option>
                                            <option class="bg-white" value="Approved">Approved</option>
                                            <option class="bg-white" value="For Printing">For Printing</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Issued By & Purpose -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-xl font-bold mb-4">Purpose & Issued By</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                                    <div class="relative">
                                        <input id="purpose" name="purpose" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Purpose</label>
                                        <span id="purpose-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <div class="relative">
                                        <input id="issued-by" name="issued_by" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Issued By</label>
                                        <span id="issued-by-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-end items-center gap-2">
                    <!-- Old Print (Copy Later)
                    <a href="print/brgyclearance_print.php?id=<?= $row['id']?>">
                        <button class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">Print </button>
                    </a>
                    -->
                    <button id="add-button" type="button" class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300" onclick="confirmPrint(<?= $row['id'] ?>)">
                        Print
                    </button>
                    <a href="../generatedocuments.php">
                        <button id="cancel-button" class="rounded-md border-2 border-c w-32 p-2 place-self-center hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700">Cancel</button>
                    </a>
                </div>
                <!-- Confirm Print -->
                <div class="fixed inset-0 z-50 hidden" id="confirmPrint">
                    <div class="w-screen h-screen flex justify-center items-center">
                        <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                        <div class="relative grid grid-cols-1 grid-rows-2 h-72 w-96 overflow-auto rounded-md bg-white z-10">
                            <div class="grid justify-center">
                                <div class="text-3xl font-bold place-self-center mt-12">Confirm Print?</div>
                                <div class="mb-24 mt-4">Do you confirm this record?</div>
                            </div>
                            <div class="flex justify-center space-x-4 mt-6">
                                <button  type="submit" name="confirm" class="bg-sg rounded-md w-32 h-12">
                                <input  type="hidden" name="selected_id" value="<?= $row['id'] ?>">
                                    Yes, Confirm 
                                </button>
                                <button name="cancel"  class="bg-sg rounded-md w-32 h-12" onclick="cancelConfirmation()">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>   
        </div>
        <!-- Bottom Logo -->
        <div class="w-full flex justify-center mt-12">
            <img src="../../img/coat.png" alt="Bottom Image" class="w-[100px] h-[100px] object-contain">
        </div>
        <!--Select from Records -->
        <div class="fixed z-50 hidden" id="selectRecords">
            <div class=" w-screen h-screen flex justify-center items-center flex-col ">
                <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                <div class="relative flex flex-col h-full w-4/12 overflow-auto bg-white z-10 my-10  border-4 border-c rounded-xl ">
                    <div class="grid justify-center h-full w-full grow-0">
                    <!-- Search -->
                        <div class="flex justify-center items-center mt-2">
                            <form method="post">
                                <input name="search" id="search" type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none focus:ring-2 ring-c h-8 transition duration-300">
                                <button id="searchBtn" class="rounded-md absolute right-54 top-[26px] transform -translate-y-1/2 border-gray-300 p-2 h-8 flex items-center justify-center pointer-events-none">
                                </button>
                            </form>
                        </div>
                        <!-- Tables -->
                        <div class="h-full w-screengrow">
                            <div class="overflow-hidden w-full mt-2">
                                <div class="border-2 border-c rounded-lg mx-4">
                                    <!--Personal Information Table -->
                                    <div id="tb1" class="overflow-auto no-scrollbar"  style="height: 70vh;">
                                    <div class="rounded-t-sm pt-2 bg-c ">
                                        <table id="residentTable" class="w-full border-collapse">
                                            <colgroup>
                                                <col class="w-[200px]">
                                                <col class="w-[400px]">
                                                <col class="w-[200px]">
                                            </colgroup>
                                            <thead class="bg-c sticky top-0 ">
                                            <tr class="uppercase ">
                                                <!--Basic Information + Action-->
                                                <th class="py-4 min-w-20">ID</th>
                                                <th class="py-4">Name</th>
                                                <th class="min-w-20">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class=" text-gray-600 bg-white">
                                                <?php 
                                                $i = 1; //auto numbering
                                                foreach ($result as $row) {
                                                ?>
                                                <tr class="hover:bg-gray-100">
                                                    <td class="border-y-2 border-c ">
                                                        <div class="flex justify-center min-w-20">
                                                            <?= $i ?>
                                                        </div>
                                                    </td>
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center">
                                                            <?=$row['first_name']?>
                                                            <?=$row['middle_name']?>
                                                            <?=$row['last_name']?>
                                                        </div>
                                                    </td>
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center items-center h-20 grow">
                                                            <a href="brgyclearance.php?id=<?= $row['id']?>">
                                                                <button name="select" class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">
                                                                Select
                                                                </button>
                                                            </a>
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
                            <div class="flex justify-center items-center p-4 grow ">
                                <button class="rounded-md border-2 border-c w-32 p-2 place-self-center hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700" onclick="cancelSelect()">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    //confirm deletion
    function selectRecords() {
        document.getElementById("selectRecords").classList.remove("hidden");
    }
    function cancelSelect() {
        document.getElementById("selectRecords").classList.add("hidden");
    }
    //confirm print
    function confirmPrint() {
        document.getElementById("confirmPrint").classList.remove("hidden");
    }
    function cancelConfirmation() {
        document.getElementById("confirmPrint").classList.add("hidden");
    }

    //script for requiring input fields
    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("personal_info");
    const firstNameInput = document.getElementById("first-name");
    const lastNameInput = document.getElementById("last-name");
    const controlNumberInput = document.getElementById("control-number");
    const dateIssuedInput = document.getElementById("date-of-issuance");
    const purposeInput = document.getElementById("purpose");
    const issuedByInput = document.getElementById("issued-by");

    const firstNameError = document.getElementById("first-name-error");
    const lastNameError = document.getElementById("last-name-error");
    const controlNumberError = document.getElementById("control-number-error");
    const dateIssuedError = document.getElementById("date-of-issuance-error");
    const purposeError = document.getElementById("purpose-error");
    const issuedByError = document.getElementById("issued-by-error");

    const addButton = document.getElementById("add-button"); // Assume the Add button has this ID
    const cancelButton = document.getElementById("cancel-button"); // Assume the Cancel button has this ID

    form.addEventListener("submit", (event) => {
            let isValid = true;
            let firstInvalidElement = null;

            // Validate First Name
            if (!firstNameInput.value.trim()) {
                isValid = false;
                firstNameError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || firstNameInput;
            } else {    
                firstNameError.classList.add("hidden");
            }

            // Validate Last Name
            if (!lastNameInput.value.trim()) {
                isValid = false;
                lastNameError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || lastNameInput;
            } else {
                lastNameError.classList.add("hidden");
            }

            // Validate Control Number
            if (!controlNumberInput.value.trim()) {
                isValid = false;
                controlNumberError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || controlNumberInput;
            } else {
                controlNumberError.classList.add("hidden");
            }

            // Validate Date issued
            if (!dateIssuedInput.value.trim()) {
                isValid = false;
                dateIssuedError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || dateIssuedInput;
            } else {
                dateIssuedError.classList.add("hidden");
            }

            // Validate Purpose
            if (!purposeInput.value.trim()) {
                isValid = false;
                purposeError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || purposeInput;
            } else {
                purposeError.classList.add("hidden");
            }

            // Validate Issued By
            if (!issuedByInput.value.trim()) {
                isValid = false;
                issuedByError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || issuedByInput;
            } else {
                issuedByError.classList.add("hidden");
            }
            
            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
                firstInvalidElement.scrollIntoView({ behavior: "smooth", block: "center" });
                firstInvalidElement.focus();
                document.getElementById("confirmPrint").classList.add("hidden");
            } 
        });
        // Cancel Button: Redirect to another page
        cancelButton.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent default button behavior
            // Redirect to another page (replace 'your-page-url' with the actual URL)
            window.location.href = "../residentpage.php"; 
        });
    });
    
    </script>
    <script>
    //for contact number
    $(document).ready(function() {
        // Input mask for the phone number
        $('#phone').inputmask({
            mask: '+63 999 999 9999',
            placeholder: ' ',
            showMaskOnHover: true,
            showMaskOnFocus: true
        });

        // Checkbox functionality for No Middle Name
        $('#no-middle-name').change(function() {
            if ($(this).is(':checked')) {
                $('#middle-name').prop('disabled', true).css('background-color', '#f0f0f0'); // Turn gray and disable
                $('#middle-name-label').prop('disabled', true).css('background-color', '#f0f0f0'); // Turn gray and disable
            } else {
                $('#middle-name').prop('disabled', false).css('background-color', 'white'); // Enable and reset color
                $('#middle-name-label').prop('disabled', false).css('background-color', 'white'); // Enable and reset color
            }
        });
    });
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
</body>
</html>
