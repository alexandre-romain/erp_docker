<?php
include_once("../config/common.php");

//On récupérè les widgets actifs ou non
$wid_inter_all 				= $_REQUEST['wid_inter_all'] ;
$wid_inter_user 			= $_REQUEST['wid_inter_user'];
$wid_ticket_user 			= $_REQUEST['wid_ticket_user'];
$wid_ticket_all 			= $_REQUEST['wid_ticket_all'];
$wid_ticket_close_non_fact 	= $_REQUEST['wid_ticket_close_non_fact'];
$wid_task_day 				= $_REQUEST['wid_task_day'];
$wid_commande				= $_REQUEST['wid_commande'];
$wid_bon_liv				= $_REQUEST['wid_bon_liv'];
$wid_panier					= $_REQUEST['wid_panier'];
$user 						= $_REQUEST['user'];

if ($wid_inter_all == 'on') {$wid_inter_all='1';}
else {$wid_inter_all='0';}

if ($wid_inter_user == 'on') {$wid_inter_user='1';}
else {$wid_inter_user='0';}

if ($wid_ticket_user == 'on') {$wid_ticket_user='1';}
else {$wid_ticket_user='0';}

if ($wid_ticket_all == 'on') {$wid_ticket_all='1';}
else {$wid_ticket_all='0';}

if ($wid_ticket_close_non_fact == 'on') {$wid_ticket_close_non_fact='1';}
else {$wid_ticket_close_non_fact='0';}

if ($wid_task_day == 'on') {$wid_task_day='1';}
else {$wid_task_day='0';}

if ($wid_commande == 'on') {$wid_commande='1';}
else {$wid_commande='0';}

if ($wid_bon_liv == 'on') {$wid_bon_liv='1';}
else {$wid_bon_liv='0';}

if ($wid_panier == 'on') {$wid_panier='1';}
else {$wid_panier='0';}



//On active/désactive les widgets pour l'utilisateur
$sql= "UPDATE ".$tblpref."user SET widgt_inter_all='".$wid_inter_all."', widgt_inter_user='".$wid_inter_user."', widgt_ticket_user='".$wid_ticket_user."', widgt_ticket_all='".$wid_ticket_all."', widgt_ticket_close_non_fact='".$wid_ticket_close_non_fact."', widgt_task_day='".$wid_task_day."', widgt_commande='".$wid_commande."', widgt_bon_liv='".$wid_bon_liv."', widgt_panier='".$wid_panier."' WHERE login='".$user."'";
$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

header('Location: ../../profil_user.php?valid=ok');
?>