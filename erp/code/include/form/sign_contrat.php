<?php
include("../config/common.php");
include("../fonctions.php");
//Récupération des variable du parc informatique
$id_parc		=$_REQUEST['id_parc'];
$id_contrat		=$_REQUEST['id_contrat'];
$id_monitoring	=$_REQUEST['id_monitoring'];
//Si la date a été fixée par l'utilisateur (encore aucun monitoring signé)
if (isset($_REQUEST['debut'])) {
	$debut			=$_REQUEST['debut'];
	//Si on signe le contrat.
	if (isset($_REQUEST['sign_contrat']) && $_REQUEST['sign_contrat'] == 'oui') {
		//On va updater le monitoring, pour le signer
		$sql="UPDATE ".$tblpref."contrat_maintenance SET sign='1', date_sign='".dateEU_to_dateUSA($debut)."' WHERE id='".$id_contrat."' AND actif='1'";
		$req=mysql_query($sql);
		//Ensuite on va récupérer les informations nécessaire, afin de créer l'échéance
		$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id='".$id_contrat."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$facturation=$obj->type_fact;
		//On calcule la prochaine echéance
		if ($facturation == 'men') {
			$month_add=1;
		}
		else if ($facturation == 'tri') {
			$month_add=3;
		}
		else if ($facturation == 'sem') {
			$month_add=6;
		}
		else if ($facturation == 'ann') {
			$month_add=12;
		}
		$debut_sec=strtotime($debut);
		//NEXT Echeance
		$date_r=date('Y-m-d', strtotime('+'.$month_add.' month', $debut_sec));
		//On récupère les autres valeurs
		$nbr_pc			=$obj->nbr_pc;
		$nbr_laptop		=$obj->nbr_laptop;
		$nbr_server		=$obj->nbr_server;
		$nbr_mobile		=$obj->nbr_mobile;
		$nbr_printer	=$obj->nbr_printer;
		$prix_traite	=$obj->prix_traite;
		$prix_mois		=$obj->prix_mois;
		//On insère en BDD dans monitoring_echeance
		$sql="INSERT INTO ".$tblpref."contrat_echeance(id_contrat, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_contrat."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois."', '".$prix_traite."', '".$date_r."')";
		$req=mysql_query($sql);
		$id_echeance_c=mysql_insert_id();
		$prix_c=$prix_traite;
	}
	//Si on signe le monitoring
	if (isset($_REQUEST['sign_monitoring']) && $_REQUEST['sign_monitoring'] == 'oui') {
		//On va updater le monitoring, pour le signer
		$sql="UPDATE ".$tblpref."monitoring SET sign='1', date_sign='".dateEU_to_dateUSA($debut)."' WHERE id='".$id_monitoring."' AND actif='1'";
		$req=mysql_query($sql);
		//Ensuite on va récupérer les informations nécessaire, afin de créer l'échéance
		$sql="SELECT * FROM ".$tblpref."monitoring WHERE id='".$id_monitoring."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$facturation=$obj->type_fact;
		//On calcule la prochaine echéance
		if ($facturation == 'men') {
			$month_add=1;
		}
		else if ($facturation == 'tri') {
			$month_add=3;
		}
		else if ($facturation == 'sem') {
			$month_add=6;
		}
		else if ($facturation == 'ann') {
			$month_add=12;
		}
		$debut_sec=strtotime($debut);
		//NEXT Echeance
		$date_r=date('Y-m-d', strtotime('+'.$month_add.' month', $debut_sec));
		//On récupère les autres valeurs
		$nbr_pc			=$obj->nbr_pc;
		$nbr_laptop		=$obj->nbr_laptop;
		$nbr_server		=$obj->nbr_server;
		$nbr_mobile		=$obj->nbr_mobile;
		$nbr_printer	=$obj->nbr_printer;
		$prix_traite	=$obj->prix_traite;
		$prix_mois		=$obj->prix_mois;
		//On insère en BDD dans monitoring_echeance
		$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois."', '".$prix_traite."', '".$date_r."')";
		$req=mysql_query($sql);
		$id_echeance_m=mysql_insert_id();
		$prix_m=$prix_traite;
	}
}
//Si un mnitoring est déjà signé.
else if (isset($_REQUEST['debut_fix'])) {
	$date_r			=$_REQUEST['debut_fix'];
	//Si on signe le contrat.
	if (isset($_REQUEST['sign_contrat']) && $_REQUEST['sign_contrat'] == 'oui') {
		//On va récupérer les informations du contrat
		$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id='".$id_contrat."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$facturation=$obj->type_fact;
		//On calcule la prochaine echéance
		if ($facturation == 'men') {
			$month_add=1;
		}
		else if ($facturation == 'tri') {
			$month_add=3;
		}
		else if ($facturation == 'sem') {
			$month_add=6;
		}
		else if ($facturation == 'ann') {
			$month_add=12;
		}
		$date_r_sec=strtotime($date_r);
		//NEXT Echeance
		$debut=date('Y-m-d', strtotime('-'.$month_add.' month', $date_r_sec));
		//On récupère les autres valeurs
		$nbr_pc			=$obj->nbr_pc;
		$nbr_laptop		=$obj->nbr_laptop;
		$nbr_server		=$obj->nbr_server;
		$nbr_mobile		=$obj->nbr_mobile;
		$nbr_printer	=$obj->nbr_printer;
		$prix_traite	=$obj->prix_traite;
		$prix_mois		=$obj->prix_mois;
		//On va updater le contrat, pour le signer
		$sql="UPDATE ".$tblpref."contrat_maintenance SET sign='1', date_sign='".$debut."' WHERE id='".$id_contrat."' AND actif='1'";
		$req=mysql_query($sql);
		//On insère en BDD dans monitoring_echeance
		$sql="INSERT INTO ".$tblpref."contrat_echeance(id_contrat, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_contrat."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois."', '".$prix_traite."', '".dateEU_to_dateUSA($date_r)."')";
		$req=mysql_query($sql);
		$id_echeance_c=mysql_insert_id();
		$prix_c=$prix_traite;
	}
	//Si on signe le monitoring.
	if (isset($_REQUEST['sign_monitoring']) && $_REQUEST['sign_monitoring'] == 'oui') {
		//On va récupérer les informations du contrat
		$sql="SELECT * FROM ".$tblpref."monitoring WHERE id='".$id_monitoring."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$facturation=$obj->type_fact;
		//On calcule la prochaine echéance
		if ($facturation == 'men') {
			$month_add=1;
		}
		else if ($facturation == 'tri') {
			$month_add=3;
		}
		else if ($facturation == 'sem') {
			$month_add=6;
		}
		else if ($facturation == 'ann') {
			$month_add=12;
		}
		$date_r_sec=strtotime($date_r);
		//NEXT Echeance
		$debut=date('Y-m-d', strtotime('-'.$month_add.' month', $date_r_sec));
		//On récupère les autres valeurs
		$nbr_pc			=$obj->nbr_pc;
		$nbr_laptop		=$obj->nbr_laptop;
		$nbr_server		=$obj->nbr_server;
		$nbr_mobile		=$obj->nbr_mobile;
		$nbr_printer	=$obj->nbr_printer;
		$prix_traite	=$obj->prix_traite;
		$prix_mois		=$obj->prix_mois;
		//On va updater le contrat, pour le signer
		$sql="UPDATE ".$tblpref."monitoring SET sign='1', date_sign='".$debut."' WHERE id='".$id_monitoring."' AND actif='1'";
		$req=mysql_query($sql);
		echo $sql;
		//On insère en BDD dans monitoring_echeance
		$sql="INSERT INTO ".$tblpref."monitoring_echeance(id_monitoring, nbr_pc, nbr_laptop, nbr_server, nbr_mobile, nbr_printer, prix_mois, prix_traite, echeance) VALUES ('".$id_monitoring."', '".$nbr_pc."', '".$nbr_laptop."', '".$nbr_server."', '".$nbr_mobile."', '".$nbr_printer."', '".$prix_mois."', '".$prix_traite."', '".dateEU_to_dateUSA($date_r)."')";
		$req=mysql_query($sql);
		$id_echeance_m=mysql_insert_id();
		$prix_m=$prix_traite;
	}
}

