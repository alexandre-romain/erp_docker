<?php
include("../config/common.php");
//On récupère l'id
$id=$_REQUEST['id'];
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
$_SESSION['message']='Monitoring supprim&eacute;.';
header('Location: ../../fiche_parc.php?id='.$id);
?>