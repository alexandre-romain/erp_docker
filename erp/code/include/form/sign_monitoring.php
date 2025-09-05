<?php
include("../config/common.php");
include("../fonctions.php");
//Récupération des variable du parc informatique
$id_parc		=$_REQUEST['id_parc'];
$id_monitoring	=$_REQUEST['id_monitoring'];
$debut			=$_REQUEST['debut'];
//Si la date a été fixée par l'utilisateur (encore aucun contrat signé)
if (isset($_REQUEST['debut'])) {
	//On va updater le monitoring, pour le signer
	$sql="UPDATE ".$tblpref."monitoring SET sign='1', date_sign='".dateEU_to_dateUSA($debut)."' WHERE id='".$id_monitoring."' AND actif='1'";
	$req=mysql_query($sql);
	//Ensuite on va récupérer les informations nécessaire, afin de créer l'échéance
	$sql="SELECT * FROM ".$tblpref."monitoring WHERE id='".$id_monitoring."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$facturation=$obj->type_fact;
	//On calcule la prochaine echéance
	if ($facturation == 'men') {
		$month_add=1;
	}
	else if ($facturation == 'tri') {
		$month_add=3;
	}
	else if ($facturation == 'sem') {
		$month_add=6;
	}
	else if ($facturation == 'ann') {
		$month_add=12;
	}
	$debut_sec=strtotime($debut);
	//NEXT Echeance
	$date_r=date('Y-m-d', strtotime('+'.$month_add.' month', $debut_sec));
	//On récupère les autres valeurs
	$nbr_pc			=$obj->nbr_pc;
	$nbr_laptop		=$obj->nbr_laptop;
	$nbr_server		=$obj->nbr_server;
	$nbr_mobile		=$obj->nbr_mobile;
	$nbr_printer	=$obj->nbr_printer;
	$prix_traite	=$obj->prix_traite;
	$prix_mois		=$obj->prix_mois;
	//On insère en BDD dans monitoring_echeance
	$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois."', '".$prix_traite."', '".$date_r."')";
	$req=mysql_query($sql);
}
//Si un contrat est déjà signé.
else if (isset($_REQUEST['debut_fix'])) {
	$date_r			=$_REQUEST['debut_fix'];
	//On va récupérer les informations du contrat
	$sql="SELECT * FROM ".$tblpref."monitoring WHERE id='".$id_monitoring."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$facturation=$obj->type_fact;
	//On calcule la prochaine echéance
	if ($facturation == 'men') {
		$month_add=1;
	}
	else if ($facturation == 'tri') {
		$month_add=3;
	}
	else if ($facturation == 'sem') {
		$month_add=6;
	}
	else if ($facturation == 'ann') {
		$month_add=12;
	}
	$date_r_sec=strtotime($date_r);
	//NEXT Echeance
	$debut=date('Y-m-d', strtotime('-'.$month_add.' month', $date_r_sec));
	//On récupère les autres valeurs
	$nbr_pc			=$obj->nbr_pc;
	$nbr_laptop		=$obj->nbr_laptop;
	$nbr_server		=$obj->nbr_server;
	$nbr_mobile		=$obj->nbr_mobile;
	$nbr_printer	=$obj->nbr_printer;
	$prix_traite	=$obj->prix_traite;
	$prix_mois		=$obj->prix_mois;
	//On va updater le contrat, pour le signer
	$sql="UPDATE ".$tblpref."monitoring SET sign='1', date_sign='".$debut."' WHERE id='".$id_monitoring."' AND actif='1'";
	$req=mysql_query($sql);
	echo $sql;
	//On insère en BDD dans monitoring_echeance
	$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois."', '".$prix_traite."', '".dateEU_to_dateUSA($date_r)."')";
	$req=mysql_query($sql);
}
session_start();
$_SESSION['message']="Monitoring sign&eacute;";
//header('Location: ../../fiche_parc.php?id='.$id_parc);
?>