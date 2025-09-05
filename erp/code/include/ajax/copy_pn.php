<?php
include("../config/common.php");
$id = $_REQUEST['id'] ;
$sql="SELECT reference FROM ".$tblpref."article WHERE num='".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
echo $obj->reference;
?>