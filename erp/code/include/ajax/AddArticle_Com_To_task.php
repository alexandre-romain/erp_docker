<?php
include("../config/common.php");
$article	=$_REQUEST['article'];	//ID de la ligne cont_bon
$nbr		=$_REQUEST['nbr'];		//Nombre d'articles à lier selectionné par l'user 
$num_task	=$_REQUEST['num_task'];	//ID de la tâche

//On va récupérer le N° du ticket
$sql_info_ticket="SELECT ticket_num";
$sql_info_ticket.=" FROM ".$tblpref."task";
$sql_info_ticket.=" WHERE rowid='".$num_task."'";
$req_info_ticket=mysql_query($sql_info_ticket);
$obj_info_ticket=mysql_fetch_object($req_info_ticket);
$num_ticket=$obj_info_ticket->ticket_num;

echo $sql_info_ticket.'<br/>';

//A partir du n° de ticket on va récupérer le N° de client de manière à pouvoir créer le BL pour ce client.
$sql_info_client ="SELECT soc";
$sql_info_client.=" FROM ".$tblpref."ticket";
$sql_info_client.=" WHERE rowid='".$num_ticket."'";
$req_info_client=mysql_query($sql_info_client);
$results_info_client=mysql_fetch_object($req_info_client);
$id_cli=$results_info_client->soc;

echo $sql_info_client.'<br/>';

//On va récupérer les informations de cont_bon, nécessaire tout au long du process
$sql_infos ="SELECT *";
$sql_infos.=" FROM ".$tblpref."cont_bon";
$sql_infos.=" WHERE num=".$article."";
$req_infos=mysql_query($sql_infos);
$results=mysql_fetch_object($req_infos);

echo $sql_infos.'<br/>';

$bon_num=			$results->bon_num;
$article_num=		$results->article_num;
$article_name=		$results->article_name;
$quanti=			$results->quanti;
$tot_art_htva=		$results->tot_art_htva;
$tot_tva_art=		$results->tot_tva_art;
$tot_art_recupel=	$results->tot_art_recupel;
$tot_art_reprobel=	$results->tot_art_reprobel;
$tot_art_bebat=		$results->tot_art_bebat;
$p_u_jour=			$results->p_u_jour;
$livre=				$results->livre;

$new_livre=$livre+$nbr;

//On update la table cont_bon de manière à modifier la valeur "livre".
$sql_update_cont_bon ="UPDATE ".$tblpref."cont_bon SET livre='".$new_livre."' WHERE num=".$article."";
$req_update_cont_bon=mysql_query($sql_update_cont_bon);
echo $sql_update_cont_bon.'<br/>';

//Si livre(updaté)=quanti on cherche s'il y a d'autres articles non livrés dans le bl.
if ($quanti == $new_livre) {
	$sql_still_bon ="SELECT *";
	$sql_still_bon.=" FROM ".$tblpref."cont_bon";
	$sql_still_bon.=" WHERE bon_num=".$bon_num." AND quanti != livre AND num != '".$article."'";
	$req_still_bon=mysql_query($sql_still_bon);
	$num_still_bon=mysql_num_rows($req_still_bon);
	echo $sql_still_bon.'<br/>';
	//Si oui, on passe à la suite
	if ($num_still_bon > 0) {}
	//Sinon, on passe le bon.bl à 'end'	
	else {
		$sql_update_bon=" UPDATE ".$tblpref."bon_comm SET bl='end' WHERE num_bon='".$bon_num."'";
		$req_update_bon=mysql_query($sql_update_bon);
		echo $sql_update_bon.'<br/>';
	}
}
//On regarde s'il existe déjà un BL lié au ticket
$sql_check_bl="SELECT *";
$sql_check_bl.=" FROM ".$tblpref."bl";
$sql_check_bl.=" WHERE num_ticket='".$num_ticket."'";
$req_check_bl=mysql_query($sql_check_bl);
$num_check_bl=mysql_num_rows($req_check_bl);
echo $sql_check_bl.'<br/>';

