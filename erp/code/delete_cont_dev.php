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
//FINHEAD
$num_cont=isset($_GET['num_cont'])?$_GET['num_cont']:"";
$num_dev=isset($_GET['num_dev'])?$_GET['num_dev']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "DELETE FROM " . $tblpref ."cont_dev WHERE num = '".$num_cont."'";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
include_once("edit_devis.php");
include_once("include/bas.php");
?>