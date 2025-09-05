<?php
include("../config/common.php");
include("../fonctions.php");

$cli			=$_REQUEST['listeville'];
$debut			=$_REQUEST['debut'];
$duree			=$_REQUEST['duree'];
//$prix			=$_REQUEST['prix']; prix à ce niveau n'a pas de sens ....
$articles		=$_REQUEST['articles'];
$qty			=$_REQUEST['qty'];
$com_facture	=$_REQUEST['com_fact'];
$com_interne	=$_REQUEST['com_int'];
//On calcule l'échéance
$debsec=strtotime($debut);
$echeance=date('Y-m-d', strtotime('+'.$duree.' month', $debsec));
$debut=dateEU_to_dateUSA($debut);
$cle_unique = bin2hex(openssl_random_pseudo_bytes(25));

//On crée le panier
$sql="INSERT INTO ".$tblpref."panier(debut, duree, echeance, id_cli, com_facture, com_interne, cle_unique) VALUES ('".$debut."', '".$duree."', '".$echeance."', '".$cli."', '".$com_facture."', '".$com_interne."', '".$cle_unique."')";
$req=mysql_query($sql);
//On récupère l'id du panier
$id_panier=mysql_insert_id(); 
//On insère les articles dans le panier
foreach ($articles as $article) {
	$sql="INSERT INTO ".$tblpref."cont_panier(id_panier,id_product, qty) VALUES ('".$id_panier."', '".$article['name']."', '".$article['qty']."')";
	$req=mysql_query($sql);
}
header('Location: ../../packages.php?add=ok');
?>