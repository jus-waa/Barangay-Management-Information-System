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
$yourDynamicData = "Hello World";
$pdf->SetXY(57, 190);
$pdf->Write(0, $yourDynamicData);

$pdf->Output('I', 'generated.pdf');
?>