<?php
require('./fpdf.php');
require('../include/config/common.php');
//On va récupérer les informations du parc
$sql="SELECT * ";
$sql.=" FROM ".$tblpref."parcs as p";
$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = p.cli";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);

class PDF extends FPDF
{
	// En-tête
	function Header()
	{
		//On déclare le résultats de la requete, de manière à pouvoir l'utiliser dans la fonction
		global $obj;
		$this->Image('logo.jpg',11,6,50);
		// Police Arial gras 15
		$this->SetFont('Arial','',10);
		// En tête FASTIT
		$this->Cell(190,5,'Rue de la sitrée, 17',0,1,'R');
		$this->Cell(190,5,'5020 Vedrin (Namur)',0,1,'R');
		$this->Cell(190,5,'Tel : 081/731505 - Fax : 081/731506',0,1,'R');
		$this->Cell(190,5,'E-mail : info@fastitservice.be',0,1,'R');
		$this->Cell(190,5,'Web : http://www.fastitservice.be',0,1,'R');
		// Saut de ligne
		$this->Ln(5);
	}
	// Pied de page
	function Footer()
	{
		global $obj;
		// Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		// Police Arial italique 8
		$this->SetFont('Arial','I',8);
		// Numéro de page
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Cell(190,10,'Situation du parc informatique '.$obj->nom.' au '.date('d-m-Y'),1,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(52,152,219);
$pdf->Cell(38,10,'Serveur(s)',1,0,'C',1);
$pdf->SetFillColor(149,165,166);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(38,10,'PC fixe(s)',1,0,'C',1);
$pdf->SetFillColor(52,152,219);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(38,10,'Notebook(s)',1,0,'C',1);
$pdf->SetFillColor(149,165,166);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(38,10,'Mobile(s)',1,0,'C',1);
$pdf->SetFillColor(52,152,219);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(38,10,'Imprimante(s)',1,1,'C',1);
$pdf->Cell(38,10,$obj->nbr_server,1,0,'C',1);
$pdf->SetFillColor(149,165,166);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(38,10,$obj->nbr_pc,1,0,'C',1);
$pdf->SetFillColor(52,152,219);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(38,10,$obj->nbr_laptop,1,0,'C',1);
$pdf->SetFillColor(149,165,166);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(38,10,$obj->nbr_mobile,1,0,'C',1);
$pdf->SetFillColor(52,152,219);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(38,10,$obj->nbr_printer,1,1,'C',1);
$pdf->Output();
?>