<?php
include("../include/config/common.php");
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
$num_doc=isset($_GET['num_dev'])?$_GET['num_dev']:"";
$nom=isset($_GET['nom'])?$_POST['nom']:"";	 
$euro= '�';
$devise = ereg_replace('&#128;', $euro, $devise);
$entrep_nom= stripslashes($entrep_nom);
$tel= stripslashes($tel);
$tva_vend= stripslashes($tva_vend);
$compte= stripslashes($compte);
$mail= stripslashes($mail);		

//pour la date
$sql = "select coment, tot_htva, tot_tva,  DATE_FORMAT(echeance,'%d/%m/%Y') AS echeance, DATE_FORMAT(date,'%d/%m/%Y') AS date_2,DATE_FORMAT(date,'%Y%m%d') AS date_3 from " . $tblpref ."devis where num_dev = $num_doc";
$req = mysql_query($sql) or die('Erreur SQL
!<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$date_doc = $data[date_2];
$echeance = $data[echeance];
$date_num_doc = $data[date_3];
$total_htva = $data[tot_htva];
$total_tva = $data[tot_tva];
$coment = $data[coment];
$tot_tva_inc = $total_htva + $total_tva ;
$acompte = ($tot_tva_inc / 10)*3; //30% d'acompte

//pour le nom de client
$sql1 = "SELECT num_client, mail, nom, nom2, rue, numero, boite, ville, cp, num_tva, tel AS tel_client, fax AS fax_client FROM " . $tblpref ."client RIGHT JOIN " . $tblpref ."devis on client_num = num_client WHERE  num_dev = $num_doc";
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
		$ville = $data['ville'];
		$cp = $data['cp'];
		$num_tva = $data['num_tva'];
		$tel_client = $data['tel_client'];
		$fax_client = $data['fax_client'];
		$mail_client = $data['mail'];
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
    //Ajoute du JavaScript pour lancer la bo�te d'impression ou imprimer immediatement
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

	//d�co coordonn�es client
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(113, 23, 85, 36, 3.5, 'DF', '1234');
	$this->SetFillColor(245,245,245);
	
	//d�co tva entreprise
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(12, 85, 85, 6, 3, 'DF', '1234');
	$this->SetFillColor(245,245,245);
	
	//d�co tva client
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(113, 85, 85, 6, 3, 'DF', '1234');
	$this->SetFillColor(245,245,245);
	
	//d�co n� doc
	$this->RoundedRect(12, 94, 85, 6, 3, 'DF','1234');
	
	//d�co date
	$this->RoundedRect(113, 94, 41, 6, 3, 'DF','1234');	
	
	//d�co echeance
	$this->RoundedRect(157, 94, 41, 6, 3, 'DF','1234');
	
	//d�co bas de page
	//$this->SetFillColor(255,255,255);
	//$this->RoundedRect(12, -15, 186, 8, 3, 'DF', '1234');
    }
    function Footer() //imprime le contenu bas de page
    {
	//n� page
	$this->SetFont('Arial','',8);
	$this->SetY(-15);
	$this->SetX(158);
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');

	//Pour reception
	$this->SetFont('Arial','',8);
	$this->SetY(-28);
	$this->SetX(12);
	$this->MultiCell(30,4,"Pour r�ception,",0,C,0);	

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
	//d�co bas de page
	//$this->SetFillColor(255,255,255);
	//$this->RoundedRect(12, -15, 186, 8, 3, 'DF', '1234');
	}
	function imprimer_contenu($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client)
	{
	//la r�f�rence client
	$this->SetFont('Arial','',9);
	$this->SetY(6);
	$this->SetX(113);
	$this->MultiCell(85,6,"R�f�rence client : $num_client",0,C,0);//
	//les coordon�es clients
	$this->SetFont('Arial','',9);
	$this->SetY(23);
	$this->SetX(113);
	$this->MultiCell(85,6,"\n $nom \n $nom2 \n $rue $numero $boite \n $cp  $ville \n ",0,C,0);

	//Troisieme cellule les coordon�es entreprise
	$this->SetFont('Arial','',9);
	$this->SetY(47);
	$this->SetX(12);
	$this->MultiCell(85,5,"\n$social_rue\n$social_cp $social_ville\n$tel $fax\n$mail\n$web\n",0,C,0);
	
	//cellule coordonn�es client2
	$this->SetFont('Arial','',9);
	$this->SetY(70);
	$this->SetX(113);
	$this->MultiCell(85,6,"T�l. : $tel_client   Fax : $fax_client\nEmail : $mail_client",0,C,0);	

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

	//N� document
	$this->SetFont('Arial','B',10);
	$this->SetY(94);
	$this->SetX(12);
	$this->Cell(85,6,"Devis n� : $date_num_doc-$num_doc",0,0,'C',0);

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

// titre du tableau
$pdf->SetWidths(array(20,81,35,15,15,20));
$pdf->Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array(Marque,Description,Reference,Qte,PU,'Total HTVA'));
$pdf->SetX(12);
$pdf->SetWidths(array(35,15,15,15,106));
$pdf->Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array(Garantie,Recupel,Reprobel,Bebat,'N� de S�rie'));
srand(microtime()*1000000);

