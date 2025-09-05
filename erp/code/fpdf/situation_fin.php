<?php
include("../include/config/common.php");
include("../include/fonctions.php");
session_cache_limiter('private');
if ($_GET['pdf_user']=='adm') {
require_once("../include/verif.php");
} else {
require_once("../include/verif_client.php");
}
error_reporting(0);
define('FPDF_FONTPATH','font/');
require("../include/config/var.php");	
require("../include/configav.php");	
require_once("../include/language/$lang.php");
require('mysql_table.php');

//fONCTION EXTENDED FPDF
class PDF extends PDF_MySQL_Table
{
	//debut Js
	var $javascript;
	var $n_js;

	function IncludeJS($script) {
		$this->javascript=$script;
	}

	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS '.$this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (isset($this->javascript)) {
			$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}
	
	function AutoPrint($dialog=false, $nb_impr) {
		//Ajoute du JavaScript pour lancer la boîte d'impression ou imprimer immediatement
		$param=($dialog ? 'true' : 'false');
		$script=str_repeat("print($param);",$nb_impr);
			
		$this->IncludeJS($script);
	}
	//fin js
	function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
	{
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
		elseif($style=='FD' or $style=='DF')
			$op='B';
		else
			$op='S';
		$MyArc = 4/3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

		$xc = $x+$w-$r;
		$yc = $y+$r;
		$this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
		if (strpos($angle, '2')===false)
			$this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
		else
			$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

		$xc = $x+$w-$r;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
		if (strpos($angle, '3')===false)
			$this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
		else
			$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

		$xc = $x+$r;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
		if (strpos($angle, '4')===false)
			$this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
		else
			$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

		$xc = $x+$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
		if (strpos($angle, '1')===false)
		{
			$this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
			$this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
		}
		else
			$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}
	
	function Footer() //imprime le contenu bas de page
	{
	//n° page
	$this->SetFont('Arial','',8);
	$this->SetY(-15);
	$this->SetX(158);
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');	
	
	//banque
	$this->SetFont('Arial','B',8);
	$this->SetTextColor(255,0,0);
	$this->SetY(-15);
	$this->SetX(70);
	$this->MultiCell(70,4,"IBAN : BE70 3630 8937 4325\nBIC/SWIFT : BBRUBEBB",0,C,0);	
	//déco bas de page
	//$this->SetFillColor(255,255,255);
	//$this->RoundedRect(12, -15, 186, 8, 3, 'DF', '1234');
	}
	function imprimer_contenu($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client)
	{
	//la référence client
	$this->SetFont('Arial','',9);
	$this->SetY(6);
	$this->SetX(113);
	$this->MultiCell(85,6,"Référence client : $num_client",0,C,0);//
	//les coordonées clients
	$this->SetFont('Arial','',9);
	$this->SetY(23);
	$this->SetX(113);
	$this->MultiCell(85,6,"\n $nom \n $nom2 \n $rue $numero $boite \n $cp  $ville \n ",0,C,0);

	//Troisieme cellule les coordonées entreprise
	$this->SetFont('Arial','',9);
	$this->SetY(47);
	$this->SetX(12);
	$this->MultiCell(85,5,"\n$social_rue\n$social_cp $social_ville\n$tel $fax\n$mail\n$web\n",0,C,0);
	
	//cellule coordonnées client2
	$this->SetFont('Arial','',9);
	$this->SetY(70);
	$this->SetX(113);
	$this->MultiCell(85,6,"Tél. : $tel_client   Fax : $fax_client\nEmail : $mail_client",0,C,0);	

	//TVA entreprise
	$this->SetFont('Arial','',10);
	$this->SetY(85);
	$this->SetX(12);
	$this->Cell(85,6,"TVA : $tva_vend",0,0,'C',0);

	//TVA client
	$this->SetFont('Arial','',10);
	$this->SetY(85);
	$this->SetX(113);
	$this->Cell(85,6,"TVA : $num_tva",0,0,'C',0);

	//N° document
	$this->SetFont('Arial','B',10);
	$this->SetY(94);
	$this->SetX(12);
	$this->Cell(85,6,"Facture n° : $date_num_doc-$num_doc",0,0,'C',0);

	//Date
	$this->SetFont('Arial','',10);
	$this->SetY(94);
	$this->SetX(113);
	$this->Cell(41,6,"Date : $date_doc",0,0,'C',0);

	//Echeance
	$this->SetFont('Arial','',10);
	$this->SetY(94);
	$this->SetX(157);
	$this->Cell(41,6,"Echeance : $echeance",0,0,'C',0);
	}
}

