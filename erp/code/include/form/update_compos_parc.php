<?php
include("../config/common.php");
include("../fonctions.php");
$type=$_REQUEST['type'];
$nbr=$_REQUEST['nbr'];
$id_parc=$_REQUEST['id_parc'];
$sql="UPDATE ".$tblpref."parcs SET";
if ($type == 'server') {
	$sql.=" nbr_server =";
}
else if ($type == 'pc') {
	$sql.=" nbr_pc =";
}
else if ($type == 'laptop') {
	$sql.=" nbr_laptop =";
}
else if ($type == 'mobile') {
	$sql.=" nbr_mobile =";
}
else if ($type == 'printer') {
	$sql.=" nbr_printer =";
}
$sql.=" '".$nbr."' WHERE id='".$id_parc."'";
$req=mysql_query($sql);
echo $sql;
?>