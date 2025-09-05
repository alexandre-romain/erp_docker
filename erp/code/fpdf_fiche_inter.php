<?php
require('fpdf/fpdf.php');
require('include/config/common.php');

//Récupération de l'ID inter
$inter = 	addslashes($_REQUEST['inter']);

//Récupération des informations servants à peupler le rapport
///Requête concernant l'inter
$sql_inter ="SELECT t.name as nom_inter, c.nom as cnom, c.rue as crue, c.numero as cnumero, c.ville as cville, c.cp as ccp, c.num_tva as cnum_tva, c.tel as ctel, c.mail as cmail, c.num_client as cnumclient, t.date_due as tdatedue, t.fact_num as tfactnum, t.rowid as trowid, t.date_creation as datec, t.note as tnote";
$sql_inter.=" FROM ".$tblpref."ticket as t";
$sql_inter.=" LEFT JOIN ".$tblpref."client as c ON c.num_client=t.soc";
$sql_inter.=" WHERE rowid='".$inter."'";
$req_inter=mysql_query($sql_inter);
$results_inter=mysql_fetch_object($req_inter);
$cli=$results_inter->cnumclient;
class PDF extends FPDF
{
// En-tête
function Header()
{
	//On déclare le résultats de la requete, de manière à pouvoir l'utiliser dans la fonction
	global $results_inter;
	//Convertion des dates au format mysql
	$dateduetemp = explode(' ',$results_inter->tdatedue);
	$date = $dateduetemp[0];
	$datetemp = explode('-',$date);
	$heure = $dateduetemp[1];
	$jour = $datetemp[0];
	$mois = $datetemp[1];
	$annee = $datetemp[2];
	$date_due_ticket_correct=$annee."-".$mois."-".$jour;
	$date_due_ticket_final=$date_due_ticket_correct.' '.$heure;
    // Police Arial gras 15
    $this->SetFont('Arial','B',13);
    // Titre
    $this->Cell(190,10,'Fiche Intervention '.$results_inter->trowid.': '.$results_inter->nom_inter.'',1,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->SetFillColor(20,20,20);
//Header tableau Taches

$pdf->SetTextColor(255,255,255);$pdf->Cell(50,10,'Nom Client :',1,0,'C',1);$pdf->SetTextColor(20,20,20);$pdf->Cell(140,10,$results_inter->cnom,1,1,'C');
$pdf->SetTextColor(255,255,255);$pdf->Cell(50,10,'Date de creation :',1,0,'C',1);$pdf->SetTextColor(20,20,20);$pdf->Cell(140,10,$results_inter->datec,1,1,'C');
$pdf->SetTextColor(255,255,255);$pdf->Cell(50,10,'Demande :',1,0,'C',1);$pdf->SetTextColor(20,20,20);$pdf->Cell(140,10,$results_inter->nom_inter,1,1,'C');
$pdf->SetTextColor(255,255,255);$pdf->Cell(50,10,'Date d\'echeance :',1,0,'C',1);$pdf->SetTextColor(20,20,20);$pdf->Cell(140,10,$results_inter->tdatedue,1,1,'C');
$pdf->Ln(5);
	$pdf->SetTextColor(255,255,255);
$pdf->Cell(190,10,'Note',1,1,'C',1);
	$pdf->SetTextColor(20,20,20);
$pdf->MultiCell(0,5,$results_inter->tnote,1,1,'L');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);

$sql="SELECT t.name as tname, t.date_due as tdatedue, u.login as ulogin, tt.type as type";
$sql.=" FROM ".$tblpref."task as t";
$sql.=" LEFT JOIN ".$tblpref."user as u ON u.num = t.user_intervenant";
$sql.=" LEFT JOIN ".$tblpref."type_task as tt ON tt.rowid = t.type";
$sql.=" WHERE t.ticket_num=".$inter." and t.state='1'";
$req=mysql_query($sql);
$i=0;
while ($obj=mysql_fetch_object($req)) {
	if ($i == 0) {
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(190,10,'Taches deja realisees',1,1,'C',1);
		$pdf->SetTextColor(20,20,20);
		$pdf->Cell(95,10,'Tache',1,0,'C');$pdf->Cell(50,10,'Type',1,0,'C');$pdf->Cell(45,10,'Intervenant',1,1,'C');	
	}
	$pdf->Cell(95,10,$obj->tname,1,0,'C');$pdf->Cell(50,10,$obj->type,1,0,'C');$pdf->Cell(45,10,$obj->ulogin,1,1,'C');		
	$i++;
}

$pdf->Ln(10);
$pdf->SetFont('Arial','',12);

$sql="SELECT t.name as tname, t.date_due as tdatedue, u.login as ulogin, tt.type as type";
$sql.=" FROM ".$tblpref."task as t";
$sql.=" LEFT JOIN ".$tblpref."user as u ON u.num = t.user_intervenant";
$sql.=" LEFT JOIN ".$tblpref."type_task as tt ON tt.rowid = t.type";
$sql.=" WHERE t.ticket_num=".$inter." and t.state='0'";
$req=mysql_query($sql);
$x=0;
while ($obj=mysql_fetch_object($req)) {
	if ($x == 0) {
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(190,10,'Taches a realiser',1,1,'C',1);
		$pdf->SetTextColor(20,20,20);
		$pdf->Cell(65,10,'Tache',1,0,'C');$pdf->Cell(40,10,'Type',1,0,'C');$pdf->Cell(40,10,'Intervenant',1,0,'C');$pdf->Cell(45,10,'Date Echeance',1,1,'C');	
	}
	$pdf->Cell(65,10,$obj->tname,1,0,'C');$pdf->Cell(40,10,$obj->type,1,0,'C');$pdf->Cell(40,10,$obj->ulogin,1,0,'C');$pdf->Cell(45,10,$obj->tdatedue,1,1,'C');	
	$x++;
}

$pdf->Output();
?>