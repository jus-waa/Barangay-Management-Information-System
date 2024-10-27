<?php
include("connection.php");

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
            header("location: ../residentpage.php?msg= new record added.");
        } else {
            echo "Failed: " . $e->getMessage();
        }
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['cancel'])){
    header("location: ../residentpage.php?msg= operation cancelled.");
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
<body class="bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <!-- Main content with added horizontal margins -->
    <div class="mx-20 p-10"> 
        <div class="flex justify-center bg-pg rounded-lg p-6 w-1/4 mb-16 "> 
                <h1 class="text-2xl font-bold">Add a new resident</h1>
            </div>

        <!-- Form Section -->
        <form class="grid grid-cols-[2fr,1fr,1fr] gap-12" method="post">
            <!-- First Column -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold">First name</label>
                    <input type="text" name="first_name" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Juan" >
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
                        <option value="" selected >Select Suffix</option>
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
            </div
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
                    <select name="sex" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                        <option value=""  selected >Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold">Date of Birth</label>
                    <input type="date" name="birth_date" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                </div>
            </div
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
                <button name="cancel" class="bg-pg text-black py-1 px-3 rounded-sm hover:bg-sg focus:outline-none">
                    Cancel
                </button>
            </div>
            </div>
        </form>
    </div>
    <script>
    document.getElementById('noMid').addEventListener('change', function() {
        const middleNameInput = document.getElementById('middleNameInput');
        middleNameInput.disabled = this.checked;
        if (this.checked) {
            middleNameInput.value = '';
            middleNameInput.classList.add('bg-gray-300');
        } else {
            middleNameInput.classList.remove('bg-gray-300');
        }
    });
        
    </script>
</body>
</html>