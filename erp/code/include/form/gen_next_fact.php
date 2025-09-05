<?php
include("../config/common.php");
include("../fonctions.php");
//Récupération de l'id du parc
$id_parc=$_REQUEST['id'];
//On va récupérer le client
$sql="SELECT cli FROM ".$tblpref."parcs WHERE id = '".$id_parc."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$cli=$obj->cli;
///On va récupérer les contrat existants
//maintenance
$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id_parc."' AND sign='1' AND actif='1'";
$req=mysql_query($sql);
$exist_c=mysql_num_rows($req);
echo $exist_c.'<br/>';
if ($exist_c > 0) {
	//On va récupérer les données pour la nouvelle échéance.
	$obj=mysql_fetch_object($req);
	$id_contrat		=$obj->id;
	$nbr_pc			=$obj->nbr_pc;
	$nbr_laptop		=$obj->nbr_laptop;
	$nbr_server		=$obj->nbr_server;
	$nbr_mobile		=$obj->nbr_mobile;
	$nbr_printer	=$obj->nbr_printer;
	$prix_mois_c	=$obj->prix_mois;
	$prix_traite_c	=$obj->prix_traite;
	$type_fact_c	=$obj->type_fact;
	//On va récupérer la dernière échéance
	$sql="SELECT MAX(echeance) as maxecheance FROM ".$tblpref."contrat_echeance WHERE id_contrat='".$id_contrat."'";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
	$obj=mysql_fetch_object($req);
	$echeance=$obj->maxecheance;
	//On calcule la nouvelle, en fonction de la facturation
	if ($type_fact_c == 'men') {
		$month_add=1;
	}
	else if ($type_fact_c == 'tri') {
		$month_add=3;
	}
	else if ($type_fact_c == 'sem') {
		$month_add=6;
	}
	else if ($type_fact_c == 'ann') {
		$month_add=12;
	}
	$actuelsec=strtotime($echeance);
	$new_echeance=date('Y-m-d', strtotime('+'.$month_add.' month', $actuelsec));
	//On insère une nouvelle échéance.
	$sql="INSERT INTO ".$tblpref."contrat_echeance(id_contrat, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_contrat."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois_c."', '".$prix_traite_c."', '".$new_echeance."')";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
	$id_echeance_c=mysql_insert_id();
	//Calcul des prix contrat
	$prix_c_tvac=$prix_traite_c*1.21;
	$tva_c=$prix_c_tvac-$prix_traite_c;
}
//monitoring
$sql="SELECT * FROM ".$tblpref."monitoring WHERE id_parc='".$id_parc."' AND sign='1' AND actif='1'";
$req=mysql_query($sql);
echo $sql.'<br/>';
$exist_m=mysql_num_rows($req);
if ($exist_m > 0) {
	//On va récupérer les données pour la nouvelle échéance.
	$obj=mysql_fetch_object($req);
	$id_monitoring	=$obj->id;
	$nbr_pc			=$obj->nbr_pc;
	$nbr_laptop		=$obj->nbr_laptop;
	$nbr_server		=$obj->nbr_server;
	$nbr_mobile		=$obj->nbr_mobile;
	$nbr_printer	=$obj->nbr_printer;
	$prix_mois_m	=$obj->prix_mois;
	$prix_traite_m	=$obj->prix_traite;
	$type_fact_m	=$obj->type_fact;
	//On va récupérer la dernière échéance
	$sql="SELECT MAX(echeance) as maxecheance FROM ".$tblpref."monitoring_echeance WHERE id_monitoring='".$id_monitoring."'";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
	$obj=mysql_fetch_object($req);
	$echeance=$obj->maxecheance;
	//On calcule la nouvelle, en fonction de la facturation
	if ($type_fact_m == 'men') {
		$month_add=1;
	}
	else if ($type_fact_m == 'tri') {
		$month_add=3;
	}
	else if ($type_fact_m == 'sem') {
		$month_add=6;
	}
	else if ($type_fact_m == 'ann') {
		$month_add=12;
	}
	$actuelsec=strtotime($echeance);
	$new_echeance=date('Y-m-d', strtotime('+'.$month_add.' month', $actuelsec));
	//On insère une nouvelle échéance.
	$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois_m."', '".$prix_traite_m."', '".$new_echeance."')";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
	$id_echeance_m=mysql_insert_id();	
	//Calcul des prix monitoring
	$prix_m_tvac=$prix_traite_m*1.21;
	$tva_m=$prix_m_tvac-$prix_traite_m;
}
//Création des totaux
$prix_total_ht=$prix_traite_c+$prix_traite_m;
$total_tva=$tva_c+$tva_m;
$prix_total_ttc=$prix_c_tvac+$prix_m_tvac;
///Et des variables nécessaires
$comment='Periode du '.dateUSA_to_dateEU($echeance).' au '.dateUSA_to_dateEU($new_echeance).'';
//Création de la facture
///Facture
$sql="INSERT INTO ".$tblpref."facture(CLIENT, date_fact, echeance_fact, total_fact_h, total_fact_ttc, coment, tva) VALUES ('".$cli."', '".date('Y-m-d')."', '".date('Y-m-d', strtotime('+8 days'))."', '".$prix_total_ht."', '".$prix_total_ttc."', '".$comment."', 'non')";
$req=mysql_query($sql);
echo $sql.'<br/>';
$num_facture=mysql_insert_id();
///BL
$sql="INSERT INTO ".$tblpref."bl(client_num, date, tot_htva, tot_tva, fact, fact_num, status) VALUES ('".$cli."', '".date('Y-m-d')."', '".$prix_total_ht."', '".$total_tva."', 'ok', '".$num_facture."', '1')";
$req=mysql_query($sql);
echo $sql.'<br/>';
$num_bl=mysql_insert_id();
//On regarde quels articles pousser en fonction de la facturation souhaitée (men, tri, sem, ann)
if ($type_fact_c == 'men') {
	$article_c=1489;
	$article_m=96553;
}
else if ($type_fact_c == 'tri') {
	$article_c=904;
	$article_m=96554;
}
else if ($type_fact_c == 'sem') {
	$article_c=648;
	$article_m=96555;
}
else if ($type_fact_c == 'ann') {
	$article_c=96552;
	$article_m=96556;
}
//Si la maintenance est signée
if ($exist_c > 0) {
	$sql="INSERT INTO ".$tblpref."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) VALUES ('".$num_bl."', '".$article_c."', '1', '".$prix_traite_c."', '".$tva_c."', '".$prix_traite_c."')";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
	//On update les échéance nécessaires.
	$sql="UPDATE ".$tblpref."contrat_echeance SET fact='1', fact_num='".$num_facture."' WHERE id='".$id_echeance_c."'";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
}
//Si le monitoring est signé
if ($exist_m > 0) {
	$sql="INSERT INTO ".$tblpref."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) VALUES ('".$num_bl."', '".$article_m."', '1', '".$prix_traite_m."', '".$tva_m."', '".$prix_traite_m."')";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
	//On update les échéance nécessaires.
	$sql="UPDATE ".$tblpref."monitoring_echeance SET fact='1', fact_num='".$num_facture."' WHERE id='".$id_echeance_m."'";
	$req=mysql_query($sql);
	echo $sql.'<br/>';
}
$sql="SELECT nom FROM ".$tblpref."client WHERE id='".$cli."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$nom_cli=$obj->nom;
session_start();
$_SESSION['message']='Facture g&eacute;n&eacute;r&eacute;e<br/><a class="styled" href="./fpdf/facture_pdf.php?num='.$num_facture.'&nom='.$nom_cli.'&pdf_user=adm" target="_blank">Vous pouvez la consulter en cliquant ici</a>';
header('Location: ../../fiche_parc.php?id='.$id_parc);
?>