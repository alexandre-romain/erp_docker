<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
require_once("include/configav.php");
$article=isset($_POST['article'])?$_POST['article']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$num_lot=isset($_POST['lot'])?$_POST['lot']:"";
$PV=isset($_POST['PV'])?$_POST['PV']:"";
//on recupere le prix htva		
$sql2 = "SELECT prix_htva, fourn, taux_tva, marge FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql2) or die('Erreur SQL1 <br>'.$sql2.'<br>'.mysql_error());
$obj_2=mysql_fetch_object($result);
$PA=$obj_2->prix_htva;
$fourn=$obj_2->fourn;
$taux_tva = $obj_2->taux_tva;
$marge = $obj_2->marge;
//CALCUL DES DIFFERENTS MONTANTS
if ( (!$PV) && ($marge == '0')) { 
	$prix_article = $PA; 
}
elseif ((!$PV) && ($marge != '0')) { 
	$prix_article = (($marge / 100) + 1) * $PA; 
}
else { 
	$prix_article = $PV; 
}
$total_htva = $prix_article * $quanti ;
$mont_tva = $total_htva / 100 * $taux_tva ;
//inserer les données dans la table du contenu des bons.
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."cont_bon(num_lot, quanti, article_num, bon_num, tot_art_htva, to_tva_art, p_u_jour, fourn) 
VALUES ('$num_lot', '$quanti', '$article', '$num_bon', '$total_htva', '$mont_tva', '$prix_article', '$fourn')";
mysql_query($sql1) or die('Erreur SQL3 !<br>'.$sql1.'<br>'.mysql_error());

include_once("edit_bon.php");