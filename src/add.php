<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body class="inset-0 h-full w-full">
    <div class="grid grid-cols-[2.5fr_2fr_1fr]">
        <!-- Left Section -->
        <div class="bg-sg mr-52 rounded-r-xl">
            <div class="px-32 sticky top-0">
                <div class="bg-sg text-sg h-64">.</div>
                <div class="bg-sg  p-16">
                    <h1 class="text-white text-3xl font-bold">Add a new record</h1>
                    <p class="text-c mt-2">Enter and save important data to keep your database updated.</p>
                </div>
                <div class="bg-sg text-sg h-64">.</div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="w-full p-6">
            <form class="">
                <!-- Personal Information -->
                <div class="rounded-lg p-2 mb-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4 ">Personal Information</h2>
                        <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                            <div>
                                <input id="first-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">First Name</label>
                            </div>
                            <div class="relative">
                                <input id="middle-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg" placeholder=" "/> 
                                <label id="middle-name-label" class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Middle Name</label>
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <span class="flex-grow"></span>
                                    <input type="checkbox" id="no-middle-name" class="mr-2 border-gray-400" />
                                    <label for="no-middle-name" class="text-sm text-gray-500 mr-4">No Middle Name</label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="last-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Last Name</label>
                                </div>
                                <div for="suffix" class="flex flex-col flex-grow">
                                    <select id="suffix" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
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
                                    <input id="age" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Age</label>
                                </div>
                                <div for="gender" class="flex flex-col flex-grow">
                                    <select id="gender" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                        <option class="bg-white" value="">Select Gender</option>
                                        <option class="bg-white" value="Male">Male</option>
                                        <option class="bg-white" value="Female">Female</option>
                                    </select>
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
                                <input id="date-of-birth" name="first_name" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  text-gray-500 text-sm p-2.1 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Date of Birth</label>
                            </div>
                            <div>
                                <input id="place-of-birth-city" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-4 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Place of Birth (Municipality/City)</label>
                            </div>
                            <div>
                                <input id="place-of-birth-province" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
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
                                <input id="email" name="first_name" type="email" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200  text-gray-500 text-sm p-2.1 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Email Address</label>
                            </div>
                            <div>
                                <input id="phone" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Phone Number</label>
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
                                <input id="house-number" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">House Number</label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="street-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Street Name</label>
                                </div>
                                <div class="flex-grow">
                                    <input id="barangay-name" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Barangay Name</label>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow mr-2">
                                    <input id="municipality-city" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Municipality/City</label>
                                </div>
                                <div class="flex-grow mr-2">
                                    <input id="province" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                    <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl ">Province</label>
                                </div>
                                <div class="flex-grow">
                                    <input id="zip-code" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
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
                                <select id="civil-status" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                    <option value="">Select Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="flex-grow">
                                <input id="citizenship" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Citizenship</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Residency -->
                <div class="rounded-lg p-2 mb-8">
                    <h2 class="text-xl font-bold mb-4">Residency and Occupation</h2>
                    <div class="border-2 grid grid-cols-1 gap-4 p-6 rounded-md hover:border-sg transition duration-700">
                        <div class="flex flex-col w-full">
                            <select id="residency-type" class="border-2 border-gray-200 rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
                                <option value="">Select Residency Type</option>
                                <option value="Owner">Owner</option>
                                <option value="Renter">Renter</option>
                                <option value="Co-owner">Co-owner</option>
                                <option value="Live-in Family Member">Live-in Family Member</option>
                                <option value="Roommate">Roommate</option>
                                <option value="Temporary Resident">Temporary Resident</option>
                                <option value="Subtenant">Subtenant</option>
                                <option value="Occupant">Occupant</option>
                            </select>
                        </div>
                        <div>
                            <input id="citizenship" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                            <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Citizenship</label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-grow mr-2">
                                <input id="start-date" name="first_name" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-2 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Start Date of Residency</label>
                            </div>
                            <div class="flex-grow">
                                <input id="end-date" name="first_name" type="date" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-2 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">End Date of Residency</label>
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
                                <select id="blood-type" class="border-2 border-gray-200 w-full rounded-md focus:outline-none focus:border-sg  p-2.1 text-gray-500 text-sm">
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
                                <input id="religion" name="first_name" type="text" autocomplete="off" class="block bg-transparent w-full border-2 border-gray-200 text-m p-2 peer rounded-md focus:outline-none focus:border-sg " placeholder=" "/> 
                                <label class="absolute text-gray-500 pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:translate-x-0 peer-focus:-translate-y-14 z-10 bg-white pl-1 text-left rounded-2xl">Religion</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-end gap-2">
                    <button class="rounded-md bg-c w-32 p-2 place-self-center hover:bg-sg transition duration-700">Add</button><br>
                    <button class="rounded-md bg-c w-32 p-2 place-self-center hover:bg-sg transition duration-700">Cancel</button><br>
                </div>
            </form>
        </div>
        <!-- Right Section -->
        <div class="p-4">
            <h1 class="text-3xl font-bold"></h1>
        </div>
    </div>

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
