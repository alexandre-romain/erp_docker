<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$tot_ht=isset($_POST['tot_ht'])?$_POST['tot_ht']:"";
$tot_tva=isset($_POST['tot_tva'])?$_POST['tot_tva']:"";
$bon_num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$cli=isset($_POST['client_num'])?$_POST['client_num']:"";
mysql_select_db($db) or die ("Could not select $db database");

$sql2 = "UPDATE " . $tblpref ."bon_comm SET tot_htva='".$tot_ht."'  WHERE num_bon = $bon_num";
mysql_query($sql2) OR die("<p>Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");
$sql3 = "UPDATE " . $tblpref ."bon_comm SET tot_tva='".$tot_tva."'  WHERE num_bon = $bon_num";
mysql_query($sql3) OR die("<p>Erreur Mysql2<br/>$sql3<br/>".mysql_error()."</p>");
$sql4 = "UPDATE " . $tblpref ."bon_comm SET coment='".$coment."'  WHERE num_bon = $bon_num";
mysql_query($sql4) OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
session_start();
$_SESSION['message'] = 'Bon de commande cr&eacute;&eacute;<br/> <a class="styled" href="./convert_bl.php?commande='.$bon_num.'&date='.date('d/m/Y').'">Cliquez ici pour le convertir en BL.</a>';

include("form_commande.php");
 ?> 