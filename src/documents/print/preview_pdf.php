<?php
// Get the file from the query string
$file = $_GET['file'];

if (!$file || !file_exists($file)) {
    echo "PDF preview not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\output.css">
    <script src="../../../script.js"></script>
    <title>PDF Preview</title>
</head>
<body>
    <div class="grid grid-cols-2 h-screen border-2 border-red-500">
        <div class="border-2">
            <button onclick="window.print()">Print</button>
            <a href="<?php echo htmlspecialchars($file);?>" download>Download</a>
        </div>
        <div class="flex flex-col items-center justify-center space-y-4 border-2 border-black">
                <iframe src="<?php echo htmlspecialchars($file);?>" class="w-3/5 h-[90%]"></iframe>
                <div class="flex space-x-2">
                    <button class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300" onclick="window.print()">Print</button>
                    <a  href="<?php echo htmlspecialchars($file);?>" download><button class="rounded-md w-32 border-2 border-c bg-c p-2 place-self-center hover:border-sg hover:bg-sg hover:text-white transition duration-300">Download</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
