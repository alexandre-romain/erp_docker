<?php
require_once("include/verif.php");
include_once("include/config/common.php");

include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
$lib=isset($_POST['lib'])?$_POST['lib']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$fourn=isset($_POST['fourn'])?$_POST['fourn']:"";
$fournisseur=isset($_POST['fournisseur'])?$_POST['fournisseur']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
$type="FG";
list($jour, $mois,$annee) = preg_split('/\//', $date, 3);
//$mois=isset($_POST['mois'])?$_POST['mois']:"";
//$jour=isset($_POST['jour'])?$_POST['jour']:"";
$fournisseur = stripslashes($fournisseur);
if($lib==''|| $prix=='')
{
echo $lang_oublie_champ;
include('form_fraisgeneraux.php');
exit;
}
if ($fourn=='' and $fournisseur=='default') { 
	echo "<br/><div class='message'>$lang_dep_choi</div>";
	include('form_fraisgeneraux.php');
	exit;  
}
if ($fournisseur =='default') {
$fourn= addslashes($fourn);
  mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."depense(fournisseur, lib, prix, date, type) VALUES ('$fourn', '$lib', '$prix', '$annee-$mois-$jour', '$type')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
echo "<br/><div class='message'>$lang_dep_enr</div>";
} else {
$fournisseur=addslashes($fournisseur);
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."depense(fournisseur, lib, prix, date, type) VALUES ('$fournisseur', '$lib', '$prix', '$annee-$mois-$jour', '$type')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$message="<br/><div class='message'>$lang_dep_enr</div>";  
}

include("form_depenses.php");

 ?> 