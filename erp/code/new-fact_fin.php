<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/finhead.php");?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
if ($user_admin != y) { 
echo "<h1>$lang_admin_droit";
exit;
}
?>
</td>
</tr>
<?php
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
$delai=isset($_POST['delai'])?$_POST['delai']:"";

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

if($client=='null' || $date_deb==''|| $date_fin=='' || $date_fact=='' )
{
$message= "<h1>$lang_oubli_champ</h1>";
include('form_facture.php');
exit;
}
//on crée la facture avec les infos dispo pour locker le n° au plus vite
$sql1 = "INSERT INTO " . $tblprefluc ."facture(acompte, coment, client, date_fact, echeance_fact)
	 VALUES ('$acompte', '$coment', '$client', '$date_fact', '$annee_echeance-$mois_echeance-$jour_echeance')";
mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
$message="<h2> Facture enregistrée<br>";

//on recherche le numero de la dernière facture créee
$sql = "SELECT MAX(num) As Maxi FROM " . $tblprefluc ."facture";
$result = mysql_query($sql) or die('Erreur');
$num = mysql_result($result, 'Maxi');

//on récupère les infos client
$sql = " SELECT nom, nom2, num_tva From " . $tblprefluc ."client WHERE num_client = $client ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
	$nom = $data['nom'];
	$nom_html =  htmlentities (urlencode ($nom));
	$nom2 = $data['nom2'];
	$tva_client = $data['num_tva'];
	}


//on traite les bl à facturer
if (isset($liste_bl)) {

	foreach ($liste_bl as $num_bl) {
	$sql 	= "SELECT tot_htva, tot_tva FROM " . $tblprefluc ."bl WHERE num_bl = $num_bl";
	$result  	= mysql_query($sql) or die ("requete foreach1 impossible");
	while ($data = mysql_fetch_array($result))
	{
	$tot_htva = $data['tot_htva'];
	$tot_tva = $data['tot_tva'];
	
	$tot_htva_facture = $tot_htva_facture + $tot_htva;
	$tot_tva_facture = $tot_tva_facture + $tot_tva;
	}
		//on met le n° de facture + statut fact = ok
		$sql2 = "UPDATE " . $tblprefluc ."bl SET fact='ok', fact_num='".$num."' WHERE num_bl = $num_bl";
		mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
	
	}
}

//on traite les inter à facturer
if (isset($liste_inter)) {

	foreach ($liste_inter as $num_inter) {
	$sql 	= "SELECT debut, fin, tarif_special, type_deplacement FROM " . $tblprefluc ."interventions WHERE num_inter = $num_inter";
	$result  	= mysql_query($sql) or die ("requete foreach1 impossible");
	while ($data	= mysql_fetch_array($result))
	{
	
	$debut = $data['debut'];
	$fin = $data['fin'];
	$tarif_special = $data['tarif_special'];
	$type_deplacement = $data['type_deplacement'];
	
	//tarifs des inters
	if ($tva_client == 'NA') { $tarif_quartdh = 9.92; } else { $tarif_quartdh = 12; }
	
	$duree_s = $fin - $debut;
	if ($duree_s % 900 > '0') { $cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; } 
	else { $cout = (int)($duree_s / 900) * $tarif_quartdh; }
	
	//cout du deplacement
	if ($type_deplacement == 1) {$cout_depl = 20;}
	elseif ($type_deplacement == 2) {$cout_depl = 30;}
	elseif ($type_deplacement == 3) {$cout_depl = 40;}
	
	//si tarif special
	if ($tarif_special == '2') { $cout = $cout * 1.5; $cout_depl = $cout_depl * 1.5;}
	elseif ($tarif_special == '3') { $cout = $cout * 2; $cout_depl = $cout_depl * 2;}
	
	$tot_htva = $cout + $cout_depl;
	$tot_tva = $tot_htva /100 *21;
	
	$tot_htva_facture = $tot_htva_facture + $tot_htva;
	$tot_tva_facture = $tot_tva_facture + $tot_tva;
	}
		//on met le n° de facture + statut fact = ok
		$sql2 = "UPDATE " . $tblprefluc ."interventions SET fact='ok', fact_num='".$num."' WHERE num_inter = $num_inter";
		mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
	
	}
}
		//on met a jour les totaux sur la facture
		$tot_ttc_facture = $tot_htva_facture + $tot_tva_facture;
		$sql2 = "UPDATE " . $tblprefluc ."facture SET  total_fact_h ='".$tot_htva_facture."', total_fact_ttc='".$tot_ttc_facture."' WHERE num = $num";
		mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());

include('new-lister_factures.php');
?>
<tr><td>
<?php
include_once("include/bas.php");
?> 
</td></tr></table>