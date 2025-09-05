<?php
header('Content-Type: text/x-csv');
header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Content-Disposition: inline; filename="export.csv"');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
require_once("./include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/configav.php");
include_once("include/fonctions.php");
include_once("include/config/var.php");

//EN-TÊTE
echo "Export Clients : FASTIT;";
echo "\n"; //fin de ligne
echo "\n"; //saut de ligne
//titres des colonnes
echo "Client;";
echo "Client Suite;";
echo "E-mail;";
echo "\n"; //fin de ligne titres
echo "\n"; //saut de ligne

$sql = "SELECT DISTINCT mail, nom, nom2 FROM gestsprl_client ORDER BY nom ASC";
$req = mysql_query($sql);
while($obj = mysql_fetch_object($req)) {
	echo $obj->nom.";";
	echo $obj->nom2.";";
	echo $obj->mail.";";
	echo "\n"; //saut de ligne
}
?>