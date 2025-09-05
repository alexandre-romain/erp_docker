<?php 
require_once("include/verif.php");
include_once("include/config/common.php");

include_once("include/language/$lang.php");
$marque=isset($_POST['marque'])?$_POST['marque']:"";
$article=isset($_POST['article'])?$_POST['article']:"";
$article_nom=isset($_POST['article_nom'])?$_POST['article_nom']:"";
$reference=isset($_POST['reference'])?$_POST['reference']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$uni=isset($_POST['uni'])?$_POST['uni']:"";
$stock=isset($_POST['stock'])?$_POST['stock']:"";
$max=isset($_POST['max'])?$_POST['max']:"";
$marge=isset($_POST['marge'])?$_POST['marge']:"";
$min=isset($_POST['min'])?$_POST['min']:"";
$recupel=isset($_POST['recupel'])?$_POST['recupel']:"";
$bebat=isset($_POST['bebat'])?$_POST['bebat']:"";
$reprobel=isset($_POST['reprobel'])?$_POST['reprobel']:"";
$categorie=isset($_POST['categorie'])?$_POST['categorie']:"";
$garantie=isset($_POST['garantie'])?$_POST['garantie']:"";

mysql_select_db($db) or die ("Could not select $db database");
$sql2 = "UPDATE " . $tblpref ."article SET `marge`='".$marge."',`uni`='".$uni."',`marque`='".$marque."',`reference`='".$reference."',`article`='".$article_nom."',`prix_htva`='".$prix."',`stock`='".$stock."',`stomin`='".$min."',`stomax`='".$max."', `cat`='".$categorie."' , `reprobel`='".$reprobel."', `recupel`='".$recupel."', `bebat`='".$bebat."' 
WHERE num ='".$article."' LIMIT 1 ";

mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
$message= "</br><div class='message'>$lang_stock_jour</div>";
include_once("lister_articles.php");
 ?> 