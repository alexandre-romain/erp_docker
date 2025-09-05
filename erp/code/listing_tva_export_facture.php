<?php //date actuelle
$date = gmdate('D, d M Y H:i:s');
 
header("Content-Type: text/dat");
header('Content-Disposition: attachment; filename=export_factures.dat');
header('Last-Modified: '. $date . ' GMT');
header('Expires: ' . $date);
//header specifique IE :s parce que sinon il aime pas
if(preg_match('/msie|(microsoft internet explorer)/i', $_SERVER['HTTP_USER_AGENT'])){
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
}else{
  header('Pragma: no-cache');
}
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
require("include/configav.php");	

//recuperation des post
$fact_min=isset($_POST['fact_min'])?$_POST['fact_min']:"";
$fact_max=isset($_POST['fact_max'])?$_POST['fact_max']:"";

//carriage return
$r = ""; 

//on imprime le header du fichier
echo 'CreateKeyAll: Y'.$r.'
IgnoreAnalClosed: Y'.$r.'
DossierSelect: 001'.$r.'
AcctingSelect: 05
';
//AcctingSelect = 2014

$sql = "SELECT num, exported, acompte, coment, total_fact_h, total_fact_ttc, DATE_FORMAT(echeance_fact,'%d/%m/%Y') AS echeance, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_2,tva,date_fact FROM " . $tblpref ."facture WHERE num BETWEEN '".$fact_min."' AND '".$fact_max."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		
//boucle sur toutes les factures
while($data = mysql_fetch_array($req))
{
	$num_doc = $data['num'];
	$totalarrondi = 0;
	$totaltvaarrondi = 0;
	$grandtotal = '0.00';
	$grandtotalht = '0.00';
	//données client
	$sql1 = "SELECT num_client, ".$tblpref."client.exported, mail, nom, nom2, rue, numero, boite, ville, cp, num_tva FROM " . $tblpref ."client RIGHT JOIN " . $tblpref ."facture on CLIENT = num_client WHERE  num = $num_doc";
	$req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	
	while($data1 = mysql_fetch_array($req1))
	{
		$num_client = $data1['num_client'];
		$nom = $data1['nom'];
		$nom2 = $data1['nom2'];
		if ($nom2 == $nom){$nom2 ='';}
		$rue = $data1['rue'];
		$numero = $data1['numero'];
		$boite = $data1['boite'];
		$ville = $data1['ville'];
		$cp = $data1['cp'];
		$num_tva = $data1['num_tva'];
		$VAT_format = "BE";
		$VATType = "0";
				
				
		$num_tva = ereg_replace("[^0-9]","",$num_tva);
		if (strlen($num_tva) <= 9) { $num_tva = "0".$num_tva; }
		if ($num_tva == '0')
		{
			$num_tva = '';
			$VAT_format = "NA";
			$VATType = "7";
		}
						   
		$exported_client = $data1['exported'];
	}
	
	//BONS DE LIVRAISON POUR CALCUL RECUPEL ETC .. DEVRA DISPARAITRE !!
	//DISPARAITRE MON CUL...
	/*$sqlbl = "SELECT DATE_FORMAT(date,'%d/%m/%Y') AS date, num_bl, tot_htva, tot_tva FROM " . $tblpref ."bl 
	WHERE  fact_num = $num_doc";
	$reqbl = mysql_query($sqlbl) or die('Erreur SQL !<br>'.$sqlbl.'<br>'.mysql_error());
	
	$total_recupel = '0.00';
	$total_reprobel = '0.00';
	$total_bebat = '0.00';
	$total_recupel_tva = '0.00';
	$total_reprobel_tva = '0.00';
	$total_bebat_tva = '0.00';
	
	while($databl = mysql_fetch_array($reqbl))
	{
		$num_bl = $databl['num_bl'];
		$date_bl = $databl['date'];
		
		$sql3 = "SELECT recupel, reprobel, bebat, quanti 
		FROM " . $tblpref ."cont_bl 
		RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bl.article_num = " . $tblpref ."article.num 
		WHERE  bl_num = $num_bl";
		
		$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
		while($data3 = mysql_fetch_array($req3))
		{
			$quanti = $data3['quanti'];
			$recupel = $data3['recupel'];
			$reprobel = $data3['reprobel'];
			$bebat = $data3['bebat'];
			
			if ($bebat != '0')
			{
				//$total_bebat = $total_bebat + ($bebat*$quanti);
				//on calcule le montant RECUPEL
				$total_bebat_inter = $bebat*$quanti;
				$total_bebat_tva_inter = $total_bebat_inter/100*21;
				
				//echo $total_bebat_inter.'<== BEBAT <br/>';

				$total_bebat_inter = floatval($total_bebat_inter);
				$total_bebat_inter = sprintf("%01.2f", $total_bebat_inter);
				
				$total_bebat_tva_inter = floatval($total_bebat_tva_inter);
				$total_bebat_tva_inter = sprintf("%01.2f", $total_bebat_tva_inter);
				
				$total_bebat = $total_bebat + $total_bebat_inter;
				$total_bebat_tva = $total_bebat_tva + $total_bebat_tva_inter;
			}
			if ($recupel != '0')
			{
				//$total_recupel = $total_recupel + ($recupel*$quanti);
				//on calcule le montant RECUPEL
				$total_recupel_inter = $recupel*$quanti;
				$total_recupel_tva_inter = $total_recupel_inter/100*21;
				
				//echo $total_recupel_inter.'<== RECUPEL <br/>';

				$total_recupel_inter = floatval($total_recupel_inter);
				$total_recupel_inter = sprintf("%01.2f", $total_recupel_inter);
				
				$total_recupel_tva_inter = floatval($total_recupel_tva_inter);
				$total_recupel_tva_inter = sprintf("%01.2f", $total_recupel_tva_inter);
				
				$total_recupel = $total_recupel + $total_recupel_inter;
				$total_recupel_tva = $total_recupel_tva + $total_recupel_tva_inter;
			}
			if ($reprobel != '0')
			{
				//$total_reprobel = $total_reprobel + ($reprobel*$quanti);
				//on calcule le montant RECUPEL
				$total_reprobel_inter = $reprobel*$quanti;
				$total_reprobel_tva_inter = $total_reprobel_inter/100*21;
				
				//echo $total_reprobel_inter.'<== REPROBEL <br/>';

				$total_reprobel_inter = floatval($total_reprobel_inter);
				$total_reprobel_inter = sprintf("%01.2f", $total_reprobel_inter);
				
				$total_reprobel_tva_inter = floatval($total_reprobel_tva_inter);
				$total_reprobel_tva_inter = sprintf("%01.2f", $total_reprobel_tva_inter);
				
				$total_reprobel = $total_reprobel + $total_reprobel_inter;
				$total_reprobel_tva = $total_reprobel_tva + $total_reprobel_tva_inter;
			}
			
		} // fin while contbl
	} //fin while bl*/
	
	
	///BOUCLE POUR CALCULER TOTAL 
	//BONS DE LIVRAISON
	$sqlbl = "SELECT DATE_FORMAT(date,'%d/%m/%Y') AS date, num_bl, tot_htva, tot_tva FROM " . $tblpref ."bl 
	WHERE  fact_num = $num_doc";
	$reqbl = mysql_query($sqlbl) or die('Erreur SQL !<br>'.$sqlbl.'<br>'.mysql_error());
	$total_recupel = '0.00';
	$total_reprobel = '0.00';
	$total_bebat = '0.00';
	
	while($databl = mysql_fetch_array($reqbl))
	{
		$num_bl = $databl['num_bl'];
		$date_bl = $databl['date'];
		
		$sql3 = "SELECT " . $tblpref ."cont_bl.num, cat1, reference, marque, recupel, reprobel, bebat , garantie, quanti, serial, uni, article, taux_tva, prix_htva, p_u_jour, tot_art_htva, to_tva_art FROM " . $tblpref ."cont_bl RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bl.article_num = " . $tblpref ."article.num WHERE  bl_num = $num_bl";
		$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
		while($data3 = mysql_fetch_array($req3))
		{
			$reference = $data3['reference'];
			$article = $data3['article'];
			$marque = $data3['marque'];
			$quanti = $data3['quanti'];
			$p_u_jour = $data3['p_u_jour'];
			$tot_art_htva = $data3['tot_art_htva'];
			$to_tva_art = $data3['to_tva_art'];
			$recupel = $data3['recupel'];
			$reprobel = $data3['reprobel'];
			$bebat = $data3['bebat'];					
			$cat = $data3['cat1'];
			
			
			$tot_art_htva = floatval($tot_art_htva);
			$tot_art_htva = sprintf("%01.2f", $tot_art_htva);
			
			$grandtotal = $grandtotal + $tot_art_htva;
			$grandtotalht = $grandtotalht + $tot_art_htva;
			
			$to_tva_art = floatval($to_tva_art);
			$to_tva_art = sprintf("%01.2f", $to_tva_art);
			
			$grandtotal = $grandtotal + $to_tva_art;
			//si taxe bebat
			if ($bebat != '0')
			{
				//on calcule le montant BEBAT
				$total_bebat_htva = $bebat*$quanti;
				$total_bebat_tva = $total_bebat_htva/100*21;
				
				$total_bebat_htva = floatval($total_bebat_htva);
				$total_bebat_htva = sprintf("%01.2f", $total_bebat_htva);
				
				$grandtotal = $grandtotal + $total_bebat_htva;
				$grandtotalht = $grandtotalht + $total_bebat_htva;
				
				$total_bebat_tva = floatval($total_bebat_tva);
				$total_bebat_tva = sprintf("%01.2f", $total_bebat_tva);
				
				$grandtotal = $grandtotal + $total_bebat_tva;
			} //fin test bebat
			if ($recupel != '0')
			{
				//on calcule le montant RECUPEL
				$total_recupel_htva = $recupel*$quanti;
				$total_recupel_tva = $total_recupel_htva/100*21;
				
				$total_recupel_htva = floatval($total_recupel_htva);
				$total_recupel_htva = sprintf("%01.2f", $total_recupel_htva);
				
				$grandtotal = $grandtotal + $total_recupel_htva;
				$grandtotalht = $grandtotalht + $total_recupel_htva;
				
				$total_recupel_tva = floatval($total_recupel_tva);
				$total_recupel_tva = sprintf("%01.2f", $total_recupel_tva);
				
				$grandtotal = $grandtotal + $total_recupel_tva;		
			}//fin test recupel
			if ($reprobel != '0')
			{
				//on calcule le montant REPROBEL
				$total_reprobel_htva = $reprobel*$quanti;
				$total_reprobel_tva = $total_reprobel_htva/100*21;
				
				
				$total_reprobel_htva = floatval($total_reprobel_htva);
				$total_reprobel_htva = sprintf("%01.2f", $total_reprobel_htva);
				
				$grandtotal = $grandtotal + $total_reprobel_htva;
				$grandtotalht = $grandtotalht + $total_reprobel_htva;
				
				$total_reprobel_tva = floatval($total_reprobel_tva);
				$total_reprobel_tva = sprintf("%01.2f", $total_reprobel_tva);
				
				$grandtotal = $grandtotal + $total_reprobel_tva;				
				
			} //fin test reprobel

		} //fin boucle contbl 
	} //fin boucle bl


	// INTERVENTIONS
	$sql4 = "SELECT DATE_FORMAT(date_due,'%d/%m/%Y') AS date, rowid, name, deplacement, tarif_special, TIME_TO_SEC(time_fact) as sectime, prix_fact, prix_depl FROM " . $tblpref ."task WHERE  fact_num = $num_doc";
	$req4 = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
				
	while($data4 = mysql_fetch_array($req4))
	{
		$num_inter = $data4['rowid'];
		$cause = $data4['name'];
		$cause = stripslashes($cause);
		$type_deplacement = $data4['deplacement'];
		$price_work=$data4['prix_fact'];
		$price_deplacement=$data4['prix_depl'];
		
		if ($price_deplacement == NULL) {
			
			if ($type_deplacement == 1) {$cout_depl = 20;}
			elseif ($type_deplacement == 2) {$cout_depl = 30;}
			elseif ($type_deplacement == 3) {$cout_depl = 40;}
			elseif ($type_deplacement == 0) {$cout_depl = 0;}
		}
		
		else {
			$cout_depl=$price_deplacement;
		}
		
		$total_inter_htva = $price_work+$cout_depl;
		$total_inter_tva = $total_inter_htva/100*21;
		$grnlid = "707000";
		$comart = "INTERVENTION";
		
		
		$total_inter_htva = floatval($total_inter_htva);
		$total_inter_htva = sprintf("%01.2f", $total_inter_htva);
		
		$grandtotal = $grandtotal + $total_inter_htva;
		$grandtotalht = $grandtotalht + $total_inter_htva;
		
		
		$total_inter_tva = floatval($total_inter_tva);
		$total_inter_tva = sprintf("%01.2f", $total_inter_tva);
		
		$grandtotal = $grandtotal + $total_inter_tva;		

	} //fin boucle interventions

/*echo $total_recupel.'  <== TOTAT_RECUPEL|  ';
echo $total_reprobel.'  <== TOTAT_REPROBEL|  ';
echo $total_bebat.'  <== TOTAT_BEBAT|  ';
echo $total_recupel_tva.'  <== TOTAT_TVA_RECUPEL|  ';
echo $total_reprobel_tva.'  <== TOTAT_TVA_REPROBEL|  ';
echo $total_bebat_tva.'  <== TOTAT_TVA_BEBAT|  ';

$total_tax = $total_bebat+$total_recupel+$total_reprobel+$total_recupel_tva+$total_reprobel_tva+$total_bebat_tva;

echo $total_tax.'  <== TOTAT_TAXE_TVAC|  ';*/
	//la facture
	
	$datedoc = $data['date_2'];
	$datedue = $data['echeance'];
	$datefact = $data['date_fact'];
	
	$sqlpid = "SELECT id FROM ".$tblpref."periodecomptable WHERE '".$datefact."' BETWEEN ".$tblpref."periodecomptable.datedeb AND ".$tblpref."periodecomptable.datefin";
	$reqpid = mysql_query($sqlpid) or die('Erreur SQL !<br>'.$sqlpid.'<br>'.mysql_error());
	while($datapid = mysql_fetch_array($reqpid))
	{
		$periodid = $datapid['id'];
	}
	
	//$total_htva = ($data['total_fact_h']+$total_bebat+$total_recupel+$total_reprobel);
	$total_htva = ($data['total_fact_h']);
	$total_tva = 0;
	$intracom = $data['tva'];
	//$exported_fact = $data['exported'];
	$exported_fact = 'non';
	
	if($intracom == "non")
	{
		//$total_tva = ($data['total_fact_h']/100*21)+total_recupel_tva+total_reprobel_tva+total_bebat_tva;
		//$total_tva = ($data['total_fact_h']/100*21);
		$total_tvac = $grandtotal;
	}
	else {
		$total_tvac = $grandtotalht;
	}
	
	$coment = $data['coment'];
	$acompte = $data['acompte'];
	
	/*$total_tvac = $total_htva + $total_tva ;
	$total_tvac = floatval($total_tvac);
	$total_tvac = sprintf("%01.2f", $total_tvac);*/
	
	//$total_tvac = $total_tvac+$total_bebat+$total_recupel+$total_reprobel+$total_recupel_tva+$total_reprobel_tva+$total_bebat_tva;
	
	if ($exported_fact!='oui')
	{
	echo ''.$r.'
	Sales:'.$r.'
	{'.$r.'
		Header:'.$r.'
		{'.$r.'
			JrnlID:          	"FV1"'.$r.'
			DocType:         	1'.$r.'
			DocNumber:       	"'.$num_doc.'"'.$r.'
			CustID:          	"'.$num_client.'"'.$r.'
			Comment:         	""'.$r.'
			VCSDoc:          	""'.$r.'
			PeriodID:        	"'.$periodid.'"'.$r.'
			DateDoc:         	'.$datedoc.$r.'
			DateDue:         	'.$datedue.$r.'
			DocStatus:       	0'.$r.'
			Piece:           	""'.$r.'
			CrcyDoc:         	"EUR"'.$r.'
			AmountCrcyDoc:   	'.$total_tvac.$r.'
			AmountCrcyBase:  	'.$total_tvac.$r.'
			DiscountRate:    	0.00'.$r.'
			DiscountType:    	'.$r.'
			DiscountAmnt:    	0.00'.$r.'
			DiscountAmntCrcy:	0.00'.$r.'
			DiscountDate:    	'.$datedoc.$r.'
			PaidAmntBase:    	0.00'.$r.'
			PaidAmntCrcy:    	0.00'.$r.'
			DomNum:          	""'.$r.'
			IntraTransport:  	""'.$r.'
			IntraTransaction:	""'.$r.'
			IntraIncoTerm:   	""'.$r.'
			IntraRegion:     	""'.$r.'
			IntraDestination:	""'.$r.'
			SEPGuid:         	0.0'.$r.'
			SEPStatus:       	0.0'.$r.'
			SEPToSend:       	0.0'.$r.'
			SEPClosed:       	0.0'.$r.'
		}'.$r.'
	';
			
			//BONS DE LIVRAISON
			$sqlbl = "SELECT DATE_FORMAT(date,'%d/%m/%Y') AS date, num_bl, tot_htva, tot_tva FROM " . $tblpref ."bl 
			WHERE  fact_num = $num_doc";
			$reqbl = mysql_query($sqlbl) or die('Erreur SQL !<br>'.$sqlbl.'<br>'.mysql_error());
			
			$total_recupel = '0.00';
			$total_reprobel = '0.00';
			$total_bebat = '0.00';
			
			while($databl = mysql_fetch_array($reqbl))
			{
				$num_bl = $databl['num_bl'];
				$date_bl = $databl['date'];
				
				$sql3 = "SELECT " . $tblpref ."cont_bl.num, cat1, reference, marque, recupel, reprobel, bebat , garantie, quanti, serial, uni, article, taux_tva, prix_htva, p_u_jour, tot_art_htva, to_tva_art FROM " . $tblpref ."cont_bl RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bl.article_num = " . $tblpref ."article.num WHERE  bl_num = $num_bl";
				$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
				while($data3 = mysql_fetch_array($req3))
				{
					$reference = $data3['reference'];
					$article = $data3['article'];
					$marque = $data3['marque'];
					$quanti = $data3['quanti'];
					$p_u_jour = $data3['p_u_jour'];
					$tot_art_htva = $data3['tot_art_htva'];
					$to_tva_art = $data3['to_tva_art'];
					$recupel = $data3['recupel'];
					$reprobel = $data3['reprobel'];
					$bebat = $data3['bebat'];					
					$cat = $data3['cat1'];
					
					
					$tot_art_htva = floatval($tot_art_htva);
					$tot_art_htva = sprintf("%01.2f", $tot_art_htva);
					
					$totalarrondi = $totalarrondi + $tot_art_htva;
					
					
					$to_tva_art = floatval($to_tva_art);
					$to_tva_art = sprintf("%01.2f", $to_tva_art);
					
					$totaltvaarrondi = $totaltvaarrondi + $to_tva_art;
					
					//on teste si service ou non
					if ($cat == '1') 
					{
						$grnlid = '707000';
						$comart = 'Prestations';
					}
					else 
					{ 
						$grnlid = '700000';
						$comart = $marque.' '.$article;
					}
					
					//on imprime la ligne du BL

echo '	Line:'.$r.'
	{'.$r.'
		GnrlID:						"'.$grnlid.'"'.$r.'
		AnalID:						""'.$r.'
		VATCode:					"21"'.$r.'
		Comment:					"'.$comart.'"'.$r.'
		FlagDC:						C'.$r.'
		CrcyID:						"EUR"'.$r.'
		NoDiscount:					Y'.$r.'
		AmountCrcy:					'.$tot_art_htva.$r.'
		AmountCrcyDoc:					'.$tot_art_htva.$r.'
		AmountCrcyBase:					'.$tot_art_htva.$r.'
		AmountVATCrcyDoc:				'.$to_tva_art.$r.'
		AnalRecordTag:					""'.$r.'
		AnalQuantity:					0.00'.$r.'
		AnalPercent:					0.00'.$r.'
		AnalAmountBase:					0.0'.$r.'
		IntraWeight:					0.0'.$r.'
		IntraUnit:					0.0'.$r.'
	}'.$r.'
';
					//si taxe bebat
					if ($bebat != '0')
					{
						//on calcule le montant BEBAT
						$total_bebat_htva = $bebat*$quanti;
						$total_bebat_tva = $total_bebat_htva/100*21;
						$comart = "BEBAT";
						$grnlid = "700000";
						
						$total_bebat_htva = floatval($total_bebat_htva);
						$total_bebat_htva = sprintf("%01.2f", $total_bebat_htva);
						
						$totalarrondi = $totalarrondi + $total_bebat_htva;
						
						$total_bebat_tva = floatval($total_bebat_tva);
						$total_bebat_tva = sprintf("%01.2f", $total_bebat_tva);
						
						$totaltvaarrondi = $totaltvaarrondi + $total_bebat_tva;
						
						//on imprime une ligne spécifique pour la bebat
echo '	Line:'.$r.'
	{'.$r.'
		GnrlID:						"'.$grnlid.'"'.$r.'
		AnalID:						""'.$r.'
		VATCode:					"21"'.$r.'
		Comment:					"'.$comart.'"'.$r.'
		FlagDC:						C'.$r.'
		CrcyID:						"EUR"'.$r.'
		NoDiscount:					Y'.$r.'
		AmountCrcy:					'.$total_bebat_htva.$r.'
		AmountCrcyDoc:					'.$total_bebat_htva.$r.'
		AmountCrcyBase:					'.$total_bebat_htva.$r.'
		AmountVATCrcyDoc:				'.$total_bebat_tva.$r.'
		AnalRecordTag:					""'.$r.'
		AnalQuantity:					0.00'.$r.'
		AnalPercent:					0.00'.$r.'
		AnalAmountBase:					0.0'.$r.'
		IntraWeight:					0.0'.$r.'
		IntraUnit:					0.0'.$r.'
	}'.$r.'
';	
					} //fin test bebat
					if ($recupel != '0')
					{
						//on calcule le montant RECUPEL
						$total_recupel_htva = $recupel*$quanti;
						$total_recupel_tva = $total_recupel_htva/100*21;
						$comart = "RECUPEL";
						$grnlid = "700000";
						
						$total_recupel_htva = floatval($total_recupel_htva);
						$total_recupel_htva = sprintf("%01.2f", $total_recupel_htva);
						
						$totalarrondi = $totalarrondi + $total_recupel_htva;
						
						$total_recupel_tva = floatval($total_recupel_tva);
						$total_recupel_tva = sprintf("%01.2f", $total_recupel_tva);
						
						$totaltvaarrondi = $totaltvaarrondi + $total_recupel_tva;
						
						//on imprime une ligne spécifique pour la recupel
echo '	Line:'.$r.'
	{'.$r.'
		GnrlID:						"'.$grnlid.'"'.$r.'
		AnalID:						""'.$r.'
		VATCode:					"21"'.$r.'
		Comment:					"'.$comart.'"'.$r.'
		FlagDC:						C'.$r.'
		CrcyID:						"EUR"'.$r.'
		NoDiscount:					Y'.$r.'
		AmountCrcy:					'.$total_recupel_htva.$r.'
		AmountCrcyDoc:					'.$total_recupel_htva.$r.'
		AmountCrcyBase:					'.$total_recupel_htva.$r.'
		AmountVATCrcyDoc:				'.$total_recupel_tva.$r.'
		AnalRecordTag:					""'.$r.'
		AnalQuantity:					0.00'.$r.'
		AnalPercent:					0.00'.$r.'
		AnalAmountBase:					0.0'.$r.'
		IntraWeight:					0.0'.$r.'
		IntraUnit:					0.0'.$r.'
	}'.$r.'
';							
					}//fin test recupel
					if ($reprobel != '0')
					{
						//on calcule le montant REPROBEL
						$total_reprobel_htva = $reprobel*$quanti;
						$total_reprobel_tva = $total_reprobel_htva/100*21;
						$comart = "REPROBEL";
						$grnlid = "700000";
						
						
						$total_reprobel_htva = floatval($total_reprobel_htva);
						$total_reprobel_htva = sprintf("%01.2f", $total_reprobel_htva);
						
						$totalarrondi = $totalarrondi + $total_reprobel_htva;
						
						$total_reprobel_tva = floatval($total_reprobel_tva);
						$total_reprobel_tva = sprintf("%01.2f", $total_reprobel_tva);
						
						$totaltvaarrondi = $totaltvaarrondi = $total_reprobel_tva;
						
						//on imprime une ligne spécifique pour la reprobel
echo '	Line:'.$r.'
	{'.$r.'
		GnrlID:						"'.$grnlid.'"'.$r.'
		AnalID:						""'.$r.'
		VATCode:					"21"'.$r.'
		Comment:					"'.$comart.'"'.$r.'
		FlagDC:						C'.$r.'
		CrcyID:						"EUR"'.$r.'
		NoDiscount:					Y'.$r.'
		AmountCrcy:					'.$total_reprobel_htva.$r.'
		AmountCrcyDoc:					'.$total_reprobel_htva.$r.'
		AmountCrcyBase:					'.$total_reprobel_htva.$r.'
		AmountVATCrcyDoc:				'.$total_reprobel_tva.$r.'
		AnalRecordTag:					""'.$r.'
		AnalQuantity:					0.00'.$r.'
		AnalPercent:					0.00'.$r.'
		AnalAmountBase:					0.0'.$r.'
		IntraWeight:					0.0'.$r.'
		IntraUnit:					0.0'.$r.'
	}'.$r.'
';							
						
					} //fin test reprobel

				} //fin boucle contbl 
			} //fin boucle bl


			// INTERVENTIONS
			$sql4 = "SELECT DATE_FORMAT(date_due,'%d/%m/%Y') AS date, rowid, name, deplacement, tarif_special, TIME_TO_SEC(time_fact) as sectime, prix_fact, prix_depl FROM " . $tblpref ."task WHERE  fact_num = $num_doc";
			$req4 = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
						
			while($data4 = mysql_fetch_array($req4))
			{
				$num_inter = $data4['rowid'];
				$cause = $data4['name'];
				$cause = stripslashes($cause);
				$type_deplacement = $data4['deplacement'];
				$price_work=$data4['prix_fact'];
				$price_deplacement=$data4['prix_depl'];
				
				/*if ($type_deplacement == '0') { $depl = 'aucun';} 
				elseif ($type_deplacement == '1') { $depl = '-20km';} 
				elseif ($type_deplacement == '2'){ $depl = '20-40km';} 
				elseif ($type_deplacement == '3'){ $depl = '+40km';}
				
				$tarif_special = $data4['tarif_special'];
				
				if ($tarif_special == '1') { $tarif = 'normal';} 
				elseif ($tarif_special == '2') { $tarif = '19h+';} 
				elseif ($tarif_special == '3'){ $tarif = 'Dim./Férié/22h+';} 
				
				$nbtrav = $data4['nbtrav'];
				$date_inter = $data4['date'];
				
				$duree_s = $fin - $debut;
				
				$duree_h = (int)($duree_s / 3600);
				$reste = (int)($duree_s % 3600);
				$duree_m = (int)($reste / 60);
				if ($duree_m < 10)
				{
				$duree_m = "0".$duree_m;
				}
				$duree = $duree_h.":".$duree_m;
				
				//tarifs des inters
				if ($tarif_special == '4')
				{
					$tarif_quartdh = $tarif_REDUIT*$nbtrav;
				
					$duree_s = $fin - $debut;
					if ($duree_s % 900 > '0') { $cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; } 
					else { $cout = (int)($duree_s / 900) * $tarif_quartdh; }
				}
				else
				{
				if ($num_tva == 'NA') { $tarif_quartdh = $tarif_NA*$nbtrav; } else { $tarif_quartdh = $tarif_ASSUJETI*$nbtrav; }
				
				$duree_s = $fin - $debut;
				if ($duree_s % 900 > '0') { $cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; } 
				else { $cout = (int)($duree_s / 900) * $tarif_quartdh; }
				}*/	
				
				if ($price_deplacement == NULL) {
					
					if ($type_deplacement == 1) {$cout_depl = 20;}
					elseif ($type_deplacement == 2) {$cout_depl = 30;}
					elseif ($type_deplacement == 3) {$cout_depl = 40;}
					elseif ($type_deplacement == 0) {$cout_depl = 0;}
				}
				
				else {
					$cout_depl=$price_deplacement;
				}
				
				/*//si tarif special
				if ($tarif_special == '2') { $cout = $cout * 1.5; $cout_depl = $cout_depl * 1.5;}
				elseif ($tarif_special == '3') { $cout = $cout * 2; $cout_depl = $cout_depl * 2;}*/
				
				$total_inter_htva = $price_work+$cout_depl;
				$total_inter_tva = $total_inter_htva/100*21;
				$grnlid = "707000";
				$comart = "INTERVENTION";
				
				
				$total_inter_htva = floatval($total_inter_htva);
				$total_inter_htva = sprintf("%01.2f", $total_inter_htva);
				
				$totalarrondi = $totalarrondi + $total_inter_htva;
				
				
				$total_inter_tva = floatval($total_inter_tva);
				$total_inter_tva = sprintf("%01.2f", $total_inter_tva);
				
				$totaltvaarrondi = $totaltvaarrondi + $total_inter_tva;
				

						//on imprime une ligne spécifique pour l'intervention
echo '	Line:'.$r.'
	{'.$r.'
		GnrlID:						"'.$grnlid.'"'.$r.'
		AnalID:						""'.$r.'
		VATCode:					"21"'.$r.'
		Comment:					"'.$comart.'"'.$r.'
		FlagDC:						C'.$r.'
		CrcyID:						"EUR"'.$r.'
		NoDiscount:					Y'.$r.'
		AmountCrcy:					'.$total_inter_htva.$r.'
		AmountCrcyDoc:					'.$total_inter_htva.$r.'
		AmountCrcyBase:					'.$total_inter_htva.$r.'
		AmountVATCrcyDoc:				'.$total_inter_tva.$r.'
		AnalRecordTag:					""'.$r.'
		AnalQuantity:					0.00'.$r.'
		AnalPercent:					0.00'.$r.'
		AnalAmountBase:					0.0'.$r.'
		IntraWeight:					0.0'.$r.'
		IntraUnit:					0.0'.$r.'
	}'.$r.'
';				
	
			} //fin boucle interventions

			//on imprime la fin du 'sales'
echo '}';
			
			//on met a jour la facture exported
			$sql11 = "UPDATE `" . $tblpref ."facture` SET `exported` = 'non' WHERE `num` = '$num_doc'";
			mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
			
			} //fin test sur exported_fact
			
		} //fin boucle factures	
?>