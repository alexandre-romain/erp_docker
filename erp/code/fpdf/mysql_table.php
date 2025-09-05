<?php
include_once ('/var/gestion/fpdf/fpdf.php');

include_once ('/var/gestion/include/utils.php');

class PDF_MySQL_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Tableau des largeurs de colonnes
	$this->widths=$w;
}

function SetAligns($a)
{
	//Tableau des alignements de colonnes
	$this->aligns=$a;
}

function Row($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,$data) //variables
{
	//Calcule la hauteur de la ligne
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Effectue un saut de page si nécessaire
	$this->CheckPageBreak($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,$h);//variables
	//Dessine les cellules
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Sauve la position courante
		$x=$this->GetX();
		$y=$this->GetY();
		//Dessine le cadre
		$this->Rect($x,$y,$w,$h);
		//Imprime le texte
		$this->MultiCell($w,5,$data[$i],1,$a,1);
		//Repositionne à droite
		$this->SetXY($x+$w,$y);
	}
	//Va à la ligne
	$this->Ln($h);
}

function Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,$data) //variables
{
	//Calcule la hauteur de la ligne
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Effectue un saut de page si nécessaire
	$this->CheckPageBreak($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,$h);//variables
	//Dessine les cellules
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Sauve la position courante
		$x=$this->GetX();
		$y=$this->GetY();
		//Dessine le cadre
		$this->Rect($x,$y,$w,$h);
		//Imprime le texte
		$this->MultiCell($w,5,$data[$i],1,$a,1); //avec fond coloré
		//Repositionne à droite
		$this->SetXY($x+$w,$y);
	}
	//Va à la ligne
	$this->Ln($h);
}


function CheckPageBreak($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,$h)
{
	//Si la hauteur h provoque un débordement, saut de page manuel
	if($this->GetY()+$h>'223')
	{
	
	if ($coment != '')
	{
	//déco commentaire
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(42, 231, 126, 5, 3, 'DF', '12');
	
	//commentaire
	$this->SetFont('Arial','',9);
	$this->SetY(231);
	$this->SetX(42);
	$this->MultiCell(126,4,"Commentaires",0,C,0);
	
	//déco commentaire data
	$this->SetFillColor(255,255,255);
	$this->RoundedRect(42, 235, 126, 25, 3, 'DF', '34');//223 origine
	
	//commentaire data
	$this->SetFont('Arial','',8);
	$this->SetY(235);
	$this->SetX(42);
	$this->MultiCell(126,4,"$coment",0,L,0);
	}
		$this->AddPage();
		$this->imprimer_contenu($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client);
		$this->SetY(+105); //positionnement du tableau en cas de saut de page
		$this->SetX(12); //positionnement du tableau en cas de saut de page
		// titre du tableau
		$this->SetFont('Arial','',9);
		$this->SetWidths(array(20,81,35,15,15,20));
		$this->SetFillColor(235,235,235);
		$this->Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array(Marque,Description,Reference,Qte,PU,'Total HTVA'));
		$this->SetX(12);
		$this->SetWidths(array(35,15,15,15,106));
		$this->Row2($entrep_nom,$social_ville,$social_rue,$social_cp,$tel,$fax,$tva_vend,$compte,$mail,$web,$num_doc,$date_num_doc,$date_doc,$echeance,$total_htva,$total_tva,$coment,$tot_tva_inc,$num_client,$nom,$nom2,$rue,$numero,$boite,$ville,$cp,$num_tva,$mail_client,$tel_client,$fax_client,array(Garantie,Recupel,Reprobel,Bebat,'N° de Série'));
		$this->SetFillColor(255,255,255);
		$this->SetWidths(array(20,81,35,15,15,20));
		//$this->SetWidths(array(35,15,15,15,106));
		$this->Ln(1);
		$this->SetX(12);
		
}	}

function NbLines($w,$txt)
{
	//Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

}
?>