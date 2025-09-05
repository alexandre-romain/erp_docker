<?php
define('FPDF_FONTPATH','font/');
require('table_pdf.php');

$pdf=new PDF_MC_Table();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(30,50,30,40));
srand(microtime()*1000000);
//for($i=0;$i<20;$i++)
	$pdf->Row(array(mot1,mot2,mot3,mot4));
	$pdf->Row(array(mot1,mot2,mot3,mot4));
$pdf->Output();
?>
