<?php
session_start();
include("backend/connection.php");
require("backend/helper.php");
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
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
    <script src="../script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body class="relative h-screen w-full bg-cover bg-center bg-fixed">
    <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('../img/indang.webp'); filter: blur(2px); z-index: -1;"></div>
    <!-- Centering Wrapper -->
    <div class="flex justify-center place-items-center flex-col h-full relative z-10">
        <!-- Main Content -->
        <div class="w-4/5 p-6 mt-4 bg-white rounded-lg">
            <!-- Back and Select from records button -->
            <div class="grid grid-cols-2 items-center">
                <!-- Back Button -->
                <div class="grid justify-items-start pl-2">
                    <div class="flex">
                        <div>
                            <a href="generatedocuments.php" class="flex items-center p-2 rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700""><img src="../img/back.png" class="size-4" alt="select from records"></a>
                        </div>
                        <p class="flex justify-start items-center w-48 p-2 text-gray-400 ">Back</p>
                    </div>
                </div>
                <!-- Select from records -->
                <div class="grid justify-items-end ">
                    <div class="flex">
                        <p class="flex justify-end w-48 p-2 text-gray-400 ">Select from Records</p>
                        <div >
                            <button class="rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700" onclick="confirmDeletion()"><img src="../img/residency.svg" class="size-10 p-2" alt="select from records"></button>
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
                                    </div>
                                    <div class="relative">
                                        <input id="date-of-issuance" name="date_of_issuance" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
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
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="municipality-city" name="municipality_city" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $recordLoaded ? $row['municipality_city'] : $defaultValues['municipality_city']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Municipality/City</label>
                                        </div>
                                        <div class="flex-grow">
                                            <input id="zip-code" name="zip_code" maxlength="4" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg"value="<?php echo $recordLoaded ? $row['zip_code'] : $defaultValues['zip_code']?>" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Zip Code</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-lg p-2 mb-8">
                            <!-- Purpose -->
                            <div>
                                <h2 class="text-xl font-bold mb-4">Purpose</h2>
                                <div class="border-2 p-6 rounded-md hover:border-sg transition duration-700">
                                    <div class="relative">
                                        <input id="house-number" name="house_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Purpose</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>   
            <!-- Buttons -->
            <div class="flex justify-end items-center gap-2">
                <a href="backend/brgyclearance_print.php?id=<?= $row['id']?>">
                    <button class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">Print </button>
                </a>
                <a href="generatedocuments.php">
                    <button name="cancel" class="rounded-md border-2 border-c w-32 p-2 place-self-center hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700">Cancel</button>
                </a>
            </div>
        </div>
        
        <!-- Bottom Logo -->
        <div class="w-full flex justify-center mt-12">
            <img src="../img/coat.png" alt="Bottom Image" class="w-[100px] h-[100px] object-contain">
        </div>
        <!--Select from Records -->
        <div class="fixed z-50 hidden" id="confirmDeletion">
            <div class="border-4 w-screen h-screen flex justify-center items-center flex-col">
                <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                <div class="relative flex flex-col h-4/5 w-4/12 overflow-auto rounded-md bg-white z-10 border-2 mb-24">
                    <div class="grid justify-center h-full w-full border-2 grow-0">
                    <!-- Search -->
                        <div class="flex justify-center items-center mt-2">
                            <form method="post">
                                <input name="search" id="search" type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none focus:ring-2 ring-c h-8 transition duration-300">
                                <button id="searchBtn" class="rounded-md absolute right-52 top-[26px] transform -translate-y-1/2 border-gray-300 p-2 h-8 flex items-center justify-center pointer-events-none">
                                    <img class="w-4 h-4" src="../img/search.svg" alt="Search Icon"/>
                                </button>
                            </form>
                        </div>
                        <!-- Tables -->
                        <div class="h-full w-screengrow">
                            <div class="overflow-hidden mt-2 w-full">
                            <div class="border-2 border-c rounded-lg mx-4">
                            <!--Personal Information Table -->
                            <div id="tb1" class="overflow-auto no-scrollbar"  style="height: 65vh;">
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
                                    <td class=" border-y-2 border-c py-4">
                                        <div class="flex justify-center  min-w-20">
                                            <?= $i ?>
                                        </div>
                                    </td>
                                    <td class="border-y-2 border-c py-2">
                                        <div class="flex justify-center">
                                            <?=$row['first_name']?>
                                            <?=$row['middle_name']?>
                                            <?=$row['last_name']?>
                                        </div>
                                    </td>
                                    <td class="border-y-2 border-c py-2">
                                        <div class="flex justify-center items-center h-20 grow">
                                            <a href="brgyclearance.php?id=<?= $row['id']?>">
                                                <button name="select" class="rounded-md w-32 border-2 border-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">
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
                        </div>
                    </div>
                    <div class="flex justify-center items-center border-2 h-20 grow">
                        <button class="rounded-md bg-c w-32 p-2 place-self-center hover:bg-sg transition duration-300" onclick="cancelConfirmation()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    //confirm deletion
    function confirmDeletion() {
        document.getElementById("confirmDeletion").classList.remove("hidden");
    }
    function cancelConfirmation() {
        document.getElementById("confirmDeletion").classList.add("hidden");
    }
    </script>
    <script>
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
