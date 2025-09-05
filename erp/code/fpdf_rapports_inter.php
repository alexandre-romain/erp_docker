<?php
require('fpdf/fpdf.php');
require('include/config/common.php');

//Récupération de l'ID inter
$inter = 	addslashes($_REQUEST['inter']);

//Récupération des informations servants à peupler le rapport
///Requête concernant l'inter
$sql_inter ="SELECT t.name as nom_inter, c.nom as cnom, c.rue as crue, c.numero as cnumero, c.ville as cville, c.cp as ccp, c.num_tva as cnum_tva, c.tel as ctel, c.mail as cmail, c.num_client as cnumclient, t.date_due as tdatedue, t.fact_num as tfactnum";
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
    // Logo
    $this->Image('image/logo_bl.jpg',11,25,30);
    // Police Arial gras 15
    $this->SetFont('Arial','B',13);
    // Titre
    $this->Cell(190,10,'Rapport Intervention : '.$date_due_ticket_final.'',1,0,'C');
    // Saut de ligne
    $this->Ln(20);
	//Infos Fast IT															//Infos Client
	$this->SetFont('Arial','',8);
	$this->Cell(120,4,'',0,0);												$this->Cell(60,5,'Client',1,1,'C');
	$this->Ln(5);
	$this->Cell(120,4,'',0,0);												$this->Cell(60,4,$results_inter->cnom,0,1);
	$this->Cell(120,4,'Rue de la Sitree, 17',0,0);							$this->Cell(90,4,$results_inter->crue.','.$results_inter->cnumero,0,1);
	$this->Cell(120,4,'4020 Vedrin (Namur)',0,0);							$this->Cell(90,4,$results_inter->ccp.' '.utf8_decode($results_inter->cville),0,1);
	$this->Cell(120,4,'Tel: 081/731404 Fax: 081/731406',0,0);				$this->Cell(90,4,'Tel: '.$results_inter->ctel,0,1);
	$this->Cell(120,4,'E-Mail: info@fastitservice.be',0,0);					$this->Cell(90,4,'E-Mail: '.$results_inter->cmail,0,1);
	$this->Cell(120,4,'Web: http://www.fastitservice.be',0,0);				$this->Cell(90,4,'Num. TVA: '.$results_inter->cnum_tva,0,1);
	// Saut de ligne
    $this->Ln(10);
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
//Header tableau Taches

$pdf->Cell(50,10,'Demande Client :',1,0,'C');$pdf->Cell(140,10,$results_inter->nom_inter,1,1,'C');
$pdf->Ln(15);
$pdf->SetFont('Arial','',12);
$pdf->Cell(65,10,'Tache',1,0,'C');$pdf->Cell(40,10,'Type',1,0,'C');$pdf->Cell(20,10,'Duree',1,0,'C');$pdf->Cell(30,10,'Deplacement',1,0,'C');$pdf->Cell(35,10,'Date',1,1,'C');	
//Contenu Taches
//Request Taches
$pdf->SetFont('Arial','',9);
$sql1 = "SELECT t.name as name, t.time_spent as time_spent, t.date_creation as date_creation, t.deplacement as tdeplacement, t.date_due as tdatedue, tt.type as tttype";
$sql1 .= " FROM ".$tblpref."task as t";
$sql1 .= " LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
$sql1 .= " LEFT JOIN ".$tblpref."type_task as tt ON tt.rowid=t.type";
$sql1 .= " WHERE ti.rowid=".$inter."";	
$reqsql=mysql_query($sql1);
while ($obj = mysql_fetch_object($reqsql)) {
	//On converti les déplacement en lettre
	if ($obj->tdeplacement == 0) {
		$deplacement='Aucun';
	}
	else if ($obj->tdeplacement == 1) {
		$deplacement='- 20km';
	}
	else if ($obj->tdeplacement == 2) {
		$deplacement='20 - 40km';
	}
	else if ($obj->tdeplacement == 3) {
		$deplacement='40+ km';
	}
	//Convertion des dates au format mysql
	$dateduetemp = explode(' ',$obj->tdatedue);
	$date = $dateduetemp[0];
	$datetemp = explode('-',$date);
	$heure = $dateduetemp[1];
	$jour = $datetemp[0];
	$mois = $datetemp[1];
	$annee = $datetemp[2];
	$date_due_ticket_correct=$annee."-".$mois."-".$jour;
	$date_due_ticket_final=$date_due_ticket_correct.' '.$heure;
	
	$pdf->Cell(65 ,10,stripslashes($obj->name),1,0,'C');$pdf->Cell(40,10,stripslashes($obj->tttype),1,0,'C');$pdf->Cell(20,10,$obj->time_spent,1,0,'C');$pdf->Cell(30,10,$deplacement,1,0,'C');$pdf->Cell(35,10,$date_due_ticket_final,1,1,'C');
	$prix_total_articles=$prix_total_articles+$obj->pricetot;
}
$pdf->Ln(15);

//ON recherche si le client dispose d'un abonnement
$sql_abo =" SELECT ID, temps_restant, deplacements_restant";
$sql_abo.=" FROM ".$tblpref."abos";
$sql_abo.=" WHERE client=".$cli." AND actif='oui'";
$req_abo=mysql_query($sql_abo);
if ($results_abo=mysql_fetch_object($req_abo)) {
	if  ($results_inter->tfactnum == 'ABONNEMENT') {
		$pdf->Cell(90,10,'',0,0); $pdf->Cell(60,10,'Minutes restantes sur l\'abonnement:',1,0,'C'); $pdf->Cell(40,10,$results_abo->temps_restant,1,1,'C');
		$pdf->Cell(90,10,'',0,0); $pdf->Cell(60,10,'Deplacements restants sur l\'abonnement:',1,0,'C'); $pdf->Cell(40,10,$results_abo->deplacements_restant,1,1,'C');
	}
}
/*$pdf->Cell(150,10,'',0,0); 	$pdf->Cell(40,10,'Acompte recu: ..............',0,1,'L');
$pdf->Cell(150,10,'',0,0);	$pdf->Cell(40,5,'Signature client',1,1,'L');
$pdf->Cell(150,10,'',0,0);	$pdf->Cell(40,10,'pour acquis,',0,1,'L');*/

$pdf->Output();
?>