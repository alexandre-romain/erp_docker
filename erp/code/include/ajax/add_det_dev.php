<?php
include("../config/common.php");
//Début Récuperation des données
$nom 		= mysql_real_escape_string($_REQUEST['nom']);
$parent 	= $_REQUEST['parent'];

$sql="INSERT INTO ".$tblpref."det_dev(parent_dev,intitule,etat) VALUES ('$parent','$nom','Waiting')";
$req=mysql_query($sql);
?>