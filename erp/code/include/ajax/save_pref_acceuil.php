<?php
include("../config/common.php");
include("../fonctions.php");
///RECUPERATION ID USER
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//Récupération de l'id utilisiteur accédant à la page
$sql_user=" SELECT num";
$sql_user.=" FROM ".$tblpref."user";
$sql_user.=" WHERE login='".$user."'";
$req_user=mysql_query($sql_user);
$results_user=mysql_fetch_object($req_user);
$num_user=$results_user->num;
//Récup des var envoyées par JS
$type	= $_REQUEST['type'];
$state	= $_REQUEST['state'];
//On transforme l'etat
if ($state == 'oui') {
	$state = 1;
}
else {
	$state = 0;
}
//On update
$sql="UPDATE ".$tblpref."user SET";
if ($type == 'task') {
	$sql.=" widgt_inter_all='".$state."'";
}
else if ($type == 'ticket') {
	$sql.=" widgt_ticket_all='".$state."'";
}
else if ($type == 'ticketclo') {
	$sql.=" widgt_ticket_close_non_fact='".$state."'";
}
else if ($type == 'blpafact') {
	$sql.=" widgt_bon_liv='".$state."'";
}
else if ($type == 'bcpliv') {
	$sql.=" widgt_commande='".$state."'";
}
else if ($type == 'panier') {
	$sql.=" widgt_panier='".$state."'";
}
$sql.=" WHERE num='".$num_user."'";
$req=mysql_query($sql);
?>