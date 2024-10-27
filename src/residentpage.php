<?php
include("backend/connection.php");

if(isset($_POST['add'])) {
    try{
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $suffix = $_POST['suffix'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $sex = $_POST['sex'];
        $birth_date = $_POST['birth_date'];
        $birth_place = $_POST['birth_place'];
        $civil_status = $_POST['civil_status'];
        $citizenship = $_POST['citizenship'];
        $occupation = $_POST['occupation'];

        if($middle_name == NULL) {
            $middle_name = '';
        }

        $query = "INSERT INTO `resident_info`(`first_name`, `middle_name`, `last_name`, `suffix`, `age`, `address`, `sex`, `birth_date`, `birth_place`, `civil_status`, `citizenship`, `occupation`) 
                VALUES (:first_name, :middle_name, :last_name, :suffix, :age, :address, :sex , :birth_date , :birth_place , :civil_status , :citizenship, :occupation)";

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
        $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
        $stmt->bindParam(':birth_place', $birth_place, PDO::PARAM_STR);
        $stmt->bindParam(':civil_status', $civil_status, PDO::PARAM_STR);
        $stmt->bindParam(':citizenship', $citizenship, PDO::PARAM_STR);
        $stmt->bindParam(':occupation', $occupation, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt) {
            header("location: residentpage.php?msg= new record added.");
        } else {
            echo "Failed: " . $e->getMessage();
        }
    } catch(PDOException $e){
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
    <script src="../script.js"></script>
</head>
<body class="relative bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <div class="absolute w-full h-full">
    <!--Header-->
        <div class="grid grid-cols-2 items-center">
            <div class="flex flex-row items-start ">
                <!--Nav-->
                <div onmouseover="hoverNav()" onmouseleave="leaveNav()" class="flex flex-col mr-16 rounded-b-full h-14 w-16 hover:h-44 bg-pg duration-500 ease-in-out">
                    <button id="gen_doc" onmouseover="hoverDoc()" onmouseleave="leaveDoc()" class="w-20 mt-1 rounded-b-full flex">
                        <img  class="place-self-center size-10 ml-3 mb-2" src="../img/gen_doc.svg">
                        <span id="doc_title" class="hidden ml-8 z-10 p-2 border-4 border-pg rounded-full bg-c min-w-52">Generate Documents</span>
                    </button>
                    <button id="res_info" onmouseover="hoverRes()" onmouseleave="leaveRes()" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                        <img  class="place-self-center size-10 ml-3 mb-2" src="../img/res_info.svg">
                        <span id="res_title" class="hidden ml-8 z-10 p-2 border-4 border-pg rounded-full bg-c min-w-52">Resident Records</span>
                    </button>
                    <button id="setting" onmouseover="hoverSet()" onmouseleave="leaveSet()" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                        <img  class="place-self-center size-10 ml-3 mb-2" src="../img/setting.svg" >
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
            <div class="relative inline-block w-2/4 place-self-center ml-24 ll:ml-56">
                <div class="bg-pg h-12 rounded-lg flex items-center justify-center p-8">
                    <h1 class="text-2xl font-bold text-center  ">
                        List of Records
                    </h1>
                </div>
                <div class="bg-c w-3/4 h-6 rounded-lg absolute right-0 top-14 -z-10"></div>
            </div>
        </div>
        <!-- Search and Add New Button -->
        <div class="flex justify-end items-center space-x-4 mr-32">
            <div class="relative">
                <input type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none h-8">
                <button class="rounded-sm absolute right-0 top-1/2 transform -translate-y-1/2 bg-pg p-2 h-full flex items-center justify-center hover:bg-[#579656] focus:outline-none">
                    <img class="w-4 h-4" src="https://img.icons8.com/ios-filled/50/000000/search.png" alt="Search Icon"/>
                </button>
            </div>
            <button class="bg-pg text-black py-1 px-3 hover:bg-pg focus:outline-none rounded-sm" onclick="showAddResidentPopup()">Add New</button>
        </div>
        <!-- Smaller Table with minimal padding and font size -->
        <div class="overflow-x-auto pr-32 pl-32 mt-4">
            <table class="min-w-full bg-white border border-gray-300">
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
                    require("backend/connection.php");
                    $query = "SELECT * FROM resident_info";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute();
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td class="border-2">
                            <div class="flex justify-center">
                                <?=$row['id']?>
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
                                <button class="w-6 mr-1 cursor-pointer">
                                    <a id="edit_data" href="edit.php?id=<?=$row['id']?>">
                                        <img name="edit" src="../img/edit.svg" alt="edit" style="filter: brightness(0);" />
                                    </a>
                                </button>
                                <button  class="w-6 ml-1 cursor-pointer">
                                    <a href="backend/delete.php?id=<?=$row['id']?>">
                                        <img name="delete" src="../img/trash.svg" alt="delete"  style="filter: brightness(0);" />
                                    </a>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--Add resident Pop up-->
    <div id="addResidentPopup" class="grid h-screen hidden ">
        <div class="absolute overflow-auto place-self-center h-5/6 bg-white border-2 shadow-max  rounded-md w-5/6">
            <!-- Starts here -->
            <div class=" mx-20 mt-14 p-10"> 
                <div class="flex justify-center bg-pg rounded-lg p-6 w-1/4 mb-16 "> 
                        <h1 class="text-2xl font-bold">Add a new resident</h1>
                    </div>

                <!-- Form Section -->
                <form class="grid grid-cols-[2fr,1fr,1fr] gap-12" method="post">
                    <!-- First Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold">First name</label>
                            <input type="text" name="first_name" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Juan">
                        </div>
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-bold">Middle Name</label>
                                <div class="flex items-center">
                                    <input type="checkbox" id="noMid" class="mr-1">
                                    <label for="noMid" class="text-xs">No Middle Name</label>
                                </div>
                            </div>
                            <input type="text" name="middle_name" id="middleNameInput" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Dela">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Last name</label>
                            <input type="text" name="last_name" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Cruz">
                        </div>
                        <div>
                            <label class="block text-sm font-medium" style="font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">Suffix</label>
                            <select name="suffix" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                                <option value=""  selected >Select Suffix</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="PhD">PhD</option>
                                <option value="MD">MD</option>
                                <option value="Esq.">Esq.</option>
                            </select>
                        </div>
                    </div>

                    <!-- Second Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold">Address</label>
                            <input name="address" type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Indang Cavite">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Age</label>
                            <input name="age" type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. 18">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Sex</label>
                            <select name="sex" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg " >
                                <option value=""  selected >Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Date of Birth</label>
                            <input type="date" name="birth_date" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                        </div>
                    </div>

                    <!-- Third Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold">Birth Place</label>
                            <input type="text" name="birth_place" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Indang Cavite">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Civil Status</label>
                            <select name="civil_status" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                                <option value="" selected>Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Legally Separated">Legally separated</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Citizenship</label>
                            <input type="text" name="citizenship" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Filipino">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Occupation</label>
                            <input type="text" name="occupation" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Programmer">
                        </div>
                        <div class="mt-12 flex justify-end space-x-4">
                        <button name="add" class="bg-pg text-black py-1 px-3 rounded-sm hover:bg-sg focus:outline-none">
                            Add
                        </button>
                        <button class="bg-pg text-black py-1 px-3 rounded-sm hover:bg-sg focus:outline-none" onclick="hideAddResidentPopup()">
                            Cancel
                        </button>
                    </div>
                    </div>
                </form>
            </div>
            <!-- Ends here -->
        </div>
    </div>
<script>
    //hover on nav 
    function hoverNav() {
        let resident = document.getElementById("res_info");
        let setting = document.getElementById("setting");
        
        resident.style.opacity = "1";
        setting.style.opacity = "1";
    }
    function leaveNav() {
        let resident = document.getElementById("res_info");
        let setting = document.getElementById("setting");

        resident.style.opacity = "0";
        setting.style.opacity = "0";
    }
    //Hover on generate document
    function hoverDoc() {
        let doc = document.getElementById("doc_title");

        doc.style.display = "block";
    }
    function leaveDoc() {
        let doc = document.getElementById("doc_title");

        doc.style.display = "none";
    }
    //Hover on resident information
    function hoverRes() {
        let doc = document.getElementById("res_title");

        doc.style.display = "block";
    }
    function leaveRes() {
        let doc = document.getElementById("res_title");

        doc.style.display = "none";
    }
    //Hover on hover on setting
    function hoverSet() {
        let doc = document.getElementById("set_title");

        doc.style.display = "block";
    }
    function leaveSet() {
        let doc = document.getElementById("set_title");

        doc.style.display = "none";
    }
    //show/hide add resident pop up
    function showAddResidentPopup() {
        document.getElementById("addResidentPopup").classList.remove("hidden");
    }
    function hideAddResidentPopup() {
        document.getElementById("addResidentPopup").classList.add("hidden");
    }
    //no middle name
    document.getElementById('noMid').addEventListener('change', function() {
        const middleNameInput = document.getElementById('middleNameInput');
        middleNameInput.disabled = 'true';// Disable input if checkbox is checked
        middleNameInput.value = ''; // Clear the input field if checkbox is checked

        if (this.checked) {
            middleNameInput.value = ''; // Clear the input field if checkbox is checked
            middleNameInput.style.backgroundColor = '#C8C8C8'; // Change background to gray
        } else {
            middleNameInput.style.backgroundColor = ''; // Reset background when unchecked
        }
    });
</script>
</body>
</html>