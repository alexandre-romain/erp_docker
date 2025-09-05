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
$name	= $_REQUEST['name'];
//On update
$sql="UPDATE ".$tblpref."user SET background='".$name."' WHERE num='".$num_user."'";
$req=mysql_query($sql);
?>