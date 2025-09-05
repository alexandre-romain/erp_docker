<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = addslashes($_REQUEST['value']);

$sql="UPDATE ".$tblpref."dev_predef SET name='".$value."' WHERE id='".$id."'";
$req=mysql_query($sql);

echo $value;
?>