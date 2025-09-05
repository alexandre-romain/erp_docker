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
$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
//On regarde si le bl à déjà été livré, ou partiellement livré
$sql = "SELECT bl FROM " . $tblpref ."bon_comm WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$bl = $data['bl'];
}
//Si le bl est partiellement livré.
if($bl=='1')
{
	$message = "Ce bon de commande a déjà été partiellement livré.<br> Il est impossible de le supprimer.";
	include('form_commande.php');
	exit;
}
//S'il est totalement livré.
if($bl=='end')
{
	$message = "Ce bon de commande a déjà été complètement livré.<br> Il est impossible de le supprimer.";
	include('form_commande.php');
	exit;
}
//Sinon
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "DELETE FROM " . $tblpref ."bon_comm WHERE num_bon = '".$num_bon."'";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$message= "$lang_bon_effa";
include("form_commande.php");
?> 