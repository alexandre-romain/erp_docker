<?php
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
$tot_ht=isset($_POST['tot_ht'])?$_POST['tot_ht']:"";
$tot_tva=isset($_POST['tot_tva'])?$_POST['tot_tva']:"";
$dev_num=isset($_POST['dev_num'])?$_POST['dev_num']:"";
$explic=isset($_POST['explic'])?$_POST['explic']:"";
$coment=isset($_POST['coment'])?$_POST['coment']:"";
mysql_select_db($db) or die ("Could not select $db database");
//$sql1 = "INSERT INTO bon_comm(tot_htva, tot_tva) VALUES ('$tot_ht', '$tot_tva) WHERE num_bon = $bon_num";
//mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

$sql2 = "UPDATE " . $tblprefluc ."devis SET tot_htva='".$tot_ht."'  WHERE num_dev = $dev_num";
mysql_query($sql2) OR die("<p>Erreur Mysql1<br/>$sql2<br/>".mysql_error()."</p>");
$sql3 = "UPDATE " . $tblprefluc ."devis SET tot_tva='".$tot_tva."'  WHERE num_dev = $dev_num";
mysql_query($sql3) OR die("<p>Erreur Mysql2<br/>$sql3<br/>".mysql_error()."</p>");
$sql4 = "UPDATE " . $tblprefluc ."devis SET coment='".$coment."'  WHERE num_dev = $dev_num";
mysql_query($sql4) OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
$sql5 = "UPDATE " . $tblprefluc ."devis SET explic='".$explic."'  WHERE num_dev = $dev_num";
mysql_query($sql5) OR die("<p>Erreur Mysql2<br/>$sql5<br/>".mysql_error()."</p>");
$message= "Devis enregistré";
include("new-form_devis.php");
 ?> 