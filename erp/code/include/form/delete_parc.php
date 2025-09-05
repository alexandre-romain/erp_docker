<?php
include("../config/common.php");
//On récupère l'id
$id=$_REQUEST['id'];
//On supprime le parc
$sql="DELETE FROM ".$tblpref."parcs WHERE id='".$id."'";
$req=mysql_query($sql);
//On supprime le monitoring
$sql="SELECT id FROM ".$tblpref."monitoring WHERE id_parc='".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$id_monitoring=$obj->id;
$sql="DELETE FROM ".$tblpref."monitoring_echeance WHERE id_monitoring='".$id_monitoring."'";
$req=mysql_query($sql);
$sql="DELETE FROM ".$tblpref."monitoring WHERE id_parc='".$id."'";
$req=mysql_query($sql);
//On supprime le contrat
$sql="SELECT id FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$id_contrat=$obj->id;
$sql="DELETE FROM ".$tblpref."contrat_echeance WHERE id_contrat='".$id_contrat."'";
$req=mysql_query($sql);
$sql="DELETE FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id."'";
$req=mysql_query($sql);
session_start();
$_SESSION['message']='Parc supprim&eacute;.';
header('Location: ../../form_parc.php');
?>