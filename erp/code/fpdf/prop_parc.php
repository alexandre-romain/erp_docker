<?php
require('./fpdf.php');
require('../include/config/common.php');
//On va rÃ©cupÃ©rer les informations du parc
$id_parc=$_REQUEST['id_parc'];
$sql="SELECT * ";
$sql.=" FROM ".$tblpref."parcs as p";
$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = p.cli";
$sql.=" WHERE id='".$id_parc."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);

class PDF extends FPDF
{
	// En-tÃªte
	function Header()
	{
		//On dÃ©clare le rÃ©sultats de la requete, de maniÃ¨re Ã  pouvoir l'utiliser dans la fonction
		global $obj;
		$this->Image('logo.jpg',11,6,50);
		// Police Arial gras 15
		$this->SetFont('Arial','',10);
		// En tÃªte FASTIT
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
		// Positionnement Ã  1,5 cm du bas
		$this->SetY(-15);
		// Police Arial italique 8
		$this->SetFont('Arial','I',8);
		// NumÃ©ro de page
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,10,'',0,0,'L');
$pdf->SetFillColor(45,53,56);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(110,10,'Situation du parc informatique '.$obj->nom.' au '.date('d-m-Y'),0,1,'C',1);
$pdf->SetFont('Arial','',10);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(65,182,200);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(38,10,'Serveur(s)',1,0,'C',1);
$pdf->Cell(38,10,'PC fixe(s)',1,0,'C',1);
$pdf->Cell(38,10,'Notebook(s)',1,0,'C',1);
$pdf->Cell(38,10,'Mobile(s)',1,0,'C',1);
$pdf->Cell(38,10,'Imprimante(s)',1,1,'C',1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(38,10,$obj->nbr_server,1,0,'C');
$pdf->Cell(38,10,$obj->nbr_pc,1,0,'C');
$pdf->Cell(38,10,$obj->nbr_laptop,1,0,'C');
$pdf->Cell(38,10,$obj->nbr_mobile,1,0,'C');
$pdf->Cell(38,10,$obj->nbr_printer,1,1,'C');
$pdf->SetTextColor(0, 0, 0);

//Requète du contrat
$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id_parc."' AND actif='1'";
$req=mysql_query($sql);
$contrat_exist=mysql_num_rows($req);
//Si la proposition existe
if ($contrat_exist > 0) {
	$obj=mysql_fetch_object($req);
	$prix_t+=$obj->prix_traite;
	$prix_t_m+=$obj->prix_mois;
	if ($obj->type_fact == 'men') {
		$facturation='Mensuelle';
	}
	else if ($obj->type_fact == 'tri') {
		$facturation='Trimestrielle';
	}
	else if ($obj->type_fact == 'sem') {
		$facturation='Semestrielle';
	}
	else if ($obj->type_fact == 'ann') {
		$facturation='Annuelle';
	}
	$pdf->Ln(10);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15,10,'',0,0,'L');
	$pdf->SetFillColor(45,53,56);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(110,10,'Proposition de maintenance',0,1,'C',1);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->SetFillColor(65,182,200);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(90,10,'Périodicité de facturation',1,0,'C',1);
	$pdf->Cell(50,10,'Prix période HT',1,0,'C',1);
	$pdf->Cell(50,10,'Prix mensuel HT',1,1,'C',1);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(90,10,$facturation,1,0,'C');
	$pdf->Cell(50,10,$obj->prix_traite.' €',1,0,'C');
	$pdf->Cell(50,10,$obj->prix_mois.' €',1,1,'C');
}

//Requète du monitoring
$sql="SELECT * FROM ".$tblpref."monitoring WHERE id_parc='".$id_parc."' AND actif='1'";
$req=mysql_query($sql);
$monitoring_exist=mysql_num_rows($req);
//Si la proposition existe
if ($monitoring_exist > 0) {
	$obj=mysql_fetch_object($req);
	$prix_t+=$obj->prix_traite;
	$prix_t_m+=$obj->prix_mois;
	if ($obj->type_fact == 'men') {
		$facturation='Mensuelle';
	}
	else if ($obj->type_fact == 'tri') {
		$facturation='Trimestrielle';
	}
	else if ($obj->type_fact == 'sem') {
		$facturation='Semestrielle';
	}
	else if ($obj->type_fact == 'ann') {
		$facturation='Annuelle';
	}
	$pdf->Ln(10);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15,10,'',0,0,'L');
	$pdf->SetFillColor(45,53,56);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(110,10,'Proposition de monitoring',0,1,'C',1);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->SetFillColor(65,182,200);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(90,10,'Périodicité de facturation',1,0,'C',1);
	$pdf->Cell(50,10,'Prix période HT',1,0,'C',1);
	$pdf->Cell(50,10,'Prix mensuel HT',1,1,'C',1);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(90,10,$facturation,1,0,'C');
	$pdf->Cell(50,10,$obj->prix_traite.' €',1,0,'C');
	$pdf->Cell(50,10,$obj->prix_mois.' €',1,1,'C');
}
//TOTAL
if ($monitoring_exist > 0 && $contrat_exist > 0) {
	$pdf->Ln(10);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15,10,'',0,0,'L');
	$pdf->SetFillColor(45,53,56);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(110,10,'Total',0,1,'C',1);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->SetFillColor(65,182,200);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(90,10,'Périodicité de facturation',1,0,'C',1);
	$pdf->Cell(50,10,'Prix période HT',1,0,'C',1);
	$pdf->Cell(50,10,'Prix mensuel HT',1,1,'C',1);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(90,10,$facturation,1,0,'C');
	$pdf->Cell(50,10,$prix_t.' €',1,0,'C');
	$pdf->Cell(50,10,$prix_t_m.' €',1,1,'C');
}

$pdf->Output();
?>