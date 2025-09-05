<?php
include("../config/common.php");
//On récupère l'id
$id=$_REQUEST['id'];
//On supprime le monitoring
$sql="SELECT id FROM ".$tblpref."monitoring WHERE id_parc='".$id."'";
echo $sql.'<br/>';
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$id_monitoring=$obj->id;
$sql="DELETE FROM ".$tblpref."monitoring_echeance WHERE id_monitoring='".$id_monitoring."'";
echo $sql.'<br/>';
$req=mysql_query($sql);
$sql="DELETE FROM ".$tblpref."monitoring WHERE id_parc='".$id."'";
echo $sql.'<br/>';
$req=mysql_query($sql);
session_start();
$_SESSION['message']='Monitoring supprim&eacute;.';
header('Location: ../../fiche_parc.php?id='.$id);
?>