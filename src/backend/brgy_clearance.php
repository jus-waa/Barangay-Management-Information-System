<?php
require("fpdf/fpdf.php");
require_once("fpdi/FPDI-2.6.1/src/autoload.php");

use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();

$pdf -> AddPage();
$pdf -> SetFont("helvetica", "", 11);
$pdf -> setSourceFile('demo.pdf');
$template = $pdf->importPage(1);
$pdf->useTemplate($template);

$dynamicData1 = "Hello World";
$dynamicData2 = "Kapitan Juan dela Cruz";
$dynamicData3 = "Josh Andrei Lagrimas";

$pdf->SetXY(57, 190);
$pdf->Write(0, $dynamicData1);

$pdf->SetXY(127, 160);
$pdf->Write(0, $dynamicData2);

$pdf->SetXY(100, 68);
$pdf->Write(0, $dynamicData3);

$pdf->Output('I', 'generated.pdf');
?>