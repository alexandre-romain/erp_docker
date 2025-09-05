<?php
include("../config/common.php");
include("../fonctions.php");

$cli			=$_REQUEST['listeville'];
$echeance		=$_REQUEST['echeance'];
$periodicite	=$_REQUEST['periodicite'];
//$prix			=$_REQUEST['prix']; prix à ce niveau n'a pas de sens ....
$articles		=$_REQUEST['articles'];
//$qty			=$_REQUEST['qty'];
$com_facture	=$_REQUEST['com_fact'];
$com_interne	=$_REQUEST['com_int'];
//On calcule l'échéance
$echeance=dateEU_to_dateUSA($echeance);
$debut = date('Y-m-d');

foreach ($articles as $article) {

	$sql="INSERT INTO ".$tblpref."contrat(debut, periodicite, echeance, id_cli, article, com_facture, com_interne) VALUES ('".$debut."', '".$periodicite."', '".$echeance."', '".$cli."', '".$article['name']."', '".$com_facture."', '".$com_interne."')";
	$req=mysql_query($sql);
}
header('Location: ../../contrats.php?add=ok');
?>