//On va récupérer les variables nécessaire a l'établissement de la facture
//Client

//On vérifie si la facturation de la première période est demandée.
if (isset($_REQUEST['fact_first_period']) && $_REQUEST['fact_first_period'] == 'oui') {
	////On crée les entrées nécessaires à la facture
	///Calcul du total
	$prix_total_ht=$prix_c+$prix_m;
	
	$prix_c_tvac=$prix_c*1.21;
	$tva_c=$prix_c_tvac-$prix_c;
	
	$prix_m_tvac=$prix_m*1.21;
	$tva_m=$prix_m_tvac-$prix_m;
	
	$total_tva=$tva_c+$tva_m;
	$prix_total_ttc=$prix_c_tvac+$prix_m_tvac;
	///Et des variables nécessaires /* TOCHECK TOCHECK TOCHECK */
	$comment='Periode du '.$datesign.' au '.dateUSA_to_dateEU($date_r).'';
	///Facture
	$sql="INSERT INTO ".$tblpref."facture(CLIENT, date_fact, echeance_fact, total_fact_h, total_fact_ttc, coment, tva) VALUES ('".$cli."', '".date('Y-m-d')."', '".date('Y-m-d', strtotime('+8 days'))."', '".$prix_total_ht."', '".$prix_total_ttc."', '".$comment."', 'non')";
	$req=mysql_query($sql);
	$num_facture=mysql_insert_id();
	///BL
	$sql="INSERT INTO ".$tblpref."bl(client_num, date, tot_htva, tot_tva, fact, fact_num, status) VALUES ('".$cli."', '".date('Y-m-d')."', '".$prix_total_ht."', '".$total_tva."', 'ok', '".$num_facture."', '1')";
	$req=mysql_query($sql);
	$num_bl=mysql_insert_id();
	///Cont_bl
	//On regarde quels articles pousser en fonction de la facturation souhaitée (men, tri, sem, ann)
	if ($facturation == 'men') {
		$article_c=1489;
		$article_m=96553;
	}
	else if ($facturation == 'tri') {
		$article_c=904;
		$article_m=96554;
	}
	else if ($facturation == 'sem') {
		$article_c=648;
		$article_m=96555;
	}
	else if ($facturation == 'ann') {
		$article_c=96552;
		$article_m=96556;
	}
	//Si la maintenance est signée
	if (isset($_REQUEST['sign_contrat']) && $_REQUEST['sign_contrat'] == 'oui') {
		$sql="INSERT INTO ".$tblpref."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) VALUES ('".$num_bl."', '".$article_c."', '1', '".$prix_c."', '".$tva_c."', '".$prix_c."')";
		$req=mysql_query($sql);
		//On update les échéance nécessaires.
		$sql="UPDATE ".$tblpref."contrat_echeance SET fact='1', fact_num='".$num_facture."' WHERE id='".$id_echeance_c."'";
		$req=mysql_query($sql);
	}
	//Si le monitoring est signé
	if (isset($_REQUEST['sign_monitoring']) && $_REQUEST['sign_monitoring'] == 'oui') {
		$sql="INSERT INTO ".$tblpref."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) VALUES ('".$num_bl."', '".$article_m."', '1', '".$prix_m."', '".$tva_m."', '".$prix_m."')";
		$req=mysql_query($sql);
		//On update les échéance nécessaires.
		$sql="UPDATE ".$tblpref."monitoring_echeance SET fact='1', fact_num='".$num_facture."' WHERE id='".$id_echeance_m."'";
		$req=mysql_query($sql);
	}
}
//Sinon, si des contrat existent, on en marque les deux premières échéances comme facturées.
else {
	//Si le contrat est signé
	if (isset($_REQUEST['sign_contrat']) && $_REQUEST['sign_contrat'] == 'oui') {
		$sql="UPDATE ".$tblpref."contrat_echeance SET fact='1', fact_num='OLD' WHERE id='".$id_echeance_c."'";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
	}
	//Si le monitoring est signé
	if (isset($_REQUEST['sign_monitoring']) && $_REQUEST['sign_monitoring'] == 'oui') {
		$sql="UPDATE ".$tblpref."monitoring_echeance SET fact='1', fact_num='OLD' WHERE id='".$id_echeance_m."'";
		$req=mysql_query($sql);
		echo $sql.'<br/>';
	}
}


session_start();
$_SESSION['message']="Contrat sign&eacute;";
header('Location: ../../fiche_parc.php?id='.$id_parc);
?>