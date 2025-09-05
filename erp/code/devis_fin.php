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
$dev_num=isset($_POST['dev_num'])?$_POST['dev_num']:"";
mysql_select_db($db) or die ("Could not select $db database");
///On update & enregistre le devis
//TOT_HTVA
$sql2 = "UPDATE " . $tblpref ."devis SET tot_htva='".$tot_ht."'  WHERE num_dev = $dev_num";
mysql_query($sql2) OR die("<p>Erreur Mysql1<br/>$sql2<br/>".mysql_error()."</p>");
//TOT_TVA
$sql3 = "UPDATE " . $tblpref ."devis SET tot_tva='".$tot_tva."'  WHERE num_dev = $dev_num";
mysql_query($sql3) OR die("<p>Erreur Mysql2<br/>$sql3<br/>".mysql_error()."</p>");
//Message informatif "devis créer"
$message= $lang_enre;
include("form_devis.php");
 ?> 