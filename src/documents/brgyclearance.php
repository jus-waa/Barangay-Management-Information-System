<?php
include("../backend/connection.php");
include("../backend/pagination.php");
require("../backend/helper.php");

$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//require login first
if (!isset($_SESSION['users'])) {
    header('location: login.php');
    exit();
}
//check user for issued by
$userId = $_SESSION['users'];
$sql = 'SELECT * FROM users WHERE id = :id';  
$stmtuser = $dbh->prepare($sql);
$stmtuser->bindParam(':id', $userId, PDO::PARAM_INT);  
$stmtuser->execute();
$resultUser = $stmtuser->fetch(PDO::FETCH_ASSOC);
// add to printhistory
if (isset($_POST['confirm'])) {
    try{
        $first_name = $_POST['first_name']; 
        $middle_name =  $_POST['middle_name']; 
        $last_name =  $_POST['last_name'];
        $suffix = $_POST['suffix'];
        $age = $_POST['age'];
        $document_type = 'Barangay Clearance';
        $barangay_name = 'Barangay Buna Cerca';
        $print_date = $_POST['print_date'];
        $control_number = $_POST['control_number'];
        $ctc_number = $_POST['ctc_number'];
        $issued_by = $resultUser['username'];
        $purpose = $_POST['purpose'];
        
        if($middle_name == NULL) {
            $middle_name = '';
        }
        if($suffix == NULL) {
            $suffix = '';
        }
 
        $query = "INSERT INTO `print_history`(`first_name`, `middle_name`, `last_name`,  `suffix`, `age`, `document_type`, `barangay_name` ,`print_date`, `control_number`, `ctc_number`,  `issued_by`, `purpose`) VALUES (:first_name, :middle_name, :last_name, :suffix, :age, :document_type, :barangay_name, :print_date, :control_number, :ctc_number, :issued_by, :purpose)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':document_type', $document_type, PDO::PARAM_STR);
        $stmt->bindParam(':barangay_name', $barangay_name, PDO::PARAM_STR);
        $stmt->bindParam(':print_date', $print_date, PDO::PARAM_STR);
        $stmt->bindParam(':control_number', $control_number, PDO::PARAM_STR);
        $stmt->bindParam(':ctc_number', $ctc_number, PDO::PARAM_STR);
        $stmt->bindParam(':issued_by', $issued_by, PDO::PARAM_STR);
        $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
        $stmt->execute();

        // Get ID of selected record
        $lastInsertId = $dbh->lastInsertId();

        if ($stmt) {
            //header("Location: print/brgyclearance_print.php?id=" . $lastInsertId);
            echo "<script>
                window.open('print/brgyclearance_print.php?id=$lastInsertId', '_blank');
                window.open('../generatedocuments.php', '_self');
            </script>";
            exit;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} 
if (isset($_POST['confirmPrintSignature'])) {
    try{
        $first_name = $_POST['first_name']; 
        $middle_name =  $_POST['middle_name']; 
        $last_name =  $_POST['last_name'];
        $suffix = $_POST['suffix'];
        $age = $_POST['age'];
        $document_type = 'Barangay Clearance';
        $barangay_name = 'Barangay Buna Cerca';
        $print_date = $_POST['print_date'];
        $control_number = $_POST['control_number'];
        $ctc_number = $_POST['ctc_number'];
        $issued_by = $resultUser['username'];
        $purpose = $_POST['purpose'];
        
        if($middle_name == NULL) {
            $middle_name = '';
        }
        if($suffix == NULL) {
            $suffix = '';
        }
 
        $query = "INSERT INTO `print_history`(`first_name`, `middle_name`, `last_name`,  `suffix`, `age`, `document_type`, `barangay_name` ,`print_date`, `control_number`, `ctc_number`,  `issued_by`, `purpose`) VALUES (:first_name, :middle_name, :last_name, :suffix, :age, :document_type, :barangay_name, :print_date, :control_number, :ctc_number, :issued_by, :purpose)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':document_type', $document_type, PDO::PARAM_STR);
        $stmt->bindParam(':barangay_name', $barangay_name, PDO::PARAM_STR);
        $stmt->bindParam(':print_date', $print_date, PDO::PARAM_STR);
        $stmt->bindParam(':control_number', $control_number, PDO::PARAM_STR);
        $stmt->bindParam(':ctc_number', $ctc_number, PDO::PARAM_STR);
        $stmt->bindParam(':issued_by', $issued_by, PDO::PARAM_STR);
        $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
        $stmt->execute();

        // Get ID of selected record
        $lastInsertId = $dbh->lastInsertId();

        if ($stmt) {
            //header("Location: print/brgyclearance_print.php?id=" . $lastInsertId);
            echo "<script>
                window.open('print/brgyclearance_print_signatured.php?id=$lastInsertId', '_blank');
                window.open('../generatedocuments.php', '_self');
            </script>";
            exit;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <link rel="icon" type="image/x-icon" href="../../img/buna_cerca.png">
    <script src="../../script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body class="relative h-screen w-full bg-cover bg-center bg-fixed">
    <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../../img/bunacerca-bg.png'); filter: blur(5px); z-index: -1;"></div>
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
                        <p class="flex justify-start items-center w-48 p-2 ">Back</p>
                    </div>
                </div>
                <?php
                    $isEnabled = isset($_GET['id']); // Check if 'id' exists in the URL
                ?>
                <!-- Select from records -->
                <div class="grid justify-items-end">
                    <div class="flex">
                        <p class="flex justify-end w-48 p-2 ">Select from Records</p>
                        <div>
                            <button class=" rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700" onclick="selectRecords();"><img src="../../img/residency.svg" class="size-10 p-2" alt="select from records"></button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="personal_info">
                <fieldset <?= $isEnabled ? '' : 'disabled' ?>>
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
                        'age' => '',
                        'barangay_name' => 'Barangay Buna Cerca',
                    ];
                    ?>
                <!-- Two-column Grid -->
                <div class="grid grid-cols-2 gap-10 std:gap-20">
                    <!-- First Column: Personal Information and Purpose -->
                    <div>                      
                        <!-- Personal Information -->
                        <div class="rounded-lg p-2 mb-8 ">
                            <div>
                                <h2 class="text-lg font-bold mb-4">Personal Information</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md transition duration-700 hover:border-sg text-sm std:text-base">
                                    <div>
                                        <input id="first-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg pointer-events-none" value="<?php echo $recordLoaded ? $row['first_name'] : $defaultValues['first_name']?>" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">First Name</label>
                                        <span id="first-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <div class="relative">
                                        <input id="middle-name" name="middle_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg pointer-events-none" value="<?php echo $recordLoaded ? $row['middle_name'] : $defaultValues['middle_name']?>" placeholder=" "/> 
                                        <label id="middle-name-label" class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Middle Name</label>
                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <span class="flex-grow"></span>
                                            <input type="checkbox" id="no-middle-name" class="mr-2 border-gray-400" disabled/>
                                            <label for="no-middle-name" class="text-sm text-gray-500 mr-4">No Middle Name</label>
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                            <input id="last-name" name="last_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg pointer-events-none" value="<?php echo $recordLoaded ? $row['last_name'] : $defaultValues['last_name']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Last Name</label>
                                            <span id="last-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                        </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="age" name="age" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg pointer-events-none" value="<?php echo $recordLoaded ? $row['age'] : $defaultValues['age']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Age</label>
                                        </div>
                                        <div for="suffix" class="flex flex-col flex-grow">
                                            <?php
                                            $suffixOptions = ["", "Jr.", "Sr.", "II", "III", "IV", "V", "PhD", "MD", "Esq."];
                                            ?>
                                            <select id="suffix" name="suffix" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg p-2.1 text-sm pointer-events-none">
                                                <?php foreach ($suffixOptions as $suffix): ?>
                                                    <option value="<?= $suffix ?>" 
                                                        <?= ($recordLoaded ? ($row['suffix'] ?? '') : ($defaultValues['suffix'] ?? '')) == $suffix ? "selected" : "" ?>>
                                                        <?= $suffix == "" ? "Select Suffix" : $suffix ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Barangay -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-lg font-bold mb-4">Barangay</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 text-sm std:text-base rounded-md transition duration-700 hover:border-sg <?= $isEnabled ? '' : 'hover:animate-shake' ?>">
                                    <div class="flex-grow">
                                        <input id="barangay-name" name="barangay_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['barangay_name'] : $defaultValues['barangay_name']?>" placeholder=" " disabled/>
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Barangay Name</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Second Column: Address, Control Number, and Date of Issuance -->
                    <div>
                        <!-- CTC number, Control Number and Date of Issuance -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-lg font-bold mb-4">CTC number, Control Number & Date of Issuance</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 text-sm std:text-base rounded-md hover:border-sg transition duration-700 <?= $isEnabled ? '' : 'hover:animate-shake' ?>">
                                    <?php 
                                    // fetch data
                                    $stmt = $dbh->prepare("SELECT * FROM `print_history`");
                                    $stmt->execute();
                                    $print = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $controlNumber = count($print) + 80;
                                    $formattedControlNumber = sprintf("%04d", $controlNumber);
                                    ?>
                                    <div>
                                        <input id="control-number" name="control_number" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg pointer-events-none" value="BC-<?= $formattedControlNumber ?>" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Control Number</label>
                                    </div>
                                    <div class="relative">
                                        <input id="ctc-number" name="ctc_number" type="number" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/>
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">CTC Number</label>
                                        <span id="ctc-number-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <div class="relative">
                                        <input id="date-of-issuance" name="print_date" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <span id="date-of-issuance-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Issued By & Purpose -->
                        <div class="rounded-lg p-2 mb-8">
                            <div>
                                <h2 class="text-lg font-bold mb-4">Purpose & Issued By</h2>
                                <div class="border-2 grid grid-cols-1 gap-4 p-6 text-sm std:text-base rounded-md hover:border-sg transition duration-700 <?= $isEnabled ? '' : 'hover:animate-shake' ?>">
                                    <div class="relative">
                                        <input id="purpose" name="purpose" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Purpose</label>
                                        <span id="purpose-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <?php
                                        if ($resultUser) {
                                    ?>
                                    <div class="relative">
                                        <input id="issued-by" name="issued_by" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?= $resultUser['username'] ?>" placeholder=" " disabled/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Issued By</label>
                                        <span id="issued-by-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <?php 
                                        }   else {
                                            echo "No such user found.";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <!-- Old Print (Copy Later)
                    <a href="print/brgyclearance_print.php?id=<?= $row['id']?>">
                        <button class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">Print </button>
                    </a>
                    -->
                    <button type="button" class="rounded-md w-48 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300" onclick="confirmPrintSig(<?= $row['id'] ?>)">
                        Print on <b>Template</b>
                    </button>
                    <div class="flex justify-end items-center gap-2">
                        <button id="add-button" type="button" class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300" onclick="confirmPrint(<?= $row['id'] ?>)">
                            Print
                        </button>
                        <a href="../generatedocuments.php">
                            <button id="cancel-button" type="button" class="rounded-md border-2 border-c w-32 p-2 place-self-center hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700">Cancel</button>
                        </a>
                    </div>
                </div>
                <!-- Confirm Print -->
                <div class="fixed inset-0 z-50 hidden" id="confirmPrint">
                    <div class="w-screen h-screen flex justify-center items-center">
                        <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                        <div class="relative grid grid-cols-1 grid-rows-2 h-72 w-96 overflow-auto rounded-md bg-white z-10">
                            <div class="grid justify-center">
                                <div class="text-3xl font-bold place-self-center mt-12">Confirm Print?</div>
                                <div class="mb-24 mt-4">Do you want to print this record?</div>
                            </div>
                            <div class="flex justify-center space-x-4 mt-6">
                                <button type="submit" name="confirm" class="bg-sg rounded-md w-32 h-12">
                                <input type="hidden" value="<?= $row['id'] ?>">
                                    Yes
                                </button>
                                <button name="cancel" class="bg-sg rounded-md w-32 h-12" onclick="cancelConfirmation()">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Confirm Print with Signature -->
                <div class="fixed inset-0 z-50 hidden" id="confirmSig">
                    <div class="w-screen h-screen flex justify-center items-center">
                        <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                        <div class="relative grid grid-cols-1 grid-rows-2 h-72 w-96 overflow-auto rounded-md bg-white z-10">
                            <div class="grid justify-center">
                                <div class="text-3xl font-bold place-self-center mt-12">Confirm Print?</div>
                                <div class="mb-24 mt-4">Do you want to print this record?</div>
                            </div>
                            <div class="flex justify-center space-x-4 mt-6">
                                <button type="submit" name="confirmPrintSignature" class="bg-sg rounded-md w-32 h-12">
                                <input  type="hidden" value="<?= $row['id'] ?>">
                                    Yes
                                </button>
                                <button name="cancel" class="bg-sg rounded-md w-32 h-12" onclick="cancelConfirmationSig()">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                </fieldset>
            </form>   
        </div>
        <!-- Bottom Logo -->
        <div class="w-full flex justify-center mt-12">
            <img src="../../img/coat.png" alt="Bottom Image" class="hidden std:block w-[100px] h-[100px] object-contain">
        </div>
        <!--Select from Records -->
        <div class="fixed z-50" id="selectRecords">
            <div class=" w-screen h-screen flex justify-center items-center flex-col ">
                <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                <div class="relative flex flex-col h-full w-[66%] std:w-[51%] overflow-auto bg-white z-10 my-14  border-4 border-c rounded-xl ">
                    <div class="grid justify-center h-full w-full grow-0">
                        <!-- Search -->
                        <div class="relative">
                            <form method="GET" class="flex justify-center items-center pt-2 std:py-1 std:pt-4">
                                <input name="search" id="search" type="text" placeholder="Search..." value="<?=$search?>" class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 ring-sg h-8 z-10 transform translate-x-4 " >
                                <button type="submit" id="searchBtn" class=" bg-white  rounded-md p-2 focus:outline-none focus:ring-2 ring-sg h-7 flex items-center justify-center z-20 transform -translate-x-4 ">
                                    <img class="w-4" src="../../img/search.svg" alt="Search Icon"/>
                                </button>
                            </form>
                        </div>
                        <!-- Tables -->
                        <?php if ($searchResult) { ?>
                        <div class="h-full">
                            <div class="overflow-hidden w-full mt-2">
                                <div class="border-2 border-c rounded-lg mx-4">
                                    <!--Personal Information Table -->
                                    <div id="tb1" class="h-[63vh] std:h-[67.5vh]" >
                                        <div class="rounded-t-sm pt-2 bg-c ">
                                        <table id="residentTable" class="w-full border-collapse">
                                            <colgroup>
                                                <col class="w-[100px]">
                                                <col class="w-[200px]">
                                                <col class="w-[200px]">
                                                <col class="w-[200px]">
                                                <col class="w-[200px]">
                                            </colgroup>
                                            <thead class="bg-c sticky top-0 text-sm std:text-base">
                                            <tr class="uppercase ">
                                                <!--Basic Information + Action-->
                                                <th class="py-2 min-w-20">ID</th>
                                                <th class="py-2">First Name</th>
                                                <th class="py-2">Middle Name</th>
                                                <th class="py-2">Last Name</th> 
                                                <th class="py-2 min-w-20">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class=" text-gray-600 bg-white">
                                                <?php 
                                                $i = 1; //auto numbering
                                                $i = 1; //auto numbering
                                                $j = 10 * $page - 10; // adjust depending on page
                                                foreach ($searchResult as $row) {
                                                ?>
                                                <tr class="hover:bg-gray-100 text-sm std:text-base">
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center min-w-20">
                                                        <?php echo $page > 1 ? $i + $j : $i; ?>
                                                        </div>
                                                    </td>
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center">
                                                            <?=$row['first_name']?>
                                                        </div>
                                                    </td>
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center">
                                                            <?=$row['middle_name']?>
                                                        </div>
                                                    </td>
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center">
                                                            <?=$row['last_name']?>
                                                        </div>
                                                    </td>
                                                    <td class="border-y-2 border-c">
                                                        <div class="flex justify-center items-center h-10 std:h-14 grow">
                                                            <a href="brgyclearance.php?id=<?= $row['id']?>">
                                                                <button id="select-button" name="select" class="rounded-md w-32 border-2 border-c bg-c p-0.5 std:p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">
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
                                    <!-- Page Links -->
                                    <div class=" h-12 rounded-b-sm bg-c">
                                        <?php
                                            //display first and prev
                                            echo "<div class='place-self-end pt-3 p-2'>";
                                            if ($page > 1) {
                                                echo "<a href='brgyclearance.php?page=1&search=$search' class='px-4 py-2 text-sm  text-white bg-sg rounded-l-lg hover:opacity-80'>&laquo; First</a>";
                                                echo "<a href='brgyclearance.php?page=" . ($page - 1) . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>&lt; Previous</a>"; // Previous page link
                                            } else {
                                                echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200 rounded-l-lg'>&laquo; First</span>";
                                                echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200'>&lt; Previous</span>";
                                            }
                                            //display range of page link
                                            for ($i = max(1, $page - 5); $i <= min($total_pages, $page + 5); $i++) {
                                                if ($i == $page) {
                                                    echo "<span class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</span>";
                                                } else {
                                                    echo "<a href='brgyclearance.php?page=" . $i . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>" . $i . "</a>";
                                                }
                                            }
                                            // Display next and last
                                            if ($page < $total_pages) {
                                               echo "<a href='brgyclearance.php?page=" . ($page + 1) . "&search=$search' class='px-4 py-2 text-sm  text-white bg-sg hover:opacity-80'>Next &gt;</a>"; // Next page link
                                               echo "<a href='brgyclearance.php?page=$total_pages&search=$search' class='px-4 py-2 text-sm  text-white bg-sg rounded-r-lg hover:opacity-80'>Last &raquo;</a>"; // Last page link
                                            } else {
                                               echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200'>Next &gt;</span>";
                                               echo "<span class='px-4 py-2 text-sm  text-gray-400 bg-gray-200 rounded-r-lg'>Last &raquo;</span>";
                                            }
                                            echo "</div>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center items-center py-2 pt-3 grow">
                                <a href="../generatedocuments.php">
                                    <button class="rounded-md border-2 border-c p-2 w-52 hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700" onclick="cancelSelect()">Cancel</button>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    //enable after selecting records
    function enableField() {
        const fieldset = document.getElementById("fieldset");
        if (fieldset) {
            fieldset.disabled = false;
        }
    }
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
    //confirm print with signature
    function confirmPrintSig() {
        document.getElementById("confirmSig").classList.remove("hidden");
    }
    function cancelConfirmation() {
        document.getElementById("confirmPrint").classList.add("hidden");
    }
    function cancelConfirmationSig() {
        document.getElementById("confirmSig").classList.add("hidden");
    }
    //script for requiring input fields
    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("personal_info");
    const firstNameInput = document.getElementById("first-name");
    const lastNameInput = document.getElementById("last-name");
    const dateIssuedInput = document.getElementById("date-of-issuance");
    const purposeInput = document.getElementById("purpose");
    const issuedByInput = document.getElementById("issued-by");
    const ctcNumberInput = document.getElementById("ctc-number");

    const firstNameError = document.getElementById("first-name-error");
    const lastNameError = document.getElementById("last-name-error");
    const dateIssuedError = document.getElementById("date-of-issuance-error");
    const purposeError = document.getElementById("purpose-error");
    const issuedByError = document.getElementById("issued-by-error");
    const ctcNumberError = document.getElementById("ctc-number-error");

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

            // Validate CTC Number
            if (!ctcNumberInput.value.trim()) {
                isValid = false;
                ctcNumberError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || ctcNumberInput;
            } else {
                ctcNumberError.classList.add("hidden");
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
                document.getElementById("confirmPrint").classList.add("hidden");
                document.getElementById("confirmSig").classList.add("hidden");
            } 

        });
        // Cancel Button: Redirect to another page
        cancelButton.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent default button behavior
            // Redirect to another page (replace 'your-page-url' with the actual URL)
            window.location.href = "../generatedocuments.php"; 
        });
    });

    //on load if there is id in the url close select records
    document.addEventListener("DOMContentLoaded", function() {
        if(window.location.href.indexOf("id=") > 1) {
            document.getElementById("selectRecords").classList.add("hidden");
        }
    });
    </script>
    <script>
    //for contact number
    $(document).ready(function() {
        // Input mask for the phone number
        $('#phone').inputmask({
            mask: '+63 9999999999',
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
</script>
</body>
</html>