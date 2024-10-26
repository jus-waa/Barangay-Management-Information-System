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
        <form class="grid grid-cols-[2fr,1fr,1fr] gap-12">
            <!-- First Column -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold">First name</label>
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Juan">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-bold">Middle Name</label>
                        <div class="flex items-center">
                            <input type="checkbox" id="noMiddleNameCheckbox" class="mr-1">
                            <label for="noMiddleNameCheckbox" class="text-xs">No Middle Name</label>
                        </div>
                    </div>
                    <input type="text" id="middleNameInput" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Dela">
                </div>
                <div>
                    <label class="block text-sm font-bold">Last name</label>
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Cruz">
                </div>
                <div>
                    <label class="block text-sm font-medium" style="font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">Suffix</label>
                    <select class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                        <option value="">Select Suffix</option>
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
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Indang Cavite">
                </div>
                <div>
                    <label class="block text-sm font-bold">Age</label>
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. 18">
                </div>
                <div>
                    <label class="block text-sm font-bold">Sex</label>
                    <select class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg " >
                        <option value="" disabled selected >Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold">Date of Birth</label>
                    <input type="date" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                </div>
            </div>

            <!-- Third Column -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold">Birth Place</label>
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Indang Cavite">
                </div>
                <div>
                    <label class="block text-sm font-bold">Civil Status</label>
                    <select class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg">
                        <option value="" disabled selected>Select Status</option>
                        <option value="Si">Single</option>
                        <option value="Ma">Married</option>
                        <option value="Wi">Widowed</option>
                        <option value="LS">Legally separated</option>
                    </select>
                </div>
                <div>
                <label class="block text-sm font-bold">Citizenship</label>
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Filipino">
                </div>
                <div>
                <label class="block text-sm font-bold">Occupation</label>
                    <input type="text" class="mt-1 w-full p-2 border-2 border-pg rounded-md focus:outline-sg" placeholder="e.g. Programmer">
                </div>
            </div>
        </form>

        <!-- Buttons -->
        <div class="mt-12 flex justify-end space-x-4">
            <button class="bg-pg text-black py-1 px-3 rounded-sm hover:bg-sg focus:outline-none">
                Add
            </button>
            <button class="bg-pg text-black py-1 px-3 rounded-sm hover:bg-sg focus:outline-none">
                Cancel
            </button>
        </div>
    </div>
    <script>
        document.getElementById('noMiddleNameCheckbox').addEventListener('change', function() {
            const middleNameInput = document.getElementById('middleNameInput');
            middleNameInput.disabled = this.checked; // Disable input if checkbox is checked
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