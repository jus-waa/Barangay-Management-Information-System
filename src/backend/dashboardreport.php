<?php
session_start();
include("connection.php");
require("../fpdf/fpdf.php");

//for resident info
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from resident info
$i = 0;
$male = 0;
$female = 0;
$active = 0;
$inactive = 0;
foreach ($result as $row) {
    // for total residents
    $i++;
    // for no. of male and female
    if ($row['gender'] == 'Male') {
        $male++;
    } else if ($row['gender'] == 'Female') {
        $female++;
    }
    // for active residents
    if ($row['status'] == 'Active') {
        $active++;
    } else if ($row['status'] == 'Inactive') {
        $inactive++;
    }
}

//for print history
$stmt = $dbh->prepare("SELECT * FROM `print_history`");
$stmt->execute();
$result_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from print history
$n = 0; //total number of printed docs
$brgyclr = 0;
foreach ($result_history as $rows) {
    $n++;
    //for no of brgy clearance
    if($rows['document_type'] === 'Barangay Clearance') {
        $brgyclr++;
    }
}

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

if($row) {
    //Header
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(84, 10, 'Hello', 1, 0, 'C');
    $pdf->Cell(108, 5, 'Barangay Buna Cerca', 1, 0, 'C'); 
    $pdf->Cell(84, 10, 'World!', 1, 1, 'C');

    $pdf->Cell(84, 10, '', 0, 1, 'C'); //Space

    //Total res, total docs issued, gender breakdown
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(40, 10, 'Total Residents:', 1, 0, 'L');
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(14, 10, $i, 1, 0, 'C'); 
    $pdf->Cell(168, 10, 'New Cell Content', 1, 0, 'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(54, 10, 'Gender Breakdown', 1, 1, 'C'); 

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(43, 10, 'Total Documents:', 1, 0, 'L');
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(14, 10, $n, 1, 0, 'C'); 
    $pdf->Cell(165, 10, 'New Cell Content', 1, 0, 'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(30, 10, 'Male:', 1, 0, 'R'); 
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(14, 10, $male, 1, 1, 'C'); 
    
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(43, 10, 'Active Residents:', 1, 0, 'L');
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(40, 10, $active . ' out of ' . $i, 1, 0, 'C'); 
    $pdf->Cell(139, 10, 'New Cell Content', 1, 0, 'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(30, 10, 'Female:', 1, 0, 'R'); 
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(14, 10, $female, 1, 1, 'C'); 

    $pdf->Cell(84, 10, '', 0, 1, 'C'); //Space

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(84, 10, 'Documents Issued Breakdown', 1, 1, 'C');
    $pdf->Cell(50, 10, 'Barangay Clearance:', 1, 0, 'C');
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(14, 10, $brgyclr, 1, 1, 'C'); 
    

    $pdf->Output();
} else {
    die('Error! no data.');
}

?>