<?php
//On inclus le fichier de co BDD
include("../config/common.php");
//On va récupérer le nom du devis
$devis_name=$_REQUEST['devis_name'];
//On va créer le devis
$sql="INSERT INTO ".$tblpref."dev_predef(name, date_creation) VALUES('".$devis_name."', now())";
$req=mysql_query($sql);
$id_devis=mysql_insert_id();
//On met les totaux à 0, on updatera le devis après avoir inséré l'ensemble des articles.
$total_htva		=0;
$total_tva		=0;
$total_auvibel	=0;
$total_recupel	=0;
$total_reprobel	=0;
$total_bebat	=0;
///On récupère les différents composant
//Processeur
$proc=$_REQUEST['proc'];
foreach ($proc as $proc_d) {
	if ($proc_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$proc_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$proc_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'proc')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//Carte mère
$mb=$_REQUEST['mb'];
foreach ($mb as $mb_d) {
	if ($mb_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$mb_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$mb_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'mb')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//RAM
$ram=$_REQUEST['ram'];
foreach ($ram as $ram_d) {
	if ($ram_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$ram_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$ram_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'ram')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//COOLER
$fan=$_REQUEST['fan'];
foreach ($fan as $fan_d) {
	if ($fan_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$fan_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$fan_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'fan')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//PATE THERMIQUE
$cfan=$_REQUEST['cfan'];
foreach ($cfan as $cfan_d) {
	if ($cfan_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$cfan_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$cfan_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'cfan')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//CARTE GRAPHIQUE
$gpu=$_REQUEST['gpu'];
foreach ($gpu as $gpu_d) {
	if ($gpu_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$gpu_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$gpu_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'gpu')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//HDD
$hdd=$_REQUEST['hdd'];
foreach ($hdd as $hdd_d) {
	if ($hdd_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$hdd_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$hdd_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'hdd')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//LECTEUR CD
$cd=$_REQUEST['cd'];
foreach ($cd as $cd_d) {
	if ($cd_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$cd_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$cd_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'cd')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//LECTEUR DE CARTE
$card=$_REQUEST['card'];
foreach ($card as $card_d) {
	if ($card_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$card_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$card_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'card')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//CARTE WIFI
$wifi=$_REQUEST['wifi'];
foreach ($wifi as $wifi_d) {
	if ($wifi_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$wifi_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$wifi_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'wifi')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//CARTE SON
$son=$_REQUEST['son'];
foreach ($son as $son_d) {
	if ($son_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$son_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$son_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'son')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//BOITIER
$case=$_REQUEST['case'];
foreach ($case as $case_d) {
	if ($case_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$case_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$case_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'case')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//Alimentation
$alim=$_REQUEST['alim'];
foreach ($alim as $alim_d) {
	if ($alim_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$alim_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$alim_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'alim')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//SYSTEME D'EXPLOITATION
$os=$_REQUEST['os'];
foreach ($os as $os_d) {
	if ($os_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$os_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$os_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'os')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//SOFTWARES
$soft=$_REQUEST['soft'];
foreach ($soft as $soft_d) {
	if ($soft_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$soft_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$soft_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'soft')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//ECRANS
$screen=$_REQUEST['screen'];
foreach ($screen as $screen_d) {
	if ($screen_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$screen_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$screen_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'screen')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//CLAVIER
$keyb=$_REQUEST['keyb'];
foreach ($keyb as $keyb_d) {
	if ($keyb_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$keyb_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$keyb_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'keyb')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//SOURIS
$mouse=$_REQUEST['mouse'];
foreach ($mouse as $mouse_d) {
	if ($mouse_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$mouse_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$mouse_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'mouse')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//HAUT-PARLEURS
$hifi=$_REQUEST['hifi'];
foreach ($hifi as $hifi_d) {
	if ($hifi_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$hifi_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$hifi_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'hifi')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//HEADSET
$heads=$_REQUEST['heads'];
foreach ($heads as $heads_d) {
	if ($heads_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$heads_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$heads_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'heads')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//CLÉ WIFI
$wifik=$_REQUEST['wifik'];
foreach ($wifik as $wifik_d) {
	if ($wifik_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$wifik_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$wifik_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'wifik')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//PRINTER
$print=$_REQUEST['print'];
foreach ($print as $print_d) {
	if ($print_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$print_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$print_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'print')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//WEBCAM
$webc=$_REQUEST['webc'];
foreach ($webc as $webc_d) {
	if ($webc_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$webc_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$webc_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'webc')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//AUTRE
$o=$_REQUEST['o'];
foreach ($o as $o_d) {
	if ($o_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$o_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$o_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'o')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
//CÂBLAGE
$wire=$_REQUEST['wire'];
foreach ($wire as $wire_d) {
	if ($wire_d != '') {
		//On va récupérer les informations de prix de l'article
		$sql="SELECT * FROM ".$tblpref."article WHERE num='".$wire_d."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$price_ht=$obj->prix_htva;
		$marge=$obj->marge;
		//On calcule le PV
		$pv_ht=(($price_ht/100)*$marge)+$price_ht;
		//On calcul la TVA
		$taux_tva=$obj->taux_tva;
		$tva=($pv_ht/100)*$taux_tva;
		//On récupère les taxes
		$auvibel=$obj->auvibel;
		$recupel=$obj->recupel;
		$reprobel=$obj->reprobel;
		$bebat=$obj->bebat;
		//On va insérer le contenu dans la table cont_dev_predef	
		$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$wire_d."', '1', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pv_ht."', 'wire')";
		$req=mysql_query($sql);
		//TOTAUX
		$total_htva+=$pv_ht;
		$total_tva+=$tva;
		$total_auvibel+=$auvibel;
		$total_recupel+=$recupel;
		$total_reprobel+=$reprobel;
		$total_bebat+=$bebat;
	}
}
///RECUPERATION DU TOTAL
$sql="UPDATE ".$tblpref."dev_predef SET tot_htva='".$total_htva."', tot_tva='".$total_tva."', tot_recupel='".$total_recupel."', tot_reprobel='".$total_reprobel."', tot_auvibel='".$total_auvibel."', tot_bebat='".$total_bebat."' WHERE id='".$id_devis."'";
$req=mysql_query($sql);

header('Location: ../../devis_predef.php?message=add&open=list&name='.$devis_name.'');
?>