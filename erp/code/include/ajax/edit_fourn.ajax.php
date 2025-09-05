<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;

$sql="UPDATE ".$tblpref."cont_bon SET fourn='".$value."' WHERE num='".$id."'";
$req=mysql_query($sql);

$sql="SELECT * FROM ".$tblpref."fournisseurs WHERE id = '".$value."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
echo $obj->nom;
?>