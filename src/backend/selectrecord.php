<?php
include("connection.php");
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
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
</head>
<body class="relative bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <!--Header-->
    <div class="absolute w-full h-full">
        <div class="grid grid-cols-2 items-center">
                <div class="bg-pg w-3/5 p-4 px-8 mt-8 rounded-lg place-self-start ml-32">
                    <h1 class="text-5xl font-bold mb-2 text-center">
                        Resident<br>Information
                    </h1>
                    <div class="bg-c w-full h-10 rounded-lg"></div>
                </div>
            <!-- Right section -->
            <div class="relative inline-block w-2/4 place-self-center ml-24 ll:ml-56">
                <div class="bg-pg h-12 rounded-lg flex items-center justify-center p-8">
                    <h1 class="text-2xl font-bold text-center  ">
                        Select from Records
                    </h1>
                </div>
                <div class="bg-c w-3/4 h-6 rounded-lg absolute right-0 top-14 -z-10"></div>
            </div>
        </div>
        <!-- Search and Add New Button -->
        <div class="flex justify-end items-center space-x-4 mr-32">
            <div class="relative">
                <form method="post">
                    <input name="search" id="search" type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none h-8" >
                    <button id="searchBtn" class="rounded-sm absolute right-0 top-1/2 transform -translate-y-1/2 bg-pg p-2 h-full flex items-center justify-center hover:bg-[#579656] focus:outline-none">
                        <img class="w-4 h-4" src="../../img/search.svg" alt="Search Icon"/>
                    </button>
                </form>
            </div>
        </div>
        <!-- Residents Table -->
        <div class="overflow-x-auto pr-32 pl-32 mt-4">
            <table id="residentTable" class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-c text-gray-600 uppercase text-sm border-2 ">
                        <th class="border-2 border-pg">ID</th>
                        <th class="border-2 border-pg">First Name</th>
                        <th class="border-2 border-pg">Middle Name</th>
                        <th class="border-2 border-pg">Last Name</th>
                        <th class="border-2 border-pg">Suffix</th>
                        <th class="border-2 border-pg">Age</th>
                        <th class="border-2 border-pg">Address</th>
                        <th class="border-2 border-pg">Sex</th>
                        <th class="border-2 border-pg">Date of Birth</th>
                        <th class="border-2 border-pg">Birth Place</th>
                        <th class="border-2 border-pg">Civil Status</th>
                        <th class="border-2 border-pg">Citizenship</th>
                        <th class="border-2 border-pg">Occupation</th>
                        <th class="border-2 border-pg">Action</th>
                    </tr>
                </thead>
                <tbody class=" border-2 text-gray-600" >
                    <?php 
                    $i = 1; //auto numbering
                    foreach ($result as $row) {
                    ?>
                    <tr>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?= $i ?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['first_name']?></td>
                            </div>
                        <td class="border-2">
                            <div class="flex justify-center" >
                                <?=$row['middle_name']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['last_name']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['suffix']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['age']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['address']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['gender']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['birth_date']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['birth_place']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['civil_status']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['citizenship']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['occupation']?>
                            </div>
                        </td>
                        <td class="border-2">
                            <div class="flex justify-center items-center">
                                <button class="w-6 mr-1 cursor-pointer" name="" id=""> 
                                    <a href="#?id=<?= $row['id']?>">
                                        <img src="#" alt="print"/>
                                    </a>
                                </button>
                            </div>
                        </td>
                        <!-- Confirmation -->
                        <div class="absolute w-5/6 flex justify-center place-items-center hidden" id="confirmDeletion">
                            <div class="grid grid-cols-1 grid-rows-2 h-72 w-1/4 overflow-auto rounded-md bg-white shadow-max">
                                <div class=" grid justify-center">
                                    <div class="text-3xl font-bold place-self-center mt-12"> Confirm Deletion</div>
                                    <div class="mb-24 mt-4">Are you sure you want to delete this record?</div>
                                </div>
                                <div class=" flex justify-center space-x-4 mt-6">
                                    <a id="deleteLink" href="#">
                                        <button class="bg-c rounded-md w-32 h-12">
                                            Yes, Delete  
                                        </button>
                                    </a>
                                    <button class="bg-c rounded-md w-32 h-12" onclick="cancelConfirmation()">No</button>
                                </div>
                            </div>
                        </div>
                    </tr>
                    
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //hover on nav 
    function hoverNav() {
        let generate = document.getElementById("gen_doc");
        let setting = document.getElementById("setting");
        let mainNav = document.getElementById("mainNav");
        mainNav.style.height = "11rem";
        generate.style.opacity = "1";
        setting.style.opacity = "1";
    }
    function leaveNav() {
        let generate = document.getElementById("gen_doc");
        let setting = document.getElementById("setting");
        let mainNav = document.getElementById("mainNav");

        mainNav.style.height = "3.5rem";
        generate.style.opacity = "0";
        setting.style.opacity = "0";
    }
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