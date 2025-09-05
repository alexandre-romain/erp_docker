<?php
include("../config/common.php");
include("../fonctions.php");

$sql="SELECT * FROM ".$tblpref."fournisseurs WHERE actif = 1 and type='marchandises' ORDER BY nom ASC";
$req=mysql_query($sql);
while ($obj=mysql_fetch_object($req)) {
	$array[$obj->id] = $obj->nom;
}
print json_encode($array);
?>