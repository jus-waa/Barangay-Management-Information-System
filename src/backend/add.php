<?php
include("connection.php");

// add
if(isset($_POST['add'])) {
    try{
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $suffix = $_POST['suffix'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $birth_date = $_POST['birth_date'];
        $bp_municipality_city = $_POST['birthplace_municipality_city'];
        $bp_province = $_POST['birthplace_province'];
        $contact = $_POST['contact_num'];
        $email = $_POST['email_address'];
        $house_num = $_POST['house_num'];
        $street_name = $_POST['street_name'];
        $barangay_name = $_POST['barangay_name'];
        $municipality_city = $_POST['municipality_city'];
        $province = $_POST['province'];
        $zip_code = $_POST['zip_code'];
        $civil_status = $_POST['civil_status'];
        $citizenship = $_POST['citizenship'];
        $occupation = $_POST['occupation'];
        $residency_type = $_POST['residency_type'];
        $status = $_POST['status'];
        $blood_type = $_POST['blood_type'];
        $religion = $_POST['religion'];

        if($middle_name == NULL) {
            $middle_name = '';
        }

        $query = "INSERT INTO `resident_info`(`first_name`, `middle_name`, `last_name`, `suffix`, `gender`, `age`, `birth_date`, `birthplace_municipality_city`, `birthplace_province`, `contact_num`, `email_address`, `house_num`, `street_name`, `barangay_name`, `municipality_city`, `province`, `zip_code`, `civil_status`, `citizenship`, `occupation`, `residency_type`, `status`, `blood_type`, `religion`) 
                                        VALUES (:first_name, :middle_name, :last_name, :suffix, :gender, :age, :birth_date, :birthplace_municipality_city, :birthplace_province, :contact_num, :email_address, :house_num, :street_name, :barangay_name, :municipality_city, :province, :zip_code, :civil_status, :citizenship, :occupation, :residency_type, :status, :blood_type, :religion)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
        $stmt->bindParam(':birthplace_municipality_city', $bp_municipality_city, PDO::PARAM_STR);
        $stmt->bindParam(':birthplace_province', $bp_province, PDO::PARAM_STR);
        $stmt->bindParam(':contact_num', $contact, PDO::PARAM_STR);
        $stmt->bindParam(':email_address', $email, PDO::PARAM_STR);
        $stmt->bindParam(':house_num', $house_num, PDO::PARAM_STR);
        $stmt->bindParam(':street_name', $street_name, PDO::PARAM_STR);
        $stmt->bindParam(':barangay_name', $barangay_name, PDO::PARAM_STR);
        $stmt->bindParam(':municipality_city', $municipality_city, PDO::PARAM_STR);
        $stmt->bindParam(':province', $province, PDO::PARAM_STR);
        $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
        $stmt->bindParam(':civil_status', $civil_status, PDO::PARAM_STR);
        $stmt->bindParam(':citizenship', $citizenship, PDO::PARAM_STR);
        $stmt->bindParam(':occupation', $occupation, PDO::PARAM_STR);
        $stmt->bindParam(':residency_type', $residency_type, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':blood_type', $blood_type, PDO::PARAM_STR);
        $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
        $stmt->execute();
        //display if new record is added
        if($stmt) {
            header("location: ../residentpage.php?msg= Record added successfully.");
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
    <script src="../../script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <style>
    html {
    scroll-behavior: smooth;
    }
    </style>
</head>
<body class="inset-0 h-full w-full">
    <div class="grid grid-cols-[2.5fr_2fr_1fr]">
        <!-- Left Section -->
        <div class="bg-sg mr-52 rounded-r-xl">
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
                <div class="px-32 sticky top-0 ">
                    <!-- Text -->
                    <div class="bg-sg text-sg h-64"></div>
                    <div class="bg-sg  p-16">
                        <h1 class="text-white text-3xl font-bold">Add a new record</h1>
                        <p class="text-c mt-2">Enter and save important data to keep your database updated.</p>
                    </div>
                    <div class="bg-sg text-sg h-64"></div>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="w-full p-6">
            <form method="post" id=personal_info>
                <!-- Personal Information -->
                <div class="rounded-lg p-2 mb-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4 ">Personal Information</h2>
                     
                        <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                            <div>
                                <input id="first-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">First Name</label>
                                <span id="first-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                            </div>
                            <div class="relative">
                                <input id="middle-name" name="middle_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                <label id="middle-name-label" class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Middle Name</label>
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <span class="flex-grow"></span>
                                    <input type="checkbox" id="no-middle-name" class="mr-2 border-gray-400" />
                                    <label for="no-middle-name" class="text-sm text-gray-500 mr-4">No Middle Name</label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="last-name" name="last_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Last Name</label>
                                    <span id="last-name-error" class="text-red-500 text-sm hidden">Field is required</span>

                                </div>
                                <div for="suffix" class="flex flex-col flex-grow">
                                    <select id="suffix" name="suffix" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                        <option class="bg-white " value="">Suffix</option>
                                        <option class="bg-white" value="Jr.">Jr.</option>
                                        <option class="bg-white" value="Sr.">Sr.</option>
                                        <option class="bg-white" value="II">II</option>
                                        <option class="bg-white" value="III">III</option>
                                        <option class="bg-white" value="IV">IV</option>
                                        <option class="bg-white" value="V">V</option>
                                        <option class="bg-white" value="PhD">PhD</option>
                                        <option class="bg-white" value="MD">MD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="age" name="age" type="number" maxlength="3" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Age</label>
                                    <span id="age-error" class="text-red-500 text-sm hidden">Field is required</span>
                                </div>
                                <div for="gender"class="flex flex-col flex-grow">
                                    <select id="gender" name="gender" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                        <option class="bg-white " value="">Select Gender</option>
                                        <option class="bg-white" value="Male">Male</option>
                                        <option class="bg-white" value="Female">Female</option>
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
                                <input id="date-of-birth" name="birth_date" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  text-sm p-2.1 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Date of Birth</label>
                            </div>
                            <div>
                                <input id="place-of-birth-city" name="birthplace_municipality_city" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-4 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Place of Birth (Municipality/City)</label>
                            </div>
                            <div>
                                <input id="place-of-birth-province" name="birthplace_province" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-4 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Place of Birth (Province)</label>
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
                                <input id="email" name="email_address" type="email" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  text-sm p-2.1 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Email Address</label>
                            </div>
                            <div>
                                <input id="contact-num" name="contact_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Phone Number</label>
                                <span class="text-gray-400 text-sm">Format: 0999 999 9999</span><br>
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
                            <div>
                                <input id="house-number" name="house_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">House Number</label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="street-name" name="street_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Street Name</label>
                                </div>
                                <div class="flex-grow">
                                    <input id="barangay-name" name="barangay_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Barangay Name</label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="municipality-city" name="municipality_city" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Municipality/City</label>
                                </div>
                                <div class="flex-grow mr-2">
                                    <input id="province" name="province" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Province</label>
                                </div>
                                <div class="flex-grow">
                                    <input maxlength="4" id="zip-code" name="zip_code" type="text"  autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Zip Code</label>
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
                            <div for="suffix" class="flex flex-col flex-grow mr-2">
                                <select id="civil-status" name="civil_status" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                    <option value="">Select Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="flex-grow">
                                <input id="citizenship" name="citizenship" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Citizenship</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Residency -->
                <div class="rounded-lg p-2 mb-8">
                    <h2 class="text-xl font-bold mb-4">Residency and Occupation</h2>
                    <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                        <div>
                            <input id="occupation" name="occupation" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Occupation</label>
                        </div>
                        <div class="flex grow">
                            <div class="flex flex-col w-full mr-2">
                                <select id="residency-type" name="residency_type" class="border-2 border-gray-200 rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                    <option value="">Select Residency Type</option>
                                    <option value="Permanent">Permanent</option>
                                    <option value="Temporary">Temporary</option>
                                    <option value="Student">Student</option>
                                    
                                </select>
                            </div>
                            <div class="flex flex-col w-full">
                                <select id="status" name="status" class="border-2 border-gray-200 rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>    
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
                                <select id="blood-type" name="blood_type" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                    <option value="">Select Blood Type</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div class="flex-grow">
                                <input id="religion" name="religion" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Religion</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-end gap-2">
                    <button id="add-button" name="add" class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">Add</button><br>
                    <button id="cancel-button" name="cancel" class="rounded-md border-2 border-c w-32 p-2 place-self-center hover:bg-red-500 hover:border-red-500 hover:text-white transition duration-700"><a href="../residentpage.php">Cancel</a></button><br>
                </div>
            </form>
        </div>
        <!-- Right Section -->
        <div class="p-4">
            <h1 class="text-3xl font-bold"></h1>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("personal_info");
    const firstNameInput = document.getElementById("first-name");
    const lastNameInput = document.getElementById("last-name");
    const ageInput = document.getElementById("age");
    const genderInput = document.getElementById("gender");
    const contactNumberInput = document.getElementById("contact-num");
    const contactNumber = document.getElementById("contact-num").value;

    const firstNameError = document.getElementById("first-name-error");
    const lastNameError = document.getElementById("last-name-error");
    const ageError = document.getElementById("age-error");
    const genderError = document.getElementById("gender-error");
    const contactError = document.getElementById("contact-error");

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

            // Validate Age
            if (!ageInput.value.trim()) {
                isValid = false;
                ageError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || ageInput;
            } else {
                ageError.classList.add("hidden");
            }

            // Validate Gender
            if (!genderInput.value.trim()) {
                isValid = false;
                genderError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || genderInput;
            } else {
                genderError.classList.add("hidden");
            }

            // Check Contact Number
            if (!/^\d{4} \d{3} \d{4}$/.test(contactNumberInput.value.trim())) {
                isValid = false;
                event.preventDefault();
                contactError.classList.remove("hidden");
                firstInvalidElement = firstInvalidElement || contactNumberInput;
            } else {
                contactError.classList.add("hidden");
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
            mask: '9999 999 9999',
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
