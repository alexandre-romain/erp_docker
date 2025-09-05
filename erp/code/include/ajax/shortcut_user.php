<?php
include_once("../config/common.php");

//On récupérè les widgets actifs ou non
$shortcut_new_task 			= $_REQUEST['shortcut_new_task'] ;
$shortcut_list_task 		= $_REQUEST['shortcut_list_task'];
$shortcut_list_ticket 		= $_REQUEST['shortcut_list_ticket'];
$shortcut_bill 				= $_REQUEST['shortcut_bill'];
$shortcut_list_bill 		= $_REQUEST['shortcut_list_bill'];
$shortcut_list_article 		= $_REQUEST['shortcut_list_article'];
$shortcut_profil 			= $_REQUEST['shortcut_profil'];
$shortcut_accueil 			= $_REQUEST['shortcut_accueil'];
$shortcut_param_ticket 		= $_REQUEST['shortcut_param_ticket'];
$user 						= $_REQUEST['user'];

if ($shortcut_new_task == 'on') {$shortcut_new_task='1';}
else {$shortcut_new_task='0';}

if ($shortcut_list_task == 'on') {$shortcut_list_task='1';}
else {$shortcut_list_task='0';}

if ($shortcut_list_ticket == 'on') {$shortcut_list_ticket='1';}
else {$shortcut_list_ticket='0';}

if ($shortcut_bill == 'on') {$shortcut_bill='1';}
else {$shortcut_bill='0';}

if ($shortcut_list_bill == 'on') {$shortcut_list_bill='1';}
else {$shortcut_list_bill='0';}

if ($shortcut_list_article == 'on') {$shortcut_list_article='1';}
else {$shortcut_list_article='0';}

if ($shortcut_profil == 'on') {$shortcut_profil='1';}
else {$shortcut_profil='0';}

if ($shortcut_accueil == 'on') {$shortcut_accueil='1';}
else {$shortcut_accueil='0';}

if ($shortcut_param_ticket == 'on') {$shortcut_param_ticket='1';}
else {$shortcut_param_ticket='0';}



//On active/désactive les widgets pour l'utilisateur
$sql= "UPDATE ".$tblpref."user SET shortcut_new_task='".$shortcut_new_task."', shortcut_list_task='".$shortcut_list_task."', shortcut_list_ticket='".$shortcut_list_ticket."', shortcut_bill='".$shortcut_bill."', shortcut_list_bill='".$shortcut_list_bill."', shortcut_list_article='".$shortcut_list_article."', shortcut_profil='".$shortcut_profil."', shortcut_accueil='".$shortcut_accueil."', shortcut_param_ticket='".$shortcut_param_ticket."' WHERE login='".$user."'";
$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

header('Location: ../../profil_user.php?valid_shortcut=ok');
?>