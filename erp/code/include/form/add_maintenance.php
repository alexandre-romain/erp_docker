<?php
include("../config/common.php");
include("../fonctions.php");
//Récupération des variable du parc informatique
$cli			=$_REQUEST['cli'];
$id_parc		=$_REQUEST['id_parc'];
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
//On récupère les variables du monitoring
$facturation_m=$_REQUEST['facturation_m'];
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
	$datesign_m=$_REQUEST['datesign_m'];
	//La date de renouvellement
	$datesign_sec_m=strtotime($datesign_m);
	$date_r_m=date('Y-m-d', strtotime('+'.$month_add_m.' month', $datesign_sec_m));
	//On insère
	$sql="INSERT INTO ".$tblpref."monitoring(id_parc, cli, prix_mois, type_fact, prix_traite, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, sign, date_sign) VALUES ('".$id_parc."', '".$cli."', '".$p_month_m."', '".$facturation_m."', '".$prix_m."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '1', '".dateEU_to_dateUSA($datesign_m)."')";
	$req=mysql_query($sql);
	$id_monitoring=mysql_insert_id();
	$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$p_month_m."', '".$prix_m."', '".$date_r_m."')";
	$req=mysql_query($sql);
}
//Sinon
else {
	$sql="INSERT INTO ".$tblpref."monitoring(id_parc, cli, prix_mois, type_fact, prix_traite, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, sign) VALUES ('".$id_parc."', '".$cli."', '".$p_month_m."', '".$facturation_m."', '".$prix_m."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '0')";
	$req=mysql_query($sql);
}
echo $sql;
$message="Contrat correctement généré.";
//header('Location: ../../fiche_parc.php?id='.$id_parc.'&message='.$message);
?>