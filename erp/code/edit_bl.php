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
$(document).ready(function() {
	$( "#close_info" ).click(function() {
		$( "#mess_info" ).hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
if($num_bl==''){
	$num_bl=isset($_GET['num_bl'])?$_GET['num_bl']:"";
	$nom=isset($_GET['nom'])?$_GET['nom']:"";
}
$sql ="SELECT fact, status FROM ".$tblpref."bl WHERE num_bl=".$num_bl."";
$req = mysql_query($sql) or die('Erreur SQLedit_bl !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$fact = $data['fact'];
	$status = $data['status'];
}
if($fact=='1')
{
	$message = "Ce bon de livraison a déjà été facturé.<br> Il est impossible de le modifier.";
	include('form_bl.php');
	exit;
}
if ($status == '1')
{
	$message = "Ce bon de livraison est terminé.<br> Il est impossible de le modifier.";
	include('form_bl.php');
	exit;
}
//Gestion des messages informatifs
include_once("include/message_info.php");
include ("form_editer_bl.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
