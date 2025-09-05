<?php
include("../config/common.php");
//Début Récuperation des données
$state 	= $_REQUEST['state'];
$num 	= $_REQUEST['num'];

$sql="UPDATE ".$tblpref."det_dev SET etat='".$state."' WHERE num='".$num."'";
$req=mysql_query($sql);
?>