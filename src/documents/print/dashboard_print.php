<?php
session_start();
include("./../../backend/connection.php");
include("../../backend/dashboardreport.php");
require("./../../fpdf/fpdf.php");
require("./../../fpdi/FPDI-2.6.1/src/autoload.php");

use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();
$pdf->SetTitle('Barangay Management System');

$selectedPurok = isset($_GET['purokType']) ? $_GET['purokType'] : 'Overall';
$selectedPeriod = isset($_GET['timePeriod']) ? $_GET['timePeriod'] : 'weekly';
//page start
$pdf -> AddPage('P', 'Legal');
$pdf -> SetFont("Arial", "", 11);
$pdf -> setSourceFile('./../../pdfs/dashboard_report_overview.pdf');
$template = $pdf->importPage(1);
$pdf->useTemplate($template);

//population overview
$pdf->Ln(49);
$pdf->SetLeftMargin(19);
//selected purok
$pdf->SetFont('Times','B',12);
$pdf->Cell(177, 11, $selectedPurok, 0, 0, 'R');
$pdf->Ln(19);
$pdf->SetFont('Arial','',12);

if ($selectedPurok === 'Overall') {
    $pdf->Cell(35, 11, $totalHouseHold, 0, 0, 'C');
} else {
    $pdf->Cell(35, 11, $total, 0, 0, 'C');
}
$pdf->Cell(35, 11, $totalRes, 0, 0, 'C');
$pdf->Cell(35, 11, $totalActiveRes, 0, 0, 'C');
$pdf->Cell(25, 11, $permanent, 0, 0, 'C');
$pdf->Cell(24, 11, $temporary, 0, 0, 'C');
$pdf->Cell(24, 11, $student, 0, 1, 'C');
//selected purok
$pdf->Ln(7.5);
$pdf->SetFont('Times','B',12);
$pdf->Cell(177, 11, $selectedPurok, 0, 0, 'R');
//community metrics
$pdf->SetFont('Arial','',12);
$pdf->Ln(9);
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
$pdf->Ln(10.5);
//document issuance data
$pdf->SetFont('Times','B',12);
$pdf->Cell(83.5, 6.5, ucfirst(strtolower($selectedPeriod)), 0, 1, 'R');
$pdf->SetFont('Arial','',12);
if ($selectedPeriod === 'weekly') {
$pdf->Cell(83.5, 6.5, $totalWeeklyDocuments, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $brgyclrWeekly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certIndigencyWeekly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certResidencyWeekly, 0, 1, 'C');
} else if ($selectedPeriod  === 'monthly') { 
$pdf->Cell(83.5, 6.5, $totalDocsMonth, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $brgyclrMonthly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certIndigencyMonthly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certResidencyMonthly, 0, 1, 'C');
} else if ($selectedPeriod  === 'quarterly') { 
$pdf->Cell(83.5, 6.5, $totalDocsQuarterly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $brgyclrQuarterly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certIndigencyQuarterly, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certResidencyQuarterly, 0, 1, 'C');
} else if ($selectedPeriod  === 'annually') { 
$pdf->Cell(83.5, 6.5, $totalDocsAnnually, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $brgyclrAnnually, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certIndigencyAnnually, 0, 1, 'C');
$pdf->Cell(83.5, 6.5, $certResidencyAnnually, 0, 1, 'C');
}
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
