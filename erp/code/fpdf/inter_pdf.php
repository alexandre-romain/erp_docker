<?php
session_cache_limiter('private');
if ($_GET['pdf_user']=='adm') {
require_once("../include/verif2.php");
} else {
require_once("../include/verif_client.php");
  
}
error_reporting(0);
define('FPDF_FONTPATH','font/');
include("../include/config/common.php");
require("../include/config/var.php");	
require("../include/configav.php");	
require_once("../include/language/$lang.php");
$num_doc=isset($_GET['num_inter'])?$_GET['num_inter']:"";
$nom=isset($_GET['nom'])?$_POST['nom']:"";	 
$euro= '€';
$devise = ereg_replace('&#128;', $euro, $devise);
$entrep_nom= stripslashes($entrep_nom);
$tel= stripslashes($tel);
$tva_vend= stripslashes($tva_vend);
$compte= stripslashes($compte);
$mail= stripslashes($mail);		

//pour la date
$sql = "select coment, detail, debut, fin, cause, type_deplacement, tarif_special,nbtrav, DATE_FORMAT(date,'%d/%m/%Y') AS date_2,DATE_FORMAT(date,'%Y%m%d') AS date_3 from " . $tblpref ."interventions where num_inter = $num_doc";
$req = mysql_query($sql) or die('Erreur SQL
!<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$date_doc = $data[date_2];
$date_num_doc = $data[date_3];
$coment = $data[coment];
$coment= stripslashes($coment);
$cause = $data[cause];
$cause= stripslashes($cause);
$detail = $data[detail];
$detail= stripslashes($detail);
$debut = $data[debut];
$fin = $data[fin];
$type_deplacement = $data[type_deplacement];
$tarif_special = $data['tarif_special'];
$nbtrav = $data['nbtrav'];

  $duree_s = $fin - $debut;
  $duree_h = (int)($duree_s / 3600);
  $reste = (int)($duree_s % 3600);
  $duree_m = (int)($reste / 60);
  if ($duree_m < 10)
  {
  $duree_m = "0".$duree_m;
  }
  $duree = $duree_h.":".$duree_m;

  $debut_aff = date("h:i", $debut);
  $fin_aff = date("h:i", $fin);

//pour le nom de client
$sql1 = "SELECT num_client, mail, nom, nom2, rue, numero, boite, ville, cp, num_tva, tel AS tel_client, fax AS fax_client FROM " . $tblpref ."client RIGHT JOIN " . $tblpref ."interventions on client_num = num_client WHERE  num_inter = $num_doc";
$req = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$num_client = $data['num_client'];
		$nom = $data['nom'];
		$nom2 = $data['nom2'];
		if ($nom2 == $nom){$nom2 ='';}
		$rue = $data['rue'];
		$rue= stripslashes($rue);
		$numero = $data['numero'];
		$boite = $data['boite'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$num_tva = $data['num_tva'];
		$tel_client = $data['tel_client'];
		$fax_client = $data['fax_client'];
		$mail_client = $data['mail'];
		}

$sql2 = "SELECT * FROM " . $tblpref ."abos WHERE  client = $num_client AND actif='oui'";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data2 = mysql_fetch_array($req2))
{
$abo = $data2['ID'];
$tarif_abo = $data2['tarif'];
$temps_restant_abo = $data2['temps_restant'];
$depl_restant_abo = $data2['deplacements_restant'];

		
	$temps_restant_s_abo = $temps_restant_abo * 60;
	$temps_restant_h_abo = (int)($temps_restant_s_abo / 3600);
  	$reste_abo = (int)($temps_restant_s_abo % 3600);
  	$temps_restant_m_abo = (int)($reste_abo / 60);
  	if ($temps_restant_m_abo < 10)
  	{
  	$temps_restant_m_abo = "0".$temps_restant_m_abo;
  	}
	$temps_restant_abo = $temps_restant_h_abo.":".$temps_restant_m_abo;	

	$sql3 = "SELECT * FROM " . $tblpref ."tarifs WHERE ID = $tarif_abo";
	$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
	while($data3 = mysql_fetch_array($req3))
	{
		$description_abo = $data3['description'];
		$duree_abo = $data3['duree'];
		$depl_abo = $data3['deplacements'];
	}
}

