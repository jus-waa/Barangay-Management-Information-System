<?php
include("../../backend/connection.php");
include("../../backend/dashboardreport.php");
require("../../fpdf/fpdf.php");

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

// header
$pdf->Ln(5);
$pdf->SetFont('Arial','B',24);
$pdf->Cell(84, 10, '', 0, 0, 'C');
$pdf->Cell(108, 5, 'Barangay Buna Cerca', 0, 0, 'C'); 
$pdf->Cell(84, 10, '', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(276, 10, 'Report Overview', 0, 1, 'C');
// total res, total docs issued, gender breakdown
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30, 10, '', 0, 0, 'C'); //Space
$pdf->Cell(38, 10, 'Total Households:', 0, 0, 'L');
$pdf->SetFont('Arial','',14);
$pdf->Cell(12, 10, $household, 0, 0, 'C'); 

$pdf->Cell(120.5, 10, '', 0, 0, 'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(54, 10, 'Gender Breakdown', 0, 1, 'C'); 

$pdf->SetFont('Arial','B',12);
$pdf->Cell(30, 10, '', 0, 0, 'C'); //Space
$pdf->Cell(34, 10, 'Total Residents:', 0, 0, 'L');
$pdf->SetFont('Arial','',14);
$pdf->Cell(12, 10, $i, 0, 0, 'C'); 

$pdf->Cell(104, 10, '', 0, 0, 'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40, 10, 'Male:', 0, 0, 'R'); 
$pdf->SetFont('Arial','',14);
$pdf->Cell(22, 10, $male, 0, 1, 'C'); 

$pdf->SetFont('Arial','B',12);
$pdf->Cell(30, 10, '', 0, 0, 'C'); //Space
$pdf->Cell(37, 10, 'Active Residents:', 0, 0, 'L');
$pdf->SetFont('Arial','',14);
$pdf->Cell(34, 10, $active . ' out of ' . $i, 0, 0, 'C'); 
$pdf->Cell(90.5, 10, '', 0, 0, 'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(34, 10, 'Female:', 0, 0, 'R'); 
$pdf->SetFont('Arial','',14);
$pdf->Cell(12, 10, $female, 0, 1, 'C'); 

$pdf->SetFont('Arial','B',12);
$pdf->Cell(30, 10, '', 0, 0, 'C'); //Space
$pdf->Cell(37, 10, 'Total Documents:', 0, 0, 'L');
$pdf->SetFont('Arial','',14);
$pdf->Cell(10, 10, $n, 0, 1, 'C'); 
$pdf->Ln(10);


// Weekly Document Issuance Report
$tableWidth = 124;

// Docs breakdown
$pdf->SetFont('Arial','B',12);
$pdf->Cell(15, 10, '', 0, 0, 'C'); //Space
$pdf->Cell($tableWidth, 10, 'Document Issuance Breakdown', 1, 0, 'C');
$pdf->Cell($tableWidth, 10, 'Weekly Document Issuance', 1, 1, 'C');
$pdf->Cell(15, 10, '', 0, 0, 'C'); //Space
$pdf->Cell(62, 10, 'Document Types', 1, 0, 'C');
$pdf->Cell(62, 10, 'Documents Issued', 1, 0, 'C');
$pdf->Cell(62, 10, 'Day of the Week', 1, 0, 'C');
$pdf->Cell(62, 10, 'Documents Issued', 1, 1, 'C');

// Document Types
$docsType = ['Barangay Clearance:', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
$docsIssued = [$brgyclr, 0, 0, 0, 0, 0, 0];

// Days of the week
$daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

$maxRows = max(count($docsType), count($daysOfWeek));

$pdf->SetFont('Arial', '', 12);
for ($i = 0; $i < $maxRows; $i++) {
    $pdf->Cell(15, 10, '', 0, 0, 'C'); //Space
    // Left column: Document Issuance Breakdown
    if (isset($docsType[$i])) {
        $pdf->Cell(62, 10, $docsType[$i], 1, 0, 'C');
        $pdf->Cell(62, 10, isset($docsIssued[$i]) ? $docsIssued[$i] : '-', 1, 0, 'C');
    } else {
        // Empty cells if data is shorter
        $pdf->Cell(62, 10, '', 1, 0, 'C');
        $pdf->Cell(62, 10, '', 1, 0, 'C');
    }
    // Right column: Weekly Document Issuance Report
    if (isset($daysOfWeek[$i])) {
        $pdf->Cell(62, 10, $daysOfWeek[$i], 1, 0, 'C');
        $pdf->Cell(62, 10, isset($documentCounts[$i]) ? $documentCounts[$i] : '-', 1, 1, 'C');
    } else {
        // Empty cells if data is shorter
        $pdf->Cell(62, 10, '', 1, 0, 'C');
        $pdf->Cell(62, 10, '', 1, 1, 'C');
    }
}
$pdf->Output();
?>