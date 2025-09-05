<?php
include_once("../config/common.php");
//On récupères les valeurs
$value = $_REQUEST['recu'] ;
$num = $_REQUEST['num'] ;
$art_id = $_REQUEST['art_id'] ;
$qty = $_REQUEST['qty'] ;
$date_day=date('Y-m-d');
$date_ref=date('Ymd');

//On update la ligne du contenu du bon, recu = oui
$sql_recu="UPDATE ".$tblpref."cont_bon SET recu='".$value."' WHERE num=".$num."";
$req_recu=mysql_query($sql_recu);

$sql="SELECT stock FROM ".$tblpref."article WHERE num='".$art_id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$stock=$obj->stock;

$new_stock=$stock+$qty;

$sql_update_stock="UPDATE ".$tblpref."article SET stock='".$new_stock."' WHERE num='".$art_id."'";
$req_update_stock=mysql_query($sql_update_stock);
?>