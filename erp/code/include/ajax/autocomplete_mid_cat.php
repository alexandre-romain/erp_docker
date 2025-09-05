<?php
include("../config/common.php");

if(isset($_GET['rech'])) 	{
		$rech=$_GET['rech'];
}

$sql="SELECT id_cat, categorie FROM ".$tblpref."categorie WHERE parent_cat='".$rech."' ORDER BY categorie ASC";
$req=mysql_query($sql);
$num=mysql_num_rows($req);
while ($obj=mysql_fetch_object($req)) {
	echo '<option value="'.$obj->id_cat.'">'.$obj->categorie.'</option>';
}
if ($num == 0) {
	echo '<option value="null"><span style=" background:#333; color:#FFF">Pas de sous-categorie</span></option>';
}

?>