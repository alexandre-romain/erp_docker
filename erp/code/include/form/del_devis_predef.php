<?php
include("../config/common.php");
include("../fonctions.php");
//On récupère l'id du devis à supprimer
$id=$_REQUEST['id_dev'];
$sql="SELECT name FROM ".$tblpref."dev_predef WHERE id='".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$devis_name=$obj->name;
//On va supprimer le cont_dev_predef
$sql="DELETE FROM ".$tblpref."cont_dev_predef WHERE id_dev_predef = '".$id."'";
$req=mysql_query($sql);
//On supprime le devis
$sql="DELETE FROM ".$tblpref."dev_predef WHERE id='".$id."'";
$req=mysql_query($sql);
header('Location: ../../devis_predef.php?message=del&open=list&name='.$devis_name.'');
?>
