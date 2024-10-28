<?php
include("backend/connection.php");
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
        <div class="grid grid-cols-2 items-center -z-20">
            <div class="flex flex-row items-start ">
                <!--Nav-->
                <div id="mainNav" onmouseover="hoverNav()" onmouseleave="leaveNav()" class="flex flex-col mr-16 rounded-b-full h-14 w-16 bg-pg duration-500 ease-in-out">
                    <a href="residentpage.php">
                        <button id="res_info"  onmouseover="toggleDisplay('res_title', true)" onmouseleave="toggleDisplay('res_title', false)" class="w-20 mt-2 rounded-b-full flex">
                            <img  class="place-self-center size-8 ml-4 mb-4" src="../img/res_info.svg">
                            <span id="res_title" class="hidden ml-8 z-10 p-2 border-4 border-pg rounded-full bg-c min-w-52">Resident Information</span>
                        </button>
                    </a>
                    <button id="gen_doc" onmouseover="toggleDisplay('doc_title', true)" onmouseleave="toggleDisplay('doc_title', false)" class="w-20 opacity-0 mt-1 rounded-b-full flex">
                        <img  class="place-self-center size-10 ml-3 mb-2" src="../img/gen_doc.svg">
                        <span id="doc_title" class="hidden ml-8 z-10 p-2 border-4 border-pg rounded-full bg-c min-w-52">Generate Documents</span>
                    </button>
                    <button id="setting"  onmouseover="toggleDisplay('set_title', true)" onmouseleave="toggleDisplay('set_title', false)" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                        <img  class="place-self-center size-8 ml-4 mb-4" src="../img/setting.svg" >
                        <span id="set_title" class="hidden ml-8 z-10 p-2 border-4 border-pg rounded-full bg-c min-w-52">System Settings</span>
                    </button>
                    
                </div>
                <!-- Left section: Title -->
                <div class="bg-pg w-3/5 p-4 px-8 mt-8 rounded-lg place-self-center">
                    <h1 class="text-5xl font-bold mb-2 text-center">
                        Resident<br>Information
                    </h1>
                    <div class="bg-c w-full h-10 rounded-lg"></div>
                </div>
            </div>
            <!-- Right section -->
            <div class="relative inline-block w-2/4 place-self-center ml-24 ll:ml-56 -z-20">
                <div class="bg-pg h-12 rounded-lg flex items-center justify-center p-8">
                    <h1 class="text-2xl font-bold text-center  ">
                        List of Records
                    </h1>
                </div>
                <div class="bg-c w-3/4 h-6 rounded-lg absolute right-0 top-14 -z-10"></div>
            </div>
        </div>
        <!-- Search, Add New Button, Bulk Import -->
        <div class="flex justify-end items-center space-x-4 mr-32">
            <div class="relative">
                <form method="post">
                    <input name="search" id="search" type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none h-8" >
                    <button id="searchBtn" class="rounded-sm absolute right-0 top-1/2 transform -translate-y-1/2 bg-white border border-l-0 border-gray-300 p-2 h-full flex items-center justify-center ">
                        <img class="w-4 h-4" src="https://img.icons8.com/ios-filled/50/000000/search.png" alt="Search Icon"/>
                    </button>
                </form>
            </div>
            <a href="backend/add.php"><button class="bg-pg text-black py-1 px-3 hover:bg-[#579656] focus:outline-none rounded-sm focus:ring-4 ring-c mr-24">Add Record</button></a>
            <div>
                <form id="formUpload">
                    <label for="file_input">
                        <img id="file_output" class="absolute top-40 right-36 ml-4 p-1 z-20 duration-150 cursor-pointer hover:z-20 hover:-translate-y-1"  style="cursor: pointer;" src="../img/gen_doc.svg">
                        <input type="file" id="file_input" name="file" accept="csv/*" class="hidden -z-10"> </input>
                    </label>
                    <div>
                        <div class="absolute top-40 right-32 ml-4 p-1 border-2 h-20 w-26"></div>
                        <button id="btnUpload" name="btnUpload" class="absolute top-52 right-32 bg-pg text-black py-1 px-3 hover:bg-[#579656] focus:outline-none rounded-sm focus:ring-4 ring-c">Bulk Import</button>
                    </div>
                </form>
                <div class="msgUpload"></div>
            </div>
        </div>
        <!-- Residents Table -->
        <div class="overflow-x-auto pr-32 pl-32 mt-4">
            <table id="residentTable" class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-c text-gray-600 uppercase text-sm border-2 ">
                        <th class="border-2 border-pg">ID</th>
                        <th class="border-2 border-pg">First Name</th>
                        <th class="border-2 border-pg ">Middle Name</th>
                        <th class="border-2 border-pg px-2">Last Name</th>
                        <th class="border-2 border-pg">Suffix</th>
                        <th class="border-2 border-pg">Age</th>
                        <th class="border-2 border-pg px-6">Address</th>
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
                                <?=$row['sex']?>
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
                                <button class="w-6 mr-1 cursor-pointer" name="id" id="editBtn"> 
                                    <a href="backend/edit.php?id=<?= $row['id']?>">
                                        <img src="../img/edit.svg" alt="edit"/>
                                    </a>
                                </button>
                                <button  class="w-6 ml-1 cursor-pointer" onclick="confirmDeletion(<?= $row['id'] ?>)">
                                    <img name="delete" src="../img/trash.svg" alt="delete"/>
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
    
</script>
<script>
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
<script>
    const fileInput = document.querySelector("#file_input");
    const fileOutput = document.querySelector("#file_output");

    let file = "";

    fileInput.addEventListener("change", function(){
        file = this.files[0];
        displayFile();
    });

    const displayFile = () => {
        let fileReader = new FileReader();
        let fileType = file.type;
        if(fileType === "text/csv"){
            fileReader.onload=()=>{
                let fileAddress = fileReader.result;
                fileOutput.src=fileAddress;
                fileOutput.src="../img/prevcsv.jpg";
                document.querySelector("#btnUpload").style.display="block";
            };
        } else {
            fileOutput.src="../img/error.png";
        } 
        fileReader.readAsDataURL(file);
    };
</script>
</body>
</html>