//Construction des variables.
$euro= '€';
$devise = ereg_replace('&#128;', $euro, $devise);
$entrep_nom= stripslashes($entrep_nom);
$tel= stripslashes($tel);
$tva_vend= stripslashes($tva_vend);
$compte= stripslashes($compte);
$mail= stripslashes($mail);	

$pdf=new PDF();
$pdf->AliasNbPages(); 
$pdf->Open();

//Récapitulatif des comptes pour le client
$cli=$_REQUEST['cli'];
//pour le nom de client
$sql1 = "SELECT * FROM " . $tblpref ."client WHERE num_client = '".$cli."'";
$req = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$num_client = $data['num_client'];
	$nom = $data['nom'];
	$rue = $data['rue'];
	$numero = $data['numero'];
	$boite = $data['boite'];
	$cp = $data['cp'];
	$ville = $data['ville'];
}
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetY(44.5);
$pdf->SetX(99);
$pdf->Cell(190,5,$nom,0,1,'L');
$pdf->SetX(99);
if ($boite != '') {
	$pdf->Cell(190,5,$rue.', '.$numero.' Boite '.$boite,0,1,'L');
}
else {
	$pdf->Cell(190,5,$rue.', '.$numero,0,1,'L');
}
$pdf->SetX(99);
$pdf->Cell(190,5,$cp.' '.$ville,0,1,'L');
$pdf->Line(0,111,210,111);
// En tête FASTIT
//On récupère le total des facture
$sql_tot="SELECT SUM(total_fact_ttc) as total FROM ".$tblpref."facture WHERE payement='non' AND client = '".$cli."'";
$req_tot=mysql_query($sql_tot);
$obj_tot=mysql_fetch_object($req_tot);
$total_imp=$obj_tot->total;
$pdf->AddPage();
$pdf->Image('logo.jpg',11,6,50);
// Police Arial gras 15
$pdf->SetFont('Arial','',10);
// En tête FASTIT
$pdf->Cell(190,5,'Rue de la Sitrée, 17',0,1,'R');
$pdf->Cell(190,5,'5020 Vedrin (Namur)',0,1,'R');
$pdf->Cell(190,5,'Tel : 081/731505 - Fax : 081/731506',0,1,'R');
$pdf->Cell(190,5,'E-mail : compta@fastitservice.be',0,1,'R');
$pdf->Cell(190,5,'Web : http://www.fastitservice.be',0,1,'R');
// Saut de ligne
$pdf->Ln(5);
//Message situation financière
$pdf->SetFillColor(65,182,200);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(190,10,'Etat du compte client "'.$nom.'" au '.date('d-m-Y'),0,1,'C',1);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->Ln(5);
$pdf->MultiCell(190,5,'Madame, Monsieur,',0);
$pdf->Ln(5);
$pdf->MultiCell(190,5,'Sauf erreur ou omission de notre part, nous constatons que votre compte client présente à ce jour un solde débiteur de '.$total_imp.' euros TVAC.
Ce montant correspond à une ou plusieurs factures dont vous trouverez le détail ci-dessous. Nous vous joignons également des copies de ces factures.',0);
$pdf->Ln(2);
$pdf->MultiCell(190,5,'L’échéance étant dépassée, nous vous prions de bien vouloir régulariser cette situation au plus vite. 
Dans le cas où vous auriez réglé ces montants entretemps, merci de ne pas tenir compte du présent courrier.',0);
$pdf->Ln(5);
$pdf->MultiCell(190,5,'Vous remerciant de votre réaction rapide, veuillez agréer, Madame, Monsieur, l’expression de nos salutations distinguées.',0);
$pdf->Cell(190,5,'Fast IT Service',0,1,'R');
$pdf->Ln(10);
//Détails des impayés
$pdf->SetFillColor(65,182,200);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(190,10,'Détail des impayés',0,1,'C',1);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->Ln(5);
$pdf->SetFillColor(45,53,55);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(45,53,55);
$pdf->Cell(70,10,'N° facture',1,0,'C',1);
$pdf->Cell(60,10,'Echéance',1,0,'C',1);
$pdf->Cell(60,10,'Solde dû',1,1,'C',1);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
//On récupère le total des facture
$sql="SELECT * FROM ".$tblpref."facture WHERE payement='non' AND client = '".$cli."'";
$req=mysql_query($sql);
while ($obj=mysql_fetch_object($req)) {
	$date_fact=$obj->date_fact;
	$ref=str_replace('-','',$date_fact);
	$pdf->Cell(70,10,$ref.'-'.$obj->num,1,0,'C');
	$pdf->Cell(60,10,dateUSA_to_dateEU($obj->echeance_fact),1,0,'C');
	$pdf->Cell(60,10,$obj->total_fact_ttc.' €',1,1,'C');
}
$pdf->Cell(70,10,'',0,0,'C');
$pdf->SetFillColor(45,53,55);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(45,53,55);
$pdf->Cell(60,10,'Total :',1,0,'R',1);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(60,10,$total_imp.' €',1,1,'C');
//On boucle sur les factures
$sql_boucle="SELECT * FROM ".$tblpref."facture WHERE payement='non' AND client = '".$cli."'";
$req_boucle=mysql_query($sql_boucle);
///Boucle sur les factures 
while ($obj_boucle = mysql_fetch_object($req_boucle)) {
	$num_doc=$obj_boucle->num;	
	//pour la date
	$sql = "select acompte, coment, total_fact_h, DATE_FORMAT(echeance_fact,'%d/%m/%Y') AS echeance, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_2,DATE_FORMAT(date_fact,'%Y%m%d') AS date_3,tva from " . $tblpref ."facture where num = $num_doc";
	$req = mysql_query($sql) or die('Erreur SQL!<br>'.$sql.'<br>'.mysql_error());
	$data = mysql_fetch_array($req);
	$date_doc = $data[date_2];
	$echeance = $data[echeance];
	$date_num_doc = $data[date_3];
	$total_htva = $data[total_fact_h];
	$total_tva = 0;
	$intracom = $data['tva'];
	
	if($intracom == "non")
	{
	$total_tva = $total_htva/100*21;
	}
	
	$coment = $data[coment];
	$acompte = $data['acompte'];
	$tot_tva_inc = $total_htva + $total_tva ;
	
	
	//pour le nom de client
	$sql1 = "SELECT num_client, mail, nom, nom2, rue, numero, boite, ville, cp, num_tva, tel AS tel_client, fax AS fax_client FROM " . $tblpref ."client RIGHT JOIN " . $tblpref ."facture on CLIENT = num_client WHERE  num = $num_doc";
	$req = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req))
	{
		$num_client = $data['num_client'];
		$nom = $data['nom'];
		$nom2 = $data['nom2'];
		if ($nom2 == $nom){$nom2 ='';}
		$rue = $data['rue'];
		$numero = $data['numero'];
		$boite = $data['boite'];
		$ville = utf8_decode($data['ville']);
		$cp = $data['cp'];
		$num_tva = $data['num_tva'];
		$tel_client = $data['tel_client'];
		$fax_client = $data['fax_client'];
		$mail_client = $data['mail'];
	}
	$pdf->AddPage();
	///HEADER FACT
	//la grande cellule sous le tableau
	$pdf->SetFillColor(235,235,235);
	$pdf->SetFont('Arial','B',6);
	$pdf->SetY(105);
	$pdf->SetX(12);
	$pdf->Cell(186,115,"",1,0,'C',1);
	//le logo
	$pdf->Image("logo_bl.jpg",21,8,67,0,'JPG');
	//déco coordonnées client
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(113, 23, 85, 36, 3.5, 'DF', '1234');
	$pdf->SetFillColor(245,245,245);
	//déco tva entreprise
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(12, 85, 85, 6, 3, 'DF', '1234');
	$pdf->SetFillColor(245,245,245);
	//déco tva client
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(113, 85, 85, 6, 3, 'DF', '1234');
	$pdf->SetFillColor(245,245,245);
	//déco n° doc
	$pdf->RoundedRect(12, 94, 85, 6, 3, 'DF','1234');
	//déco date
	$pdf->RoundedRect(113, 94, 41, 6, 3, 'DF','1234');	
	//déco echeance
	$pdf->RoundedRect(157, 94, 41, 6, 3, 'DF','1234');
	///FIN HEADER FACT
	///FOOTER FACT
	//Pour reception
	$pdf->SetFont('Arial','',8);
	$pdf->SetY(-28);
	$pdf->SetX(12);
	$pdf->MultiCell(30,4,"Pour réception,",0,C,0);	
	//cachet
	$pdf->SetFont('Arial','',8);
	$pdf->SetY(-28);
	$pdf->SetX(42);
	$pdf->MultiCell(30,4,"Cachet du client",0,C,0);
	///FIN FOOTER FACT
	$pdf->imprimer_contenu($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client);
	$pdf->SetFont('Arial','',9);
	//Tableau
	$pdf->SetFillColor(235,235,235);
	$pdf->SetY(105);
	$pdf->SetX(12);
	
	// titre du tableau
	srand(microtime()*1000000);
	
	//BONS DE LIVRAISON
	$sql = "SELECT DATE_FORMAT(date,'%d/%m/%Y') AS date, num_bl, tot_htva, tot_tva FROM " . $tblpref ."bl 
			WHERE  fact_num = $num_doc";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	
	$total_recupel = '0.00';
	$total_reprobel = '0.00';
	$total_bebat = '0.00';
	$total_auvibel = '0.00';
	
			while($data = mysql_fetch_array($req))
			{
			$num_bl = $data['num_bl'];
			$date_bl = $data['date'];
				//on écrit une ligne avec le N° de bl pour référence
				$pdf->SetFillColor(235,235,235);	
				$pdf->SetWidths(array(186));
				$pdf->SetX(12);
				$pdf->Cell(186,10,"Bon de livraison n°".$num_bl." du ".$date_bl."",1,1,'C');
				$pdf->Ln(1);
				$pdf->SetX(12);
				$pdf->SetWidths(array(20,81,35,10,20,20));
				$pdf->Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array(Marque,Description,Reference,Qte,PU,'Total HTVA'));
				$pdf->Ln(1);
				$pdf->SetX(12);
				$pdf->SetWidths(array(35,15,15,15,15,91));
				$pdf->Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array(Garantie,Recupel,Reprobel,Bebat,Auvibel,'N° de Série'));
				$pdf->Ln(1);
				$sql2 = "SELECT ".$tblpref."cont_bl.num, ".$tblpref."cont_bl.article_name, reference, marque, recupel, reprobel, bebat, auvibel, garantie, quanti, serial, uni, article, taux_tva, prix_htva, p_u_jour, tot_art_htva FROM " . $tblpref ."cont_bl RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bl.article_num = " . $tblpref ."article.num WHERE  bl_num = $num_bl";
				$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
				while($data2 = mysql_fetch_array($req2))
				{
		
				$reference = $data2['reference'];
				$article = $data2['article'];
				$article_name = $data2['article_name'];
				if ($article_name != NULL && $article_name != '') {
					$article=$article_name;
				}
				$marque = $data2['marque'];
				$uni = $data2['uni'];
				$quanti = $data2['quanti'];
				$p_u_jour = $data2['p_u_jour'];
				$tot_art_htva = $data2['tot_art_htva'];
				$garantie = $data2['garantie'];
				$recupel = $data2['recupel'];
				$reprobel = $data2['reprobel'];
				$bebat = $data2['bebat'];
				$auvibel = $data2['auvibel'];
				$serial = $data2['serial'];
					if ($bebat != '0')
					{
					$total_bebat = $total_bebat + ($bebat*$quanti);
					}
					if ($recupel != '0')
					{
					$total_recupel = $total_recupel + ($recupel*$quanti);
					}
					if ($reprobel != '0')
					{
					$total_reprobel = $total_reprobel + ($reprobel*$quanti);
					}
					if ($auvibel != '0')
					{
					$total_auvibel = $total_auvibel + ($auvibel*$quanti);
					}
				$pdf->SetFillColor(255,255,255);	
				$pdf->SetWidths(array(20,81,35,10,20,20));
				$pdf->SetX(12);
				$pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array($marque,$article,$reference,$quanti,$p_u_jour." €",$tot_art_htva." €"));
				$pdf->SetX(12);
				$pdf->SetWidths(array(35,15,15,15,15,91));
				$pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array($garantie,$recupel." €",$reprobel." €",$bebat." €",$auvibel." €",$serial));
				$pdf->Ln(1);
				$pdf->SetX(12);
				$pdf->SetWidths(array(35,20,81,15,15,20));
				}
	}
	// INTERVENTIONS
			/*$sql3 = "SELECT DATE_FORMAT(date,'%d/%m/%Y') AS date, num_inter, cause, debut, fin, type_deplacement, tarif_special,nbtrav FROM " . $tblpref ."interventions 
			WHERE  fact_num = $num_doc";
			$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());*/
			$sql3 = "SELECT DATE_FORMAT(date_due,'%d/%m/%Y') AS date, rowid, name, deplacement, tarif_special, TIME_TO_SEC(time_fact) as sectime, prix_fact, prix_depl FROM " . $tblpref ."task 
			WHERE  fact_num = $num_doc";
			$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
		
	
			$alternative = '1';				
			while($data3 = mysql_fetch_array($req3))
			{
				
				$num_inter = $data3['rowid'];
				$cause = $data3['name'];
				$cause = stripslashes($cause);
				$cout = $data3['prix_fact'];
				$cout_depl = $data3['prix_depl'];
				
				$type_deplacement = $data3['deplacement'];
				if ($type_deplacement == 0) { $depl = 'aucun';} elseif ($type_deplacement == 1) { $depl = '-20km';} elseif ($type_deplacement == 2){ $depl = '20-40km';} elseif ($type_deplacement == 3){ $depl = '+40km';}
				$tarif_special = $data3['tarif_special'];
				if ($tarif_special == 1) { $tarif = 'normal';} elseif ($tarif_special == 2) { $tarif = '19h+';} elseif ($tarif_special == 3){ $tarif = 'Dim./Férié/22h+';} elseif ($tarif_special == 4){ $tarif = 'Reduit';}
				$nbtrav = '1';
				$date_inter = $data3['date'];
				$duree_s = $data3['sectime'];
				
				$duree_h = (int)($duree_s / 3600);
				$reste = (int)($duree_s % 3600);
				$duree_m = (int)($reste / 60);
				if ($duree_m < 10)
				{
				$duree_m = "0".$duree_m;
				}
				$duree = $duree_h.":".$duree_m;
				
					
				$tot_htva_inter = $cout + $cout_depl;
				$tot_htva_inter = floatval($tot_htva_inter);
				$tot_htva_inter = sprintf("%01.2f", $tot_htva_inter);
				
				if ($alternative == '1') 
				{
					// on écrit une ligne pour les Interventions
					$pdf->SetFillColor(235,235,235);	
					$pdf->SetWidths(array(186));
					$pdf->SetX(12);
					$pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array("Interventions"));
					$pdf->Ln(1);
					//on ecrit une ligne avec les titres des cellules
					$pdf->SetFillColor(235,235,235);	
					$pdf->SetWidths(array(20,99,12,15,20,20));
					$pdf->SetX(12);

					$pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array("Date","Cause de l'Intervention","Durée","Depl.","Tarif","Total HTVA"));
					$pdf->Ln(1);
				}
				//on écrit une ligne avec l'inter
				$pdf->SetFillColor(255,255,255);	
				$pdf->SetWidths(array(20,99,12,15,20,20));
				$pdf->SetX(12);
				$pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array($date_inter,$cause,$duree."h",$depl,$tarif,$tot_htva_inter." €"));
				$pdf->Ln(1);
				$alternative = $alternative +1;
			}
		// les totaux sur la dernière page
		//on verifie les taxes bebat etc 
	
		if ($total_recupel != '0.00')
		{
		$total_htva = $total_htva + $total_recupel;
		$total_tva = $total_tva + ($total_recupel * 0.21);
		$tot_tva_inc = $tot_tva_inc + ($total_recupel * 1.21);
		//$acompte = ($tot_tva_inc / 10)*3; //30% d'acompte
		}
		if ($total_reprobel != '0.00')
		{
		$total_htva = $total_htva + $total_reprobel;
		$total_tva = $total_tva + ($total_reprobel * 0.21);
		$tot_tva_inc = $tot_tva_inc + ($total_reprobel * 1.21);
		//$acompte = ($tot_tva_inc / 10)*3; //30% d'acompte
		}
		if ($total_bebat != '0.00')
		{
		$total_htva = $total_htva + $total_bebat;
		$total_tva = $total_tva + ($total_bebat * 0.21);
		$tot_tva_inc = $tot_tva_inc + ($total_bebat * 1.21);
		//$acompte = ($tot_tva_inc / 10)*3; //30% d'acompte
		}
		if ($total_auvibel != '0.00')
		{
		$total_htva = $total_htva + $total_auvibel;
		$total_tva = $total_tva + ($total_auvibel * 0.21);
		$tot_tva_inc = $tot_tva_inc + ($total_auvibel * 1.21);
		//$acompte = ($tot_tva_inc / 10)*3; //30% d'acompte
		}
	
	/////////////////////////////////////////////////////
	
	//déco soumis tva
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(12, 222, 25, 6, 3, 'DF', '12');
	
	//soumis tva
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(12);
	$pdf->Cell(25,6,"Soumis à la TVA",0,0,'C',0);
	
	//déco soumis tva data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(12, 228, 25, 6, 3, 'DF', '34');
	
	//soumis tva data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(228);
	$pdf->SetX(12);
	$pdf->Cell(25,6,"$total_htva €",0,0,'C',0);
	
	///////////////////////////////////////////////////
	
	//déco taux tva
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(39, 222, 25, 6, 3, 'DF', '12');
	
	//taux tva
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(39);
	$pdf->Cell(25,6,"Taux de TVA",0,0,'C',0);
	
	//déco soumis tva data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(39, 228, 25, 6, 3, 'DF', '34');
	
	//soumis tva data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(228);
	$pdf->SetX(39);
	
	if($intracom == "non")
	{
	$pdf->Cell(25,6,"21 %",0,0,'C',0);
	}else
	{
	$pdf->Cell(25,6,"Intra-com",0,0,'C',0);
	
	}
	/////////////////////////////////////////////////////
	
	//déco tot htva
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(148, 222, 25, 6, 3, 'DF', '14');
	
	//tot htva
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(148);
	$pdf->Cell(25,6,"Total HTVA",0,0,'C',0);
	
	//déco tot htva data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(173, 222, 25, 6, 3, 'DF', '23');
	
	$total_htva = floatval($total_htva);
	$total_htva = sprintf("%01.2f", $total_htva);
	
	//tot htva data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(173);
	$pdf->Cell(25,6,"$total_htva €",0,0,'C',0);
	
	/////////////////////////////////////////////////////////
	
	//déco tot tva
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(148, 230, 25, 6, 3, 'DF', '14');
	
	//tot tva
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(230);
	$pdf->SetX(148);
	$pdf->Cell(25,6,"Total TVA",0,0,'C',0);
	
	//déco tot tva data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(173, 230, 25, 6, 3, 'DF', '23');
	
	$total_tva = floatval($total_tva);
	$total_tva = sprintf("%01.2f", $total_tva);
	
	//tot tva data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(230);
	$pdf->SetX(173);
	$pdf->Cell(25,6,"$total_tva €",0,0,'C',0);
	
	////////////////////////////////////////////////
	
	//déco grand total
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(148, 238, 25, 6, 3, 'DF', '14');
	
	//grand total
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(238);
	$pdf->SetX(148);
	$pdf->Cell(25,6,"Grand Total",0,0,'C',0);
	
	//déco grand total data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(173, 238, 25, 6, 3, 'DF', '23');
	
	$tot_tva_inc = floatval($tot_tva_inc);
	$tot_tva_inc = sprintf("%01.2f", $tot_tva_inc);
	
	//grand total data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(238);
	$pdf->SetX(173);
	$pdf->Cell(25,6,"$tot_tva_inc €",0,0,'C',0);
	
	/////////////////////////////////////////////////
	
	//déco acompte
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(148, 246, 25, 6, 3, 'DF', '1');
	
	//acompte
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(246);
	$pdf->SetX(148);
	$pdf->Cell(25,6,"Acompte",0,0,'C',0);
	
	//déco grand total data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(148, 252, 25, 6, 3, 'DF', '4');
	
	$acompte = floatval($acompte);
	$acompte = sprintf("%01.2f", $acompte);
	
	//grand total data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(252);
	$pdf->SetX(148);
	$pdf->Cell(25,6,"$acompte €",0,0,'C',0);
	
	/////////////////////////////////////////////////
	
	//déco a payer
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(173, 246, 25, 6, 3, 'DF', '2');
	
	//a payer
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY(246);
	$pdf->SetX(173);
	$pdf->Cell(25,6,"A Payer",0,0,'C',0);
	
	//déco A payer data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(173, 252, 25, 6, 3, 'DF', '3');
	
	$apayer = $tot_tva_inc - $acompte; // c'est une facture
	$apayer = floatval($apayer);
	$apayer = sprintf("%01.2f", $apayer);
	
	//a payer data
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY(252);
	$pdf->SetX(173);
	$pdf->Cell(25,6,"$apayer €",0,0,'C',0);
	
	/////////////////////////////////////////////////RECUPEL
	
	//déco recupel
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(70, 222, 15, 5, 3, 'DF', '12');
	
	//recupel
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(67.5);
	$pdf->Cell(20,5,"Recupel",0,0,'C',0);
	
	//déco recupel data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(70, 226, 15, 5, 3, 'DF', '34');
	
	$total_recupel = floatval($total_recupel);
	$total_recupel = sprintf("%01.2f", $total_recupel);
	
	//recupel data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(68);
	$pdf->Cell(20,5,"$total_recupel €",0,0,'C',0);
	
	/////////////////////////////////////////////////////REPROBEL
	
	//déco reprobel
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(89, 222, 15, 5, 3, 'DF', '12');
	
	//reprobel
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(86.5);
	$pdf->Cell(20,5,"Reprobel",0,0,'C',0);
	
	//déco reprobel data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(89, 226, 15, 5, 3, 'DF', '34');
	
	$total_reprobel = floatval($total_reprobel);
	$total_reprobel = sprintf("%01.2f", $total_reprobel);
	
	//reprobel data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(87);
	$pdf->Cell(20,5,"$total_reprobel €",0,0,'C',0);
	
	/////////////////////////////////////////////////////BEBAT
	
	//déco bebat
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(108, 222, 15, 5, 3, 'DF', '12');
	
	//bebat
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(105.5);
	$pdf->Cell(20,5,"Bebat",0,0,'C',0);
	
	//déco bebat data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(108, 226, 15, 5, 3, 'DF', '34');
	
	$total_bebat = floatval($total_bebat);
	$total_bebat = sprintf("%01.2f", $total_bebat);
	
	//bebat data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(106);
	$pdf->Cell(20,5,"$total_bebat €",0,0,'C',0);
	
	/////////////////////////////////////////////////////AUVIBEL
	
	//déco auvibel
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(127, 222, 15, 5, 3, 'DF', '12');
	
	//auvibel
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(124.5);
	$pdf->Cell(20,5,"Auvibel",0,0,'C',0);
	
	//déco auvibel data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(127, 226, 15, 5, 3, 'DF', '34');
	
	$total_bebat = floatval($total_bebat);
	$total_bebat = sprintf("%01.2f", $total_bebat);
	
	//auvibel data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(125);
	$pdf->Cell(20,5,"$total_auvibel €",0,0,'C',0);
	
	/////////////////////////////////////////////////////
	
	//acceptation cond gen
	$pdf->SetFont('Arial','',6);
	$pdf->SetY(235);
	$pdf->SetX(13);
	$pdf->Cell(134,3,"L'acceptation du présent document entraine l'acceptation par le client des conditions générales disponibles sur www.fastitservice.be",0,0,'C',0);
	
	// commentaires si présents
	if ($coment != '')
	{
	//déco commentaire
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(12, 239, 126, 5, 3, 'DF', '12');
	
	//commentaire
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(239);
	$pdf->SetX(12);
	$pdf->MultiCell(126,4,"Commentaires",0,C,0);
	
	//déco commentaire data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(12, 243, 126, 25, 3, 'DF', '34');//223 origine
	
	//commentaire data
	$pdf->SetFont('Arial','',8);
	$pdf->SetY(243);
	$pdf->SetX(12);
	$pdf->MultiCell(126,4,"$coment",0,L,0);
	}
}
//Finalisation
$pdf->Output();
?> 