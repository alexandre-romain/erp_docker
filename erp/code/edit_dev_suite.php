<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_list").hide();
	$("#hide_list").click(function(){
		$("#list").hide(500);	
		$("#hide_list").hide();
		$("#show_list").show();
	});
	$("#show_list").click(function(){
		$("#list").show(500);	
		$("#hide_list").show();
		$("#show_list").hide();
	});
	$("#hide_filter").hide();
	$("#hide_filter").click(function(){
		$("#filter").hide(500);	
		$("#hide_filter").hide();
		$("#show_filter").show();
	});
	$("#show_filter").click(function(){
		$("#filter").show(500);	
		$("#hide_filter").show();
		$("#show_filter").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
//On récupère les variables
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$num_dev=isset($_POST['num_dev'])?$_POST['num_dev']:"";
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$article=isset($_POST['article'])?$_POST['article']:"";
$PV=isset($_POST['PV'])?$_POST['PV']:"";
//on recupere le prix htva		
$sql2 = "SELECT prix_htva FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql2) or die('Erreur SQL1 !<br>'.$sql2.'<br>'.mysql_error());
$obj=mysql_fetch_object($result);
//$PA = mysql_result($result, 'prix_htva');
$PA=$obj->prix_htva;
//on recupere le taux de tva
$sql3 = "SELECT taux_tva FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql3) or die('Erreur SQL2 !<br>'.$sql3.'<br>'.mysql_error());
$obj=mysql_fetch_object($result);
//$taux_tva = mysql_result($result, 'taux_tva');
$taux_tva=$obj->taux_tva;
//on recupere la marge
$sql4 = "SELECT marge FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
$obj=mysql_fetch_object($result);
//$marge = mysql_result($result, 'marge');
$marge=$obj->marge;

if ( (!$PV) && ($marge == '0'))
{ $prix_article = $PA; }
elseif ((!$PV) && ($marge != '0'))
{ 
$prix_article = (($marge / 100) + 1) * $PA; }
else
{ $prix_article = $PV; }

$total_htva = $prix_article * $quanti ;
$mont_tva = $total_htva / 100 * $taux_tva ;
//inserer les données dans la table du contenu des devis.
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."cont_dev(quanti, article_num, dev_num, tot_art_htva, to_tva_art, p_u_jour) VALUES ('$quanti', '$article', '$num_dev', '$total_htva', '$mont_tva', '$prix_article')";
mysql_query($sql1) or die('Erreur SQL3 !<br>'.$sql1.'<br>'.mysql_error());
include ("form_editer_devis.php");
?>
