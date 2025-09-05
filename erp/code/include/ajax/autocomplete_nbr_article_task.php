<?php	
include("../config/common.php");

//On récupère le n° de la ligne de cont_bon sélectionée
$article=$_GET['article'];

$sql="SELECT quanti, livre";
$sql.=" FROM ".$tblpref."cont_bon";
$sql.=" WHERE num='".$article."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);

$nbr=$obj->quanti-$obj->livre;

for ($i=$nbr ; $i > 0 ; $i--) {
	echo '<option value="'.$i.'">'.$i.'</option>';
}


?>