//Si oui on en récupère l'ID
if ($num_check_bl > 0) {
	$obj_check_bl=mysql_fetch_object($req_check_bl);
	$num_bl=$obj_check_bl->num_bl;
}
//Sinon on crée le bl et on récupère son ID
else {
	$date_bl=date('Y-m-d');
	//Création du BL
	$sql_insert_bl="INSERT INTO ".$tblpref."bl(client_num, bon_num, date, num_ticket) VALUES ('$id_cli','$bon_num','$date_bl','$num_ticket')";
	$req_insert_bl=mysql_query($sql_insert_bl);
	echo $sql_insert_bl.'<br/>';
	//Récupération de l'ID (dernier ID inséré)
	$sql_num_bl="SELECT MAX(num_bl) as maxnum FROM ".$tblpref."bl";
	$req_num_bl=mysql_query($sql_num_bl);
	$obj_num_bl=mysql_fetch_object($req_num_bl);
	echo $sql_num_bl.'<br/>';
	$num_bl=$obj_num_bl->maxnum;
}

//On récupère les montants des FEES pour insertion dans le cont_bl
$sql_fees ="SELECT bebat, reprobel, recupel, auvibel";
$sql_fees.=" FROM ".$tblpref."article";
$sql_fees.=" WHERE num='".$article_num."'";
$req_fees=mysql_query($sql_fees);
$obj_fees=mysql_fetch_object($req_fees);

echo $sql_fees.'<br/>';

$auvibel	=$obj_fees->auvibel*$nbr;      //On Multiplie la taxe par le nbr d'articles
$reprobel	=$obj_fees->reprobel*$nbr;
$bebat		=$obj_fees->bebat*$nbr;
$recupel	=$obj_fees->recupel*$nbr;

//On construit les totaux (pour insertion dans le cont_bl
$tot_htva	=$p_u_jour*$nbr;
$tot_tva	=$tot_htva*0.21;

///On crée le cont_bl associé au BL créer/récupérer précédement (ID)
//SI l'article a un nom perso
if ($article_name != NULL && $article_name != '') {
	$sql_cont_bl="INSERT INTO ".$tblpref."cont_bl(bl_num,num_cont_bon,article_num,article_name,quanti,tot_art_htva,to_tva_art,tot_art_recupel,tot_art_reprobel,tot_art_bebat,p_u_jour,num_task,add_by) VALUES ('$num_bl','$article','$article_num','$article_name','$nbr','$tot_htva','$tot_tva','$recupel','$reprobel','$bebat','$p_u_jour','$num_task','comm')";
}
else {
	$sql_cont_bl="INSERT INTO ".$tblpref."cont_bl(bl_num,num_cont_bon,article_num,quanti,tot_art_htva,to_tva_art,tot_art_recupel,tot_art_reprobel,tot_art_bebat,p_u_jour,num_task,add_by) VALUES ('$num_bl','$article','$article_num','$nbr','$tot_htva','$tot_tva','$recupel','$reprobel','$bebat','$p_u_jour','$num_task','comm')";
}

$req_cont_bl=mysql_query($sql_cont_bl);
echo $sql_cont_bl.'<br/>';

//On récupère les infos de prix du bl et on les updates de manière a pouvoir insérer des totaux correct dans les BLs
$sql_val_bl="SELECT tot_htva, tot_tva, tot_recupel, tot_reprobel, tot_bebat FROM ".$tblpref."bl WHERE num_bl='".$num_bl."'";
$req_val_bl=mysql_query($sql_val_bl);
$obj_val_bl=mysql_fetch_object($req_val_bl);

echo $sql_val_bl.'<br/>';

$inter_tot_htva		=$obj_val_bl->tot_htva;
$inter_tot_tva		=$obj_val_bl->tot_tva;
$inter_tot_bebat	=$obj_val_bl->tot_bebat;
$inter_tot_reprobel	=$obj_val_bl->tot_reprobel;
$inter_tot_recupel	=$obj_val_bl->tot_recupel;

$final_tot_htva	=$tot_htva+$inter_tot_htva;
$final_tot_tva	=$tot_tva+$inter_tot_tva;	
$tot_reprobel	=$reprobel+$inter_tot_reprobel;
$tot_bebat		=$bebat+$inter_tot_bebat;
$tot_recupel	=$recupel+$inter_tot_recupel;

//On Update le BL avec les montant calculés ci-dessus
$sql_update_bl="UPDATE ".$tblpref."bl SET tot_htva='".$final_tot_htva."', tot_tva='".$final_tot_tva."', tot_recupel='".$tot_recupel."', tot_reprobel='".$tot_reprobel."', tot_bebat='".$tot_bebat."' WHERE num_bl='".$num_bl."'";
$req_update_bl=mysql_query($sql_update_bl);
?>