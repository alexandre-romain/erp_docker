<?php
include("../config/common.php");
include("../fonctions.php");

//Récupération des variable du parc informatique
$cli			=$_REQUEST['listeville'];
$nbr_pc			=$_REQUEST['nbr_pc'];
if ($nbr_pc == '') {
	$nbr_pc=0;
}
$nbr_laptop		=$_REQUEST['nbr_laptop'];
if ($nbr_laptop == '') {
	$nbr_laptop=0;
}
$nbr_server		=$_REQUEST['nbr_server'];
if ($nbr_server == '') {
	$nbr_server=0;
}
$nbr_mobile		=$_REQUEST['nbr_mobile'];
if ($nbr_mobile == '') {
	$nbr_mobile=0;
}
$nbr_printer	=$_REQUEST['nbr_printer'];
if ($nbr_printer == '') {
	$nbr_printer=0;
}
//On insère le parc
$sql="INSERT INTO ".$tblpref."parcs(cli, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, date_creation, date_modif) VALUES ('".$cli."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', now(), now())";
echo $sql.'<br/>';
$req=mysql_query($sql);
$id_parc=mysql_insert_id();
//On vérifie si un contrat est souhaité
if (isset($_REQUEST['contrat']) && $_REQUEST['contrat'] == 'oui') {
	//On récupère les variables du contrat
	$facturation=$_REQUEST['facturation'];
	$prix_c=$_REQUEST['prix_c'];
	//On calcule le prix mensuel
	if ($facturation == 'men') {
		$p_month=$prix_c;
		$month_add=1;
	}
	else if ($facturation == 'tri') {
		$p_month=$prix_c/3;
		$month_add=3;
	}
	else if ($facturation == 'sem') {
		$p_month=$prix_c/6;
		$month_add=6;
	}
	else if ($facturation == 'ann') {
		$p_month=$prix_c/12;
		$month_add=12;
	}
	//Si le contrat est signé
	if (isset($_REQUEST['sign']) && $_REQUEST['sign'] == 'oui') {
		$datesign=$_REQUEST['datesign'];
		//La date de renouvellement
		$datesign_sec=strtotime($datesign);
		$date_r=date('Y-m-d', strtotime('+'.$month_add.' month', $datesign_sec));
		//On insère
		$sql="INSERT INTO ".$tblpref."contrat_maintenance(id_parc, cli, prix_mois, type_fact, prix_traite, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, sign, date_sign) VALUES ('".$id_parc."', '".$cli."', '".$p_month."', '".$facturation."', '".$prix_c."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '1', '".dateEU_to_dateUSA($datesign)."')";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
		$id_contrat=mysql_insert_id();
		//On insère les données de nbr composante & prix afin de conserver l'historique.
		$sql="INSERT INTO ".$tblpref."contrat_echeance(id_contrat, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_contrat."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$p_month."', '".$prix_c."', '".$date_r."')";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
		$id_echeance_c = mysql_insert_id();
	}
	//Sinon 
	else {
		$sql="INSERT INTO ".$tblpref."contrat_maintenance(id_parc, cli, prix_mois, type_fact, prix_traite, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, sign) VALUES ('".$id_parc."', '".$cli."', '".$p_month."', '".$facturation."', '".$prix_c."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '0')";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
	}
}

//On vérifie si un monitoring est souhaité
if (isset($_REQUEST['monitoring']) && $_REQUEST['monitoring'] == 'oui') {
	//On récupère les variables du monitoring
	$facturation_m=$_REQUEST['facturation'];
	$prix_m=$_REQUEST['prix_m'];
	//On calcule le prix mensuel
	if ($facturation_m == 'men') {
		$p_month_m=$prix_m;
		$month_add_m=1;
	}
	else if ($facturation_m == 'tri') {
		$p_month_m=$prix_m/3;
		$month_add_m=3;
	}
	else if ($facturation_m == 'sem') {
		$p_month_m=$prix_m/6;
		$month_add_m=6;
	}
	else if ($facturation_m == 'ann') {
		$p_month_m=$prix_m/12;
		$month_add_m=12;
	}
	//Si le monitoring est signé
	if (isset($_REQUEST['sign_m']) && $_REQUEST['sign_m'] == 'oui') {
		$datesign=$_REQUEST['datesign'];
		//La date de renouvellement
		$datesign_sec_m=strtotime($datesign);
		$date_r=date('Y-m-d', strtotime('+'.$month_add_m.' month', $datesign_sec_m));
		//On insère
		$sql="INSERT INTO ".$tblpref."monitoring(id_parc, cli, prix_mois, type_fact, prix_traite, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, sign, date_sign) VALUES ('".$id_parc."', '".$cli."', '".$p_month_m."', '".$facturation_m."', '".$prix_m."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '1', '".dateEU_to_dateUSA($datesign)."')";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
		$id_monitoring=mysql_insert_id();
		$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$p_month_m."', '".$prix_m."', '".$date_r."')";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
		$id_echeance_m = mysql_insert_id();
	}
	//Sinon
	else {
		$sql="INSERT INTO ".$tblpref."monitoring(id_parc, cli, prix_mois, type_fact, prix_traite, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, sign) VALUES ('".$id_parc."', '".$cli."', '".$p_month_m."', '".$facturation_m."', '".$prix_m."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '0')";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
	}
}

