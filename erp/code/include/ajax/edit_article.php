<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = mysql_real_escape_string($_REQUEST['value']) ;
$num = $_REQUEST['num'];

if ($id == 'stock_fastit') { //on update le name
	$sql="UPDATE ".$tblpref."article SET stock='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'stomin') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET stomin='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'stomax') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET stomax='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'garantie') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET garantie='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'marge') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET marge='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'tva') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET taux_tva='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'note') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET commentaire='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'nom_perso') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET article_name='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

//MORE UPDATE

else if ($id == 'nom') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET article='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'marque') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET marque='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'partnumber') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET reference='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'unit') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET uni='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'stock_fourn') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET stock_tech='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'backorder') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET backorder_date='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'auvibel') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET auvibel='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'bebat') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET bebat='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'recupel') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET recupel='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'reprobel') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET reprobel='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'prix_achat') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET prix_htva='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

else if ($id == 'list_price') { //on update le tarif
	$sql="UPDATE ".$tblpref."article SET list_price='".$value."' WHERE num=".$num."";
	$req=mysql_query($sql);
}

echo $value;
?>