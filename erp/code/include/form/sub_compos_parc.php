<?php
include("../config/common.php");
include("../fonctions.php");
$id_parc=$_REQUEST['parc'];
$type=$_REQUEST['type'];
$sql="UPDATE ".$tblpref."parcs SET";
if ($type == 'server') {
	$sql.=" nbr_server = nbr_server - 1";
}
else if ($type == 'pc') {
	$sql.=" nbr_pc = nbr_pc - 1";
}
else if ($type == 'laptop') {
	$sql.=" nbr_laptop = nbr_laptop - 1";
}
else if ($type == 'mobile') {
	$sql.=" nbr_mobile = nbr_mobile - 1";
}
else if ($type == 'printer') {
	$sql.=" nbr_printer = nbr_printer - 1";
}
$sql.=" WHERE id = '".$id_parc."'";
$req=mysql_query($sql);
?>