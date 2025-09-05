<?php	
include("../config/common.php");

//On récupère le n° de la ligne de cont_bon sélectionée
$rech=$_GET['rech'];
$id_rech=$_GET['id_rech'];
$sql="SELECT id_cat FROM ".$tblpref."cat_x_cat_devis WHERE";
if ($id_rech == 'rech_proc') {
	 $sql.=" cat_devis = 'processeur'";
}

else if ($id_rech == 'rech_cm') {
	$sql.=" cat_devis = 'motherboard'";
}

else if ($id_rech == 'rech_ram') {
	$sql.=" cat_devis = 'ram'";
}

else if ($id_rech == 'rech_fan') {
	$sql.=" cat_devis = 'fan'";
}

else if ($id_rech == 'rech_cfan') {
	$sql.=" cat_devis = 'pate'";
}

else if ($id_rech == 'rech_gpu') {
	$sql.=" cat_devis = 'gpu'";
}

else if ($id_rech == 'rech_hdd') {
	$sql.=" cat_devis = 'hdd'";
}

else if ($id_rech == 'rech_cd') {
	$sql.=" cat_devis = 'cd'";
}

else if ($id_rech == 'rech_card') {
	$sql.=" cat_devis = 'carte'";
}

else if ($id_rech == 'rech_wifi') {
	$sql.=" cat_devis = 'wifi'";
}

else if ($id_rech == 'rech_son') {
	$sql.=" cat_devis = 'son'";
}

else if ($id_rech == 'rech_case') {
	$sql.=" cat_devis = 'case'";
}

else if ($id_rech == 'rech_alim') {
	$sql.=" cat_devis = 'alimentation'";
}

else if ($id_rech == 'rech_os') {
	$sql.=" cat_devis = 'os'";
}

else if ($id_rech == 'rech_soft') {
	$sql.=" cat_devis = 'software'";
}

else if ($id_rech == 'rech_screen') {
	$sql.=" cat_devis = 'screen'";
}

else if ($id_rech == 'rech_keyb') {
	$sql.=" cat_devis = 'keyboard'";
}

else if ($id_rech == 'rech_mouse') {
	$sql.=" cat_devis = 'mouse'";
}

else if ($id_rech == 'rech_hifi') {
	$sql.=" cat_devis = 'hifi'";
}

else if ($id_rech == 'rech_heads') {
	$sql.=" cat_devis = 'headset'";
}

else if ($id_rech == 'rech_wifik') {
	$sql.=" cat_devis = 'wifikey'";
}

else if ($id_rech == 'rech_print') {
	$sql.=" cat_devis = 'printer'";
}

else if ($id_rech == 'rech_webc') {
	$sql.=" cat_devis = 'webcam'";
}

else if ($id_rech == 'rech_o') {
	$sql.=" cat_devis = 'other'";
}

else if ($id_rech == 'rech_wire') {
	$sql.=" cat_devis = 'wire'";
}

$req=mysql_query($sql);
$i=0;
while ($obj = mysql_fetch_object($req)) {
	$id_cat[$i] = $obj->id_cat;
	$i++;
}

$sql="SELECT *";
$sql.=" FROM ".$tblpref."article";
$sql.=" WHERE (article LIKE '%".$rech."%' OR marque LIKE '%".$rech."%' OR reference LIKE '%".$rech."%') AND (";
$cmpt=0;
foreach ($id_cat as $idcat) {
	if ($cmpt == 0) {
		$sql.=" (cat1 = '".$idcat."' OR cat2 = '".$idcat."' OR cat3 = '".$idcat."')";
	}
	else {
		$sql.=" OR (cat1 = '".$idcat."' OR cat2 = '".$idcat."' OR cat3 = '".$idcat."')";
	}
	$cmpt++;
}
$sql.=" )";
$sql.=" ORDER BY marque, article ASC";
$req=mysql_query($sql);
while ($obj = mysql_fetch_object($req)) {
	?>
    <option value="<?php echo $obj->num;?>"><?php echo utf8_encode($obj->marque.'|'.$obj->article.'|'.$obj->reference);?></option>
    <?php
}
echo $sql;
?>