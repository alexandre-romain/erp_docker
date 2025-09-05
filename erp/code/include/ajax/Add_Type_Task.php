<?php
include("../config/common.php");


$nom = $_REQUEST['nom'];

if (empty($nom)) {
echo 'Vous devez entrez un nom pour le nouveau type de t&acirc;ches, cliquez <a href="../../param_ticket.php">ici</a> pour revenir à l\'&eacute;cran pr&eacutec&eacute;dent';
}
else {
$sql="INSERT INTO ".$tblpref."type_task(type) VALUES ('$nom')";
$reqsql=mysql_query($sql) or die;

}

header('Location: ../../param_ticket.php');
?>