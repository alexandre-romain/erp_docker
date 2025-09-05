<?php
include_once("../config/common.php");
//On récupères les valeurs
$qty = $_REQUEST['qty'] ;
$art_id = $_REQUEST['art_id'] ;
foreach ($_REQUEST['serial'] as  $serial) {
	echo $serial.'<-<br/>';
	$sql="INSERT INTO ".$tblpref."stock(article, serial) VALUES ('$art_id', '$serial')";
	$req=mysql_query($sql);
}
header('Location: ../../fichier_commande.php');
?>