<?php
include("../config/common.php");
include("../fonctions.php");
$cat	= $_REQUEST['cat'];
$type	= $_REQUEST['type'];

$sql="INSERT INTO ".$tblpref."cat_x_cat_devis(cat_devis, id_cat) VALUES ('".$type."', '".$cat."')";
$req=mysql_query($sql);
?>