<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$acompte=isset($_POST['acompte'])?$_POST['acompte']:"";
$date_deb=isset($_POST['date_deb'])?$_POST['date_deb']:"";
list($jour_deb, $mois_deb,$annee_deb) = preg_split('/\//', $date_deb, 3);
$date_fin=isset($_POST['date_fin'])?$_POST['date_fin']:"";
list($jour_f, $mois_f,$annee_f) = preg_split('/\//', $date_fin, 3);
$date_fact=isset($_POST['date_fact'])?$_POST['date_fact']:"";
list($jour_fact, $mois_fact,$annee_fact) = preg_split('/\//', $date_fact, 3);
$client=isset($_POST['client'])?$_POST['client']:"";
$annee_fac=isset($_POST['annee_fac'])?$_POST['annee_fac']:"";
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$coment=addslashes($coment);
$delai=isset($_POST['delai'])?$_POST['delai']:"";
$tvaouinon=isset($_POST['tvaouinon'])?$_POST['tvaouinon']:"";
$liste_bl=isset($_POST['liste_bl'])?$_POST['liste_bl']:"";
$liste_inter=isset($_POST['liste_inter'])?$_POST['liste_inter']:"";
echo($tvaouinon);
if($tvaouinon != "oui")
{
	$tvaouinon = "non";
}
//calcul de l'écheance
$jour_echeance = $jour_fact;
$mois_echeance = $mois_fact;
$annee_echeance = $annee_fact;
while ($i<$delai)
{
$jour_echeance = $jour_echeance +1;
	if ($jour_echeance >= 30) 
	{
	$mois_echeance = $mois_echeance +1;
	$jour_echeance = 1;
		if ($mois_echeance == 13)
		{
		$annee_echeance = $annee_echeance +1;
		$mois_echeance = 1;
		} 
	}
	$i = $i+1;
}
$debut = "$annee_deb-$mois_deb-$jour_deb" ;
$fin = "$annee_f-$mois_f-$jour_f" ;
$date_fact ="$annee_fact-$mois_fact-$jour_fact";
//Si des champs requis sont oubliés, on renvoi sur le form de création avec message
if($client=='null' || $date_deb==''|| $date_fin=='' || $date_fact=='' )
{
	$message= $lang_oubli_champ;
	include('form_facture.php');
	exit;
}
//on crée la facture avec les infos dispo pour locker le n° au plus vite
$sql1 = "INSERT INTO " . $tblpref ."facture(acompte, coment, client, date_fact, echeance_fact, tva)
	 VALUES ('$acompte', '$coment', '$client', '$date_fact', '$annee_echeance-$mois_echeance-$jour_echeance', '$tvaouinon')";
mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
$message="Facture enregistrée";
//on recherche le numero de la dernière facture créee
$sql = "SELECT MAX(num) As Maxi FROM " . $tblpref ."facture";
$result = mysql_query($sql) or die('Erreur');
$obj=mysql_fetch_object($result);
$num=$obj->Maxi;
//on récupère les infos client
$sql = " SELECT nom, nom2, num_tva From " . $tblpref ."client WHERE num_client = $client ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req)) {
	$nom = $data['nom'];
	$nom_html =  htmlentities (urlencode ($nom));
	$nom2 = $data['nom2'];
	$num_tva = $data['num_tva'];
}
//on traite les bl à facturer
if (isset($liste_bl)) {

	foreach ($liste_bl as $num_bl) {
	$sql 	= "SELECT tot_htva, tot_tva FROM " . $tblpref ."bl WHERE num_bl = $num_bl";
	$result  	= mysql_query($sql) or die ("requete foreach1 impossible");
	while ($data = mysql_fetch_array($result)){
	$tot_htva = $data['tot_htva'];
	$tot_tva = $data['tot_tva'];
	
	$tot_htva_facture = $tot_htva_facture + $tot_htva;
	$tot_tva_facture = $tot_tva_facture + $tot_tva;
	}
		//on met le n° de facture + statut fact = ok
		$sql2 = "UPDATE " . $tblpref ."bl SET fact='ok', fact_num='".$num."' WHERE num_bl = $num_bl";
		mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
	}
}
//on traite les inter à facturer
if (isset($liste_inter)) {

	foreach ($liste_inter as $num_inter) {
		//Récupération du time_fact_fixed
		$time_fact=isset($_POST['time_facturation_'.$num_inter.''])?$_POST['time_facturation_'.$num_inter.'']:"";
		//Récupération du déplacement fixé
		$cout_depl_fixed=isset($_REQUEST['depl_fixed_'.$num_inter.''])?$_REQUEST['depl_fixed_'.$num_inter.'']:"";
		$cout_depl_fixed=str_replace(',','.',$cout_depl_fixed);
		//Récupération du total fixé
		$cout_fact_fixed=isset($_REQUEST['fact_fixed_'.$num_inter.''])?$_REQUEST['fact_fixed_'.$num_inter.'']:"";
		$cout_fact_fixed=str_replace(',','.',$cout_fact_fixed);
		$sql="UPDATE ".$tblpref."task SET time_fact='".$time_fact."', prix_fact='".$cout_fact_fixed."', prix_depl='".$cout_depl_fixed."' WHERE rowid='".$num_inter."'";
		$req=mysql_query($sql);
		
		$sql 	= "SELECT tarif_special, deplacement, TIME_TO_SEC(time_fact) as sectime, ticket_num as ticketnum, prix_fact, prix_depl  FROM ".$tblpref."task WHERE rowid=$num_inter";
		$result  	= mysql_query($sql) or die ("requete foreach2 impossible:".mysql_error());
		/*while ($data	= mysql_fetch_array($result))
		{		
		$tarif_special = $data['tarif_special'];
		$nbtrav = '1';
		$type_deplacement = $data['deplacement'];	
		$duree_s=$data['sectime'];
		$num_ticket=$data['ticketnum'];
		//tarifs des inters
		
		
		if ($tarif_special == '4'){
			$tarif_quartdh = $tarif_REDUIT*$nbtrav;	
		
			if ($duree_s % 900 > '0') { 
				$cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; 
			} 
			else { 
				$cout = (int)($duree_s / 900) * $tarif_quartdh; 
			}
		}
		else{
				if ($num_tva == 'NA') { 
					$tarif_quartdh = $tarif_NA*$nbtrav; 
				} 
				else { 
					$tarif_quartdh = $tarif_ASSUJETI*$nbtrav; 
				}
				
				if ($duree_s % 900 > '0') { 
					$cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; 
				} 
				else { 
					$cout = (int)($duree_s / 900) * $tarif_quartdh; 
				}
			}		
		//cout du deplacement
		if ($type_deplacement == '1') {$cout_depl = '20';}
		elseif ($type_deplacement == '2') {$cout_depl = '30';}
		elseif ($type_deplacement == '3') {$cout_depl = '40';}
		elseif ($type_deplacement == '0') {$cout_depl = '0';}
		//si tarif special
		if ($tarif_special == 2) { $cout = $cout * 1.5; $cout_depl = $cout_depl * 1.5;}
		elseif ($tarif_special == 3) { $cout = $cout * 2; $cout_depl = $cout_depl * 2;}
		*/
		$data	= mysql_fetch_array($result);
		
		
		
		$cout=$data['prix_fact'];
		$cout_depl=$data['prix_depl'];
		$num_ticket=$data['ticketnum'];
		
		$tot_htva = $cout + $cout_depl;
		$tot_tva = ($tot_htva/100) *21;
				
		$tot_htva_facture = $tot_htva_facture + $tot_htva;
		$tot_tva_facture = $tot_tva_facture + $tot_tva;
		
		
		//on met le n° de facture + statut fact = ok
		$sql2 = "UPDATE " . $tblpref ."task SET facture='ok', fact_num='".$num."' WHERE rowid = $num_inter";
		mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
		
		$sql3 = "UPDATE ".$tblpref."ticket SET facture='ok', fact_num='".$num."' WHERE rowid = $num_ticket";
		mysql_query($sql3) or die('Erreur SQL2 !<br>'.$sql3.'<br>'.mysql_error());
		
	}
}
//on met a jour les totaux sur la facture
$tot_ttc_facture = $tot_htva_facture + $tot_tva_facture;
$sql2 = "UPDATE " . $tblpref ."facture SET  total_fact_h ='".$tot_htva_facture."', total_fact_ttc='".$tot_ttc_facture."' WHERE num = $num";
mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
include('lister_factures.php');
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>