<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;

$sql="UPDATE ".$tblpref."article SET article_name='".$value."' WHERE num='".$id."'";
$req=mysql_query($sql);

echo $value;
?>