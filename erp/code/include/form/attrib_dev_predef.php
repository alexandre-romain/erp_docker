<?php
//On inclus le fichier de co BDD
include("../config/common.php");
$id_devis_predef	= $_REQUEST['id_devis'];
$id_client			= $_REQUEST['id_client'];
$comment			= $_REQUEST['comment'];
$transform			= $_REQUEST['transform'];
//Récupération nom client, pour affichage dans message informatifs
$sql="SELECT nom FROM ".$tblpref."client WHERE num_client='".$id_client."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$nom_cli=$obj->nom;
if ($transform == dev) {
	//On va copier les infos de dev_predef dans devis
	///On récupère les infos dans le dev predef
	$sql="SELECT * FROM ".$tblpref."dev_predef WHERE id='".$id_devis_predef."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$tot_htva=$obj->tot_htva;
	$tot_tva=$obj->tot_tva;
	$tot_recupel=$obj->tot_recupel;
	$tot_reprobel=$obj->tot_reprobel;
	$tot_bebat=$obj->tot_bebat;
	$name=$obj->name;
	//On crée les infos manquante
	$creation=date('Y-m-d');
	$echeance=date('Y-m-d', strtotime("+ 10 days"));
	//On insère
	$sql="INSERT INTO ".$tblpref."devis(client_num, date, echeance, tot_htva, tot_tva, tot_recupel, tot_reprobel, tot_bebat, coment) VALUES ('".$id_client."', '".$creation."', '".$echeance."', '".$tot_htva."', '".$tot_tva."', '".$tot_recupel."', '".$tot_reprobel."', '".$tot_bebat."', '".$comment."')";
	$req=mysql_query($sql);
	$id_devis=mysql_insert_id();
	//On va copier les infos de chaque lignes de cont_dev_predef dans cont_devis
	$sql="SELECT * FROM ".$tblpref."cont_dev_predef WHERE id_dev_predef='".$id_devis_predef."'";
	$req=mysql_query($sql);
	while ($obj = mysql_fetch_object($req)) {
		//On récupère les infos
		$article=$obj->article_num;
		$quanti=$obj->quanti;
		$tot_art_htva=$obj->tot_art_htva;
		$tot_art_tva=$obj->tot_tva_art;
		$tot_art_recupel=$obj->tot_art_recupel;
		$tot_art_reprobel=$obj->tot_art_reprobel;
		$tot_art_bebat=$obj->tot_art_bebat;
		$pu=$obj->p_u;
		$type=$obj->type;
		//On insère
		$sql_i="INSERT INTO ".$tblpref."cont_dev(dev_num, article_num, quanti, tot_art_htva, to_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, p_u_jour, type) VALUES ('".$id_devis."', '".$article."', '".$quanti."', '".$tot_art_htva."', '".$tot_art_tva."', '".$tot_art_recupel."', '".$tot_art_reprobel."', '".$bebat."', '".$pu."', '".$type."')";
		$req_i=mysql_query($sql_i);
	}
	header('Location: ../../lister_devis.php?message=ok&nom='.$name.'&cli='.$nom_cli);
}
else if ($transform == bon) {
	//On va copier les infos de dev_predef dans bon
	///On récupère les infos dans le dev predef
	$sql="SELECT * FROM ".$tblpref."dev_predef WHERE id='".$id_devis_predef."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$tot_htva=$obj->tot_htva;
	$tot_tva=$obj->tot_tva;
	$tot_recupel=$obj->tot_recupel;
	$tot_reprobel=$obj->tot_reprobel;
	$tot_bebat=$obj->tot_bebat;
	$name=$obj->name;
	//On crée les infos manquante
	$creation=date('Y-m-d');
	//On insère
	$sql="INSERT INTO ".$tblpref."bon_comm(client_num, date, tot_htva, tot_tva, tot_recupel, tot_reprobel, tot_bebat, coment) VALUES ('".$id_client."', '".$creation."', '".$tot_htva."', '".$tot_tva."', '".$tot_recupel."', '".$tot_reprobel."', '".$tot_bebat."', '".$comment."')";
	$req=mysql_query($sql);
	$id_bon=mysql_insert_id();
	echo $sql;
	//On va copier les infos de chaque lignes de cont_dev_predef dans cont_devis
	$sql="SELECT * FROM ".$tblpref."cont_dev_predef WHERE id_dev_predef='".$id_devis_predef."'";
	$req=mysql_query($sql);
	while ($obj = mysql_fetch_object($req)) {
		//On récupère les infos
		$article=$obj->article_num;
		$quanti=$obj->quanti;
		$tot_art_htva=$obj->tot_art_htva;
		$tot_art_tva=$obj->tot_tva_art;
		$tot_art_recupel=$obj->tot_art_recupel;
		$tot_art_reprobel=$obj->tot_art_reprobel;
		$tot_art_bebat=$obj->tot_art_bebat;
		$pu=$obj->p_u;
		$type=$obj->type;
		//On insère
		$sql_i="INSERT INTO ".$tblpref."cont_bon(bon_num, article_num, quanti, tot_art_htva, to_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, p_u_jour, type) VALUES ('".$id_bon."', '".$article."', '".$quanti."', '".$tot_art_htva."', '".$tot_art_tva."', '".$tot_art_recupel."', '".$tot_art_reprobel."', '".$tot_art_bebat."', '".$pu."', '".$type."')";
		$req_i=mysql_query($sql_i);
	}
	header('Location: ../../lister_commandes.php?message=ok&nom='.$name.'&cli='.$nom_cli);
}
else {
	header('Location: ../../devis_predef.php?message=error_transform&open=list');
}

?>