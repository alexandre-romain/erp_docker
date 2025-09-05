<?php
include("../config/common.php");
include("../fonctions.php");
session_start();
//Récupération des variable du parc informatique
$id_parc		=$_REQUEST['id_parc'];
$id_monitoring	=$_REQUEST['id_monitoring'];
//Nombres de composantes
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
//On récupère les variables du contrat
$facturation_m=$_REQUEST['facturation_m'];
$prix_m=$_REQUEST['prix_m'];
//On calcule le prix mensuel
if ($facturation_m == 'men') {
	$p_month=$prix_m;
	$multiplier=1;
}
else if ($facturation_m == 'tri') {
	$p_month=$prix_m/3;
	$multiplier=3;
}
else if ($facturation_m == 'sem') {
	$p_month=$prix_m/6;
	$multiplier=6;
}
else if ($facturation_m == 'ann') {
	$p_month=$prix_m/12;
	$multiplier=12;
}
$sql="UPDATE ".$tblpref."monitoring SET prix_mois='".$p_month."', type_fact='".$facturation_m."', prix_traite='".$prix_m."', nbr_pc='".$nbr_pc."', nbr_laptop='".$nbr_laptop."', nbr_server='".$nbr_server."', nbr_mobile='".$nbr_mobile."', nbr_printer='".$nbr_printer."' WHERE id='".$id_monitoring."'";
$req=mysql_query($sql);
//On va vérifier s'il existe un contrat de maintenance pour le parc, de manière a faire coller la périodicité de facturation.
$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id_parc."' AND actif='1'";
$req=mysql_query($sql);
$contrat_exist=mysql_num_rows($req);
echo $sql.'<br/>';
if ($contrat_exist > 0) {
	$obj=mysql_fetch_object($req);
	$prix_mois 	= $obj->prix_mois;
	$id_contrat	= $obj->id;
	$type_fact	= $obj->type_fact;
	echo $type_fact.'<br/>';
	echo $facturation_m.'<br/>';
	$_SESSION['message']="Monitoring correctement mis &agrave; jour.";
	//Si la périodicité de facturation change.
	if ($type_fact != $facturation_m) {
		$new_prix_traite = $prix_mois*$multiplier;
		$sql="UPDATE ".$tblpref."contrat_maintenance SET type_fact = '".$facturation_m."', prix_traite = '".$new_prix_traite."' WHERE id='".$id_contrat."'";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
		$_SESSION['message']="Monitoring correctement mis &agrave; jour, la facturation de la maintenance du parc &agrave; &eacute;t&eacute; adapt&eacute;e";
	}
}
else {
	$_SESSION['message']="Monitoring correctement mis &agrave; jour.";
}
header('Location: ../../fiche_parc.php?id='.$id_parc);
?>