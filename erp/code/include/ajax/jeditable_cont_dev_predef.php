<?php
include("../config/common.php");
$id=$_REQUEST['id'];
$value=$_REQUEST['value'];
$id_devis=$_REQUEST['id_dev'];
if (is_numeric($value)) {
	//On récupère les valeurs actuelles pour calcul ;)
	$sql="SELECT * FROM ".$tblpref."cont_dev_predef WHERE id='".$id."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$art_htva=$obj->tot_art_htva;
	$art_tva=$obj->tot_tva_art;
	$art_recupel=$obj->tot_art_recupel;
	$art_reprobel=$obj->tot_art_reprobel;
	$art_bebat=$obj->tot_art_bebat;
	$art_auvibel=$obj->tot_art_auvibel;
	$art_pu=$obj->p_u;
	$art_quanti=$obj->quanti;
	$sql="SELECT * FROM ".$tblpref."dev_predef WHERE id='".$id_devis."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$dev_htva=$obj->tot_htva;
	$dev_tva=$obj->tot_tva;
	$dev_recupel=$obj->tot_recupel;
	$dev_reprobel=$obj->tot_reprobel;
	$dev_auvibel=$obj->tot_auvibel;
	$dev_bebat=$obj->tot_bebat;
	//Calcul (on soustrait les anciens totaux de l'article modifié.)
	$inter_htva		= $dev_htva-$art_htva;
	$inter_tva		= $dev_tva-$art_tva;
	$inter_recupel	= $dev_recupel-$art_recupel;
	$inter_reprobel	= $dev_reprobel-$art_reprobel;
	$inter_auvibel	= $dev_auvibel-$art_auvibel;
	$inter_bebat	= $dev_bebat-$art_bebat;
	//Calcul (nouveau totaux de l'article.)
	$cont_art_htva		= ($art_pu)*$value;
	$cont_art_tva		= ($art_tva/$art_quanti)*$value;
	if ($cont_art_recupel > 0) {
		$cont_art_recupel	= ($art_recupel/$art_quanti)*$value;
	}
	else {
		$cont_art_recupel	= 0;
	}
	if ($cont_art_reprobel > 0) {
		$cont_art_reprobel	= ($art_reprobel/$art_quanti)*$value;
	}
	else {
		$cont_art_reprobel	= 0;
	}
	if ($cont_art_auvibel > 0) {
		$cont_art_auvibel	= ($art_auvibel/$art_quanti)*$value;
	}
	else {
		$cont_art_auvibel	= 0;
	}
	if ($cont_art_bebat > 0) {
		$cont_art_bebat		= ($art_bebat/$art_quanti)*$value;
	}
	else {
		$cont_art_bebat	= 0;
	}
	//On update le cont.
	$sql="UPDATE ".$tblpref."cont_dev_predef SET quanti='".$value."', tot_art_htva='".$cont_art_htva."', tot_tva_art='".$cont_art_tva."', tot_art_recupel='".$cont_art_recupel."', tot_art_reprobel='".$cont_art_reprobel."', tot_art_auvibel='".$cont_art_auvibel."', tot_art_bebat='".$cont_art_bebat."' WHERE id='".$id."'";
	$req=mysql_query($sql);
	//On calcule les nouveaux totaux devis
	$tot_htva		= $inter_htva+$cont_art_htva;
	$tot_tva		= $inter_tva+$cont_art_tva;
	$tot_recupel	= $inter_recupel+$cont_art_recupel;
	$tot_reprobel	= $inter_reprobel+$cont_art_reprobel;
	$tot_auvibel	= $inter_auvibel+$cont_art_auvibel;
	$tot_bebat		= $inter_bebat+$cont_art_bebat;
	//On update le devis
	$sql="UPDATE ".$tblpref."dev_predef SET tot_htva='".$tot_htva."', tot_tva='".$tot_tva."', tot_recupel='".$tot_recupel."', tot_reprobel='".$tot_reprobel."', tot_auvibel='".$tot_auvibel."', tot_bebat='".$tot_bebat."' WHERE id='".$id_devis."'";
	$req=mysql_query($sql);
	?>
	<!-- On relance la fonction afin d'afficher les totaux corrects -->
	<script>
	det_devis_predef('<?php echo $id_devis;?>');
	</script>
<?php
}
else {
	echo 'ERREUR!<br/>Veuillez entrer un nombre';
}
?>