//On vérifie si la facturation de la première période est demandée.
if (isset($_REQUEST['fact_first']) && $_REQUEST['fact_first'] == 'oui') {
	////On crée les entrées nécessaires à la facture
	///Calcul du total
	$prix_total_ht=$prix_c+$prix_m;
	$prix_c_tvac=$prix_c*1.21;
	$tva_c=$prix_c_tvac-$prix_c;
	$prix_m_tvac=$prix_m*1.21;
	$tva_m=$prix_m_tvac-$prix_m;
	$prix_total_ttc=$prix_c_tvac+$prix_m_tvac;
	///Et des variables nécessaires
	$comment='Période du '.$datesign.' au '.dateUSA_to_dateEU($date_r).'';
	///Facture
	$sql="INSERT INTO ".$tblpref."facture(CLIENT, date_fact, echeance_fact, total_fact_h, total_fact_ttc, coment, tva) VALUES ('".$cli."', '".date('Y-m-d')."', '".date('Y-m-d', strtotime('+8 days'))."', '".$prix_total_ht."', '".$prix_total_ttc."', '".$comment."', 'non')";
	$req=mysql_query($sql);
	$num_facture=mysql_insert_id();
	///BL
	$sql="INSERT INTO ".$tblpref."bl(client_num, date, tot_htva, tot_tva, fact, fact_num, status) VALUES ('".$cli."', '".date('Y-m-d')."', '".$prix_total_ht."', '".$prix_total_ttc."', 'ok', '".$num_facture."', '1')";
	$req=mysql_query($sql);
	$num_bl=mysql_insert_id();
	///Cont_bl
	//On regarde quels articles pousser en fonction de la facturation souhaitée (men, tri, sem, ann)
	if ($facturation == 'men') {
		$article_c=1489;
		$article_m=96553;
	}
	else if ($facturation == 'tri') {
		$article_c=904;
		$article_m=96554;
	}
	else if ($facturation == 'sem') {
		$article_c=648;
		$article_m=96555;
	}
	else if ($facturation == 'ann') {
		$article_c=96552;
		$article_m=96556;
	}
	//Si la maintenance est signée
	if (isset($_REQUEST['sign']) && $_REQUEST['sign'] == 'oui') {
		$sql="INSERT INTO ".$tblpref."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) VALUES ('".$num_bl."', '".$article_c."', '1', '".$prix_c."', '".$tva_c."', '".$prix_c."')";
		$req=mysql_query($sql);
		//On update les échéance nécessaires.
		$sql="UPDATE ".$tblpref."contrat_echeance SET fact='1', fact_num='".$num_facture."' WHERE id='".$id_echeance_c."'";
		$req=mysql_query($sql);
	}
	//Si le monitoring est signé
	if (isset($_REQUEST['sign_m']) && $_REQUEST['sign_m'] == 'oui') {
		$sql="INSERT INTO ".$tblpref."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) VALUES ('".$num_bl."', '".$article_m."', '1', '".$prix_m."', '".$tva_m."', '".$prix_m."')";
		$req=mysql_query($sql);
		//On update les échéance nécessaires.
		$sql="UPDATE ".$tblpref."monitoring_echeance SET fact='1', fact_num='".$num_facture."' WHERE id='".$id_echeance_m."'";
		$req=mysql_query($sql);
	}
}
//Sinon, si des contrat existent, on en marque les deux premières échéances comme facturées.
else {
	//Si le contrat est signé
	if (isset($_REQUEST['sign']) && $_REQUEST['sign'] == 'oui') {
		$sql="UPDATE ".$tblpref."contrat_echeance SET fact='1', fact_num='OLD' WHERE id='".$id_echeance_c."'";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
	}
	//Si le monitoring est signé
	if (isset($_REQUEST['sign_m']) && $_REQUEST['sign_m'] == 'oui') {
		$sql="UPDATE ".$tblpref."monitoring_echeance SET fact='1', fact_num='OLD' WHERE id='".$id_echeance_m."'";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
	}
}
session_start();
$_SESSION['message']="Parc correctement ajout&eacute;.";
header('Location: ../../form_parc.php');
?>