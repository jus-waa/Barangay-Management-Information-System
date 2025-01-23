<?php
session_start();
include("./../../backend/connection.php");
include("../../backend/dashboardreport.php");
require("./../../fpdf/fpdf.php");
require("./../../fpdi/FPDI-2.6.1/src/autoload.php");

use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();
//page start
$pdf -> AddPage('P', 'Legal');
$pdf -> SetFont("times", "", 11);
$pdf -> setSourceFile('./../../pdfs/transaction_history_overview.pdf');
$template = $pdf->importPage(1);
$pdf->useTemplate($template);

$pdf->SetFont('Times','B',12);
//population overview
$pdf->Ln(51);
$pdf->SetLeftMargin(19);
$pdf->SetFillColor(255, 229, 153);
$pdf->Cell(178, 7, "PREVIOUS RECORDS", 1, 1, 'L', true);

$pdf->SetFont('Times','',12);
$pdf->SetLeftMargin(19);
$pdf->Cell(35, 11, $totalHouseHold, 0, 0, 'C');
$pdf->Cell(35, 11, $totalRes, 1, 0, 'C');
$pdf->Cell(35, 11, $active, 0, 0, 'C');
$pdf->Cell(25, 11, $permanent, 0, 0, 'C');
$pdf->Cell(24, 11, $temporary, 0, 0, 'C');
$pdf->Cell(24, 11, $student, 0, 1, 'C');



$pdf->Output();
?>