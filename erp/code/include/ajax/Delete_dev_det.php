<?php
include("../config/common.php");
//Début Récuperation des données
$num 	= $_REQUEST['num'];

$sql="DELETE FROM ".$tblpref."det_dev WHERE num='".$num."'";
$req=mysql_query($sql);
?>