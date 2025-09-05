<?php
include("../config/common.php");


$article=isset($_POST['article'])?$_POST['article']:"";
$uni=isset($_POST['uni'])?$_POST['uni']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$taux_tva=isset($_POST['taux_tva'])?$_POST['taux_tva']:"";
$commentaire=isset($_POST['commentaire'])?$_POST['commentaire']:"";
$stock=isset($_POST['stock'])?$_POST['stock']:"";
$stomin=isset($_POST['stomin'])?$_POST['stomin']:"";
$stomax=isset($_POST['stomax'])?$_POST['stomax']:"";
$categorie=isset($_POST['categorie'])?$_POST['categorie']:"";
$marge=isset($_POST['marge'])?$_POST['marge']:"";
$garantie=isset($_POST['garantie'])?$_POST['garantie']:"";
$reference=isset($_POST['reference'])?$_POST['reference']:"";
$marque=isset($_POST['marque'])?$_POST['marque']:"";
$recupel=isset($_POST['recupel'])?$_POST['recupel']:"";
$reprobel=isset($_POST['reprobel'])?$_POST['reprobel']:"";
$bebat=isset($_POST['bebat'])?$_POST['bebat']:"";

$sql="INSERT INTO ".$tblpref."article(article, prix_htva, taux_tva, commentaire, uni, stock, stomin, stomax, cat, garantie, reference, marque, recupel, reprobel, bebat) VALUES ('$article','$prix','$taux_tva','$commentaire','$uni','$stock','$stomin','$stomax','$categorie','$garantie','$reference','$marque','$recupel','$reprobel','$bebat')";
$reqsql=mysql_query($sql) or die;


header('Location: ../../list_articles.php');


?>