<?php
include("connection.php");

$id = $_GET['id'];
if(isset($_POST['update'])) {
    try{
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $suffix = $_POST['suffix'];
        $gender = $_POST['gender'];
        $birth_date = $_POST['birth_date'];
        $bp_municipality_city = $_POST['birthplace_municipality_city'];
        $bp_province = $_POST['birthplace_province'];
        $father_name = $_POST['father_name'];
        $mother_maiden_name = $_POST['mother_maiden_name'];
        $contact = $_POST['contact_num'];
        $email = $_POST['email_address'];
        $house_num = $_POST['house_num'];
        $street_name = $_POST['street_name'];
        $purok = $_POST['purok'];
        $barangay_name = "Barangay Buna Cerca";
        $municipality_city = "Indang";
        $province = "Cavite";
        $zip_code = "4122";
        $civil_status = $_POST['civil_status'];
        $citizenship = $_POST['citizenship'];
        $ethnicity = $_POST['ethnicity'];
        $occupation = $_POST['occupation'];
        $residency_type = $_POST['residency_type'];
        $status = $_POST['status'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $eye_color = $_POST['eye_color'];
        $blood_type = $_POST['blood_type'];
        $religion = $_POST['religion'];
        //no middle name
        if($middle_name == NULL) {
            $middle_name = '';
        }
        //auto update age depending on birth date
        function calculateAge($birthdate) {
            $birthDate = new DateTime($birthdate);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthDate)->y; // Get the difference in years
            return $age;
        }
        $query = "UPDATE `resident_info` SET
                `first_name`=:first_name,
                `middle_name`=:middle_name, 
                `last_name`=:last_name,
                `suffix`=:suffix,
                `gender`=:gender,
                `age`= :age,
                `birth_date`= :birth_date,
                `birthplace_municipality_city` = :birthplace_municipality_city,
                `birthplace_province` =  :birthplace_province,
                `contact_num` = :contact_num,
                `email_address` = :email_address,
                `house_num` = :house_num,
                `street_name` = :street_name,
                `purok` = :purok, 
                `barangay_name` = :barangay_name,
                `municipality_city` = :municipality_city, 
                `province` = :province, 
                `father_name` = :father_name,
                `mother_maiden_name` = :mother_maiden_name, 
                `zip_code` = :zip_code, 
                `civil_status` = :civil_status, 
                `citizenship` = :citizenship,
                `ethnicity` = :ethnicity,
                `occupation` = :occupation,
                `residency_type` = :residency_type,
                `status` = :status,
                `height` = :height,
                `weight` = :weight,
                `eye_color` = :eye_color,
                `blood_type` = :blood_type,
                `religion` = :religion WHERE `id`=$id";

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':age', calculateAge($birth_date), PDO::PARAM_INT);
        $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
        $stmt->bindParam(':birthplace_municipality_city', $bp_municipality_city, PDO::PARAM_STR);
        $stmt->bindParam(':birthplace_province', $bp_province, PDO::PARAM_STR);
        $stmt->bindParam(':contact_num', $contact, PDO::PARAM_STR);
        $stmt->bindParam(':email_address', $email, PDO::PARAM_STR);
        $stmt->bindParam(':house_num', $house_num, PDO::PARAM_STR);
        $stmt->bindParam(':street_name', $street_name, PDO::PARAM_STR);
        $stmt->bindParam(':purok', $purok, PDO::PARAM_STR);
        $stmt->bindParam(':barangay_name', $barangay_name, PDO::PARAM_STR);
        $stmt->bindParam(':municipality_city', $municipality_city, PDO::PARAM_STR);
        $stmt->bindParam(':province', $province, PDO::PARAM_STR);
        $stmt->bindParam(':father_name', $father_name, PDO::PARAM_STR);
        $stmt->bindParam(':mother_maiden_name', $mother_maiden_name, PDO::PARAM_STR);
        $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
        $stmt->bindParam(':civil_status', $civil_status, PDO::PARAM_STR);
        $stmt->bindParam(':citizenship', $citizenship, PDO::PARAM_STR);
        $stmt->bindParam(':ethnicity', $ethnicity, PDO::PARAM_STR);
        $stmt->bindParam(':occupation', $occupation, PDO::PARAM_STR);
        $stmt->bindParam(':residency_type', $residency_type, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
        $stmt->bindParam(':eye_color', $eye_color, PDO::PARAM_STR);
        $stmt->bindParam(':blood_type', $blood_type, PDO::PARAM_STR);
        $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt) {
            header("location: ../residentpage.php?msg= Record updated successfully.");
        } else {
            echo "Failed: " . $e->getMessage();
        }
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['cancel'])){
    header("location: ../residentpage.php?msg= Operation cancelled.");
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
<body class="inset-0 h-full w-full">
    <div class="grid grid-cols-[1fr_2fr_2.5fr]">
        <!-- Left Section -->
        <div class="p-4">
            <h1 class="text-3xl font-bold"></h1>
        </div>
        <!-- Main Content -->
        <div class="w-full p-6 px-2 std:px-6">
            <?php 
            $query = "SELECT * FROM `resident_info` WHERE `id` = :id";
            $stmt = $dbh->prepare($query);
            $stmt->execute(['id' => $_GET['id']]);
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form method="post" id="personal_info">
                <!-- Personal Information -->
                <div class="rounded-lg p-2 mb-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4 ">Personal Information</h2>
                        <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                            <div>
                                <input id="first-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['first_name']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">First Name</label>
                                <span id="first-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div class="relative">
                                <input id="middle-name" name="middle_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['middle_name']?>" placeholder=" "/> 
                                <label id="middle-name-label" class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Middle Name</label>
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <span class="flex-grow"></span>
                                    <input type="checkbox" id="no-middle-name" class="mr-2 border-gray-400" />
                                    <label for="no-middle-name" class="text-sm text-gray-500 mr-4">No Middle Name</label>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <input id="last-name" name="last_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg"  value="<?php echo $row['last_name']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Last Name</label>
                                <span id="last-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div class="flex items-start justify-between">
                                <div for="suffix" class="flex flex-col flex-grow mr-2">
                                    <?php
                                    $suffixOptions = ["", "Jr.", "Sr.", "II", "III", "IV", "V", "PhD", "MD", "Esq."];
                                    ?>
                                    <select id="suffix" name="suffix" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                        <?php foreach ($suffixOptions as $suffix): ?>
                                            <option value="<?= $suffix ?>" <?= $row['suffix'] == $suffix ? "selected" : "" ?>>
                                                <?= $suffix == "" ? "Select Suffix" : $suffix?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div for="gender" class="flex flex-col flex-grow">
                                    <?php
                                    $genderOptions = ["", "Male", "Female"];
                                    ?>
                                    <select id="gender" name="gender" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                        <?php foreach ($genderOptions as $gender): ?>
                                            <option value="<?=$gender?>" <?= $row['gender'] == $gender ? "selected" : "" ?>>
                                                <?= $gender == "" ? "Select Gender" : $gender?> 
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="gender-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Birth Details -->
                <div class="rounded-lg p-2 mb-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4 ">Birth Details</h2>
                        <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                            <div>
                                <input id="date-of-birth" name="birth_date" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  text-sm p-2.1 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['birth_date']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Date of Birth</label>
                                <span id="birthdate-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div>
                                <input id="place-of-birth-city" name="birthplace_municipality_city" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['birthplace_municipality_city']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-4 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Place of Birth (Municipality/City)</label>
                                <span id="birthplace-city-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div>
                                <input id="place-of-birth-province" name="birthplace_province" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['birthplace_province']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-4 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Place of Birth (Province)</label>
                                <span id="birthplace-province-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <!-- Father's Name & Mother's Maiden Name -->
                            <div class="flex items-start justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="father" name="father_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['father_name']?>" placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Father's Name</label>
                                    <span id="father-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                                <div class="flex-grow">
                                    <input id="mother" name="mother_maiden_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['mother_maiden_name']?>" placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Mother's Maiden Name</label>
                                    <span id="mother-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Information -->
                <div class="rounded-lg p-2 mb-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4 ">Contact Information</h2>
                        <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                            <div>
                                <input id="email" name="email_address" type="email" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  text-sm p-2.1 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['email_address']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Email Address</label>
                                <span id="email-address-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div>
                                <input id="contact-num" name="contact_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['contact_num']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Phone Number</label>
                                <span class="text-gray-400 text-sm">Format: 09991239999</span><br>
                                <span id="contact-error" class="text-red-500 text-sm hidden">Must be 11 digits</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Address Details -->
                <div class="rounded-lg p-2 mb-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4 ">Address Details</h2>
                        <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="house-number" name="house_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['house_num']?>" placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">House Number</label>
                                    <span id="house-number-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                                <?php
                                $purokOptions = ["", "Purok 1", "Purok 2", "Purok 3", "Purok 4", "Purok 5", "Purok 6", "Purok 7", "Purok 8"];
                                ?>
                                <div class="flex-grow">
                                    <select id="purok" name="purok" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-black text-sm">
                                        <?php foreach ($purokOptions as $purok): ?>
                                            <option value="<?=$purok?>" <?= ucwords($row['purok']) == $purok ? "selected" : "" ?>>
                                                <?=$purok == "" ? "Select Purok" : $purok ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="purok-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                            </div>
                            <div class="flex items-start justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="street-name" name="street_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['street_name']?>" placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Street Name</label>
                                    <span id="street-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                                <div class="flex-grow">
                                    <input id="barangay-name" name="barangay_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['barangay_name']?>" placeholder=" " disabled/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Barangay Buna Cerca</label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="municipality-city" name="municipality_city" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['municipality_city']?>" placeholder=" " disabled/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Indang</label>
                                </div>
                                <div class="flex-grow mr-2">
                                    <input id="province" name="province" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['province']?>" placeholder=" " disabled/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Cavite</label>
                                </div>
                                <div class="flex-grow">
                                    <input id="zip-code" name="zip_code" maxlength="4" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['zip_code']?>" placeholder=" " disabled/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">4122</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Civil status and citizenship -->
                <div class="rounded-lg p-2 mb-8">
                    <h2 class="text-xl font-bold mb-4 ">Civil Status and Citizenship</h2>
                    <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                        <div class="flex items-center justify-between">
                            <?php 
                            $civilStatusOptions = ["", "Single", "Married", "Divorced", "Separated", "Widowed"];
                            ?>
                            <div for="" class="flex flex-col flex-grow">
                                <select id="civil-status" name="civil_status" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                    <?php foreach($civilStatusOptions as $civilStatus): ?>
                                        <option value="<?=$civilStatus?>" <?= ucwords($row['civil_status']) == $civilStatus ? "selected" : "" ?>>
                                            <?=$civilStatus == "" ? "Select Civil Status" : $civilStatus?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="civil-status-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-grow mr-2">
                                <input id="citizenship" name="citizenship" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['citizenship']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Citizenship</label>
                                <span id="citizenship-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div class="flex-grow">
                                <input id="ethnicity" name="ethnicity" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['ethnicity']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Ethnicity</label>
                                <span id="ethnicity-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Residency -->
                <div class="rounded-lg p-2 mb-8">
                    <h2 class="text-xl font-bold mb-4">Residency and Occupation</h2>
                    <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                        <div>
                            <input id="occupation" name="occupation" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['occupation']?>" placeholder=" "/> 
                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Occupation</label>
                        </div>
                        <div class="flex grow">
                            <div class="flex flex-col w-full mr-2">
                                <?php
                                $residencyOptions = ["", "Permanent", "Temporary", "Student"];
                                ?>
                                <select id="residency-type" name="residency_type" class="border-2 border-gray-200 rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                    <?php foreach($residencyOptions as $residencyType): ?>
                                        <option value="<?=$residencyType?>" <?= ucwords($row['residency_type']) == $residencyType ? "selected" : "" ?>>
                                            <?=$residencyType == "" ? "Select Residency Type" : $residencyType?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="residency-type-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div class="flex flex-col w-full">
                                <?php
                                $statusOptions = ["", "Active", "Inactive"];
                                ?>
                                <select id="status" name="status" class="border-2 border-gray-200 rounded-md focus:outline-none focus:border-sg  p-2.1 text-sm">
                                    <?php foreach($statusOptions as $statusType): ?>
                                        <option value="<?=$statusType?>" <?= ucwords($row['status']) == $statusType ? "selected" : "" ?>>
                                            <?=$statusType == "" ? "Select Status" : $statusType?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="status-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Health -->
                <div class="rounded-lg p-2 mb-8">
                    <h2 class="text-xl font-bold mb-4 ">Health</h2>
                    <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                        <div class="flex items-center">
                            <div for="suffix" class=" flex-grow mr-2">
                                <?php
                                $bloodOptions = ["", "A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"]
                                ?>
                                <select id="blood-type" name="blood_type" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1  text-sm">
                                    <?php foreach($bloodOptions as $bloodType): ?>
                                        <option value="<?=$bloodType?>" <?= $row['blood_type'] == $bloodType ? "selected" : "" ?>>
                                            <?=$bloodType == "" ? "Select Blood Type" : $bloodType?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="flex-grow">
                                <input id="religion" name="religion" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" value="<?php echo $row['religion']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Religion</label>
                                <span id="religion-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-grow mr-2">
                                <input maxlength="3" id="height" name="height" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg "value="<?php echo $row['height']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Height</label>
                                <span class="absolute transform -translate-y-8 translate-x-22 std:translate-x-38 text-gray-500 text-sm">cm</span>
                            </div>
                            <div class="flex-grow mr-2">
                                <input maxlength="3" id="weight" name="weight" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg "value="<?php echo $row['weight']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Weight</label>
                                <span class="absolute transform -translate-y-8 translate-x-23 std:translate-x-38 text-gray-500 text-sm">kg</span>
                            </div>
                            <div class="flex-grow">
                                <input id="eye_color" name="eye_color" type="text"  autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg "value="<?php echo $row['eye_color']?>" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Eye Color</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-end gap-2">
                    <button name="update" class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">Update</button><br>
                    <button name="cancel" class="rounded-md border-2 border-c w-32 p-2 place-self-center hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700">Cancel</button><br>
                </div>
                <?php } ?>
            </form>
        </div>
        <!-- Right Section -->
        <div class="bg-sg ml-52 rounded-l-xl">
            
            <!-- Content -->
            <div class="sticky top-0">
                <!-- Back Button -->
                <div class="flex">
                <a href="../residentpage.php" class="flex items-center">
                    <div class="flex items-center p-2 rounded-md cursor-pointer transition duration-700 hover:scale-125 hover:animate-wiggle">
                        <img src="../../img/back-white.png" class="size-4" alt="select from records">
                    </div>
                    <p class="flex justify-start w-48 p-2 text-white">Back</p>
                </a>
                </div>
                <div class="px-12 std:px-32 sticky top-0">
                    <div class="bg-sg text-sg h-64"></div>
                    <div class="bg-sg p-12 std:p-16">
                        <h1 class="text-white text-xl std:text-3xl font-bold">Edit record</h1>
                        <p class="text-c text-sm std:text-base">Update existing data to ensure your records are accurate and current.</p>
                    </div>
                    <div class="bg-sg text-sg  h-64"></div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("personal_info");

        // Input fields
        const firstNameInput = document.getElementById("first-name");
        const lastNameInput = document.getElementById("last-name");
        const genderInput = document.getElementById("gender");

        const birthDateInput = document.getElementById("date-of-birth");
        const birthPlaceCityInput = document.getElementById("place-of-birth-city");
        const birthPlaceProvinceInput = document.getElementById("place-of-birth-province");
        const fatherInput = document.getElementById("father");
        const motherInput = document.getElementById("mother");
        
        const emailAddressInput = document.getElementById("email");
        const contactNumberInput = document.getElementById("contact-num");
        const contactNumber = document.getElementById("contact-num").value;

        const houseNumberInput = document.getElementById("house-number");
        const streetInput = document.getElementById("street-name");
        const purokInput = document.getElementById("purok");

        const civilStatusInput = document.getElementById("civil-status");
        const citizenshipInput = document.getElementById("citizenship");
        const ethnicityInput = document.getElementById("ethnicity");
        const residencyTypeInput = document.getElementById("residency-type");
        const statusInput = document.getElementById("status");
        const religionInput = document.getElementById("religion");

        // Error fields
        const firstNameError = document.getElementById("first-name-error");
        const lastNameError = document.getElementById("last-name-error");
        const genderError = document.getElementById("gender-error");

        const birthDateError = document.getElementById("birthdate-error");
        const birthPlaceCityError = document.getElementById("birthplace-city-error");
        const birthPlaceProvinceError = document.getElementById("birthplace-province-error");
        const fatherError = document.getElementById("father-error");
        const motherError = document.getElementById("mother-error");

        const emailAddressError = document.getElementById("email-address-error");
        const contactError = document.getElementById("contact-error");

        const houseNumberError = document.getElementById("house-number-error");
        const streetError = document.getElementById("street-name-error");
        const purokError = document.getElementById("purok-error");
        
        const civilStatusError = document.getElementById("civil-status-error");
        const citizenshipError = document.getElementById("citizenship-error");
        const ethnicityError = document.getElementById("ethnicity-error");
        const residencyTypeError = document.getElementById("residency-type-error");
        const statusError = document.getElementById("status-error");
        const religionError = document.getElementById("religion-error");

        const addButton = document.getElementById("add-button"); 
        const cancelButton = document.getElementById("cancel-button"); 

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
            // Validate Gender
            if (!genderInput.value.trim()) {
                isValid = false;
                genderError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || genderInput;
            } else {
                genderError.classList.add("hidden");
            }

            // Validate Birth Date
            if (!birthDateInput.value.trim()) {
                isValid = false;
                birthDateError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || birthDateInput;
            } else {
                birthDateError.classList.add("hidden");
            }
            // Validate Birth Place City
            if (!birthPlaceCityInput.value.trim()) {
                isValid = false;
                birthPlaceCityError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || birthPlaceCityInput;
            } else {
                birthPlaceCityError.classList.add("hidden");
            }
            // Validate Birth Place Province
            if (!birthPlaceProvinceInput.value.trim()) {
                isValid = false;
                birthPlaceProvinceError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || birthPlaceProvinceInput;
            } else {
                birthPlaceProvinceError.classList.add("hidden");
            }
            // Validate Father
            if (!fatherInput.value.trim()) {
                isValid = false;
                fatherError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || fatherInput;
            } else {
                fatherError.classList.add("hidden");
            }
            // Validate Mother 
            if (!motherInput.value.trim()) {
                isValid = false;
                motherError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || motherInput;
            } else {
                motherError.classList.add("hidden");
            }

            // Validate Email Address
            if (!emailAddressInput.value.trim()) {
                isValid = false;
                emailAddressError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || emailAddressInput;
            } else {
                emailAddressError.classList.add("hidden");
            } 
            // Check Contact Number
            if (!/^\d{11}$/.test(contactNumberInput.value.trim())) {
                isValid = false;
                event.preventDefault();
                contactError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || contactNumberInput;
            } else {
                contactError.classList.add("hidden");
            }

            // Validate House Number
            if (!houseNumberInput.value.trim()) {
                isValid = false;
                houseNumberError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || houseNumberInput;
            } else {
                houseNumberError.classList.add("hidden");
            }
            // Validate Street Name
            if (!streetInput.value.trim()) {
                isValid = false;
                streetError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || streetInput;
            } else {
                streetError.classList.add("hidden");
            }
            // Validate Purok
            if (!purokInput.value.trim()) {
                isValid = false;
                purokError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || purokInput;
            } else {
                purokError.classList.add("hidden");
            }

            // Validate Civil Status
            if (!civilStatusInput.value.trim()) {
                isValid = false;
                civilStatusError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || civilStatusInput;
            } else {
                civilStatusError.classList.add("hidden");
            }
            // Validate Citizenship
            if (!citizenshipInput.value.trim()) {
                isValid = false;
                citizenshipError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || citizenshipInput;
            } else {
                citizenshipError.classList.add("hidden");
            }
            // Validate Ethnicity
            if (!ethnicityInput.value.trim()) {
                isValid = false;
                ethnicityError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || ethnicityInput;
            } else {
                ethnicityError.classList.add("hidden");
            }
            // Validate Residency
            if (!residencyTypeInput.value.trim()) {
                isValid = false;
                residencyTypeError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || residencyTypeInput;
            } else {
                residencyTypeError.classList.add("hidden");
            }
            // Validate Status
            if (!statusInput.value.trim()) {
                isValid = false;
                statusError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || statusInput;
            } else {
                statusError.classList.add("hidden");
            }
            // Validate Religion
            if (!religionInput.value.trim()) {
                isValid = false;
                religionError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || religionInput;
            } else {
                religionError.classList.add("hidden");
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
                firstInvalidElement.scrollIntoView({ behavior: "smooth", block: "center" });
                firstInvalidElement.focus();
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
    $(document).ready(function() {
        // Input mask for the phone number
        $('#phone').inputmask({
            mask: '99999999999',
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