require('mysql_table.php');
//page 1
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
		function AutoPrint($dialog=false, $nb_impr)
{
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
    function Header() //imprime le contenu statique de la page
    {
	//la grande cellule sous le tableau
	$this->SetFillColor(235,235,235);
	$this->SetFont('Arial','B',6);
	$this->SetY(105);
	$this->SetX(12);
	$this->Cell(186,115,"",1,0,'C',1);
	
	//le logo
	$this->Image("logo_bl.jpg",21,8,67,0,'JPG');

	//déco coordonnées client
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(113, 23, 85, 36, 3.5, 'DF', '1234');
	$this->SetFillColor(245,245,245);
	
	//déco tva entreprise
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(12, 85, 85, 6, 3, 'DF', '1234');
	$this->SetFillColor(245,245,245);
	
	//déco tva client
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(113, 85, 85, 6, 3, 'DF', '1234');
	$this->SetFillColor(245,245,245);
	
	//déco n° doc
	$this->RoundedRect(12, 94, 85, 6, 3, 'DF','1234');
	
	//déco date
	$this->RoundedRect(113, 94, 41, 6, 3, 'DF','1234');	
    }
    function Footer() //imprime le contenu bas de page
    {
	//n° page
	$this->SetFont('Arial','',8);
	$this->SetY(-15);
	$this->SetX(158);
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');

	//Pour reception
	$this->SetFont('Arial','',8);
	$this->SetY(-28);
	$this->SetX(12);
	$this->MultiCell(30,4,"Pour Réception,",0,C,0);	

	//cachet
	$this->SetFont('Arial','',8);
	$this->SetY(-28);
	$this->SetX(42);
	$this->MultiCell(30,4,"Cachet du client",0,C,0);	
	
	//banque
	$this->SetFont('Arial','',8);
	$this->SetY(-15);
	$this->SetX(88);
	$this->MultiCell(70,4,"IBAN : BE70 3630 8937 4325\nBIC/SWIFT : BRUBEBB",0,C,0);
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
	$this->Cell(85,6,"Rapport d'Intervention n° : $date_num_doc-$num_doc",0,0,'C',0);

	//Date
	$this->SetFont('Arial','',10);
	$this->SetY(94);
	$this->SetX(113);
	$this->Cell(41,6,"Date : $date_doc",0,0,'C',0);
	}
}
$pdf=new PDF_MySQL_Table();
$pdf=new PDF();
$pdf->AliasNbPages(); 
$pdf->Open();
$pdf->AddPage();
$pdf->imprimer_contenu($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client);
$pdf->SetFont('Arial','',9);
//Tableau
$pdf->SetFillColor(235,235,235);
$pdf->SetY(105);
$pdf->SetX(12);

	//cause de l'inter
	$pdf->SetFillColor(235,235,235);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY(105);
	$pdf->SetX(12);
	$pdf->Cell(186,5,"Cause de l'Intervention :",1,0,'L',1);
	
	//Nombre travailleur
    $pdf->SetFillColor(235,235,235);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY(105);
    $pdf->SetX(152);
    $pdf->Cell(41,5,"Nombre d'intervenant(s) :",1,0,'L',1);
    
    //Nombre travailleur data
    $pdf->SetFillColor(235,235,235);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY(105);
    $pdf->SetX(193);
    $pdf->Cell(5,5,$nbtrav,1,0,'L',1);

	
	//cause de l'inter data
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(111);
	$pdf->SetX(12);
	$pdf->Cell(186,5,"$cause",1,0,'L',1);
	
	
	
	//detail de l'inter
	$pdf->SetFillColor(235,235,235);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY(117);
	$pdf->SetX(12);
	$pdf->Cell(186,5,"Detail de l'Intervention :",1,0,'L',1);
	//detail de l'inter data
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(123);
	$pdf->SetX(12);
	$pdf->MultiCell(186,4,"$detail",1,L,1);
	
	
	//déco debut
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(74, 222, 20, 5, 3, 'DF', '12');
	
	//debut
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(74);
	$pdf->Cell(20,5,"Début",0,0,'C',0);
	
	//déco debut data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(74, 226, 20, 5, 3, 'DF', '34');
	
	//debut data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(74);
	$pdf->Cell(20,5,$debut_aff." h",0,0,'C',0);
	
	/////////////////////////////////////////////////////
	
	//déco fin
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(96, 222, 20, 5, 3, 'DF', '12');
	
	//fin
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(96);
	$pdf->Cell(20,5,"Fin",0,0,'C',0);
	
	//déco fin data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(96, 226, 20, 5, 3, 'DF', '34');
	
	//fin data
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(96);
	$pdf->Cell(20,5,"$fin_aff h",0,0,'C',0);
	
	/////////////////////////////////////////////////////
	
	//déco durée
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(118, 222, 20, 5, 3, 'DF', '12');
	
	//durée
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(222);
	$pdf->SetX(118);
	$pdf->Cell(20,5,"Durée",0,0,'C',0);
	
	//déco duree data
	$pdf->SetFillColor(255,255,255);
	$pdf->RoundedRect(118, 226, 20, 5, 3, 'DF', '34');
	
	// duree
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(226);
	$pdf->SetX(118);
	$pdf->Cell(20,5,"$duree h",0,0,'C',0);
	
	
	
