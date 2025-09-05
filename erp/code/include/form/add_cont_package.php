<?php
include("../config/common.php");
include("../fonctions.php");
//On récupère les var
$article=$_REQUEST['articles'];
$qty=$_REQUEST['qty'];
$id_panier=$_REQUEST['id_panier'];
//On insère les articles
$sql="INSERT INTO ".$tblpref."cont_panier(id_panier, id_product, qty) VALUES ('".$id_panier."', '".$article."', '".$qty."')";
$req=mysql_query($sql);
echo $sql;
?>