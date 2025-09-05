<?php
include_once("../config/common.php");
//On récupères les valeurs
$num = $_REQUEST['num'] ;
$date_day=date('Y-m-d');
$date_ref=date('Ymd');

foreach ($_REQUEST['received'] as $id ) {
	//On update la ligne de det_dep
	$sql="UPDATE ".$tblpref."det_dep SET received= '".date('Y-m-d')."' WHERE id = '".$id."'";
	$req=mysql_query($sql);
	//On cherche le type et le cas échéant la ligne de cont_bon correspondante.
	$sql="SELECT * FROM ".$tblpref."det_dep WHERE id = '".$id."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$type=$obj->type;
	$id_article=$obj->article_num;
	$qty=$obj->quanti;
	if ($type == 'cc') {
		//Si commande client
		$id_cont_bon=$obj->id_cont_bon;
		$sql="UPDATE ".$tblpref."cont_bon SET recu = '".date('Y-m-d')."' WHERE num='".$id_cont_bon."'";
		$req=mysql_query($sql);
	}
	//On récup les infos stock
	$sql="SELECT * FROM article WHERE num='".$id_article."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$stock=$obj->stock;
	//On incrémente
	$new_stock=$stock+$qty;
	//On pousse en BDD le new_stock
	$sql="UPDATE ".$tblpref."article SET stock='".$new_stock."' WHERE num='".$id_article."'";
	$req=mysql_query($sql);
}
//On update la ligne du contenu du bon, commander = oui
$sql_commande="UPDATE ".$tblpref."cont_bon SET recu='".date('Y-m-d')."' WHERE num=".$num."";
$req_commande=mysql_query($sql_commande);
//On update la ligne de det_dep
$sql="UPDATE ".$tblpref."det_dep SET received= '".date('Y-m-d')."' WHERE id_cont_bon = '".$num."'";
$req=mysql_query($sql);
//header('Location: ../../fiche_depense.php?id='.$num);
header('Location: ../../fichier_commande.php');
?>