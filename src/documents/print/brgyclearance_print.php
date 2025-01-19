<?php
session_start();
include("./../../backend/connection.php");
require("./../../fpdf/fpdf.php");
require("./../../fpdi/FPDI-2.6.1/src/autoload.php");

use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();
//page start
$pdf -> AddPage();
$pdf -> SetFont("Arial", "", 11);
$pdf -> setSourceFile('./../../pdfs/BRGY.-CLEARANCE-NEW-KAP-2025.pdf');
$template = $pdf->importPage(1);
$pdf->useTemplate($template);
//fetch user issuedby
$userId = $_SESSION['users'];
$sql = 'SELECT * FROM users WHERE id = :id';  
$stmtuser = $dbh->prepare($sql);
$stmtuser->bindParam(':id', $userId, PDO::PARAM_INT);  
$stmtuser->execute();
$resultUser = $stmtuser->fetch(PDO::FETCH_ASSOC);
//fetch data from print history 
$id = $_GET['id']; 
$query = "SELECT * FROM `print_history` WHERE `id` = :id";
$stmt = $dbh->prepare($query);
$stmt->execute(['id' => $_GET['id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $fullName = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . " " . $row['suffix'];
    $age = $row['age'];
    $barangay_name = 'Barangay Buna Cerca';
    $print_date = $row['print_date'];
    $control_number = $row['control_number'];
    $ctc_number = $row['ctc_number'];
    $issued_by = $resultUser['username'];
    $purpose = $row['purpose'];

    //split the date 
    $dateParts = explode('-', $print_date);
    $year = (int)$dateParts[0];  // Year as an integer
    $month = (int)$dateParts[1]; // Month as an integer
    $day = (int)$dateParts[2];   // Day as an integer
    //convert to month name
    $monthName = date("F", mktime(0, 0, 0, $month, $day, $year));
    $daySuffix = "th"; //default th
    if ($day == 1 || $day == 21 || $day == 31) {
        $daySuffix = "st";
    } elseif ($day == 2 || $day == 22) {
        $daySuffix = "nd";
    } elseif ($day == 3 || $day == 23) {
        $daySuffix = "rd";
    }

    $pdf->SetXY(57, 59.5);
    $pdf->Write(0, $control_number);

    $pdf->SetXY(150, 99);
    $pdf->Write(0, $fullName);

    $pdf->SetXY(77, 104);
    $pdf->Write(0, $age);

    $pdf->SetXY(106, 138);
    $pdf->Write(0, $day . $daySuffix);

    $pdf->SetXY(132, 138);
    $pdf->Write(0, $monthName);

    $pdf->SetXY(93, 143);
    $pdf->Write(0, $purpose);

    $pdf->SetXY(100, 221);
    $pdf->Write(0, $ctc_number);

    $pdf->SetXY(97, 226.5);
    $pdf->Write(0, $print_date);

    $pdf->SetXY(96, 231.5);
    $pdf->Write(0, $barangay_name);

    $pdf->Output('I', 'generated.pdf');
} else {
    die('Error: No record found for the provided ID.');
}

?>