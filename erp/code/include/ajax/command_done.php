<?php
include_once("../config/common.php");
//On récupères les valeurs
$fourn	= $_REQUEST['fourn'];
$type	= $_REQUEST['type'];

foreach ($_REQUEST['to_com'] as $numf ) {
	$int_exp=explode('_', $numf);
	$type=$int_exp['0'];
	$num=$int_exp['1'];
	$date_day=date('Y-m-d');
	$date_ref=date('Ymd');
	//Si commande client
	if ($type == 'cc') {
		//On update la ligne du contenu du bon, commander = oui
		$sql_commande="UPDATE ".$tblpref."cont_bon SET commande='".date('Y-m-d')."' WHERE num=".$num."";
		$req_commande=mysql_query($sql_commande);
		//ON construit la requête nous permettant de récupérer les infos concernant la ligne traitée.
		$sqlinfo ="SELECT cb.bon_num as bon_num, cb.fourn as fourn, cb.quanti as quanti, a.prix_htva as puht, cb.to_tva_art, cb.tot_art_bebat, cb.tot_art_recupel, cb.tot_art_reprobel, cb.article_num";
		$sqlinfo.=" FROM ".$tblpref."cont_bon as cb";
		$sqlinfo.=" LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num";
		$sqlinfo.=" WHERE cb.num='".$num."'";
		$reqsqlinfo=mysql_query($sqlinfo);
		$obj=mysql_fetch_object($reqsqlinfo);
		//On pousse ces infos dans des variables, pour une utilisation/notation plus aisée.
		$article		=$obj->article_num;
		$bon_num		=$obj->bon_num;
		$fourn			=$obj->fourn;
		$pu_htva		=$obj->puht;
		$tot_tva		=$obj->to_tva_art;
		$qty			=$obj->quanti;
		$tot_bebat		=$obj->tot_art_bebat;
		$tot_recupel	=$obj->tot_art_recupel;
		$tot_reprobel	=$obj->tot_art_reprobel;
		$tot_htva		=$pu_htva*$qty;
		//On s'ocuppe de la ligne depense
		if (isset($num_dep)) {
			$sql="SELECT num, prix";
			$sql.=" FROM ".$tblpref."depense";
			$sql.=" WHERE num='".$num_dep."'";
			$req=mysql_query($sql);
			$obj=mysql_fetch_object($req);
			$old_montant=$obj->prix;
			$new_price=$old_montant+$tot_htva;
			$sql_achat="UPDATE ".$tblpref."depense SET prix='".$new_price."' WHERE num='".$num_dep."'";
			$req_achat=mysql_query($sql_achat);
		}
		else {
			//On récupère le nom du fournisseur (en toutes lettres)
			$sql="SELECT nom FROM ".$tblpref."fournisseurs WHERE id='".$fourn."'";
			$req=mysql_query($sql);
			$obj=mysql_fetch_object($req);
			$fournisseur=$obj->nom;
			$sql_achat="INSERT INTO ".$tblpref."depense(date, lib, fournisseur, prix, type) VALUES ('$date_day', 'AM".$date_ref.$fournisseur."', '$fournisseur', '$tot_htva', 'AM')";
			$req_achat=mysql_query($sql_achat);
			$num_dep=mysql_insert_id();
		}
		//On va insérer l'article commandé dans le cont_dep(ense).
		$sql="INSERT INTO ".$tblpref."det_dep(type, id_dep, id_cont_bon, article_num, quanti, tot_htva, tot_tva, tot_bebat, tot_recupel, tot_reprobel, p_u_jour) VALUES ('".$type."', '".$num_dep."', '".$num."', '".$article."', '".$qty."', '".$tot_htva."', '".$tot_tva."', '".$tot_bebat."', '".$tot_recupel."', '".$tot_reprobel."', '".$pu_htva."')";
		$req=mysql_query($sql);
	}
	//Si commande stock
	else if ($type == 'cs') {
		//On récupère les infos dont on a besoin.
		$sql="SELECT a.num, a.article, a.reference, a.prix_htva, a.stomin, a.stock, a.stomax, a.fourn";
		$sql.=" FROM ".$tblpref."article as a";
		$sql.=" WHERE a.num = '".$num."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$article		=$obj->article;
		$min			=$obj->stomin;
		$cur			=$obj->stock;
		$qty			=$min-$cur;
		$prix_htva		=$obj->prix_htva;
		$tot_htva		=$prix_htva*$qty;
		$tot_tva		=($tot_htva/100)*21;
		$bebat			=$obj->bebat;
		$tot_bebat		=$bebat*$qty;
		$recupel		=$obj->recupel;
		$tot_recupel	=$recupel*$qty;
		$reprobel		=$obj->reprobel;
		$tot_reprobel	=$reprobel*$qty;
		$fourn			=$obj->fourn;
		//On va maj l'article pour signifier la commande
		$sql="UPDATE ".$tblpref."article SET in_comm = '".$qty."' WHERE num='".$num."'";
		$req=mysql_query($sql);
		//On s'ocuppe de la ligne depense
		if (isset($num_dep)) {
			$sql="SELECT num, prix";
			$sql.=" FROM ".$tblpref."depense";
			$sql.=" WHERE num='".$num_dep."'";
			$req=mysql_query($sql);
			$obj=mysql_fetch_object($req);
			$old_montant=$obj->prix;
			$new_price=$old_montant+$tot_htva;
			$sql_achat="UPDATE ".$tblpref."depense SET prix='".$new_price."' WHERE num='".$num_dep."'";
			$req_achat=mysql_query($sql_achat);
		}
		else {
			//On récupère le nom du fournisseur (en toutes lettres)
			$sql="SELECT nom FROM ".$tblpref."fournisseurs WHERE id='".$fourn."'";
			$req=mysql_query($sql);
			$obj=mysql_fetch_object($req);
			$fournisseur=$obj->nom;
			$sql_achat="INSERT INTO ".$tblpref."depense(date, lib, fournisseur, prix, type) VALUES ('$date_day', 'AM".$date_ref.$fournisseur."', '$fournisseur', '$tot_htva', 'AM')";
			$req_achat=mysql_query($sql_achat);
			$num_dep=mysql_insert_id();
		}
		
		//On va insérer l'article commandé dans le cont_dep(ense).
		$sql="INSERT INTO ".$tblpref."det_dep(type, id_dep, article_num, quanti, tot_htva, tot_tva, tot_bebat, tot_recupel, tot_reprobel, p_u_jour) VALUES ('".$type."', '".$num_dep."','".$num."', '".$qty."', '".$tot_htva."', '".$tot_tva."', '".$tot_bebat."', '".$tot_recupel."', '".$tot_reprobel."', '".$prix_htva."')";
		$req=mysql_query($sql);
	}
}
header('Location: ../../fiche_depense.php?id='.$num_dep);
?>