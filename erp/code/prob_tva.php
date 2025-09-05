<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");



$sql = "SELECT * FROM " . $tblpref ."facture";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($nb = mysql_fetch_array($req))
{
$id = $nb['num'];
$nbtrav = $nb['tva'];


if($nbtrav == "oui")
{
$sql2="Update ".$tblpref."facture SET tva='non' where num=$id";
	$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());


}else
{
$sql2="Update ".$tblpref."facture SET tva='oui' where num=$id";
	$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

}

}

echo"fini";
?>


 
 
