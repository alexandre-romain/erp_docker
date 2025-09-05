<?php
include("../config/common.php");
$article	=$_REQUEST['article'];	//ID article
$nbr		=$_REQUEST['nbr'];		//Nombre d'articles à lier selectionné par l'user 
$num_task	=$_REQUEST['num_task'];	//ID de la tâche
//On va récupérer le N° du ticket
$sql_info_ticket="SELECT ticket_num";
$sql_info_ticket.=" FROM ".$tblpref."task";
$sql_info_ticket.=" WHERE rowid='".$num_task."'";
$req_info_ticket=mysql_query($sql_info_ticket);
$obj_info_ticket=mysql_fetch_object($req_info_ticket);
	//Stockage des données dans var
	$num_ticket=$obj_info_ticket->ticket_num;
//A partir du n° de ticket on va récupérer le N° de client de manière à pouvoir créer le BL pour ce client.
$sql_info_client ="SELECT soc";
$sql_info_client.=" FROM ".$tblpref."ticket";
$sql_info_client.=" WHERE rowid='".$num_ticket."'";
$req_info_client=mysql_query($sql_info_client);
$results_info_client=mysql_fetch_object($req_info_client);
	//Stockage des données dans var
	$id_cli=$results_info_client->soc;

//On regarde s'il existe déjà un BL lié au ticket
$sql_check_bl="SELECT *";
$sql_check_bl.=" FROM ".$tblpref."bl";
$sql_check_bl.=" WHERE num_ticket='".$num_ticket."'";
$req_check_bl=mysql_query($sql_check_bl);
$num_check_bl=mysql_num_rows($req_check_bl);
//Si oui on en récupère l'ID
if ($num_check_bl > 0) {
	$obj_check_bl=mysql_fetch_object($req_check_bl);
		//Stockage des données dans var
		$num_bl=$obj_check_bl->num_bl;
}
//Sinon on crée le bl et on récupère son ID
else {
	$date_bl=date('Y-m-d');
	//Création du BL
	$sql_insert_bl="INSERT INTO ".$tblpref."bl(client_num, bon_num, date, num_ticket) VALUES ('$id_cli','$bon_num','$date_bl','$num_ticket')";
	$req_insert_bl=mysql_query($sql_insert_bl);
	//Récupération de l'ID (dernier ID inséré)
	$sql_num_bl="SELECT MAX(num_bl) as maxnum FROM ".$tblpref."bl";
	$req_num_bl=mysql_query($sql_num_bl);
	$obj_num_bl=mysql_fetch_object($req_num_bl);
		//Stockage des données dans var
		$num_bl=$obj_num_bl->maxnum;
}
//On va récupérer les données de l'articles
$sql="SELECT * FROM ".$tblpref."article WHERE num = '".$article."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
	//Stockage des données dans var
	$prix_htva		=$obj->prix_htva;
	$taux_tva		=$obj->taux_tva;
	$marge			=$obj->marge;
	$auvibel		=$obj->auvibel*$nbr;
	$recupel		=$obj->recupel*$nbr;
	$reprobel		=$obj->reprobel*$nbr;
	$bebat			=$obj->bebat*$nbr;
	$article_name	=$obj->article_name;
//On va s'occuper de calculer les prix réels (marge, tva et nbr)
$p_u_jour=$prix_htva+(($prix_htva/100)*$marge);
$tot_htva=$p_u_jour*$nbr;
$tot_tva=($tot_htva/100)*$taux_tva;
///On crée le cont_bl associé au BL créer/récupérer précédement (ID)
//SI l'article a un nom perso
if ($article_name != NULL && $article_name != '') {
	$sql_cont_bl="INSERT INTO ".$tblpref."cont_bl(bl_num,article_num,article_name,quanti,tot_art_htva,to_tva_art,tot_art_recupel,tot_art_reprobel,tot_art_bebat,p_u_jour,num_task,add_by) VALUES ('$num_bl','$article','$article_name','$nbr','$tot_htva','$tot_tva','$recupel','$reprobel','$bebat','$p_u_jour','$num_task','stock')";
}
//Sinon
else {
	$sql_cont_bl="INSERT INTO ".$tblpref."cont_bl(bl_num,article_num,quanti,tot_art_htva,to_tva_art,tot_art_recupel,tot_art_reprobel,tot_art_bebat,p_u_jour,num_task,add_by) VALUES ('$num_bl','$article','$nbr','$tot_htva','$tot_tva','$recupel','$reprobel','$bebat','$p_u_jour','$num_task','stock')";
}
$req_cont_bl=mysql_query($sql_cont_bl);
//On récupère les infos de prix du bl et on les updates de manière a pouvoir insérer des totaux correct dans les BLs
$sql_val_bl="SELECT tot_htva, tot_tva, tot_recupel, tot_reprobel, tot_bebat FROM ".$tblpref."bl WHERE num_bl='".$num_bl."'";
$req_val_bl=mysql_query($sql_val_bl);
$obj_val_bl=mysql_fetch_object($req_val_bl);
	//Récup VAR
	$inter_tot_htva		=$obj_val_bl->tot_htva;
	$inter_tot_tva		=$obj_val_bl->tot_tva;
	$inter_tot_bebat	=$obj_val_bl->tot_bebat;
	$inter_tot_reprobel	=$obj_val_bl->tot_reprobel;
	$inter_tot_recupel	=$obj_val_bl->tot_recupel;
	//NEW VARS
	$final_tot_htva	=$tot_htva+$inter_tot_htva;
	$final_tot_tva	=$tot_tva+$inter_tot_tva;	
	$tot_reprobel	=$reprobel+$inter_tot_reprobel;
	$tot_bebat		=$bebat+$inter_tot_bebat;
	$tot_recupel	=$recupel+$inter_tot_recupel;
//On Update le BL avec les montant calculés ci-dessus
$sql_update_bl="UPDATE ".$tblpref."bl SET tot_htva='".$final_tot_htva."', tot_tva='".$final_tot_tva."', tot_recupel='".$tot_recupel."', tot_reprobel='".$tot_reprobel."', tot_bebat='".$tot_bebat."' WHERE num_bl='".$num_bl."'";
$req_update_bl=mysql_query($sql_update_bl);
///On décrémente le stock
//RECUP ANCIEN
$sql="SELECT stock FROM ".$tblpref."article WHERE num='".$article."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
	$stock=$obj->stock;
//Calcul du nouveau stock
$new_stock=$stock-$nbr;
//UPDATE
$sql="UPDATE ".$tblpref."article SET stock = '".$new_stock."' WHERE num='".$article."'";
$req=mysql_query($sql);
?>