<?php
include("connection.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $query = "SELECT * FROM resident_info WHERE `id` = :id";
        $stmt = $dbh->prepare($query);
        $stmt->execute(['id' => $id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <!-- Info Details -->
            <div class="grid gap-2 text-black ">
                <!--Personal Info Summary -->
                <div class="grid-cols-2">
                    <p class="text-lg font-bold">Personal Information</p>
                    <!-- First Name -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>First Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['first_name']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Middle Name -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Middle Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li  class="text-sg text-sm italic font-normal"><?=$row['middle_name']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Last Name -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Last Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li  class="text-sg text-sm italic font-normal"><?=$row['last_name']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Suffix -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Suffix</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li  class="text-sg text-sm italic font-normal"><?=$row['suffix']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Gender -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Gender</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li  class="text-sg text-sm italic font-normal"><?=$row['gender']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Age -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Age</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li  class="text-sg text-sm italic font-normal"><?=$row['age']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Birth Details -->
                <div class="grid-cols-2">
                <p class="text-lg font-bold">Birth Details</p>
                    <!-- Birth Date-->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Date of Birth</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['birth_date']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Birthplace Municipality City -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Birthplace Municipality City</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['birthplace_municipality_city']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Birthplace Province -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Birthplace Province</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['birthplace_province']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Birthplace Province -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Father's Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['father_name']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Birthplace Province -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Mother's Maiden Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['mother_maiden_name']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Contact Number -->
                <div class="grid-cols-2">
                <p class="text-lg font-bold">Contact Number</p>
                    <!-- Birthplace Province -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Contact Number</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['contact_num']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Email Address -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Email Address</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['email_address']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Address Details -->
                <div class="grid-cols-2">
                <p class="text-lg font-bold">Address Details</p>
                    <!-- Birthplace Province -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>House Number</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['house_num']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Street Name -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Street Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['street_name']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Street Name -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Purok</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['purok']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Barnangay Name -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Barangay Name</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['barangay_name']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Municipality/City -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Municipality/City</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['municipality_city']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Province -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Province</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['province']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Zip Code -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Zip Code</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['zip_code']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Citizenship and Civil Status -->
                <div class="grid-cols-2">
                <p class="text-lg font-bold">Citizenship and Civil Status</p>
                    <!-- Civil Status -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Civil Status</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['civil_status']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Citizenship -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Citizenship</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['citizenship']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Citizenship -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Ethnicity</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['ethnicity']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Residency and Occupation -->
                <div class="grid-cols-2">
                <p class="text-lg font-bold">Residency and Occupation</p>
                    <!-- Occupation -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Occupation</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['occupation']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Type of Residency -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Type of Residency</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['residency_type']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Status</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['status']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Health -->
                <div class="grid-cols-2">
                <p class="text-lg font-bold">Health</p>
                    <!-- Height -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Height</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['height']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Weight -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Weight</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['weight']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Eye Color -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Eye Color</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['eye_color']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Bloodtype -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Blood Type</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['blood_type']?></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Religion -->
                    <div class="flex">
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li>Religion</li>
                            </ul>
                        </div>
                        <div class="w-6/12 ">
                            <ul class="ml-6 text-sm"> 
                                <li class="text-sg text-sm italic font-normal"><?=$row['religion']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "Resident not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
