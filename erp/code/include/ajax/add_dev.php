<?php
include("../config/common.php");
//Début Récuperation des données
$soc 		= addslashes($_REQUEST['listeville']);
$nom 		= addslashes($_REQUEST['nom']);
$date_day	= date('Y-m-d');

$sql="INSERT INTO ".$tblpref."dev(nom, date_c, client) VALUES ('$nom', '$date_day', '$soc')";
$req=mysql_query($sql);

header('Location: ../../journal_dev.php'); 
?>											