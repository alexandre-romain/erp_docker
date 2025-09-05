<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;
$cli = $_REQUEST['num_cli'] ;


if ($id == 'name') { //on update le name
	$sql="UPDATE ".$tblpref."client SET nom='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'mail') { //on update le name
	$sql="UPDATE ".$tblpref."client SET mail='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'tel') { //on update le name
	$sql="UPDATE ".$tblpref."client SET tel='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'gsm') { //on update le name
	$sql="UPDATE ".$tblpref."client SET gsm='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'tva') { //on update le name
	$sql="UPDATE ".$tblpref."client SET num_tva='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'rue') { //on update le name
	$sql="UPDATE ".$tblpref."client SET rue='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'numero') { //on update le name
	$sql="UPDATE ".$tblpref."client SET numero='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'boite') { //on update le name
	$sql="UPDATE ".$tblpref."client SET boite='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'cp') { //on update le name
	$sql="UPDATE ".$tblpref."client SET cp='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}

else if ($id == 'ville') { //on update le name
	$sql="UPDATE ".$tblpref."client SET ville='".$value."' WHERE num_client=".$cli."";
	$req=mysql_query($sql);
}
echo $value;
?>

