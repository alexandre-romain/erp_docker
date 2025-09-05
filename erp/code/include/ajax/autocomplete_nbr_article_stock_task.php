<?php	
include("../config/common.php");

//On récupère le n° de la ligne de cont_bon sélectionée
$article=$_GET['article'];

$sql="SELECT stock";
$sql.=" FROM ".$tblpref."article";
$sql.=" WHERE num='".$article."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);

$stock=$obj->stock;
$nbr=number_format($stock, 0);


for ($i=$nbr ; $i > 0 ; $i--) {
	echo '<option value="'.$i.'">'.$i.'</option>';
}


?>