// les totaux sur la dernière page
        if ($abo != "")
		{
		//déco type abonnement
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(12, 222, 52, 6, 3, 'DF', '12');

		//type abonnnement
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(222);
		$pdf->SetX(12);
		$pdf->Cell(52,6,"Type d'abonnement",0,0,'C',0);		

		
		//déco type abo data
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(12, 228, 52, 6, 3, 'DF', '34');
		
		//type abo data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(228);
		$pdf->SetX(12);
		$pdf->Cell(52,6,"$description_abo | $duree_abo h | $depl_abo Depl",0,0,'C',0);		
		
		////
		
		//déco votre abo
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(148, 222, 50, 6, 3, 'DF', '1234');
		
		//votre abo
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(222);
		$pdf->SetX(148);
		$pdf->Cell(50,6,"Votre abonnement",0,0,'C',0);
	
		////
		
		//déco temps restant
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(148, 230, 30, 6, 3, 'DF', '14');
		
		//temps restant
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(230);
		$pdf->SetX(148);
		$pdf->Cell(30,6,"Temps restant",0,0,'C',0);
		
		//déco temps restant data
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(178, 230, 20, 6, 3, 'DF', '23');
		
		//temps restant data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(230);
		$pdf->SetX(178);
		$pdf->Cell(20,6,"$temps_restant_abo h",0,0,'C',0);
		
		////
		
		//déco depl restant
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(148, 238, 30, 6, 3, 'DF', '14');
		
		//depl restant
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(238);
		$pdf->SetX(148);
		$pdf->Cell(30,6,"Déplacements",0,0,'C',0);
		
		//déco depl restant data
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(178, 238, 20, 6, 3, 'DF', '23');
		
		//depl restant data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(238);
		$pdf->SetX(178);
		$pdf->Cell(20,6,"$depl_restant_abo depl.",0,0,'C',0);
		
		////		
		
		//acceptation cond gen
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(235);
		$pdf->SetX(13);
		$pdf->Cell(134,3,"L'acceptation du présent document entraine l'acceptation par le client des conditions générales disponibles sur www.fastitservice.be.",0,0,'C',0);
		
			////
		
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
		else
		{
		
		if($tarif_special == '5')
		{		

		$sql4 = "SELECT * FROM " . $tblpref ."maintenance WHERE  Idcli = $num_client AND actif='oui'";
		$req4 = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
		$data4 = mysql_fetch_array($req4);
		
		$client = $data4['Idcli'];
		$dateDeb =$data4['Datedeb'];
		$dateFin =$data4['Datefin'];
		$actif =$data4['Actif'];
    	// Mise en forme de la date debut contrat et date fin de contrat pour pouvoir par après la tester par rapport a la date d'intervention.
		
		$date_debut = explode("-", $dateDeb);
		
		$anneeDeb = intval ($date_debut[0]);
		$moisDeb = intval ($date_debut[1]);
		$jourDeb = intval ($date_debut[2]);
		
		$dateDeb_terminee = mktime (0, 0, 0, $moisDeb, $jourDeb, $anneeDeb);
		
		$date_fin = explode("-", $dateFin);
		
		$anneeFin = intval ($date_fin[0]);
		$moisFin = intval ($date_fin[1]);
		$jourFin = intval ($date_fin[2]);
		
		$dateFin_terminee = mktime (0, 0, 0, $moisFin, $jourFin, $anneeFin);
		//
		$sql5 = "SELECT * FROM " . $tblpref ."interventions WHERE  client_num = $num_client AND tarif_special = 5";
		$req5 = mysql_query($sql5) or die('Erreur SQL !<br>'.$sql5.'<br>'.mysql_error());
		
		// déclaration des variable pour sotcker le nombre de seconde passé lors du contrat et des 6mois
		$totalmois=0;
		$total6mois=0;
		//
		
		// Prise de la date du jour pour après retrancher les 6 mois! et avoir notre interval.
		$anneejour = date('Y');
		$moisjour = date('m');
		$jourjour = date('d');
		
		$datedujour = mktime (0,0,0,$moisjour,$jourjour,$anneejour);
		$datedujour = intval ($datedujour);
		// 15552000 est égale a 6 mois en timestamp!
		$duree6mois = $datedujour - 15552000 ;
		$duree1mois = $datedujour - 2592000;
		
		// PAssge en boucle sur tous les fichiers retourné de la BD
		while($data5 = mysql_fetch_array($req5))
		{
			$dateinter = $data5['date'];
			$debutinter = $data5['debut'];
			$fininter = $data5['fin'];
			
			
			$date_inter = explode("-", $dateinter);
		
			$anneeinter = intval ($date_inter[0]);
			$moisinter = intval ($date_inter[1]);
			$jourinter = intval ($date_inter[2]);
		
			$dateinter_terminee = mktime (0, 0, 0, $moisinter, $jourinter, $anneeinter);
			
			
			if( $duree1mois <= $dateinter_terminee && $datedujour > $dateinter_terminee)
			//Ajout dans le total du mois
			{
			
			$nombresec = ($fininter-$debutinter)*$nbtrav;
			$totalmois += $nombresec;
			}
			
			//Ajout dans le total des 6 mois!
			if ($duree6mois <= $dateinter_terminee && $datedujour >= $dateinter_terminee)
			{
			
			$nombreseconde = ($fininter-$debutinter)*$nbtrav;
			$total6mois += $nombreseconde;
			}
		
		}
		
		//Mise en forme du total des heures sur le mois de contrat
		$totalmois = $totalmois/3600;
		$totalmois_design = explode (".",$totalmois);
		
		$heuremois = intval($totalmois_design[0]);
		// Multiplication des minutes par 60.
		$minutemois = "0.";
		$minutemois .= $totalmois_design[1];
		$minutemois = floatval($minutemois);
		$minutemois = $minutemois*60;
		$minutemois = intval ($minutemois);
		
		if($minutemois == 0)
		{
			$minutemois .= "0";
		}
		
		// Mise en forme du total des heures sur les 6 mois précédent!
		$total6mois = $total6mois/3600;
		
		$total6mois_design = explode (".",$total6mois);
		
		$heure6mois = intval($total6mois_design[0]);
		// Multiplication des minutes par 60.
		$minute6mois = "0.";
		$minute6mois .= $total6mois_design[1];
		$minute6mois = floatval($minute6mois);
		$minute6mois = $minute6mois*60;
		$minute6mois = intval ($minute6mois);
		
		if($minute6mois == 0)
		{
			$minute6mois .= "0";
		}
		
		//déco Maintenance
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(148, 222, 50, 6, 3, 'DF', '1234');
		
		//Maintenance
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(222);
		$pdf->SetX(148);
		$pdf->Cell(50,6,"Contrat de Maintenance",0,0,'C',0);
	
		////
		
		//déco Libelle mois
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(148, 230, 30, 6, 3, 'DF', '14');
		
		//Libelle mois
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(229);
		$pdf->SetX(148);
		$pdf->Cell(30,6,"Heures de maintenance",0,0,'C',0);
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(231);
		$pdf->SetX(148);
		$pdf->Cell(30,6,"sur le mois en cours",0,0,'C',0);
		//déco Temps total
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(178, 230, 20, 6, 3, 'DF', '23');
		
		//temps Temps total
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(230);
		$pdf->SetX(178);
		$pdf->Cell(20,6,$heuremois."h".$minutemois ,0,0,'C',0);
		
		////
		
		//déco depl restant
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(148, 238, 30, 6, 3, 'DF', '14');
		
		//depl restant
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(237);
		$pdf->SetX(148);
		$pdf->Cell(30,6,"Heures de maintenance ",0,0,'C',0);
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(239);
		$pdf->SetX(148);
		$pdf->Cell(30,6,"sur les 6 derniers mois",0,0,'C',0);
		
		//déco depl restant data
		$pdf->SetFillColor(255,255,255);
		$pdf->RoundedRect(178, 238, 20, 6, 3, 'DF', '23');
		
		//depl restant data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(238);
		$pdf->SetX(178);
		$pdf->Cell(20,6,$heure6mois."h".$minute6mois,0,0,'C',0);
		
		////		
		
		//acceptation cond gen
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(235);
		$pdf->SetX(13);
		$pdf->Cell(134,3,"L'acceptation du présent document entraine l'acceptation par le client des conditions générales disponibles sur www.fastitservice.be.",0,0,'C',0);
		
			////
		
			if ($actif == 'non')
			{
			
			$coment ="Attention votre contrat de maintenance est arrivé à terme!";
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
		else
		{
			
		//on calcule les totaux pour affichage	
		if ($tarif_special == '4')
		{
		$tarif_quartdh = $tarif_REDUIT*$nbtrav;
		
		$duree_s = $fin - $debut;
		if ($duree_s % 900 > '0') { $cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; } 
		else { $cout = (int)($duree_s / 900) * $tarif_quartdh; }
		}
		else{
		if ($num_tva == 'NA') { $tarif_quartdh = $tarif_NA*$nbtrav; } else { $tarif_quartdh = $tarif_ASSUJETI*$nbtrav; }
		
		$duree_s = $fin - $debut;
		if ($duree_s % 900 > '0') { $cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; } 
		else { $cout = (int)($duree_s / 900) * $tarif_quartdh; }
		}		
		//cout du deplacement
		if ($type_deplacement == 1) {$cout_depl = $depl_court;}
		elseif ($type_deplacement == 2) {$cout_depl = $depl_moyen;}
		elseif ($type_deplacement == 3) {$cout_depl = $depl_long;}
		
		//si tarif special
		if ($tarif_special == '2') { $cout = $cout * 1.5; $cout_depl = $cout_depl * 1.5;}
		elseif ($tarif_special == '3') { $cout = $cout * 2; $cout_depl = $cout_depl * 2;}

		
		$tot_htva = $cout + $cout_depl;
		$tot_tva = $tot_htva /100 *21;
		$tot_tva_inc = $tot_htva + $tot_tva;
			
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
		
		$tot_htva = floatval($tot_htva);
		$tot_htva = sprintf("%01.2f", $tot_htva);
		
		//soumis tva data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(228);
		$pdf->SetX(12);
		$pdf->Cell(25,6,"$tot_htva €",0,0,'C',0);
		
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
		$pdf->Cell(25,6,"21 %",0,0,'C',0);
		
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
		
		//tot htva data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(222);
		$pdf->SetX(173);
		$pdf->Cell(25,6,"$tot_htva €",0,0,'C',0);
		
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

		$tot_tva = floatval($tot_tva);
		$tot_tva = sprintf("%01.2f", $tot_tva);
		
		//tot tva data
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(230);
		$pdf->SetX(173);
		$pdf->Cell(25,6,"$tot_tva €",0,0,'C',0);
		
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
		
		//sera facturé ..
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(246);
		$pdf->SetX(146);
		$pdf->Cell(50,3,"Cette Intervention apparaîtra sur votre prochaine facture",0,0,'L',0);
		
		//acceptation cond gen
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(235);
		$pdf->SetX(13);
		$pdf->Cell(134,3,"L'acceptation du présent document entraine l'acceptation par le client des conditions générales disponibles sur www.fastitservice.be.",0,0,'C',0);
		
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
	}
//Finalisation

//Détermination d'un nom de fichier temporaire dans le répertoire courant
$file=basename(tempnam(getcwd(),'tmp'));

rename($file,$file.'.pdf');
$file.='.pdf';

$destination = "./output/";
$destination .= "RI";
$destination .=$date_num_doc;
$destination .="-";
$destination .=$num_doc;
$destination .="_";
$nom = str_replace(' ','_',$nom);
$nom = str_replace(';','_',$nom);
$nom = str_replace(':','_',$nom);
$nom = str_replace('&','_',$nom);
$nom = str_replace(',','_',$nom);
$nom = str_replace('/','_',$nom);
$nom = str_replace("\\",'_',$nom);
$nom = str_replace("'",'_',$nom);
$destination .=$nom;
$destination .=".pdf";

//Sauvegarde du PDF dans le fichier
$pdf->Output($destination);

chmod($destination,444);

echo "<HTML><SCRIPT>document.location='$destination';</SCRIPT></HTML>";
?> 
