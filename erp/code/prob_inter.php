<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");



$sql = "SELECT * FROM " . $tblpref ."interventions";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($nb = mysql_fetch_array($req))
{
$id = $nb['num_inter'];
$nbtrav = $nb['nbtrav'];


if($nbtrav == 0)
{
$sql2="Update ".$tblpref."interventions SET nbtrav=1 where num_inter=$id";
	$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());


}

}

echo"fini";
?>


 
 
