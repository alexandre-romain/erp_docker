<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="include/js/showinfoticket.js"></script> 
<script>
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$sql="SELECT * FROM ".$tblpref."ticket WHERE fact_num = 'PURGE'";
$req=mysql_query($sql);
while ($obj=mysql_fetch_object($req)) {
	$sqlu="UPDATE ".$tblpref."task SET fact_num = 'PURGE' WHERE ticket_num = '".$obj->rowid."'";
	$requ=mysql_query($sqlu);
}
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>