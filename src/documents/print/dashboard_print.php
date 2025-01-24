<?php
session_start();
include("./../../backend/connection.php");
include("../../backend/dashboardreport.php");
require("./../../fpdf/fpdf.php");
require("./../../fpdi/FPDI-2.6.1/src/autoload.php");

use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();
$pdf->SetTitle('Barangay Management System');

//page start
$pdf -> AddPage('P', 'Legal');
$pdf -> SetFont("Arial", "", 11);
$pdf -> setSourceFile('./../../pdfs/dashboard_report_overview.pdf');
$template = $pdf->importPage(1);
$pdf->useTemplate($template);

$pdf->SetFont('Arial','',12);
//population overview
$pdf->Ln(68);
$pdf->SetLeftMargin(19);
$pdf->Cell(35, 11, $totalHouseHold, 0, 0, 'C');
$pdf->Cell(35, 11, $totalRes, 0, 0, 'C');
$pdf->Cell(35, 11, $active, 0, 0, 'C');
$pdf->Cell(25, 11, $permanent, 0, 0, 'C');
$pdf->Cell(24, 11, $temporary, 0, 0, 'C');
$pdf->Cell(24, 11, $student, 0, 1, 'C');
//community metrics
$pdf->Ln(16.5);
$pdf->SetLeftMargin(113);
$pdf->Cell(83.5, 6.5, $infant, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $toddler, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $child, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $teenager, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $youngAdult, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $middleAgedAdult, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $seniorAdult, 0, 1, 'C');
//gender breakdown
$pdf->Cell(83.5, 6.5, $male, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $female, 0, 1, 'C');
//civil status
$pdf->Cell(83.5, 6.5, $single, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $married, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $divorced, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $separated, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $widowed, 0, 1, 'C');
//blood type
$pdf->Cell(83.5, 6.5, $a_plus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $b_plus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $ab_plus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $o_plus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $a_minus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $b_minus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $ab_minus, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $o_minus, 0, 1, 'C');
$pdf->Ln(17);
//document issuance data
$pdf->Cell(83.5, 6.5, $totalDocs, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $brgyclr, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certIndigency, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certResidency, 0, 1, 'C');
$pdf->Ln(15);


$pdf->SetLeftMargin(148);
$pdf->SetFont('Times','I',12);
$pdf->Cell(52, 8.5, $formattedDate, 0, 1, 'C');

/*
Old format
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
*/
$pdf->Output();
