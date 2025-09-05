<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete()
{
	var agree=confirm("<?php echo $lang_sup_li; ?>");
	if (agree)
	 	return true ;
	else
	 	return false ;
}
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
if($num_bon==''){
$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
}
$sql = "SELECT bl FROM " . $tblpref ."bon_comm WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$bl = $data['bl'];
}
if($bl=='1')
{
	$message = "Ce bon de commande a déjà été partiellement livré.<br> Il est impossible de le modifier.";
	include('form_commande.php');
	exit;
}
if($bl=='end')
{
	$message = "Ce bon de commande a déjà été complètement livré.<br> Il est impossible de le modifier.";
	include('form_commande.php');
	exit;
}
include ("form_editer_bon.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
