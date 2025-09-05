<?php
include("../config/common.php");
//On récupère l'id
$id=$_REQUEST['id'];
//On delete le panier
$sql="DELETE FROM ".$tblpref."contrat WHERE id='".$id."'";
$req=mysql_query($sql);
header('Location: ../../contrats.php?add=del');
?>