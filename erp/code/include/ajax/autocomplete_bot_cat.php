<?php
include("../config/common.php");

if(isset($_GET['rech'])) 	{
		$rech=$_GET['rech'];
}

$sql="SELECT id_cat, categorie FROM ".$tblpref."categorie WHERE parent_cat='".$rech."' ORDER BY categorie ASC";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
/*while ($obj=mysql_fetch_object($req)) {
	echo '<option value="'.$obj->id_cat.'">'.$obj->categorie.'</option>';
}

$rows=mysql_num_rows($obj);*/
if ($rows == 0) {
	echo '<option value="null">Pas de sous-cat.</option>'
}


?>