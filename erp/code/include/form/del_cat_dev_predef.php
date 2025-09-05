<?php
include("../config/common.php");
include("../fonctions.php");
$id	= $_REQUEST['id'];
$sql="DELETE FROM ".$tblpref."cat_x_cat_devis WHERE id='".$id."'";
$req=mysql_query($sql);

echo $sql;
?>