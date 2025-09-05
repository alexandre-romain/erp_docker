<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="./include/js/autocomplete.js"></script>
<script type="text/javascript" src="./include/js/jquery.jeditable.js"></script>
<script>
$(document).ready(function() {
	$( "#close_info" ).click(function() {
	  $( "#mess_info" ).hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<?php
//On récupère le nom de la nouvelle cat + cat parent.
$categorie=isset($_POST['categorie'])?$_POST['categorie']:"";
$cat_parent=isset($_POST['cat_parent'])?$_POST['cat_parent']:"";
if ($cat_parent == 'none') {
	$cat_level=1;
	$sql1 = "INSERT INTO ".$tblpref."categorie(categorie, cat_level) VALUES ('".$categorie."', '".$cat_level."')";
}
else {
	//On va récupérer le niveau de la catégorie parente
	$sql_c="SELECT * FROM ".$tblpref."categorie WHERE id_cat='".$cat_parent."'";
	$req_c=mysql_query($sql_c);
	$obj_c=mysql_fetch_object($req_c);
	$level=$obj_c->cat_level;
	$cat_level=$level+1;
	$sql1 = "INSERT INTO ".$tblpref."categorie(categorie, cat_level, parent_cat) VALUES ('".$categorie."', '".$cat_level."', '".$cat_parent."')";
}
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
?>
<div class="message_info" id="mess_info">
	<div id="close_info" class="del"><i class="fa fa-times"></i></div>
	<span><i class="fa fa-info-circle fa-fw"></i></span>
	<?php echo $lang_nouv_categorie." '".$categorie."'.";?>   	
</div>
<?php
include("form_article.php");
?>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?> 