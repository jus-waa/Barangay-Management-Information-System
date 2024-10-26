<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management Sytem</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../script.js"></script>
</head>
<body class="absolute inset-0 h-full w-full bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <!--Header-->
    <div class="grid grid-cols-2 items-center">
        <div class="flex flex-row items-start ">
            <!--Nav-->
            <div onmouseover="hoverNav()" onmouseleave="leaveNav()" class="flex flex-col mr-12 rounded-b-full h-16 hover:h-52 bg-lg duration-500 ease-in-out">
                <button id="gen_doc" onmouseover="hoverDoc()" onmouseleave="leaveDoc()" class="w-20 mt-2 rounded-b-full flex">
                    <img  class="place-self-center size-12 ml-4 mb-2" src="../img/gen_doc.svg">
                    <span id="doc_title" class="hidden ml-8 z-10 p-2 border-4 border-dg rounded-full bg-lg min-w-52">Generate Documents</span>
                </button>
                <button id="res_info" onmouseover="hoverRes()" onmouseleave="leaveRes()" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                    <img  class="place-self-center size-12 ml-4 mb-2" src="../img/res_info.svg">
                    <span id="res_title" class="hidden ml-8 z-10 p-2 border-4 border-dg rounded-full bg-lg min-w-52">Resident Records</span>
                </button>
                <button id="setting" onmouseover="hoverSet()" onmouseleave="leaveSet()" class="w-20 opacity-0 mt-2 rounded-b-full flex">
                    <img class="place-self-center size-12 ml-4" src="../img/setting.svg" alt="System">
                    <span id="set_title" class="hidden ml-8 z-10 p-2 border-4 border-dg rounded-full bg-lg min-w-52" >System Settings</span>
                </button>
            </div>
            <!-- Left section: Title -->
            <div class="bg-lg w-3/5 p-4 pr-8 pl-8 mt-8 rounded-lg place-self-center mr-32">
                <h1 class="text-5xl font-bold mb-2 text-center">
                    Resident<br>Information
                </h1>
                <div class="bg-dg w-full h-10 rounded-lg"></div>
            </div>
        </div>
        <!-- Right section -->
        <div class="relative inline-block w-2/4 place-self-center ml-56">
            <div class="bg-lg h-12 rounded-lg flex items-center justify-center p-8">
                <h1 class="text-2xl font-bold text-center  ">
                    List of Records
                </h1>
            </div>
            <div class="bg-dg w-3/4 h-6 rounded-lg absolute right-0 top-14 -z-10"></div>
        </div>
    </div>
    <!-- Search and Add New Button -->
    <div class="flex justify-end items-center space-x-4 mr-32">
        <div class="relative">
            <input type="text" placeholder="Search..." class="border border-gray-300 rounded-md p-2 w-60 focus:outline-none h-8">
            <button class="rounded-sm absolute right-0 top-1/2 transform -translate-y-1/2 bg-lg p-2 h-full flex items-center justify-center hover:bg-[#579656] focus:outline-none">
                <img class="w-4 h-4" src="https://img.icons8.com/ios-filled/50/000000/search.png" alt="Search Icon"/>
            </button>
        </div>
        <button class="bg-lg text-black py-1 px-3 hover:bg-lg focus:outline-none rounded-sm">Add New</button>
    </div>
    <!-- Smaller Table with minimal padding and font size -->
    <div class="overflow-x-auto pr-32 pl-32 mt-4">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="text-gray-600 uppercase text-xs leading-none">
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Suffix</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Date of Birth</th>
                    <th>Birth Place</th>
                    <th>Civil Status</th>
                    <th>Citizenship</th>
                    <th>Occupation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-xs font-light">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="flex justify-center items-center">
                            <button class="w-3 mr-1 cursor-pointer">
                                <img src="https://img.icons8.com/ios-filled/50/000000/pencil.png" alt="edit" class="w-3 h-3" style="filter: brightness(0);" />
                            </button>
                            <button class="w-3 ml-1 cursor-pointer">
                                <img src="https://img.icons8.com/ios-filled/50/000000/trash.png" alt="delete" class="w-3 h-3" style="filter: brightness(0);" />
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
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
</script>
</body>
</html>