<?php
include("../config/common.php");
include("../fonctions.php");
$id				=$_REQUEST['id_panier'];
$cli			=$_REQUEST['listeville'];
$debut			=$_REQUEST['debut'];
$duree			=$_REQUEST['duree'];
$com_fact			=$_REQUEST['com_fact'];
$com_int			=$_REQUEST['com_int'];
//$prix			=$_REQUEST['prix'];
//On calcule l'échéance
$debsec=strtotime($debut);
$echeance=date('Y-m-d', strtotime('+'.$duree.' month', $debsec));
$debut=dateEU_to_dateUSA($debut);
//On update le panier
$sql="UPDATE ".$tblpref."panier SET debut='".$debut."', duree='".$duree."', echeance='".$echeance."', id_cli='".$cli."', com_facture='".$com_fact."', com_interne='".$com_int."' WHERE id='".$id."'";
$req=mysql_query($sql);
header('Location: ../../packages.php?add=edit');
?>