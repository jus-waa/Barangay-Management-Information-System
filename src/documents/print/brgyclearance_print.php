<?php
session_start();
include("./../../backend/connection.php");
require("./../../fpdf/fpdf.php");
require("./../../fpdi/FPDI-2.6.1/src/autoload.php");

use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();

$pdf -> AddPage();
$pdf -> SetFont("helvetica", "", 11);
$pdf -> setSourceFile('./../../pdfs/demo_brgyclearance.pdf');
$template = $pdf->importPage(1);
$pdf->useTemplate($template);

$id = $_GET['id'];
$query = "SELECT * FROM `print_history` WHERE `id` = :id";
$stmt = $dbh->prepare($query);
$stmt->execute(['id' => $_GET['id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $dynamicData1 = $row['first_name'];
    $dynamicData2 = $row['middle_name'];
    $dynamicData3 = $row['last_name'];

    $pdf->SetXY(57, 190);
    $pdf->Write(0, $dynamicData1);

    $pdf->SetXY(127, 160);
    $pdf->Write(0, $dynamicData2);

    $pdf->SetXY(100, 68);
    $pdf->Write(0, $dynamicData3);

    $pdf->Output('I', 'generated.pdf');
} else {
    die('Error: No record found for the provided ID.');
}

?>