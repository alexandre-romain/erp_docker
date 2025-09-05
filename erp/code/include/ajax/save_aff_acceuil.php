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
if ($state == 'my') {
	$state = 1;
}
else {
	$state = 0;
}
$sql="UPDATE ".$tblpref."user SET";
//On check le type
if ($type == 'task') {
	$sql.=" widgt_task_state = '".$state."'";
}
if ($type == 'ticket') {
	$sql.=" widgt_ticket_state = '".$state."'";
}
$sql.=" WHERE num='".$num_user."'";

echo $sql;
$req=mysql_query($sql);
?>