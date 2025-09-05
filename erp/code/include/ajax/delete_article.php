<?php
include("../config/common.php");

$num = $_REQUEST['num'] ;

$sql="UPDATE ".$tblpref."article SET actif='non' WHERE num=".$num."";
$req=mysql_query($sql);

session_start();
$_SESSION['message']='Article correctement supprim&eacute;';

header('Location: ../../lister_articles_form.php');
?>