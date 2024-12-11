<?php


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
            <form method="post" id="personal_info">
                <div class="grid grid-cols-2 ">
                    <!-- Back Button -->
                    <div class="grid justify-items-start pl-2">
                        <div class="flex">
                            <div class="flex items-center p-2 rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700">
                                <img src="../img/back.png" class="size-4" alt="select from records">
                            </div>
                            <p class="flex justify-start w-48 p-2 text-gray-400 ">Back</p>
                        </div>
                    </div>
                    <!-- Select from records -->
                    <div class="grid justify-items-end ">
                        <div class="flex">
                            <p class="flex justify-end w-48 p-2 text-gray-400 ">Select from Records</p>
                            <div class="rounded-md cursor-pointer border-2 hover:border-sg hover:bg-c transition duration-700">
                                <img src="../img/residency.svg" class="size-10 p-2" alt="select from records">
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input id="first-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">First Name</label>
                                        <span id="first-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                    </div>
                                    <div class="relative">
                                        <input id="middle-name" name="middle_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label id="middle-name-label" class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Middle Name</label>
                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <span class="flex-grow"></span>
                                            <input type="checkbox" id="no-middle-name" class="mr-2 border-gray-400" />
                                            <label for="no-middle-name" class="text-sm text-gray-500 mr-4">No Middle Name</label>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="last-name" name="last_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Last Name</label>
                                            <span id="last-name-error" class="text-red-500 text-sm hidden">Field is required</span>
                                        </div>
                                        <div for="suffix" class="flex flex-col flex-grow">
                                            <select id="suffix" name="suffix" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg p-2.1 text-gray-500 text-sm">
                                                <option value="">Select Suffix</option>
                                                <option value="Jr.">Jr.</option>
                                                <option value="Sr.">Sr.</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                                <option value="IV">IV</option>
                                                <option value="V">V</option>
                                                <option value="PhD">PhD</option>
                                                <option value="MD">MD</option>
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
                                        <input id="house-number" name="house_num" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                        <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">House Number</label>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="street-name" name="street_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Street Name</label>
                                        </div>
                                        <div class="flex-grow">
                                            <input id="barangay-name" name="barangay_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Barangay Name</label>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-grow mr-2">
                                            <input id="city-name" name="city_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">City Name</label>
                                        </div>
                                        <div class="flex-grow">
                                            <input id="zipcode" name="zipcode" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300 transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Zip Code</label>
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
                            <!-- Buttons -->
                            <div class="flex justify-end gap-2 pt-4">
                                <button type="submit" name="print" class="rounded-md bg-c w-32 p-2 place-self-center hover:bg-sg transition duration-700">Print</button><br>
                                <button name="cancel" class="rounded-md bg-c w-32 p-2 place-self-center hover:bg-sg transition duration-700">Cancel</button><br>
                            </div>
                        </div>
                    </div>
                </div>
            </form>   
        </div>
        <div class="w-full flex justify-center mt-12">
            <img src="../img/coat.png" alt="Bottom Image" class="w-[100px] h-[100px] object-contain">
        </div>
        <!--Delete Confirmation -->
        <div class="fixed z-50 hidden" id="confirmDeletion">
            <div class="border-4 w-screen h-screen flex justify-center items-center">
                <div class="absolute inset-0 bg-black opacity-50 w-screen h-screen grid"></div> <!-- Background overlay -->
                <div class="relative grid grid-cols-1 grid-rows-2 h-72 w-96 overflow-auto rounded-md bg-white z-10">
                    <div class="grid justify-center">
                        <div class="text-3xl font-bold place-self-center mt-12">Confirm Deletion</div>
                        <div class="mb-24 mt-4">Are you sure you want to delete this record?</div>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a id="deleteLink" href="#">
                            <button class="bg-sg rounded-md w-32 h-12">
                                Yes, Delete  
                            </button>
                        </a>
                        <button class="bg-sg rounded-md w-32 h-12" onclick="cancelConfirmation()">No</button>
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
    </script>
</body>
</html>