$sql = "SELECT " . $tblpref ."cont_dev.num, reference, marque, recupel, reprobel, bebat , garantie, quanti, uni, article, taux_tva, prix_htva, p_u_jour, tot_art_htva FROM " . $tblpref ."cont_dev RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_dev.article_num = " . $tblpref ."article.num WHERE  dev_num = $num_doc";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$total_recupel = '0.00';
$total_reprobel = '0.00';
$total_bebat = '0.00';

while($data = mysql_fetch_array($req))
    {
	
	$reference = $data['reference'];
	$article = $data['article'];
	$marque = $data['marque'];
	$uni = $data['uni'];
	$quanti = $data['quanti'];
	$p_u_jour = $data['p_u_jour'];
	$tot_art_htva = $data['tot_art_htva'];
	$garantie = $data['garantie'];
	$recupel = $data['recupel'];
	$reprobel = $data['reprobel'];
	$bebat = $data['bebat'];
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
	$pdf->SetFillColor(255,255,255);	
	$pdf->SetWidths(array(20,81,35,15,15,20));
	$pdf->Ln(1);
	$pdf->SetX(12);
    $pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array($marque,$article,$reference,$quanti,$p_u_jour." �",$tot_art_htva." �"));
	$pdf->SetX(12);
	$pdf->SetWidths(array(35,15,15,15,106));
	$pdf->Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array($garantie,$recupel." �",$reprobel." �",$bebat." �",$serial));
	$pdf->SetX(12);
	$pdf->SetWidths(array(35,20,81,15,15,20));
	}

// les totaux sur la derni�re page
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

/////////////////////////////////////////////////////

//d�co soumis tva
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(12, 222, 25, 6, 3, 'DF', '12');

//soumis tva
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(12);
$pdf->Cell(25,6,"Soumis � la TVA",0,0,'C',0);

//d�co soumis tva data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(12, 228, 25, 6, 3, 'DF', '34');

$total_htva = floatval($total_htva);
$total_htva = sprintf("%01.2f", $total_htva);

//soumis tva data
$pdf->SetFont('Arial','',9);
$pdf->SetY(228);
$pdf->SetX(12);
$pdf->Cell(25,6,"$total_htva �",0,0,'C',0);

///////////////////////////////////////////////////

//d�co taux tva
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(39, 222, 25, 6, 3, 'DF', '12');

//taux tva
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(39);
$pdf->Cell(25,6,"Taux de TVA",0,0,'C',0);

//d�co soumis tva data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(39, 228, 25, 6, 3, 'DF', '34');

//soumis tva data
$pdf->SetFont('Arial','',9);
$pdf->SetY(228);
$pdf->SetX(39);
$pdf->Cell(25,6,"21 %",0,0,'C',0);

/////////////////////////////////////////////////////

//d�co tot htva
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(148, 222, 25, 6, 3, 'DF', '14');

//tot htva
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(148);
$pdf->Cell(25,6,"Total HTVA",0,0,'C',0);

//d�co tot htva data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(173, 222, 25, 6, 3, 'DF', '23');

$total_htva = floatval($total_htva);
$total_htva = sprintf("%01.2f", $total_htva);

//tot htva data
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(173);
$pdf->Cell(25,6,"$total_htva �",0,0,'C',0);

/////////////////////////////////////////////////////////

//d�co tot tva
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(148, 230, 25, 6, 3, 'DF', '14');

//tot tva
$pdf->SetFont('Arial','',9);
$pdf->SetY(230);
$pdf->SetX(148);
$pdf->Cell(25,6,"Total TVA",0,0,'C',0);

//d�co tot tva data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(173, 230, 25, 6, 3, 'DF', '23');

$total_tva = floatval($total_tva);
$total_tva = sprintf("%01.2f", $total_tva);

//tot tva data
$pdf->SetFont('Arial','',9);
$pdf->SetY(230);
$pdf->SetX(173);
$pdf->Cell(25,6,"$total_tva �",0,0,'C',0);

////////////////////////////////////////////////

//d�co grand total
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(148, 238, 25, 6, 3, 'DF', '14');

//grand total
$pdf->SetFont('Arial','',9);
$pdf->SetY(238);
$pdf->SetX(148);
$pdf->Cell(25,6,"Grand Total",0,0,'C',0);

//d�co grand total data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(173, 238, 25, 6, 3, 'DF', '23');

$tot_tva_inc = floatval($tot_tva_inc);
$tot_tva_inc = sprintf("%01.2f", $tot_tva_inc);

