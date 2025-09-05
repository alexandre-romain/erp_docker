<?php
include("../config/common.php");
$num_ticket = $_REQUEST['num_ticket'] ;
//On initialise la variable qui va contenir notre temps en secondes
$timesec=0;
//Requete permettant de récupérer le timespent
$sql ="SELECT TIME_TO_SEC(t.time_spent) as timesec, ti.soc as tisoc, t.rowid as trowid, t.deplacement as deplacement";
$sql.=" FROM ".$tblpref."task as t";
$sql.=" LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid = t.ticket_num";
$sql.=" WHERE ti.rowid=".$num_ticket."";
$req=mysql_query($sql);
//On initialise le compteur de déplacement.
$deplacement=0;
while ($results=mysql_fetch_object($req)) { // Temps que cela match, on additione les timesec, on en profite pour récupérer l'id du client et pour passer toutes les tâches à "facturées" en Abonnement
		$timesec=$timesec+$results->timesec;
		$cli=$results->tisoc;
		$sql_fact_task=" UPDATE ".$tblpref."task SET facture='ok', fact_num='ABONNEMENT' WHERE rowid=".$results->trowid."";
		$req_fact_task=mysql_query($sql_fact_task);
		if ($results->deplacement != 0) {
			$deplacement++;
		}
}
$minutes=floor($timesec/60);
//On récupère l'ID de l'abonnement
$sql_abo =" SELECT ID, temps_restant, deplacements_restant";
$sql_abo.=" FROM ".$tblpref."abos";
$sql_abo.=" WHERE client=".$cli." AND actif='oui'";	
$req_abo=mysql_query($sql_abo);
if ( $results_abo=mysql_fetch_object($req_abo)) {
	$id_abo=$results_abo->ID;
	$temps_restant_old=$results_abo->temps_restant;
	$depl_old=$results_abo->deplacements_restant;
}
$temps_restant=$temps_restant_old-$minutes;
$delp_restant=$depl_old-$deplacement;
//On update les abonnements
$sql=" UPDATE ".$tblpref."abos SET temps_restant=".$temps_restant.", deplacements_restant='".$delp_restant."' WHERE ID=".$id_abo."";
$req=mysql_query($sql);

$sql=" UPDATE ".$tblpref."ticket SET facture='ok', fact_num='ABONNEMENT' WHERE rowid=".$num_ticket."";
$req=mysql_query($sql);

header('Location: ../../ticket.php?num_ticket='.$num_ticket.''); 
?>