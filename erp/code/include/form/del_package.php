<?php
include("../config/common.php");
//On récupère l'id
$id=$_REQUEST['id'];
//On delete le panier
$sql="DELETE FROM ".$tblpref."panier WHERE id='".$id."'";
$req=mysql_query($sql);
//ON delete le contenu du panier
$sql="DELETE FROM ".$tblpref."cont_panier WHERE id_panier='".$id."'";
$req=mysql_query($sql);
header('Location: ../../packages.php?add=del');
?>