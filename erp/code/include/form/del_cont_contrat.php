<?php
include("../config/common.php");
//On récupère l'id
$id=$_REQUEST['id'];
//ON delete le contenu du panier
$sql="DELETE FROM ".$tblpref."cont_panier WHERE id='".$id."'";
$req=mysql_query($sql);
?>