//grand total data
$pdf->SetFont('Arial','',9);
$pdf->SetY(238);
$pdf->SetX(173);
$pdf->Cell(25,6,"$tot_tva_inc �",0,0,'C',0);

/////////////////////////////////////////////////

//d�co acompte
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(148, 246, 25, 6, 3, 'DF', '1');

//acompte
$pdf->SetFont('Arial','',9);
$pdf->SetY(246);
$pdf->SetX(148);
$pdf->Cell(25,6,"Acompte",0,0,'C',0);

//d�co grand total data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(148, 252, 25, 6, 3, 'DF', '4');

$acompte = floatval($acompte);
$acompte = sprintf("%01.2f", $acompte);

//grand total data
$pdf->SetFont('Arial','',9);
$pdf->SetY(252);
$pdf->SetX(148);
$pdf->Cell(25,6,"$acompte �",0,0,'C',0);

/////////////////////////////////////////////////

//d�co a payer
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(173, 246, 25, 6, 3, 'DF', '2');

//a payer
$pdf->SetFont('Arial','B',9);
$pdf->SetY(246);
$pdf->SetX(173);
$pdf->Cell(25,6,"A Payer",0,0,'C',0);

//d�co A payer data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(173, 252, 25, 6, 3, 'DF', '3');

$apayer = $acompte; // c'est un devis
$apayer = floatval($apayer);
$apayer = sprintf("%01.2f", $apayer);
//a payer data
$pdf->SetFont('Arial','B',9);
$pdf->SetY(252);
$pdf->SetX(173);
$pdf->Cell(25,6,"$apayer �",0,0,'C',0);

/////////////////////////////////////////////////

//d�co recupel
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(74, 222, 20, 5, 3, 'DF', '12');

//recupel
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(74);
$pdf->Cell(20,5,"Recupel",0,0,'C',0);

//d�co recupel data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(74, 226, 20, 5, 3, 'DF', '34');

$total_recupel = floatval($total_recupel);
$total_recupel = sprintf("%01.2f", $total_recupel);

//recupel data
$pdf->SetFont('Arial','',9);
$pdf->SetY(226);
$pdf->SetX(74);
$pdf->Cell(20,5,"$total_recupel �",0,0,'C',0);

/////////////////////////////////////////////////////

//d�co reprobel
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(96, 222, 20, 5, 3, 'DF', '12');

//reprobel
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(96);
$pdf->Cell(20,5,"Reprobel",0,0,'C',0);

//d�co reprobel data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(96, 226, 20, 5, 3, 'DF', '34');

$total_reprobel = floatval($total_reprobel);
$total_reprobel = sprintf("%01.2f", $total_reprobel);

//reprobel data
$pdf->SetFont('Arial','',9);
$pdf->SetY(226);
$pdf->SetX(96);
$pdf->Cell(20,5,"$total_reprobel �",0,0,'C',0);

/////////////////////////////////////////////////////

//d�co bebat
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(118, 222, 20, 5, 3, 'DF', '12');

//bebat
$pdf->SetFont('Arial','',9);
$pdf->SetY(222);
$pdf->SetX(118);
$pdf->Cell(20,5,"Bebat",0,0,'C',0);

//d�co bebat data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(118, 226, 20, 5, 3, 'DF', '34');

$total_bebat = floatval($total_bebat);
$total_bebat = sprintf("%01.2f", $total_bebat);

//bebat data
$pdf->SetFont('Arial','',9);
$pdf->SetY(226);
$pdf->SetX(118);
$pdf->Cell(20,5,"$total_bebat �",0,0,'C',0);

/////////////////////////////////////////////////////

//acceptation cond gen
$pdf->SetFont('Arial','',6);
$pdf->SetY(235);
$pdf->SetX(13);
$pdf->Cell(134,3,"L'acceptation du pr�sent document entraine l'acceptation par le client des conditions g�n�rales imprim�es au verso ou fournies en annexe.",0,0,'C',0);

// commentaires si pr�sents
if ($coment != '')
{
//d�co commentaire
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(12, 239, 126, 5, 3, 'DF', '12');

//commentaire
$pdf->SetFont('Arial','',9);
$pdf->SetY(239);
$pdf->SetX(12);
$pdf->MultiCell(126,4,"Commentaires",0,C,0);

//d�co commentaire data
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(12, 243, 126, 25, 3, 'DF', '34');//223 origine

//commentaire data
$pdf->SetFont('Arial','',8);
$pdf->SetY(243);
$pdf->SetX(12);
$pdf->MultiCell(126,4,"$coment",0,L,0);
}
//Finalisation

//D�termination d'un nom de fichier temporaire dans le r�pertoire courant
$file=basename(tempnam(getcwd(),'tmp'));
rename($file,$file.'.pdf');
$file.='.pdf';

$destination = "./output/";
$destination .= "DE";
$destination .= $date_num_doc;
$destination .= "-";
$destination .= $num_doc;
$destination .= "_";
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
