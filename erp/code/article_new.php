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
$article=isset($_POST['article'])?$_POST['article']:"";
$uni=isset($_POST['uni'])?$_POST['uni']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$taux_tva=isset($_POST['taux_tva'])?$_POST['taux_tva']:"";
$commentaire=isset($_POST['commentaire'])?$_POST['commentaire']:"";
$stock=isset($_POST['stock'])?$_POST['stock']:"";
$stomin=isset($_POST['stomin'])?$_POST['stomin']:"";
$stomax=isset($_POST['stomax'])?$_POST['stomax']:"";
$fourn=isset($_POST['fourn'])?$_POST['fourn']:"";

$cat1=isset($_POST['cat1'])?$_POST['cat1']:"";

if ($_POST['cat2'] == 0 || $_POST['cat2'] == 'null') {
	$cat2='';
}
else {
	$cat2=isset($_POST['cat2'])?$_POST['cat2']:"";
}
if ($_POST['cat3'] == 0 || $_POST['cat3'] == 'null') {
	$cat3='';
}
else {
	$cat3=isset($_POST['cat3'])?$_POST['cat3']:"";
}

$marge=isset($_POST['marge'])?$_POST['marge']:"";
$garantie=isset($_POST['garantie'])?$_POST['garantie']:"";
$reference=isset($_POST['reference'])?$_POST['reference']:"";
$marque=isset($_POST['marque'])?$_POST['marque']:"";
$recupel=isset($_POST['recupel'])?$_POST['recupel']:"";
$reprobel=isset($_POST['reprobel'])?$_POST['reprobel']:"";
$bebat=isset($_POST['bebat'])?$_POST['bebat']:"";


if($article=='' || $prix==''|| $taux_tva=='' || $uni=='' )
{
	$error='Vous n\'avez pas renseign&eacute; les champs suivants : <br/>';
	if ($article=='') {
		$error.="Nom de l'article";
		$nume++;
	}
	if ($uni=='') {
		if ($nume > 0) {
			$error.=", Unité de l'article";
		}
		else {
			$error.="Unité de l'article";
		}
		$nume++;
	}
	if ($prix=='') {
		if ($nume > 0) {
			$error.=", Prix d'achat";
		}
		else {
			$error.="Prix d'achat";
		}
		$nume++;
	}
	if ($taux_tva=='') {
		if ($nume > 0) {
			$error.=", Taux de tva";
		}
		else {
			$error.="Taux de tva";
		}
		$nume++;
	}
	?>
    <div class="message_info" id="mess_info">
        <div id="close_info" class="del"><i class="fa fa-times"></i></div>
        <span><i class="fa fa-info-circle fa-fw"></i></span>
     	<?php echo $error;?>   	
    </div>
	<?php
}
else {
	mysql_select_db($db) or die ("Could not select $db database");
	$sql1 = "INSERT INTO " . $tblpref ."article(article, fourn, prix_htva, taux_tva, commentaire, uni, stock, stomin, stomax, cat1, cat2, cat3, marge, garantie, reference, marque, recupel, reprobel, bebat) VALUES ('$article', '$fourn', '$prix', '$taux_tva', '$commentaire', '$uni', '$stock', '$stomin', '$stomax', '$cat1', '$cat2', '$cat3', '$marge', '$garantie', '$reference', '$marque', '$recupel', '$reprobel', '$bebat')";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	$_SESSION['message']='Article "'.$article.'" cr&eacute;e';
}
include("form_article.php");
?>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>